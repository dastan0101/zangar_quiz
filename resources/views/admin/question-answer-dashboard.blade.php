@extends('layout/admin-layout')

@section('space-work')

    <h2>Q&A</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQnaModal">
        Add Q&A
    </button>  
    
    {{-- Table --}}
    <table class="table">
        <thead>
            <th>#</th>
            <th>Question</th>
            <th>Answers</th>
            <th>Edit</th>
        </thead>
        <tbody>
            @if (count($questions) > 0)
                @foreach ($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->question }}</td>
                    <td>
                        <a href="" class="ansButton btn btn-success" data-id="{{ $question->id }}" data-toggle="modal" data-target="#showAnswersModal">
                            See Answers
                        </a>
                    </td>
                    <td>
                        <button href="" class="editButton btn btn-info" data-id="{{ $question->id }}" data-toggle="modal" data-target="#editQnaModal">
                            Edit
                        </button>
                    </td>
                </tr>
                    
                @endforeach
            @else
                <tr>
                    <td colspan="3">No questions yet...</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Question and Answer Modal -->
    <div class="modal fade" id="addQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamTitle">Add Q&A</h5>

                    <button id="addAnswer" class="ml-5 btn btn-info">Add Answer</button>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addQna">
                    @csrf
                    <div class="modal-body addModalAnswers">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="w-100" name="question" placeholder="Enter Question" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p class="error" style="color:red"></p>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Q&A</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <!-- Edit Question and Answer Modal -->
    <div class="modal fade" id="editQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamTitle">Edit Q&A</h5>

                    <button id="addEditAnswer" class="ml-5 btn btn-info">Add Answer</button>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editQna">
                    @csrf
                    <div class="modal-body editModalAnswers">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="question_id" id="question_id">
                                <input type="text" class="w-100" id="question" name="question" placeholder="Enter Question" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p class="editError" style="color:red"></p>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit Q&A</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    
    <!-- Show Answers Modal -->
    <div class="modal fade" id="showAnswersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamTitle">Show Answer</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Answer</th>
                            <th>Is Correct</th>
                        </thead>
                        <tbody class="showAnswers">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <p class="error" style="color:red"></p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // question
        $(document).ready(function(){
            // add
            $("#addQna").submit(function (e) {
                e.preventDefault();

                if ($(".answers").length < 2) {
                    $(".error").text("Please add minimum 2 answers!");
                    setTimeout(function() {
                        $(".error").text("");
                    }, 2000);
                } else {
                    
                    var checkIsCorrect = false;

                    for (let i = 0; i < $('.is_correct').length; i++) {
                        if ($('.is_correct:eq('+i+')').prop('checked') == true) {
                            checkIsCorrect = true;
                            $('.is_correct:eq('+i+')').val($('.is_correct:eq('+i+')').next().find('input').val())
                        }
                    }

                    if (checkIsCorrect) {
                        var formData = $(this).serialize();

                        $.ajax({
                            url:"{{ route('addQna') }}",
                            type:"POST",
                            data:formData,
                            success:function(data) {
                                console.log(data);
                                if (data.success == true) {
                                    location.reload();
                                } else {
                                    alert(data.msg);
                                }
                            }
                        });
                    } else {
                        $(".error").text("Please select correct answer!");
                    setTimeout(function() {
                        $(".error").text("");
                    }, 2000);
                    }

                }
            });

            // answer
            $("#addAnswer").click(function() {

                if ($(".answers").length >= 6) {
                        $(".error").text("You can add maximum 6 answers!");
                        setTimeout(function() {
                            $(".error").text("");
                        }, 2000);
                    } else {
                        var html = '<div class="row answers ml-1 mt-2 mr-1"><input type="radio" name="is_correct" class="is_correct"><div class="col"><input type="text" class="w-100" name="answers[]" placeholder="Enter Answers" required></div><button class="btn btn-danger removeBtn">Remove</button></div>';
                    
                        $(".addModalAnswers").append(html);
                    }
            });

            $(document).on('click', '.removeBtn', function() {
                $(this).parent().remove();
            });

            // show answer
            $(".ansButton").click(function() {
                var questions = @json($questions);
                var questionId = $(this).attr('data-id');
                var html = '';

                for (let i = 0; i < questions.length; i++) {
                    if (questions[i]['id'] == questionId) {
                        var answersLen = questions[i]['answers'].length;
                        
                        for (let j = 0; j < answersLen; j++) {
                            let is_correct = "False";
                            let style = "";
                            if (questions[i]['answers'][j]['is_correct'] == 1) {
                                is_correct = "True";
                                style = 'style="color:green; weight:bold;"';
                            }
                            html += '<tr><td>'+(j+1)+'</td> <td>'+questions[i]['answers'][j]['answer']+'</td> <td '+style+'">'+is_correct+'</td> </tr>';
                        }
                        break;
                    }
                }
                $('.showAnswers').html(html);
            });

            // edit answer
            $("#addEditAnswer").click(function() {

                if ($(".editAnswers").length >= 6) {
                    $(".editError").text("You can add maximum 6 answers!");
                    setTimeout(function() {
                        $(".editError").text("");
                    }, 2000);
                } else  {
                    var html = '<div class="row editAnswers ml-1 mt-2 mr-1"><input type="radio" name="is_correct" class="edit_is_correct"><div class="col"><input type="text" class="w-100" name="new_answers[]" placeholder="Enter Answers" required></div><button class="btn btn-danger removeBtn">Remove</button></div>';
                
                    $(".editModalAnswers").append(html);
                }
            });

            $(".editButton").click(function() {
                var questionId = $(this).attr('data-id');

                $.ajax({
                    url:"{{ route('getQnaDetails') }}",
                    type:"GET",
                    data:{questionId:questionId},
                    success:function(data) {
                        console.log(data);
                        var qna = data.data[0];
                        $("#question_id").val(qna['id']);
                        $("#question").val(qna['question']);
                        $(".editAnswers").remove();

                        var html = '';
                        
                        for (let i = 0; i < qna['answers'].length; i++) {

                            var checked = '';
                            if (qna['answers'][i]['is_correct'] == 1) {
                                checked = 'checked';
                            }

                            html += '<div class="row editAnswers ml-1 mt-2 mr-1"><input type="radio" '+checked+' name="is_correct" class="edit_is_correct"><div class="col"><input type="text" class="w-100" name="answers['+qna['answers'][i]['id']+']" placeholder="Enter Answers" value="'+qna['answers'][i]['answer']+'" required></div><button class="btn btn-danger removeBtn removeAnswer" data-id="'+qna['answers'][i]['id']+'">Remove</button></div>';
                        }
                        $(".editModalAnswers").append(html);
                    }
                });
            });

            // Edit Qna submission
            $("#editQna").submit(function (e) {
                e.preventDefault();

                if ($(".editAnswers").length < 2) {
                    $(".editError").text("Please add minimum 2 answers!");
                    setTimeout(function() {
                        $(".editError").text("");
                    }, 2000);
                } else {
                    
                    var checkIsCorrect = false;

                    for (let i = 0; i < $('.edit_is_correct').length; i++) {
                        if ($('.edit_is_correct:eq('+i+')').prop('checked') == true) {
                            checkIsCorrect = true;
                            $('.edit_is_correct:eq('+i+')').val($('.edit_is_correct:eq('+i+')').next().find('input').val())
                        }
                    }

                    if (checkIsCorrect) {

                        var formData = $(this).serialize();

                        $.ajax({
                            url:"{{ route('editQna') }}",
                            type:"POST",
                            data:formData,
                            success:function(data) {
                                console.log(data);
                                if (data.success == true) {
                                    location.reload();
                                } else {
                                    alert(data.msg);
                                }
                            }
                        });
                    } else {
                        $(".editError").text("Please select correct answer!");
                        setTimeout(function() {
                            $(".editError").text("");
                        }, 2000);
                    }

                }
            });

            // remove exist answer
            $(document).on('click','.removeAnswer', function() {
                var answer_id = $(this).attr('data-id');

                $.ajax({
                    url:"{{ route('deleteAnswer') }}",
                    type:"GET",
                    data:{id:answer_id},
                    success:function() {
                        if (data.success == true) {
                            location.reload();
                            // console.log(data.msg);
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

        });


    </script>
@endsection