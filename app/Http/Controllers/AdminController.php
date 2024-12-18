<?php

namespace App\Http\Controllers;

use App\Guide;
use App\Menu;
use App\Tour;
use App\User;

use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    // Show all bookings from all bookers

    public function show_all() {
        $bookings = DB::table('tours')
            ->join('bookings', 'tours.id', '=', 'bookings.tour_id')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->orderby('tours.id')
            ->get();

        return view('admin/show_all', compact('bookings'));
    }

    //Show details for selected tour

    public function tour($id) {
        $tour = Tour::find($id);

        $people = DB::table('bookings')
            ->select(DB::raw("sum(reserved_number) as number"), 'tour_id')
            ->join('tours', 'bookings.tour_id', '=', 'tours.id')
            ->where('tour_id', '=', $id)
            ->groupBy('tour_id')
            ->first();

        return view('admin/tour', compact('tour', 'people'));
    }

    //Edit selected tour

    public function edit_tour($id) {
        $tour = Tour::find($id);
        $guides = Guide::all();

        return view('admin/edit_tour', compact('tour', 'guides'));
    }

    public function update_tour($id) {
        $tour = Tour::find($id);

        if(request('people') != null) {
            for($i = 0; $i < sizeof(request('people')); $i++) {
                $tour->bookings[$i]->attended_number = request('people')[$i];
                $tour->bookings[$i]->save();
            }
        }

        $tour->capacity = request('capacity');
        $tour->guide_id = request('guide');
        $tour->save();

        return redirect(route('tour', ["id" => $id]));
    }

    //Cancel tour

    public function cancel_tour($id) {
        $tour = Tour::find($id);

        $tour->status = 'canceled';

        $tour->save();

        return redirect()->back()->with('message', 'The tour has been canceled');
    }

    //Restore canceled tour

    public function restore_tour($id) {
        $tour = Tour::find($id);

        $tour->status = 'pending';

        $tour->save();

        return redirect()->back()->with('message', 'The tour is no longer canceled');
    }

    //Select date to display tours

    public function date_tours() {
        $tours = Tour::select('date')->where('tour_time', '>', now())->distinct()->limit(49)->get();

        return view('admin/date_tours', compact('tours'));
    }

    //Display tours by selected date and choose guides for tours

    public function date_guide($date = null) {
        $date = request('date');

        $tours = Tour::where('date', '=', $date)->get();
        $guides = Guide::all();

        return view('admin/guides', compact('tours', 'guides', 'date'));
    }

    //Set guides for tours

    public function set_guides($date) {
        $tours = Tour::where('date', '=', $date)->where('status', '=', 'pending')->get();

        for($i = 0; $i < sizeOf(request('guides')); $i++) {
            $tours[$i]->guide_id = request('guides')[$i];
            $tours[$i]->save();
        }

        return redirect()->back();
    }

    //Show tours for selected guide

    public function guide_tours($id) {
        $guide = Guide::find($id);
        $tours = $guide->tours->where('tour_time', '>', now());

        return view('admin/guide_tours', compact('guide', 'tours'));
    }

    //Create new tours

    public function set_tours() {
        $tours = Tour::all();

        return view('admin/set_tours', compact('tours'));
    }

    public function create_tours(Request $request) {
        $request->validate([
           'begin' =>  'required',
            'end' => 'required',
            'times' => 'required'
        ]);

        $begin = new DateTime(request('begin'));
        $end = new DateTime(request('end'));

        if(now() > new DateTime(request('begin')) || now() > new DateTime(request('end'))) {
            return redirect()->back()->with('error', 'Cannot set tours for past days');
        }

        $times = request('times');

        foreach ($times as $time) {
            $tours = Tour::where('date', '=', $begin)->where('starting_time', '=', $time)->first();

            if($tours != null) {
                return redirect()->back()->with('error', 'Tours already exist');
            }
        }

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ( $period as $dt ) {
            for($i = 0; $i < sizeof($times); $i++) {
                if($times[$i] >= '16:00:00') {
                    $price = 35;
                } else {
                    $price = 30;
                }

                $date = $dt->format('Y-m-d');
                $tour_time = $date . ' ' . $times[$i];

                Tour::create(['date' => $date,
                    'starting_time' => $times[$i],
                    'tour_time' => $tour_time,
                    'price' => $price]);
            }
        }

        return redirect(route('tours'))->with('message', 'New tours are successfully created');
    }

    //Delete selected tour

    public function delete_tour($id) {
        $tour = Tour::find($id);
        $tour->delete();

        return redirect()->back();
    }

    //Add new guide

    public function new_guide() {
      return view('admin/new_guide');
    }

    public function add_guide(Request $request) {
        $request->validate([
           'name' => 'required|unique:guides|max:255',
        ]);

        Guide::create(['name' => request('name')]);
        return redirect()->back()->with('message', 'New guide added');
    }

    //Delete selected guide

    public function delete_guide($id) {
        $guide = Guide::find($id);
        $guide->delete();

        return redirect(route('home'));
    }

    //Show details for a selected booker

    public function booker_details() {
        $bookers = User::where('type', 'booker')->get();

        return view('admin/booker_details', compact('bookers'));
    }

    public function get_details() {
        $bookings = DB::table('tours')
            ->join('bookings', 'tours.id', '=', 'bookings.tour_id')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->whereBetween('tours.date', [request('begin'), request('end')])
            ->where('name', '=', request('booker'))
            ->orderby('tours.id')
            ->get();

        return view('admin/show_all', compact('bookings'));
    }

    //Add food item

    public function new_item() {
        return view('admin/new_item');
    }

    public function add_item(Request $request) {
        $request->validate([
            'name' => 'required|unique:menu|max:32',
        ]);

        Menu::create(['name' => request('name')]);
        return redirect()->back()->with('message', 'New item added');
    }
}
