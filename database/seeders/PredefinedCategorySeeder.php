<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PredefinedCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'description' => 'Resources related to technology, programming, and gadgets.'],
            ['name' => 'Education', 'description' => 'Educational content, courses, and learning resources.'],
            ['name' => 'Entertainment', 'description' => 'Movies, TV shows, music, and pop culture.'],
            ['name' => 'Health & Fitness', 'description' => 'Fitness tips, health articles, and wellness resources.'],
            ['name' => 'Business', 'description' => 'Business strategies, entrepreneurship, and market insights.'],
            ['name' => 'Finance', 'description' => 'Investments, cryptocurrency, and personal finance tips.'],
            ['name' => 'Travel', 'description' => 'Travel guides, destinations, and vacation ideas.'],
            ['name' => 'Lifestyle', 'description' => 'Fashion, beauty, home decor, and lifestyle tips.'],
            ['name' => 'Food & Recipes', 'description' => 'Recipes, cooking tips, and restaurant recommendations.'],
            ['name' => 'Science', 'description' => 'Scientific articles, discoveries, and research.'],
            ['name' => 'Sports', 'description' => 'News, updates, and analysis of various sports.'],
            ['name' => 'News & Media', 'description' => 'Current affairs, world news, and media outlets.'],
            ['name' => 'Self-Development', 'description' => 'Motivational content, self-improvement, and productivity.'],
            ['name' => 'Gaming', 'description' => 'Video games, game reviews, and gaming communities.'],
            ['name' => 'Art & Design', 'description' => 'Art inspiration, graphic design, and creative resources.'],
            ['name' => 'DIY & Crafts', 'description' => 'Do-it-yourself projects, crafts, and handmade goods.'],
            ['name' => 'Parenting', 'description' => 'Parenting tips, resources, and advice.'],
            ['name' => 'Photography', 'description' => 'Photography tips, techniques, and portfolios.'],
            ['name' => 'Books & Literature', 'description' => 'Book reviews, reading lists, and literary resources.'],
            ['name' => 'Nature & Environment', 'description' => 'Nature conservation, environment, and wildlife.'],
            ['name' => 'History', 'description' => 'Historical articles, documentaries, and resources.'],
            ['name' => 'Automobiles', 'description' => 'Cars, motorcycles, and automotive industry news.'],
            ['name' => 'Politics', 'description' => 'Political news, analysis, and opinions.'],
            ['name' => 'Real Estate', 'description' => 'Property listings, market insights, and real estate tips.'],
            ['name' => 'Spirituality', 'description' => 'Mindfulness, meditation, and spiritual growth.']
        ];

        DB::table('predefined_categories')->insert($categories);
    }
}
