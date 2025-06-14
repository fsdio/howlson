<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin users
        $adminUsers = User::role('admin')->get();
        
        if ($adminUsers->isEmpty()) {
            $this->command->warn('No admin users found. Please run RolesTableSeeder first.');
            return;
        }

        $blogs = [
            [
                'title' => 'Welcome to Our Blog',
                'content' => '<p>This is our first blog post. We are excited to share our thoughts and insights with you.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
                'excerpt' => 'This is our first blog post. We are excited to share our thoughts and insights with you.',
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'meta_title' => 'Welcome to Our Blog - Company Name',
                'meta_description' => 'Read our first blog post where we share our thoughts and insights about our industry.',
            ],
            [
                'title' => 'Tips for Better Productivity',
                'content' => '<p>Productivity is key to success in any field. Here are some tips to help you become more productive:</p><ul><li>Set clear goals</li><li>Prioritize your tasks</li><li>Take regular breaks</li><li>Use productivity tools</li><li>Eliminate distractions</li></ul><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>',
                'excerpt' => 'Learn essential tips to boost your productivity and achieve better results in your work.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'meta_title' => 'Tips for Better Productivity - Boost Your Performance',
                'meta_description' => 'Discover proven tips and strategies to improve your productivity and achieve better results.',
            ],
            [
                'title' => 'The Future of Technology',
                'content' => '<p>Technology is evolving at an unprecedented pace. In this article, we explore what the future holds for various technological innovations.</p><p>From artificial intelligence to quantum computing, the possibilities are endless. We discuss the potential impact of these technologies on our daily lives and business operations.</p><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'excerpt' => 'Explore the exciting possibilities that emerging technologies bring to our future.',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'meta_title' => 'The Future of Technology - What to Expect',
                'meta_description' => 'Explore emerging technologies and their potential impact on our future lives and businesses.',
            ],
            [
                'title' => 'Draft: Upcoming Features',
                'content' => '<p>This is a draft post about upcoming features that we are planning to release.</p><p>We are working on several exciting new features that will enhance user experience and provide more value to our customers.</p>',
                'excerpt' => 'A preview of the exciting new features we are working on.',
                'status' => 'draft',
                'published_at' => null,
                'meta_title' => 'Upcoming Features - What\'s Coming Next',
                'meta_description' => 'Get a sneak peek at the new features we are developing for our platform.',
            ],
        ];

        foreach ($blogs as $blogData) {
            $blogData['id'] = Str::uuid();
            $blogData['slug'] = Str::slug($blogData['title']);
            $blogData['author_id'] = $adminUsers->random()->id;
            
            Blog::create($blogData);
        }

        $this->command->info('Blog seeder completed successfully.');
    }
}