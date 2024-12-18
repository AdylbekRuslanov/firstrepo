@extends('layouts.app')

@section('content')
    @if($bookings->isEmpty())
        <h3>No bookings</h3>
    @else

        @if(Session::has('message'))
            <div class="alert alert-info">
                {{ Session::get('message') }}
            </div>
        @endif

        <h4>All bookings for: {{ $bookings[0]->user->name }}</h4>
        <table class="table">
            <thead>
            <tr>

                <th scope="col">Дата</th>
                <th scope="col">Время</th>
                <th scope="col">Зарезервированный номер</th>
                <th scope="col">Посещаемый номер</th>
                <th scope="col">Имя</th>
                <th scope="col">Комиссия</th>
                @if(Auth::user()->id == $bookings[0]->user_id)
                    <th scope="col">Редактировать</th>
                    <th scope="col">Отмена</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>
                        <a href={{ route('show_by_date',['date' => $booking->tour->date]) }}>{{ DateTime::createFromFormat('Y-m-d', $booking->tour->date)->format('d-m') }}</a>
                    </td>
                    <td>{{ date('H:i', strtotime($booking->tour->starting_time)) }}</td>
                    <td>{{ $booking->reserved_number }}</td>
                    <td>{{ $booking->attended_number }}</td>
                    <td>{{ $booking->names }}</td>
                    <?php $percent = $booking->tour->price / 100 * 20 * $booking->reserved_number;
                    echo "<td> $percent € </td>"; ?>
                    @if(Auth::user()->id == $booking->user_id)
                        @if($booking->tour->date > date('Y-m-d H:i:s', strtotime('-1 day', time())))
                            <td><a href={{ route('edit_booking', ['id' => $booking->id]) }}>Edit</a></td>
                            <td><a href={{ route('delete_booking',['id' => $booking->id]) }}>Delete</a></td>
                        @else
                            <td>/</td>
                            <td>/</td>
                        @endif
                    @endif
                </tr>
            @endforeach
            <td>Ukupno: {{ $total }} €</td>
            </tbody>
        </table>
    @endif
@endsection
