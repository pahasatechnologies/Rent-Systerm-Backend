<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->states('admin')->create();
        factory(App\User::class)->states('agent')->create();
        factory(App\User::class)->states('owner')->create();
        factory(App\User::class)->states('user')->create();
    }
}
