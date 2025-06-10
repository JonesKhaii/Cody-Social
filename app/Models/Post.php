<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\PostCategory;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Parsedown;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'tags',
        'summary',
        'short_desc',
        'slug',
        'description',
        'photo',
        'quote',
        'post_cat_id',
        'post_tag_id',
        'added_by',
        'status',
        'post_type',
        'meta_data'
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];
    protected static $parsedown;
    protected static function getParsedown()
    {
        if (!static::$parsedown) {
            static::$parsedown = new Parsedown();
            static::$parsedown->setSafeMode(true);
        }
        return static::$parsedown;
    }

    public function cat_info()
    {
        return $this->belongsTo(Category::class, 'post_cat_id', 'id')
            ->select('id', 'name as title', 'slug');
    }

    public function tag_info()
    {
        return $this->hasOne('App\Models\PostTag', 'id', 'post_tag_id');
    }
    // public function author_info()
    // {
    //     if ($this->author_type == 'doctor') {
    //         return $this->belongsTo(Doctor::class, 'added_by');
    //     }

    //     return $this->belongsTo(User::class, 'added_by');
    // }
    public function author_info()
    {
        if ($this->author_type == 'doctor') {
            return $this->belongsTo(Doctor::class, 'added_by')->select('id', 'name', 'photo');
        }

        return $this->belongsTo(User::class, 'added_by')->select('id', 'name', 'photo');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'added_by');
    }


    public function getAuthorInfoAttribute()
    {
        // Cache trong memory để tránh query lặp lại
        if (!array_key_exists('author_info_cached', $this->relations)) {
            if ($this->author_type == 'doctor') {
                $author = $this->relations['doctor'] ?? $this->doctor()->select('id', 'name', 'photo')->first();
            } else {
                $author = $this->relations['user'] ?? $this->user()->select('id', 'name', 'photo')->first();
            }

            $this->setRelation('author_info_cached', $author);
        }

        return $this->relations['author_info_cached'];
    }

    // Scope lọc theo loại bài đăng
    public function scopeOfType($query, $type)
    {
        return $query->where('post_type', $type);
    }

    // Scope lọc sự kiện sắp diễn ra
    public function scopeUpcomingEvents($query)
    {
        return $query->where('post_type', 'event')
            ->whereRaw('JSON_EXTRACT(meta_data, "$.event_start_date") > ?', [now()->format('Y-m-d H:i:s')]);
    }

    // Scope lọc sự kiện đã diễn ra
    public function scopePastEvents($query)
    {
        return $query->where('post_type', 'event')
            ->whereRaw('JSON_EXTRACT(meta_data, "$.event_end_date") < ?', [now()->format('Y-m-d H:i:s')]);
    }

    // Scope lọc các bài nổi bật
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Getter cho sự kiện
    public function getEventStartDateAttribute()
    {
        if ($this->post_type == 'event' && isset($this->meta_data['event_start_date'])) {
            return $this->meta_data['event_start_date'];
        }
        return null;
    }

    public function getEventEndDateAttribute()
    {
        if ($this->post_type == 'event' && isset($this->meta_data['event_end_date'])) {
            return $this->meta_data['event_end_date'];
        }
        return null;
    }

    public function getLocationAttribute()
    {
        if ($this->post_type == 'event' && isset($this->meta_data['location'])) {
            return $this->meta_data['location'];
        }
        return null;
    }

    public function getSpeakerAttribute()
    {
        if ($this->post_type == 'event' && isset($this->meta_data['speaker'])) {
            return $this->meta_data['speaker'];
        }
        return null;
    }

    // Getter cho video
    public function getVideoUrlAttribute()
    {
        if ($this->post_type == 'video' && isset($this->meta_data['video_url'])) {
            return $this->meta_data['video_url'];
        }
        return null;
    }

    public function getDurationAttribute()
    {
        if ($this->post_type == 'video' && isset($this->meta_data['duration'])) {
            return $this->meta_data['duration'];
        }
        return null;
    }

    // Getter cho nghiên cứu
    public function getDocumentUrlAttribute()
    {
        if ($this->post_type == 'research' && isset($this->meta_data['document_url'])) {
            return $this->meta_data['document_url'];
        }
        return null;
    }

    public static function getAllPost($type = null)
    {
        $query = Post::with(['cat_info'])->orderBy('id', 'DESC');

        if ($type) {
            $query->where('post_type', $type);
        }

        return $query->paginate(10);
    }

    public static function getPostBySlug($slug)
    {
        return Post::with(['tag_info'])->where('slug', $slug)->where('status', 'active')->first();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id')->whereNull('parent_id')->where('status', 'active')->latest();
    }

    public function allComments()
    {
        return $this->hasMany(PostComment::class)->where('status', 'active');
    }

    public static function getBlogByTag($slug)
    {
        return Post::where('tags', $slug)->paginate(8);
    }

    public static function countActivePost()
    {
        $data = Post::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'clinic_post', 'post_id', 'clinic_id')
            ->withPivot('notes')
            ->withTimestamps();
    }

    public function isTreatmentPost()
    {
        // Danh sách ID danh mục phương pháp điều trị
        $treatmentCategoryIds = range(88, 100);
        return in_array($this->post_cat_id, $treatmentCategoryIds);
    }

    // Kiểm tra xem user hoặc doctor đã like bài viết chưa
    public function isLikedBy($userOrDoctor)
    {
        if (!$userOrDoctor) {
            return false;
        }

        return $this->likes()
            ->where(function ($query) use ($userOrDoctor) {
                if ($userOrDoctor instanceof \App\Models\User) {
                    $query->where('user_id', $userOrDoctor->id);
                } elseif ($userOrDoctor instanceof \App\Models\Doctor) {
                    $query->where('doctor_id', $userOrDoctor->id);
                }
            })
            ->exists();
    }

    // Phương thức lấy sự kiện sắp diễn ra
    public static function getUpcomingEvents($limit = 6)
    {
        return Post::ofType('event')
            ->with(['cat_info'])
            ->whereRaw('JSON_EXTRACT(meta_data, "$.event_start_date") > ?', [now()->format('Y-m-d H:i:s')])
            ->orderByRaw('JSON_EXTRACT(meta_data, "$.event_start_date") ASC')
            ->take($limit)
            ->get();
    }

    // Phương thức lấy câu chuyện nghề y mới nhất
    public static function getLatestStories($limit = 6)
    {
        return Post::ofType('story')
            ->with(['cat_info'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    // Phương thức lấy nghiên cứu mới nhất
    public static function getLatestResearches($limit = 6)
    {
        return Post::ofType('research')
            ->with(['cat_info'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    // Phương thức lấy video chia sẻ chuyên môn
    public static function getLatestVideos($limit = 6)
    {
        return Post::ofType('video')
            ->with(['cat_info'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    // Phương thức lấy bài viết theo danh mục
    public static function getPostsByCategory($categoryId, $limit = 10)
    {
        return Post::where('post_cat_id', $categoryId)
            ->with(['cat_info'])
            ->where('status', 'active')
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
    }

    // Phương thức lấy bài viết liên quan
    public static function getRelatedPosts($post, $limit = 3)
    {
        return Post::where('post_cat_id', $post->post_cat_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'active')
            ->where('post_type', $post->post_type)
            ->take($limit)
            ->get();
    }

    // Statistic
    public function getPostInteractionTotals()
    {
        $doctorId = auth()->guard('doctor')->id();

        $posts = Post::where('added_by', $doctorId)
            ->withCount(['likes', 'comments'])
            ->select('id', 'views') // chỉ lấy cần thiết
            ->get();

        $totals = [
            'likes' => $posts->sum('likes_count'),
            'comments' => $posts->sum('comments_count'),
            'views' => $posts->sum('views'),
        ];

        return response()->json($totals);
    }

    public function getPostStatsPerPost()
    {
        $doctorId = auth()->guard('doctor')->id();

        $posts = Post::where('added_by', $doctorId)
            ->withCount(['likes', 'comments'])
            ->select(['id', 'title', 'views'])
            ->get()
            ->map(function ($post) {
                return [
                    'title' => $post->title,
                    'views' => $post->views ?? 0,
                    'likes' => $post->likes_count ?? 0,
                    'comments' => $post->comments_count ?? 0,
                ];
            });

        return response()->json($posts);
    }

    public function getShortDescriptionAttribute()
    {
        return $this->short_desc ?: Str::limit($this->summary, 100);
    }

    // Phương thức để lấy short description với độ dài tùy chỉnh
    public function getShortDesc($limit = 100)
    {
        if ($this->short_desc) {
            return Str::limit($this->short_desc, $limit);
        }

        return Str::limit($this->summary, $limit);
    }



    public function getShortDescHtmlAttribute()
    {
        if (!$this->short_desc) {
            return $this->summary ? Str::limit($this->summary, 150) : '';
        }

        return static::getParsedown()->text($this->short_desc);
    }


    public function getShortDescForDisplay($limit = 200)
    {
        if (!$this->short_desc) {
            return $this->summary ? Str::limit($this->summary, $limit) : '';
        }

        // Nếu có Parsedown và text có line breaks, dùng Parsedown
        if (strpos($this->short_desc, "\n") !== false) {
            $html = static::getParsedown()->text($this->short_desc);

            // Nếu HTML quá dài, cắt bớt
            if (strlen(strip_tags($html)) > $limit) {
                $plainText = strip_tags($html);
                return Str::limit($plainText, $limit) . '...';
            }

            return $html;
        }

        // Nếu text trên 1 hàng, tự động format
        $text = $this->short_desc;

        // Tách text thành các phần
        // Tìm pattern: **text** * item * item * item
        if (preg_match('/\*\*(.*?)\*\*(.*)/', $text, $matches)) {
            $title = trim($matches[1]);
            $items = trim($matches[2]);

            $html = "<p><strong>{$title}</strong></p>";

            // Tách các items bằng dấu *
            if (!empty($items)) {
                $itemList = preg_split('/\s*\*\s*/', $items);
                $itemList = array_filter($itemList); // Bỏ empty items

                if (!empty($itemList)) {
                    $html .= '<ul>';
                    foreach ($itemList as $item) {
                        $item = trim($item);
                        if (!empty($item)) {
                            $html .= "<li>{$item}</li>";
                        }
                    }
                    $html .= '</ul>';
                }
            }

            // Kiểm tra độ dài
            if (strlen(strip_tags($html)) > $limit) {
                $plainText = strip_tags($html);
                return Str::limit($plainText, $limit) . '...';
            }

            return $html;
        }

        // Nếu không match pattern trên, chỉ return text thường
        return Str::limit($this->short_desc, $limit);
    }
}
