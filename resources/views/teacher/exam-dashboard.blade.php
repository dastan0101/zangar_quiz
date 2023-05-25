@extends('layout/teacher-layout')

@section('space-work')

    <h2>Exams</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModel">
        Add Exam
    </button>  
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Exam</th>
                <th scope="col">Subject</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Attempt</th>
                <th scope="col">Add Questions</th>
                <th scope="col">Show Questions</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            @if (count($exams) > 0)
                @php
                    $count = 1;
                @endphp
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subjects[0]['subject'] }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->time }} hours</td>
                        <td>{{ $exam->attempt }} time</td>
                        <td>
                            <a class="btn btn-success addQuestion" href="#" data-id="{{ $exam->id }}" data-toggle="modal" data-target="#addQnaModel"><i class="fa fa-plus-circle"></i></a>
                        </td>
                        <td>
                            <a class="btn bg-bg1 showQuestion" href="#" data-id="{{ $exam->id }}" data-toggle="modal" data-target="#showQnaModel"><i class="fa fa-eye"></i></a>
                        </td>
                        <td>
                            <button class="btn btn-info editButton" 
                                    data-id="{{ $exam->id }}" 
                                    data-toggle="modal" 
                                    data-target="#editExamModel">
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" 
                                    data-id="{{ $exam->id }}" 
                                    data-toggle="modal" 
                                    data-target="#deleteExamModel">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">Exams not found...</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Exam Modal -->
    <div class="modal fade" id="addExamModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamTitle">Add Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addExam">
                @csrf
                    <div class="modal-body">
                        <label>Exam Name</label>
                        <input type="text" name="exam_name" class="w-100 mb-3" required placeholder="Enter Exam Name">
                        <br>
                        <label>Subject</label>
                        <select name="subject_id" class="w-100 mb-3" required>
                            <option value="">Select Subject</option>
                            @if (count($subjects) > 0)
                                @foreach ($subjects as $subject)
                                    <option class="w-100" value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                @endforeach
                            @else
                                
                            @endif
                        </select>
                        <br>
                        <label>Date</label>
                        <input type="date" name="date" class="w-100 mb-3" required min="@php echo date('Y-m-d'); @endphp">
                        <br>
                        <label>Time</label>
                        <input type="time" name="time" class="w-100 mb-3" required>
                        <br>
                        <label>Attempt</label>
                        <input type="number" name="attempt" class="w-100 mb-3" min="1" placeholder="Enter Exam Attempt Time" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Exam Modal -->
    <div class="modal fade" id="editExamModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExamTitle">Edit Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editExam">
                @csrf
                    <div class="modal-body">
                        <label>Exam Name</label>
                        <input type="hidden" name="exam_id" id="exam_id">
                        <input type="text" class="w-100 mb-3" name="exam_name" id="exam_name" required placeholder="Enter Exam Name">
                        <br>
                        <label>Subject</label>
                        <select name="subject_id" class="w-100 mb-3" id="subject_id" required>
                            <option value="">Select Subject</option>
                            @if (count($subjects) > 0)
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                @endforeach
                            @else
                                
                            @endif
                        </select>
                        <br>
                        <label>Date</label>
                        <input type="date" class="w-100 mb-3" name="date" id="date" required min="@php echo date('Y-m-d'); @endphp">
                        <br>
                        <label>Time</label>
                        <input type="time" class="w-100 mb-3" name="time" id="time" required>
                        <br>
                        <label>Attempt</label>
                        <input type="number" class="w-100 mb-3" name="attempt" id="attempt" min="1" placeholder="Enter Exam Attempt Time" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Exam Modal -->
    <div class="modal fade" id="deleteExamModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamTitle">Edit Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteExam">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="delete_exam_id">
                        <p>Are you sure to delete this Exam?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Question & Answer Modal -->
    <div class="modal fade" id="addQnaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQnaTitle">Add Q&A</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addQna">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="addExamId">
                        <input type="search" name="search" id="search" onkeyup="searchTable()" class="w-100" placeholder="Search here">
                        <br>
                        <table class="table" id="questionsTable">
                            <thead>
                                <th>Select</th>
                                <th>Question</th>
                            </thead>
                            <tbody class="addBody">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Q&A</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Show Question & Answer Modal -->
    <div class="modal fade" id="showQnaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showQnaTitle">Show Q&A</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Question</th>
                                <th>Delete</th>
                            </thead>
                            <tbody class="showQuestionTable">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#addExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('teacherAddExam') }}",
                    type:"POST",
                    data:formData,
                    success:function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                })
            });

            // edit exam
            $(".editButton").click(function() {
                var id = $(this).attr('data-id');

                var url = '{{ route("teacherGetExamDetail", "id") }}';
                url = url.replace('id', id);

                $("#exam_id").val(id);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        if (data.success == true) {
                            var exam = data.data;
                            $("#exam_name").val(exam[0].exam_name);
                            $("#subject_id").val(exam[0].subject_id);
                            $("#date").val(exam[0].date);
                            $("#time").val(exam[0].time);
                            $("#attempt").val(exam[0].attempt);
                        } else {
                            alert(data.msg);
                        }
                    }

                });
            });

            $("#editExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('teacherEditExam') }}",
                    type:"POST",
                    data:formData,
                    success:function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            // delete subject
            $(".deleteButton").click(function() {
                var exam_id = $(this).attr('data-id');

                $("#delete_exam_id").val(exam_id);
            });

            $("#deleteExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('teacherDeleteExam') }}",
                    type:"POST",
                    data:formData,
                    success:function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                })
            });

            // add questions part
            $('.addQuestion').click(function() {
                var id = $(this).attr('data-id');
                $('#addExamId').val(id);

                $.ajax({
                    url:"{{ route('teacherGetQuestions') }}",
                    type:"GET",
                    data:{exam_id:id},
                    success:function(data) {
                        if(data.success == true) {
                            console.log(data);
                            var questions = data.data;
                            var html = '';
                            if(questions.length > 0) {
                                for (let i = 0; i < questions.length; i++) {
                                    html += '<tr><td><input type="checkbox" value="'+
                                        questions[i]['id']+
                                        '" name="questions_ids[]"></td><td>'
                                            +questions[i]['questions']+'</td></tr>';
                                }
                            } else {
                                html += '<tr><td colspan="2">Questions not available!</td></tr>';
                            }

                            $('.addBody').html(html);
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            $("#addQna").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('teacherAddQuestions') }}",
                    type:"POST",
                    data:formData,
                    success:function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                })
            });

            // show exam questions
            $('.showQuestion').click(function() {
                var id = $(this).attr('data-id');

                $.ajax({
                    url:"{{ route('teacherGetExamQuestions') }}",
                    type:"GET",
                    data:{exam_id:id},
                    success:function(data) {
                        var html = '';
                        var questions = data.data;
                        if (questions.length > 0) {
                            for (let i = 0; i < questions.length; i++) {

                                html += '<tr><td>'+(i+1)+'</td><td>'+questions[i]['question'][0]['question']+'</td><td><button class="btn btn-danger deleteQuestion" data-id="'+questions[i]['id']+'"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';

                            }
                        } else {
                            html += '<tr><td colspan="1">Questions not available</td></tr>';
                        }

                        $('.showQuestionTable').html(html);
                    }
                });
            });

            // delete questions from exam
            $(document).on('click', '.deleteQuestion', function() {
                var id = $(this).attr('data-id');
                var object = $(this); 
                $.ajax({
                    url:"{{ route('teacherDeleteExamQuestions') }}",
                    type:"GET",
                    data:{id:id},
                    success:function(data) {
                        if (data.success == true) {
                            object.parent().parent().remove();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });
        });
    </script>

    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById('search');
            filter = input.value.toUpperCase();
            table = document.getElementById('questionsTable');
            tr = table.getElementsByTagName('tr');
            for (let i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName('td')[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }                
            }
        }
    </script>
@endsection