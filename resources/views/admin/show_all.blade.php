@extends('layouts.app')

@section('content')
    @if($bookings->isEmpty())
        <h3>No bookings</h3>
    @else
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Дата</th>
                <th scope="col">Время</th>
                <th scope="col">Зарезервированный номер</th>
                <th scope="col">Посещаемый номер</th>
                <th scope="col">Имя</th>
                <th scope="col">Бронировавший</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>
                        <a href={{ route('show_by_date',['date' => $booking->date]) }}>{{ DateTime::createFromFormat('Y-m-d', $booking->date)->format('d-m') }}</a>
                    </td>
                    <td>{{ date('H:i', strtotime($booking->starting_time)) }}</td>
                    <td>{{ $booking->reserved_number }}</td>
                    <td>{{ $booking->attended_number }}</td>
                    <td>{{ $booking->names }}</td>
                    <td><a href={{ route('show_bookings', ['id' => $booking->user_id]) }}>{{ $booking->name }}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
