@extends('layout/admin-layout')

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
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            @if (count($exams) > 0)
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subjects[0]['subject'] }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->time }}</td>
                        <td>
                            <button class="btn btn-info editButton" 
                                    data-id="{{ $exam->id }}" 
                                    data-subject="{{ $exam->exam_name }}" 
                                    data-toggle="modal" 
                                    data-target="#editExamModel">
                                Edit
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" 
                                    data-id="{{ $exam->id }}" 
                                    data-toggle="modal" 
                                    data-target="#deleteExamModel">
                                Delete
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
                        <input type="text" name="exam_name" required placeholder="Enter Exam Name">
                        <br>
                        <label>Subject</label>
                        <select name="subject_id" required>
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
                        <input type="date" name="date" required min="@php echo date('Y-m-d'); @endphp">
                        <br>
                        <label>Time</label>
                        <input type="time" name="time" required>
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
                        <input type="text" name="exam_name" id="exam_name" required placeholder="Enter Exam Name">
                        <br>
                        <label>Subject</label>
                        <select name="subject_id" id="subject_id" required>
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
                        <input type="date" name="date" id="date" required min="@php echo date('Y-m-d'); @endphp">
                        <br>
                        <label>Time</label>
                        <input type="time" name="time" id="time" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#addExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('addExam') }}",
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

                var url = '{{ route("getExamDetail", "id") }}';
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
                        } else {
                            alert(data.msg);
                        }
                    }

                })
            });

            $("#editExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('editExam') }}",
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

            // delete subject
            $(".deleteButton").click(function() {
                var subject_id = $(this).attr('data-id');

                $("#delete_subject_id").val(subject_id);
            });

            $("#deleteSubject").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('deleteSubject') }}",
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
        });
    </script>

@endsection