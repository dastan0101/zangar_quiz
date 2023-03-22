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
                    <div class="modal-body">
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
                        })
                    } else {
                        $(".error").text("Please select correct answer!");
                    setTimeout(function() {
                        $(".error").text("");
                    }, 2000);
                    }

                }
            })
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
                
                    $(".modal-body").append(html);
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
                        if (questions[i]['answers'][j]['is_correct'] == 1) {
                            is_correct = "True";
                        }
                        html += '<tr><td>'+(j+1)+'</td> <td>'+questions[i]['answers'][j]['answer']+'</td> <td>'+is_correct+'</td> </tr>';
                    }
                    break;
                }
            }
            $('.showAnswers').html(html);
        });
    </script>
@endsection