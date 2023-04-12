@extends('layout/layout-common')

@section('space-work')

    <div class="word">
        <div class="welcome">
            <h3>Welcome to the</h3>
            <h1>Zangar <span>Quiz</span></h1>
            <h6>You are required to attach an email address and password to the "login" before entering the quiz</h6>
        </div>
        <div class="buttons">
            <button>LEARN MORE</button>
            <img src="{{ asset('images/play.svg') }}" alt="">
        </div>
    </div>


    <div class="login">
            <img src="{{ asset('images/logo.png') }}" alt="">
            <h1 id="wordLogin">LOGIN</h1>
            @if ($errors->any()) 

                @foreach ($errors->all() as $error) 
                    <p style="color:red">{{ $error }}</p>
                @endforeach
                
            @endif

            @if (Session::has('error'))
                <p style="color:green">{{ Session::get('error') }}</p>
            @endif

            <form  action="{{ route('userLogin') }}" method="GET">
                @csrf
                <input id="email" type="email" name="email"  placeholder="ENTER EMAIL">
                <input id="pass" type="password" name="password" placeholder="PASSWORD">
                <button id="button" type="submit">LOGIN</button>
            </form>

            <a id="forget" href="/forget-password">Forget Password</a>
    </div>

@endsection