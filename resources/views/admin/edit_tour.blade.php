@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('edit_tour', ['id' => $tour->id]) }}">
        {{ csrf_field() }}
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
                <td>{{ DateTime::createFromFormat('Y-m-d', $tour->date)->format('d-m') }}</td>
                <td>{{ date('H:i', strtotime($tour->starting_time)) }}</td>
                <td>
                    @if($tour->status == 'pending')
                        <input type="number" name="capacity" value="{{ $tour->capacity }}">
                    @else
                        <input type="hidden" name="capacity" value="{{ $tour->capacity }}">
                        {{ $tour->capacity }}
                    @endif
                </td>
                <td>{{ $tour->status }}</td>
                <td>
                    @if($tour->status == 'pending')
                        <select name="guide">
                            @if($tour->guide)
                                <option value="{{ $tour->guide->id }}">{{ $tour->guide->name }}</option>
                            @endif
                            @foreach($guides as $guide)
                                <option value="{{ $guide->id }}">{{ $guide->name }}</option>
                            @endforeach
                            @else
                                @if($tour->guide)
                                    {{ $tour->guide->name }}
                                @else
                                    Guide not set
                                @endif
                            @endif
                        </select>
                </td>
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
                @foreach($tour->bookings as $booking)
                    <td>{{ $booking->reserved_number }}</td>
                    <td>
                        @if($tour->status == "finished")
                            <select name="people[]">
                                <option>{{ $booking->reserved_number }}</option>
                                @for($i=0; $i<20; $i++)
                                    <option>{{ $i }}</option>
                                @endfor
                            </select>
                        @endif
                    </td>
                    <td>{{ $booking->names}}</td>
                    <td>{{ $booking->user->name}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-secondary">Submit</button>
        <a href="{{ url()->previous() }}" class="btn btn-primary" role="button">Назад</a>
    </form>
@endsection
