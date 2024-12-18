@extends('layouts.app')

@section('content')
    <form method="get" action="date_guide">

        @if(Session::has('message'))
            <div class="alert alert-info">
                {{ Session::get('message') }}
            </div>
        @endif

        <div class="container">
            <h4>Показать туры на дату</h4>
            <div class="form-group">
                <table class="table table-bordered" id="dynamic_field">

                    <tr>
                        <td><input type="date" name="date" class="form-control name_list"/></td>
                        <td>
                            <button type="submit" class="btn btn-secondary" role="button">Submit</button>
                        </td>
                    </tr>
                </table>

                <h4>Upcoming tours:</h4>
                <table class="table table-bordered">
                    @for($a=0; $a < sizeof($tours); $a++)
                        <tr>
                            @for($i = 0; $i < 6; $i++)
                                @if($a == sizeof($tours) - 1)
                                    @break
                                @endif
                                <td>
                                    <a href="{{route('date_guide', ['date' => $tours[$a]->date]) }}">{{ DateTime::createFromFormat('Y-m-d', $tours[$a++]->date)->format('d-m') }}</a>
                                </td>
                            @endfor
                            <td>
                                <a href="{{ route('date_guide', ['date' => $tours[$a]->date]) }}">{{ DateTime::createFromFormat('Y-m-d', $tours[$a]->date)->format('d-m') }}</a>
                            </td>
                        </tr>
                    @endfor
                </table>
            </div>
        </div>
    </form>
@endsection
