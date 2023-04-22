@extends('layout/admin-layout')

@section('space-work')

    <h2>Students</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">
        Add Student
    </button>  
    
    {{-- Table --}}
    <table class="table">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
            @if (count($students) > 0)
                @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <button type="button" data-id="{{ $student->id }}" data-name="{{ $student->name }}" data-email="{{ $student->email }}" class="btn btn-info editButton" data-toggle="modal" data-target="#editStudentModal">
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" data-id="{{ $student->id }}" class="btn btn-danger deleteButton" data-toggle="modal" data-target="#deleteStudentModal">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                    
                @endforeach
            @else
                <tr>
                    <td colspan="3">No students yet...</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamTitle">Add Student</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="w-100" name="name" placeholder="Enter Student Name" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input type="email" class="w-100" name="email" placeholder="Enter Student Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    {{-- Edit Student Modal --}}
    <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExamTitle">Edit Student</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="id" id="id">
                                <input type="text" class="w-100" name="name" id="name" placeholder="Enter Student Name" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input type="email" class="w-100" name="email" id="email" placeholder="Enter Student Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary editBtn">Edit Student</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>


    {{-- Delete Student Modal --}}
    <div class="modal fade" id="deleteStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Delete Student</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteStudent">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete this Student</p>
                        <input type="hidden" name="id" id="student_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete Student</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            // add student
            $("#addStudent").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('addStudent') }}",
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
            
            // Edit student
            $(".editButton").click(function() {
                $("#id").val( $(this).attr('data-id') );
                $("#name").val( $(this).attr('data-name') );
                $("#email").val( $(this).attr('data-email') );
            });

            $("#editStudent").submit(function(e) {
                e.preventDefault();

                $(".editBtn").prop('disabled', true);

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('editStudent') }}",
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

            // delete student
            $(".deleteButton").click(function() {
                $('#student_id').val( $(this).attr('data-id') );
            });

            $("#deleteStudent").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('deleteStudent') }}",
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

        });
    </script>
@endsection