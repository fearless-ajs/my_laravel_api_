<?php

namespace Database\Seeders;

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
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(TransactionsSeeder::class);
//        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); //Disable the foreign key check during truncation
//        User::truncate();
//        Category::truncate();
//        Product::truncate();
//        Transaction::truncate();
//        DB::table('category_product')->truncate(); //To access the category_product table direct because we don't have the table
        // \App\Models\User::factory(10)->create();


        //The number of datas needed in our tables
//        $usersQuantity        = 200;
//        $categoriesQuantity   = 30;
//        $productsQuantity     = 1000;
//        $transactionsQuantity = 1000;

        //Creating the data using the model factories
//        User::factory($usersQuantity)->create();
//        Category::factory($categoriesQuantity)->create();
//
//        Product::factory($productsQuantity)->create()->each(
//            function ($product){
//                $categories =  Category::all()->random(mt_rand(1, 5))->pluck('id');
//                $product->categories()->attach($categories);
//            });
//
//        Transaction::factory($transactionsQuantity)->create();
    }
}
