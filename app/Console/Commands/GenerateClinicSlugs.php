<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateClinicSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:clinic-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     //
    // }
    public function handle()
    {
        $this->info('Đang cập nhật slug cho các clinic chưa có...');

        \App\Models\Clinic::whereNull('slug')->orWhere('slug', '')->get()->each(function ($clinic) {
            $clinic->slug = \Str::slug($clinic->name);
            $clinic->save();
            $this->line("✔ {$clinic->name} → {$clinic->slug}");
        });

        $this->info('Hoàn tất!');
    }
}
