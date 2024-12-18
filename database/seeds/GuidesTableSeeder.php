<?php

use App\Guide;
use Illuminate\Database\Seeder;

class GuidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guides = ['Dario', 'Andro', 'Marko', 'Jakov', 'Teo', 'Antonio'];

        foreach($guides as $guide) {
            Guide::create(['name' => $guide]);
        }
    }
}
