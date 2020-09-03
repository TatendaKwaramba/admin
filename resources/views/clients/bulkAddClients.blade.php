@extends('layouts.app')

@section('content')

        <div class="container">
            <div class="card bg-light col-md-6 mt-3 ml-auto mr-auto">
                <div class="card-content text-center">
                    <div class="card-title">Upload Bulk Users</div>
                    <form action="{{ action('ClientController@bulkValidate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="file-field input-field">
                            <div class="btn">
                              <span>CSV File</span>
                              <input name="file" accept=".csv" type="file">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text">
                            </div>
                          </div>
                        <div class="">
                            <a type="submit" class="btn ">Validate Data</a>
                            <a class="btn waves-effect waves-light" >Submit
                                <i class="material-icons right">Download Template</i>
                            </a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>

        </div>
    </div>
    @stop