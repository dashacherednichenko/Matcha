@extends('layouts.app')
@section('content')
    <div class="container" id="main_container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Start page...</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Page that logged-in user see...
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
