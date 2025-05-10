<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function results(Request $request)
    {
        $q = $request->input('q');

        // Truy vấn bài viết theo từ khóa
        $posts = Post::with(['doctor', 'user'])  // Eager load quan hệ
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%")
                    ->orWhereHas('doctor', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('user', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    });
            })
            ->paginate(10); // Phân trang 10 bài viết mỗi trang

        return view('pages.search-results', compact('posts', 'q'));
    }
    public function search(Request $request)
    {
        $q = $request->input('q');

        // Tìm kiếm theo tiêu đề, tóm tắt và tên tác giả
        $results = Post::with(['doctor', 'user'])
            ->where('title', 'like', "%{$q}%")
            ->orWhere('summary', 'like', "%{$q}%")
            ->orWhereHas('doctor', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orWhereHas('user', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->get();

        return response()->json([
            'count'   => $results->count(),
            'results' => $results->map(function ($post) {
                $author = $post->doctor ?? $post->user;
                return [
                    'title'  => $post->title,
                    'slug'   => $post->slug,
                    'author' => $author->name ?? 'N/A',
                ];
            }),
        ]);
    }
}
