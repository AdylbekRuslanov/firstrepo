<?php
/**
 * Created by PhpStorm.
 * User: Ivana
 * Date: 2.3.2018.
 * Time: 18:43
 */

namespace App\Providers;


use App\Guide;
use App\Menu;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot() {
        view()->composer('layouts.navbar', function($view) {
            $view->with('bookers', User::where('type', '!=', 'admin')->get());
            $view->with('guides', Guide::all());
            $view->with('months', DB::table('tours')->select(DB::raw("MONTH(date) as month"))->distinct()->get());
            $view->with('items', Menu::all());
        });

    }

}