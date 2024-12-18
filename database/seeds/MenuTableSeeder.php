<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = ['Ham and Cheese Sandwich', 'Vegetarian Sandwich', 'Fresh Fruit'];

        foreach($menu as $item) {
            Menu::create(['name' => $item]);
        }
    }
}
