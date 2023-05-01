@extends('layout/admin-layout')

@section('space-work')
    <h2>Subjects</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubjectModel">
        Add Subject
    </button>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Subject</th>
                <th scope="col">Teacher</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            @if (count($subjects) > 0)
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>
                            <a href="/admin/course-{{ $subject->id }}" id="go_subject" data-id="{{ $subject->id }}">{{ $subject->subject }}</a>
                        </td>
                        <td>
                            @php
                            $teacher_name = '';
                                foreach ($teachers as $teacher) {
                                   if ($teacher['id'] === $subject->teacher_id) {
                                        $teacher_name = $teacher['name'];
                                   }
                                }
                            @endphp
                            {{ $teacher_name }}
                        </td>
                        <td>
                            <button class="btn btn-info editButton" 
                                    data-id="{{ $subject->id }}" 
                                    data-subject="{{ $subject->subject }}" 
                                    data-teacher_id="{{ $subject->teacher_id }}" 
                                    data-toggle="modal" 
                                    data-target="#editSubjectModel">
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" 
                                    data-id="{{ $subject->id }}" 
                                    data-toggle="modal" 
                                    data-target="#deleteSubjectModel">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">Subjects not found...</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Subject Modal -->
    <div class="modal fade" id="addSubjectModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectTitle">Add Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addSubject">
                    @csrf
                    <div class="modal-body">
                        <label>Subject</label>
                        <input type="text" class="w-100" name="subject" required placeholder="Enter Subject Name">
                        <label>Teacher</label>
                        <select name="teacher_id" class="w-100 mb-3" required>
                            <option value="">Select Teacher</option>
                            @if (count($teachers) > 0)
                                @foreach ($teachers as $teacher)
                                    <option class="w-100" value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            @else
                                <option class="w-100" value="There are no teachers yet)">There are no teachers yet</option>
                            @endif
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
            
        
        </div>
    </div>

    
    <!-- Edit Subject Modal -->
    <div class="modal fade" id="editSubjectModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubjectTitle">Edit Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editSubject">
                @csrf
                    <div class="modal-body">
                        <label>Subject</label>
                        <input type="text" class="w-100" name="subject" id="edit_subject" required placeholder="Enter Subject Name">
                        <input type="hidden" name="id" id="edit_subject_id">
                        <label>Teacher</label>
                        <select name="teacher_id" class="w-100 mb-3" id="edit_teacher_id" required>
                            <option value="">Select Teacher</option>
                            @if (count($teachers) > 0)
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            @else
                                
                            @endif
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        
    <!-- Delete Subject Modal -->
    <div class="modal fade" id="deleteSubjectModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSubjectTitle">Delete Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteSubject">
                @csrf
                    <div class="modal-body">
                        <p>Are you sure to delete this Subject?</p>
                        <input type="hidden" name="id" id="delete_subject_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

 
    <script>
        $(document).ready(function() {
            $("#addSubject").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('addSubject') }}",
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
                var teacher_id = $(this).attr('data-teacher_id');

                $("#edit_subject_id").val(subject_id);
                $("#edit_subject").val(subject);
                $("#edit_teacher_id").val(teacher_id);
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