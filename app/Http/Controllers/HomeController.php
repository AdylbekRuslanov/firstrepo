<?php

namespace App\Http\Controllers;

use App\Tour;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $tours_status = Tour::where('status', '!=', 'canceled')->get();

        foreach ($tours_status as $tour) {
            $tour_start = strtotime($tour->tour_time);
            $tour_end = strtotime($tour->tour_time) + 3 * 3600;
            $current_time = time();

            if($current_time > $tour_end) {
                $tour->status = 'finished';
                $tour->save();
            } elseif($current_time > $tour_start && $current_time < $tour_end) {
                $tour->status = 'running';
                $tour->save();
            }  else {
                $tour->status = 'pending';
                $tour->save();
            }
        }

        $tours = DB::table('tours')
            ->select(DB::raw("sum(reserved_number) as number"), 'bookings.tour_id', 'date', 'starting_time', 'tour_time', 'capacity', 'status', 'name', 'tours.id')
            ->leftJoin('bookings', 'tours.id', '=', 'bookings.tour_id')
            ->leftJoin('guides', 'tours.guide_id', '=', 'guides.id')
            ->where('tour_time', '>', date('Y-m-d H-i-s', time() - 14400))
            ->groupBy('tours.id', 'tour_id', 'date', 'starting_time', 'tour_time', 'capacity', 'status', 'guides.name')
            ->orderBy('date')
            ->orderBy('starting_time')
            ->limit(20)
            ->get();

        return view('home', compact('tours'));
    }
}
