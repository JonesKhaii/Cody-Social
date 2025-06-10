<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPerformanceIndexesToTables extends Migration
{
    public function up()
    {
        // Posts table indexes
        Schema::table('posts', function (Blueprint $table) {
            // Composite index cho status và created_at (cho homepage posts)
            $table->index(['status', 'created_at'], 'idx_posts_status_created');

            // Composite index cho category và status (cho category filtering)
            $table->index(['post_cat_id', 'status'], 'idx_posts_cat_status');

            // Index cho views (cho top viewed posts)
            $table->index('views', 'idx_posts_views');

            // Composite index cho author (cho author posts)
            $table->index(['author_type', 'added_by', 'status'], 'idx_posts_author');

            // Index cho slug (cho single post lookup)
            $table->index('slug', 'idx_posts_slug');
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            // Composite index cho type và status
            $table->index(['type', 'status'], 'idx_categories_type_status');

            // Index cho slug
            $table->index('slug', 'idx_categories_slug');
        });

        // Doctors table indexes
        Schema::table('doctors', function (Blueprint $table) {
            // Composite index cho status và rating (cho top doctors)
            $table->index(['status', 'rating'], 'idx_doctors_status_rating');
        });

        // Users table indexes - nếu chưa có
        Schema::table('users', function (Blueprint $table) {
            // Check if index exists before adding
            $indexes = collect(DB::select("SHOW INDEX FROM users"))->pluck('Key_name');

            if (!$indexes->contains('users_email_index')) {
                $table->index('email', 'idx_users_email');
            }
        });

        // Add fulltext search index cho posts (MySQL specific)
        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE posts ADD FULLTEXT idx_posts_search (title, summary)');
        }
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('idx_posts_status_created');
            $table->dropIndex('idx_posts_cat_status');
            $table->dropIndex('idx_posts_views');
            $table->dropIndex('idx_posts_author');
            $table->dropIndex('idx_posts_slug');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_type_status');
            $table->dropIndex('idx_categories_slug');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropIndex('idx_doctors_status_rating');
        });

        // Drop fulltext index
        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE posts DROP INDEX idx_posts_search');
        }
    }
}
