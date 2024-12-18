<?php

use App\User;
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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'type' => 'admin'
        ]);

        User::create([
            'name' => 'Guests',
            'email' => 'guest@guest.com',
            'password' => bcrypt('111111'),
            'type' => 'guest'
        ]);

        User::create([
            'name' => 'Booker 1',
            'email' => 'booker1@booker.com',
            'password' => bcrypt('654321'),
            'type' => 'booker'
        ]);

        User::create([
            'name' => 'Booker 2',
            'email' => 'booker2@booker.com',
            'password' => bcrypt('222222'),
            'type' => 'booker'
        ]);
    }
}
