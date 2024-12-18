@extends('layouts.app')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-info">
            {{ Session::get('message') }}
        </div>
    @endif
    <h4>Upcoming tours:</h4>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Время</th>
            <th scope="col">Вместимость</th>
            <th scope="col">Статус</th>
            <th scope="col">Гид</th>
            @if(Auth::user()->type == 'admin')
                <th scope="col">Details</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($tours as $tour)
            <tr>
                <td>{{ DateTime::createFromFormat('Y-m-d', $tour->date)->format('d-m') }}</td>
                <td>{{ date('H:i', strtotime($tour->starting_time)) }}</td>
                <td>{{ $tour->capacity - $tour->number . '/' . $tour->capacity }}</td>
                @switch($tour->status)
                    @case('finished')
                    <td><font color="black">{{ $tour->status }}</font></td>
                    @break
                    @case('pending')
                    <td><font color="green">{{ $tour->status }}</font></td>
                    @break
                    @case('running')
                    <td><font color="blue">{{ $tour->status }}</font></td>
                    @break
                    @case('canceled')
                    <td><font color="red">{{ $tour->status }}</font></td>
                    @break
                @endswitch
                @if($tour->name)
                    <td>{{ $tour->name }}</td>
                @else
                    <td>Guide not set</td>
                @endif
                @if(Auth::user()->type == ('admin'))
                    <td><a href="{{ route('tour', ['id' => $tour->id]) }}">Details</a></td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
