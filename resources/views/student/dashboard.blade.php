@extends('layout/student-layout')

@section('space-work')
    <h2>Exams</h2>

    <table class="table">
        <thead>
            <th>#</th>
            <th>Exam Name</th>
            <th>Subject Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Total Ateempt</th>
            <th>Availabe Ateempt</th>
            <th>Copy Link</th>
        </thead>

        <tbody>
            @if (count($exams) > 0)
                @php
                    $count = 1;
                @endphp
                @foreach ($exams as $exam)
                    <tr>
                        <td style="display: none;">{{ $exam->id }}</td>
                        <td>{{ $count++ }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subjects[0]['subject'] }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->time }}</td>
                        <td>{{ $exam->attempt }}</td>
                        <td>{{ $exam->attempt - $exam->attempt_counter }}</td>
                        <td><a href="#" data-code="{{ $exam->enterance_id }}" class="copy"><i class="fa fa-copy fa-2x"></i></a></td>
                    </tr>
                @endforeach
            
            @else
                <tr><td style="position:absolute" colspan="6">Exams not found!</td></tr>
            @endif

        </tbody>
    </table>

    <script>
        $(document).ready(function() {

            $('.copy').click(function() {
                $(this).parent().prepend('<span class="copied_text" style="position:absolute; margin-left:-70px; color:blue;">Copied</span>');

                var code = $(this).attr('data-code');
                var url = "{{ URL::to('/') }}/exam/"+code;

                var $temp = $('<input>');
                $('body').append($temp);
                $temp.val(url).select();
                document.execCommand('copy');
                $temp.remove();

                setTimeout(() => {
                    $('.copied_text').remove();
                }, 1000);
            });

        });
    </script>
@endsection