@extends('layouts.app')

@section('content')

    <form method="post" action="new" class="container center_div text-center">
        {{ csrf_field() }}

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::has('message'))
            <div class="alert alert-info">
                {{ Session::get('message') }}
            </div>
        @endif

        @if(Auth::user())
            <input type="hidden" name="user_id" value={{ Auth::user()->id }}>
        @else
            <input type="hidden" name="user_id" value=2>
        @endif

        <div class="form-group">
            <label for="exampleInputEmail1">Дата тура</label>
            <input type="hidden" name="date" class="form-control" value="{{ $tour->date }}">
            <p>{{ $tour->date }}</p>
        </div>

        <div class="form-group">
            <label for="time">Время тура:</label>
            <input type="hidden" name="time" class="form-control" value="{{ $tour->starting_time }}">
            <p>{{ $tour->starting_time }}</p>
        </div>

        <div class="form-group">
            <label for="people">Введите количество человек</label>
            <select name="people" class="form-control">
                @for($i=1; $i<21; $i++)
                    <option>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="names">Введите имя</label>
            <input type="string" required class="form-control" placeholder="Names" name="names">
        </div>

        <div class="form-group">
            <h4>Choose tour snack</h4>
            <br>
            @foreach($menu as $item)
                <label>{{ $item->name }}</label>
                <input type="hidden" name="item_id[]" value={{ $item->id }}>
                <select name="items[]">
                    @for($i=0; $i<10; $i++)
                        <option>{{ $i }}</option>
                    @endfor
                </select>
                <br>
                <br>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary" role="button">Submit</button>
        <a href="{{ url()->previous() }}" class="btn btn-primary" role="button">Back</a>
    </form>
@endsection