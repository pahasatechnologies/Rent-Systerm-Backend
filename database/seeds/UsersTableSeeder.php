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
        factory(App\User::class)->states('landlord')->create();
        factory(App\User::class)->states('tenant')->create();
    }
}
