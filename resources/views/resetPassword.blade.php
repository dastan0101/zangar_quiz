@extends('layout/layout-common')

@section('space-work')

    <h1>Reset Password</h1> 

    @if ($errors->any()) 

        @foreach ($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
        
    @endif


    <form action="{{ route('resetPassword') }}" method="POST">
        @csrf
        <input type="hidden" name="id"  value="{{ $user[0]['id'] }}">
        <input type="password" name="password" placeholder="Enter New Password">
        <input type="password" name="password_confirmation" placeholder="Enter Confirmation Password">
        <button type="submit">Reset Password</button>
    </form>

    <a href="/">Login</a>

@endsection