@extends('layouts.app')

@section('content')
    @if($guide->tours->isEmpty())
        <h4>No tours for selected guide</h4>
    @else
    <h3>Upcoming tours for {{ $guide->name }}</h3>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Время</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tours as $tour)
            <tr>
                <td>{{  DateTime::createFromFormat('Y-m-d', $tour->date)->format('d-m') }}</td>
                <td>{{ date('H:i', strtotime($tour->starting_time)) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('delete_guide', ['id' => $guide->id]) }}" class="btn btn-danger" role="button">Удалить гида</a>
    @endif
@endsection
