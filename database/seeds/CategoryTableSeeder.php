<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class)->states('residential')->create();
        factory(App\Category::class)->states('commercial')->create();
        factory(App\Category::class)->states('residential-child')->create();
        factory(App\Category::class)->states('commercial-child')->create();
    }
}
