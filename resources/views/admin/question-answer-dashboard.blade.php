@extends('layout/admin-layout')

@section('space-work')

    <h2>Q&A</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQnaModel">
        Add Q&A
    </button>  
    

    <!-- Exam Modal -->
    <div class="modal fade" id="addQnaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamTitle">Add Q&A</h5>

                    <button id="addAnswer" class="ml-5">Add Answer</button>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addQna">
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

    <script>
        // question
        $(document).ready(function(){
            $("#addQna").submit(function (e) {
                e.preventDefault();

                if (".answers".length > 2) {
                    $(".error").text("Please add minimum 2 answers!");
                    setTimeout(function() {
                        $(".error").text("");
                    }, 2000);
                } else {
                    
                }
            })
        });

        // answer
        $("#addAnswer").click(function() {

            if (".answers".length < 6) {
                    $(".error").text("You can add maximum 6 answers!");
                    setTimeout(function() {
                        $(".error").text("You can add maximum 6 answers!");
                    }, 2000);
                } else {
                    var html = '<div class="row answers ml-1 mt-2 mr-1"><input type="radio" name="is_correct" class="is_correct"><div class="col"><input type="text" class="w-100" name="answers[]" placeholder="Enter Answers" required></div><button class="btn btn-danger">Remove</button></div>';
                
                    $(".modal-body").append(html);
                }

        
        });
    </script>
@endsection