@extends('layout/layout-common')


@section('space-work')

    <div class="container">
        <div class="text-center">
            <h2>Thank you for passing your exam, <b>{{ Auth::user()->name }}</b></h2>

            <a href="/dashboard" class="btn btn-info">Go to dashboard</a>
        </div>
    </div>

@endsection