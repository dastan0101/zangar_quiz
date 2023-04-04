@extends('layout/layout-common')

@section('space-work')

    <div class="container opacity">
        <h1 style="color: black;">Welcome, <b>{{ Auth::user()->name }}</b></h1>
        <h1 class="text-center">{{ $exam[0]['exam_name'] }}</h1>
        @php $counter = 1; @endphp

        @if ($success == true)

            @if (count($qna) > 0)
                <form action="{{ route('examSubmit') }}" method="POST" class="mb-5" onsubmit="return isValid()">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam[0]['id'] }}">
                    
                    @foreach ($qna as $test)
                        <div>
                            <h5><b>{{ $counter++ }}. {{ $test['question'][0]['question'] }}</b></h5>
                            <input type="hidden" name="q[]" value="{{ $test['question'][0]['id'] }}">
                            <input type="text" name="answer_{{ $counter-1 }}" id="answer_{{ $counter-1 }}">
                            @foreach ($test['question'][0]['answers'] as $answer)
                                <p style="color: black">
                                    <input type="radio" name="radio_{{ $counter-1 }}" data-id="{{ $counter-1 }}" class="selected_answer" value="{{ $answer['id'] }}">
                                    {{ $answer['answer'] }}
                                </p>
                            @endforeach
                        </div>
                        <br>
                    @endforeach
                    <div class="text-center">
                        <input type="submit" class="btn btn-info" value="Submit">
                    </div>
                </form>
            @else
                <h3 style="color: red" class="text-center">Question and Answers not available.</h3>
            @endif
        @else
            <h3 style="color: red" class="text-center">{{ $msg }}</h3>
        @endif
    </div>

    <script>
        $(document).ready(function() {

            $('.selected_answer').click(function() {
                var no = $(this).attr('data-id');
                $('#answer_'+no).val($(this).val());
            });
            
        });

        function isValid() {
            var result = true;
            var question_length = parseInt({{ $counter }})-1;
            $('.error_msg').remove();
            
            for (let i = 1; i <= question_length; i++) {
                if ($('#answer_'+i).val() == "") {
                    result false;

                    $('#answer_'+i).parent().append('<span style="color: red;" class="error_msg">Please, select answer!</span>');
                    setTimeout(() => {
                        $('.error_msg').remove();
                    }, 5000);
                } 
            }
            return result;
        }
    </script>
@endsection