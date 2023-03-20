@extends('layout/layout-common')

@section('space-work')

    <h1>Login</h1> 

    @if ($errors->any()) 

        @foreach ($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
        
    @endif

    @if (Session::has('error'))
        <p style="color:green">{{ Session::get('error') }}</p>
    @endif

    <form action="{{ route('userLogin') }}" method="GET">
        @csrf
        <input type="email" name="email"  placeholder="Enter email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>

    <a href="/forget-password">Forget Password</a>

@endsection