@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card bg-light col-md-12 mt-3 ml-auto mr-auto">
            <div class="card-title valign center">
                CSV Data
            </div>
            <div class="card-content valign center">

    <form class="form-horizontal">
        {{ csrf_field() }}
        <table class="table">
            @foreach ($csv_data as $row)
                @if ($loop->first)
                    <thead class="thead-dark">
                        <tr>
                            @foreach ($row as $key => $value)
                                <th>{{ $value }}</th>
                            @endforeach
                        </tr>
                    </thead>
                @endif
                @if ($row[7] == "status")
                    @continue
                @endif
                @if ($row[7] == "FAIL")
                    <tr>
                        @foreach ($row as $key => $value)
                            <td class="alert alert-danger">{{ $value }}</td>
                        @endforeach
                    </tr>
                @else
                    <tr>
                        @foreach ($row as $key => $value)
                            <td class="alert alert-success">{{ $value }}</td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </table>

    <button class="btn btn-primary">
            Back
        </button>
    </form>
</div>
</div>
</div>

</div>
</div>

@stop
  