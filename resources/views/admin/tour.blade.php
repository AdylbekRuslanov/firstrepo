@extends('layouts.app')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-info">
            {{ Session::get('message') }}
        </div>
    @endif
    @if($people == null)
        <h3>No bookings for this tour yet</h3>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Время</th>
            <th scope="col">Вместимость</th>
            <th scope="col">Статус</th>
            <th scope="col">Гид</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @if($tour)
                <td>{{ DateTime::createFromFormat('Y-m-d', $tour->date)->format('d-m') }}</td>
                <td>{{ date('H:i', strtotime($tour->starting_time)) }}</td>
                <td>{{ $tour->capacity - $tour->number}}</td>
                <td>{{ $tour->status }}</td>
                @if($tour->guide)
                    <td>{{ $tour->guide->name }}</td>
                @else
                    <td>Guide not set</td>
                @endif
            @endif
        </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Зарезервированный номер</th>
            <th scope="col">Посещаемый номер</th>
            <th scope="col">Имя</th>
            <th scope="col">Бронировавший</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @if($tour)
                @foreach($tour->bookings as $booking)
                    <td>{{ $booking->reserved_number }}</td>
                    <td>{{ $booking->attended_number }}</td>
                    <td>{{ $booking->names}}</td>
                    <td>{{ $booking->user->name}}</td>
        </tr>
        @endforeach
        @endif
        </tbody>
    </table>

    <h6>Total number of people:</h6>
    @if($people)
        <p>{{ $people->number }}</p>
    @else
        <p>0</p>
    @endif
    <br>

    <h5>Tour snack</h5>
    <table class="table">
        <thead>
        <tr>
            @foreach($tour->tour_menu as $menu)
                <th scope="col">{{ $menu->menu->name }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <tr>
            @foreach($tour->tour_menu as $menu)
                <td>{{ $menu->quantity }}</td>
            @endforeach
        </tr>
        </tbody>
    </table>
    <a href="{{ route('edit_tour', ['id' => $tour->id]) }}" class="btn btn-primary" role="button">Редактировать</a>
    @if($tour->status == 'pending')
        <a href="{{ route('cancel_tour', ['id' => $tour->id]) }}" class="btn btn-primary" role="button">Отмена тура</a>
    @endif
    @if($tour->status == 'canceled' && $tour->tour_time > now())
        <a href="{{ route('restore_tour', ['id' => $tour->id]) }}" class="btn btn-primary" role="button">Восстановить</a>
    @endif
@endsection
