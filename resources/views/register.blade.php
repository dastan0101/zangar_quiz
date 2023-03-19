@extends('layout/layout-common')

@section('space-work')

    <h1>Registration</h1>

    @if ($errors->any()) 

        @foreach ($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
        
    @endif

    <form action="{{ route('studentRegister') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Enter Full Name">
        <input type="email" name="email"  placeholder="Enter email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="password_confirmation" placeholder="Password Confirmation">
        <button type="submit">Register</button>
    </form>

      @if (Session::has('success'))
          <p style="color:green">{{ Session::get('success') }}</p>
      @endif

@endsection