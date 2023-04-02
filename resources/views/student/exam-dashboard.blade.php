@extends('layout/layout-common')

@section('space-work')

    <div class="container">
        <p style="color: black;">Welcome, <b>{{ Auth::user()->name }}</b></p>
        <h1 class="text-center">{{ $exam[0]['exam_name'] }}</h1>

        @if ($success == true)
            @if (count($qna) > 0)
                @php
                    $counter = 1;
                @endphp
                @foreach ($qna as $test)
                    <h5>{{ $counter++ }}. {{ $test['question'][0]['question'] }}</h5>
                    @foreach ($test['question'][0]['answers'] as $answer)
                        <p>{{ $answer['answer'] }}</p>
                    @endforeach
                    <br>
                @endforeach
            @else
                <h3 style="color: red" class="text-center">Question and Answers not available.</h3>
            @endif
        @else
            <h3 style="color: red" class="text-center">{{ $msg }}</h3>
        @endif
    </div>

@endsection