<?php

use App\Tour;
use Illuminate\Database\Seeder;

class ToursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $begin = new DateTime(date('Y-m-d'));
        $end = new DateTime(date('Y-m-d', strtotime('+60 day', time())));

        $times = ['09:00:00', '11:30:00', '13:00:00', '16:00:00', '17:00:00'];

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
            for ($i = 0; $i < sizeof($times); $i++) {
                if ($times[$i] == '16:00:00' || $times[$i] == '16:30:00' || $times[$i] == '17:00:00') {
                    $price = 35;
                } else {
                    $price = 30;
                }

                $date = $dt->format('Y-m-d');

                Tour::create([
                    'date' => $dt,
                    'starting_time' => $times[$i],
                    'tour_time' => date('Y-m-d H-i-s', strtotime($date . ' ' . $times[$i])),
                    'price' => $price,
                ]);
            }
        }
    }
}
