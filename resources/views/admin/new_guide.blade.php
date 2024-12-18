@extends('layouts.app')

@section('content')
    <form method="post" action="new_guide">
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

        <div class="container">
            <h4>Имя гида</h4>
            <div class="form-group">
                <table class="table table-bordered" id="dynamic_field">
                    <tr>
                        <td><input type="text" name="name" required class="form-control name_list"/></td>
                        <td>
                            <button type="submit" class="btn btn-secondary" role="button">Submit</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
@endsection
