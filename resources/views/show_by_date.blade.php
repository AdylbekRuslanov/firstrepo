@extends('layouts.app')

@section('content')
    <h4>Bookings for date: {{ DateTime::createFromFormat('Y-m-d', $bookings[0]->date)->format('d-m-Y') }}</h4>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Время</th>
            <th scope="col">Зарезервированный номер</th>
            <th scope="col">Посещаемый номер</th>
            <th scope="col">Имя</th>
            <th scope="col">Комиссия</th>
            <th scope="col">Редактировать</th>
            <th scope="col">Отмена</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ DateTime::createFromFormat('Y-m-d', $booking->date)->format('d-m') }}</td>
                <td>{{ date('H:i', strtotime($booking->starting_time))}}</td>
                <td>{{ $booking->reserved_number }}</td>
                <td>{{ $booking->attended_number }}</td>
                <td>{{ $booking->names }}</td>
                <?php $percent = $booking->price / 100 * 20 * $booking->reserved_number;
                echo "<td> $percent € </td>"; ?>
                <td><a href={{ route('edit_booking', ['id' => $booking->id]) }}>Edit</a></td>
                <td><a href={{ route('delete_booking',['id' => $booking->id]) }}>Delete</a></td>
            </tr>
        @endforeach
        <td>Ukupno: {{ $total }} €</td>
        </tbody>
    </table>
@endsection
