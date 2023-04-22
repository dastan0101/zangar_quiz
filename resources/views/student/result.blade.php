@extends('layout/student-layout')

@section('space-work')
    
    <h2>Results</h2>

    <table class="table">
        <thead>
            <tr>
                <td>#</td>
                <td>Exam</td>
                <td>Result</td>
                <td>Status</td>
            </tr>
        </thead>

        <tbody>
            
            @if (count($attempts) > 0)
                @php
                    $i = 1;
                @endphp
                @foreach ($attempts as $attempt)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $attempt->exam->exam_name }}</td>
                        <td>
                            @if ($attempt->status == 1)
                                <b>{{ $attempt->marks }} / {{ count($attempt->exam->getQnaExam) * $attempt->exam->marks }}</b> | 
                                
                                @if ($attempt->marks >= $attempt->exam->pass_marks)
                                    <span style="color:green">Passed</span>
                                @else
                                    <span style="color:red">Failed</span>
                                @endif
                                
                            @else
                                Not Announced
                            @endif
                            
                        </td>
                        <td>
                            @if ($attempt->status == 1)
                                <a href="#" data-id="{{ $attempt->id }}" class="reviewExam" data-toggle="modal" data-target="#reviewQnaModal">Review Q&A</a>
                            @else
                                <span style="color:red">Pending</span>
                            @endif
                        </td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="4">You haven't taken any exams yet</td>
                </tr>
            @endif

        </tbody>
    </table>
    
    
    <!-- Modal -->
    <div class="modal fade" id="reviewQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="reviewExamModalTitle">Review Exam</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
                <div class="modal-body review-qna">
                    Loading...
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

    <script>

        $(document).ready(function() {
            
            $('.reviewExam').click(function() {

                var id = $(this).attr('data-id');

                $.ajax({
                    url:"{{ route('reviewStudentQna') }}",
                    type:"GET",
                    data:{attempt_id: id},
                    success:function(data) {
                        var html = '';

                        if (data.success == true) {
                            
                            var data = data.data;
                            if (data.length > 0) {
                                for (let i = 0; i < data.length; i++) {

                                    let isCorrect = '<span style="color:red" class="fa fa-close"></span>';

                                    if (data[i]['answers']['is_correct'] == 1) {
                                        isCorrect = '<span style="color:green" class="fa fa-check"></span>';
                                    }

                                    let answer = data[i]['answers']['answer'];

                                    html += '<div class="row"><div class="col-sm-12"><h6>Q('+(i+1)+'). '+data[i]['question']['question']+'</h6></div></div><p>Answer:-'+answer+'  '+isCorrect+'</p>';
                                }
                            } else {
                                html += '<h6>You didn\'t attempt any Questions.</h6>';
                            }

                        } else {
                            html += '<p>There was some kind of problem on the server side.</p>';
                        }

                        $('.review-qna').html(html);
                    }
                });
            });
            
        });

    </script>
@endsection