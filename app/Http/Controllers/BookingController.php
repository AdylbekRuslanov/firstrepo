<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Booking_Menu;
use App\Menu;
use App\Tour;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    public function welcome() {
        return view('welcome');
    }

    //Display form for new booking with upcoming tours

    public function new_booking()
    {
        $tours_date = Tour::where('tour_time', '>', now())->distinct()->limit(30)->get(['date']);
        $tours_time = Tour::where('tour_time', '>', now())->distinct()->distinct()->orderBy('starting_time')->get(['starting_time']);
        $menu = Menu::all();

        $tours =$tours = DB::table('tours')
            ->select(DB::raw("sum(reserved_number) as number"), 'tours.id', 'date', 'starting_time', 'capacity', 'price')
            ->leftJoin('bookings', 'tours.id', '=', 'bookings.tour_id')
            ->where('tour_time', '>', now())
            ->where('status', '=', 'pending')
            ->groupBy('tours.id', 'date', 'starting_time', 'capacity', 'price')
            ->orderBy('date')
            ->orderBy('starting_time')
            ->limit(20)
            ->get();

        return view('new', compact('tours', 'tours_date', 'tours_time', 'menu', 'tours'));
    }

    //Display form for new booking with selected tour

    public function book_now($id) {
        $tour = Tour::find($id);
        $menu = Menu::all();

        return view('book_now', compact('tour', 'menu'));
    }

    //Create and post new booking

    public function post_booking(Request $request)
    {
        $request->validate([
            'names' => 'required',
        ]);

        $date = request('date');
        $time = request('time');

        $tour = Tour::where('date', $date)->where('starting_time', $time)->first();

        if($tour == null) {
            return redirect()->back()->with('message', 'Invalid tour time');
        }

        if($tour->status == 'canceled') {
            return redirect()->back()->with('message', 'Selected tour has been canceled :(');
        }

        if($tour->status == 'finished' || $tour->status == 'running') {
            return redirect()->back()->with('message', 'Selected tour has already started');
        }

        $booking = Booking::select(DB::raw("SUM(reserved_number) as number"), 'tour_id')
            ->where('tour_id', '=', $tour->id)
            ->groupBy('tour_id')
            ->first();

        if($booking) {
            $num_of_people = $booking->number + request('people');
            if($num_of_people > $tour->capacity) {
                return redirect("/new")->with('message', 'Selected tour if full :(');
            }
        }

        Booking::create([
            'tour_id' => $tour->id,
            'reserved_number' => request('people'),
            'names' => request('names'),
            'user_id' => request('user_id')
        ]);

        for ($i = 0; $i < sizeof(request('items')); $i++) {
            if (request('items')[$i] != "0") {

                $booking_menu = Booking_Menu::where('menu_id', '=', request('item_id')[$i])
                    ->where('tour_id', '=', $tour->id)->first();

                if ($booking_menu) {
                    $quantity = $booking_menu->quantity + (int)request('items')[$i];
                } else {
                    $quantity = (int)request('items')[$i];
                }

                Booking_Menu::updateOrCreate(
                    ['menu_id' => request('item_id')[$i], 'tour_id' => $tour->id], [
                    'quantity' => $quantity
                ]);
            }
        }

        return redirect()->back()->with('message', 'Your booking has been posted');
    }

    //Display all bookings for one booker

    public function show_bookings($id){

        $bookings = Booking::where('user_id', $id)->get();

        $total = 0;

        foreach ($bookings as $booking) {
            $percent = ($booking->tour()->first()->price / 100 * 20) * $booking->reserved_number;
            $total += $percent;
        }

        return view('show_bookings', compact('bookings','total'));
    }

    //Display bookings for one booker on selected date

    public function show_by_date($date) {

            $bookings = DB::table('tours')
                ->join('bookings', 'tours.id', '=', 'bookings.tour_id')
                ->where('date', '=', $date)
                ->where('user_id', '=', Auth::user()->id)
                ->orderBy('starting_time')
                ->get();

        $total = 0;

        foreach ($bookings as $booking) {
            $percent = ($booking->price / 100 * 20) * $booking->reserved_number;
            $total += $percent;
        }

        return view('show_by_date', compact('bookings', 'total'));
    }

    //Display bookings for one booker in selected month

    public function show_by_months($month) {
        $bookings = DB::table('bookings')
            ->join('tours', 'bookings.tour_id', '=', 'tours.id')
            ->whereMonth('date', '=', $month)
            ->where ('user_id', '=', Auth::user()->id)
            ->get();

        $total = 0;

        foreach ($bookings as $booking) {
            $percent = ($booking->price / 100 * 20) * $booking->reserved_number;
            $total += $percent;
        }

        return view('show_by_month', compact('bookings', 'total', 'month'));

    }

    //Edit selected booking

    public function edit_booking($id) {

        $booking = Booking::find($id);

        $tour = DB::table('bookings')
            ->join('tours', 'bookings.tour_id', '=', 'tours.id')
            ->where('bookings.id', '=', $booking->id)
            ->get();

        $tours_date = DB::table('tours')->distinct()->get(['date']);
        $tours_time = DB::table('tours')->distinct()->get(['starting_time']);

        return view('edit_booking', ['booking' => $booking], compact('tour', 'tours_date', 'tours_time'));
    }

    public function update_booking($id) {
        $booking = Booking::find($id);
        $date = request('date');
        $starting_time = request('time');

        $tour = Tour::where('date', $date)->where('starting_time', $starting_time)->first();

        $booking->names = request("names");
        $booking->reserved_number = request("people");
        $booking->tour_id = $tour->id;

        $booking->save();

        return redirect(route('show_bookings', ['id' => Auth::user()->id]))->with('message', 'Your booking has been edited');
    }

    //Delete selected booking

    public function delete_booking($id) {
        $booking = Booking::find($id);
        $booking->delete();

        return redirect()->back()->with('message', 'Your booking has been deleted');
    }
}
