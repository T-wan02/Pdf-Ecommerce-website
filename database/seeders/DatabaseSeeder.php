<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CompanyDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        CompanyDetail::create([
            'name' => 'The Vault',
            'description' => 'Use our proven playbook & guides to improve your sales, email & discovery game.',
        ]);

        // Adding product datas
        Product::create([
            'name' => '4 Most common Roles in Tech Sales Overview',
            'slug' => Str::slug('4 Most common Roles in Tech Sales Overview'),
            'price' => '7.99'
        ]);
        Product::create([
            'name' => '6 Steps to Break into Tech Sales',
            'slug' => Str::slug('6 Steps to Break into Tech Sales'),
            'price' => '9.99'
        ]);
        Product::create([
            'name' => 'Beginners Guide to the Language of Sales',
            'slug' => Str::slug('Beginners Guide to the Language of Sales'),
            'price' => '7.99'
        ]);
        Product::create([
            'name' => 'Hypothesis Driven Disco Call Frame Work',
            'slug' => Str::slug('Hypothesis Driven Disco Call Frame Work'),
            'price' => '7.99'
        ]);
        Product::create([
            'name' => 'Hypothesis Research Doc',
            'slug' => Str::slug('Hypothesis Research Doc'),
            'price' => '9.99'
        ]);
        Product::create([
            'name' => 'Subject Lines that get your emails opened',
            'slug' => Str::slug('Subject Lines that get your emails opened'),
            'price' => '7.99'
        ]);
        Product::create([
            'name' => 'Turning your research into a hypothesis: Point of View',
            'slug' => Str::slug('Turning your research into a hypothesis: Point of View'),
            'price' => '14.99'
        ]);
    }
}
