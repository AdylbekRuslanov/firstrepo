@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('edit_booking', ['id' => $booking->id]) }}">
        {{ csrf_field() }}
        <table>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Дата</th>
                    <th scope="col">Время</th>
                    <th scope="col">Человек</th>
                    <th scope="col">Имя</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <select name="date">
                            <option>{{ $tour[0]->date }}</option>
                            @foreach($tours_date as $dates)
                                <option>{{ $dates->date}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="time">
                            <option>{{ $tour[0]->starting_time }}</option>
                            @foreach($tours_time as $times)
                                <option>{{ $times->starting_time}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="people">
                            <option>{{ $tour[0]->reserved_number }}</option>
                            @for($i=1; $i<21; $i++)
                                <option>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                    <td><input type="text" name="names" value={{ $booking->names }}></td>
                </tr>
                </tbody>
            </table>
        </table>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
@endsection
