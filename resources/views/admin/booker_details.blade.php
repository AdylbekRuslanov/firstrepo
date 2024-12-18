@extends('layouts.app')

@section('content')
    <form method="get" action="get_details">
        <div class="container">
            <div class="form-group">
                <h4>Показать детали пароля</h4>
                <table class="table table-bordered" id="dynamic_field">
                    <tr>
                        <td><input type="date" name="begin" class="form-control name_list"/></td>
                        <td><input type="date" name="end" class="form-control name_list"/></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="booker" class="form-control">
                                @foreach($bookers as $booker)
                                    <option>{{ $booker->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-secondary" role="button">Submit</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
@endsection
