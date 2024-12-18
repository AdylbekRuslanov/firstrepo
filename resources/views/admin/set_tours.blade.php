@extends('layouts.app')

@section('content')
    <form method="post" action="set_tours">
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

        @if(Session::has('error'))
            <div class="alert alert-info">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="container">
            <h4>Set tours:</h4>
            <div class="form-group">
                <table class="table table-bordered" id="dynamic_field">

                    <tr>
                        <td><input type="date" name="begin" class="form-control name_list"/></td>
                        <td><input type="date" name="end" class="form-control name_list"/></td>
                    </tr>

                    <tr>
                        <td><input type="time" name="times[]" class="form-control name_list"/></td>
                        <td>
                            <button type="button" name="add" id="add" class="btn btn-success">Добавить больше</button>
                        </td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-secondary" role="button">Submit</button>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                var postURL = "<?php echo url('addmore'); ?>";
                var i = 1;

                $('#add').click(function () {
                    i++;
                    $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="time" name="times[]" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
                });

                $(document).on('click', '.btn_remove', function () {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
            });
        </script>
    </form>

@endsection
