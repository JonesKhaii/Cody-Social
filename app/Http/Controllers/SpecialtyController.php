<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Doctor;
use Carbon\Carbon;

class SpecialtyController extends Controller
{
    /**
     * Hiển thị trang chính chuyên môn bác sĩ
     */
    public function index()
    {
        // Lấy dữ liệu sự kiện sắp diễn ra
        $upcomingEvents = Post::getUpcomingEvents(3);

        // Lấy câu chuyện nghề y mới nhất
        $latestStories = Post::getLatestStories(3);

        // Lấy video chuyên môn mới nhất
        $latestVideos = Post::getLatestVideos(3);

        return view('pages.specialties.index', compact('upcomingEvents', 'latestStories', 'latestVideos'));
    }

    /**
     * Hiển thị trang sự kiện chuyên môn
     */
    public function events(Request $request)
    {
        // Lấy danh mục sự kiện
        $eventCategories = Category::where('parent_id', function ($query) {
            $query->select('id')->from('categories')->where('slug', 'su-kien-chuyen-mon');
        })->get();

        // Khởi tạo query
        $upcomingQuery = Post::ofType('event')
            ->with(['cat_info', 'author_info'])
            ->whereRaw('JSON_EXTRACT(meta_data, "$.event_start_date") > ?', [now()->format('Y-m-d H:i:s')]);

        $pastQuery = Post::ofType('event')
            ->with(['cat_info', 'author_info'])
            ->whereRaw('JSON_EXTRACT(meta_data, "$.event_end_date") < ?', [now()->format('Y-m-d H:i:s')]);

        // Lọc theo loại sự kiện nếu có
        if ($request->has('type') && $request->type != '') {
            $upcomingQuery->where('post_cat_id', $request->type);
            $pastQuery->where('post_cat_id', $request->type);
        }

        // Lấy dữ liệu phân trang
        $upcomingEvents = $upcomingQuery->orderByRaw('JSON_EXTRACT(meta_data, "$.event_start_date") ASC')->paginate(6, ['*'], 'upcoming_page');
        $pastEvents = $pastQuery->orderByRaw('JSON_EXTRACT(meta_data, "$.event_start_date") DESC')->paginate(6, ['*'], 'past_page');

        return view('pages.specialties.events', compact('eventCategories', 'upcomingEvents', 'pastEvents'));
    }

    /**
     * Hiển thị trang câu chuyện nghề y
     */
    public function stories(Request $request)
    {
        // Lấy danh mục câu chuyện nghề y
        $storyCategories = Category::where('parent_id', function ($query) {
            $query->select('id')->from('categories')->where('slug', 'cau-chuyen-nghe-y');
        })->get();

        // Lấy các bài viết nổi bật
        $featuredStories = Post::ofType('story')
            ->with(['cat_info', 'author_info'])
            ->where('is_featured', true)
            ->where('status', 'active')
            ->take(2)
            ->get();

        // Khởi tạo query cho các bài viết thường
        $storiesQuery = Post::ofType('story')
            ->with(['cat_info', 'author_info'])
            ->where('status', 'active');

        // Lọc theo danh mục nếu có
        if ($request->has('category') && $request->category != '') {
            $storiesQuery->where('post_cat_id', $request->category);
        }

        // Lấy dữ liệu phân trang
        $stories = $storiesQuery->orderBy('created_at', 'DESC')->paginate(9);

        return view('pages.specialties.stories', compact('storyCategories', 'featuredStories', 'stories'));
    }

    /**
     * Hiển thị trang thành tựu và nghiên cứu
     */
    public function research(Request $request)
    {
        // Lấy danh mục nghiên cứu
        $researchCategories = Category::where('parent_id', function ($query) {
            $query->select('id')->from('categories')->where('slug', 'thanh-tuu-nghien-cuu');
        })->get();

        // Lấy các năm để lọc
        $years = range(date('Y'), date('Y') - 10);

        // Khởi tạo query
        $researches = Post::ofType('research')
            ->with(['cat_info', 'author_info'])
            ->where('status', 'active');

        // Lọc theo loại nghiên cứu
        if ($request->has('type') && $request->type != '') {
            $researches->where('post_cat_id', $request->type);
        }

        // Lọc theo năm
        if ($request->has('year') && $request->year != '') {
            $researches->whereRaw('YEAR(JSON_EXTRACT(meta_data, "$.publish_date")) = ?', [$request->year]);
        }

        // Lấy dữ liệu phân trang
        $researches = $researches->orderBy('created_at', 'DESC')->paginate(10);

        return view('pages.specialties.research', compact('researchCategories', 'years', 'researches'));
    }

    /**
     * Hiển thị trang video chia sẻ chuyên môn
     */
    public function videos(Request $request)
    {
        // Lấy danh sách bác sĩ có video
        $doctors = Doctor::whereHas('posts', function ($query) {
            $query->where('post_type', 'video');
        })->get();

        // Lấy video nổi bật
        $featuredVideo = Post::ofType('video')
            ->with(['cat_info', 'author_info'])
            ->where('is_featured', true)
            ->where('status', 'active')
            ->first();

        // Khởi tạo query
        $videosQuery = Post::ofType('video')
            ->with(['cat_info', 'author_info'])
            ->where('status', 'active');

        // Lọc theo tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $videosQuery->where('title', 'like', '%' . $request->search . '%');
        }

        // Lọc theo bác sĩ
        if ($request->has('doctor') && $request->doctor != '') {
            $videosQuery->where('added_by', $request->doctor);
        }

        // Lấy dữ liệu phân trang
        $videos = $videosQuery->orderBy('created_at', 'DESC')->paginate(9);

        return view('pages.specialties.videos', compact('doctors', 'featuredVideo', 'videos'));
    }

    /**
     * Xử lý các danh mục con của sự kiện
     */
    public function eventCategory(Request $request)
    {
        // Xác định danh mục theo URL
        $slug = explode('/', $request->path())[1];
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            abort(404);
        }

        // Lấy các bài viết thuộc danh mục này
        $posts = Post::getPostsByCategory($category->id);

        return view('specialties.event-category', compact('category', 'posts'));
    }
}
