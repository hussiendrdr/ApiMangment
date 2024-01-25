<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();

        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        DB::table('category_product')->truncate();
        User::factory(1000)->create();
        Category::factory(30)->create();
        Transaction::factory(1000)->create();

        Product::factory(1000)->create()->each(function ($product){
            $categories=Category::all()->random(mt_rand(1,5))->pluck('id')
            ;
            $product->categories()->attach($categories);
        });






        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
