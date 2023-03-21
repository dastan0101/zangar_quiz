@extends('layout/admin-layout')

@section('space-work')

    <h2>Exams</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModel">
        Add Exam
    </button>  
    
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

            // edit subject
            $(".editButton").click(function() {
                var subject_id = $(this).attr('data-id');
                var subject = $(this).attr('data-subject');

                $("#edit_subject_id").val(subject_id);
                $("#edit_subject").val(subject);
            });

            $("#editSubject").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('editSubject') }}",
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