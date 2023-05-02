@extends('layout/teacher-layout')

@section('space-work')
    <h2>{{ $subject->subject }}</h2>

    
    <table class="table">
        <caption>Course Detail</caption>
        <thead>
            <tr>
                <th scope="col">Course ID</th>
                <th scope="col">{{ $subject->id }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Course Name</th>
                <td>{{ $subject->subject }}</td>
            </tr>
            <tr>
                <th scope="row">Teacher Name</th>
                <td><b>{{ $teacher->name }}</b> <i>(You)</i></td>
            </tr>
            
        </tbody>
    </table>

    @if (count($course_material) > 0)
        @foreach ($course_material as $lesson)

            <div class="card w-100 mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <video src="{{ URL::asset("/uploads/videos/$lesson->video") }}" class="card-img-top" controls></video>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h3 class="card-title">{{ $lesson->title }}</h3>
                            <p class="card-text">{{ $lesson->description }}</p>
                            <h6><a href="{{ url('/teacher/download-presentation', $lesson->presentation) }}"><i class="fa-solid fa-file-powerpoint"></i>  {{ $lesson->presentation }}</a></h6>
                            <p class="card-text"><small class="text-muted">{{ $lesson->updated_at }}</small></p>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="card-body">
                            <button class="btn btn-info editButton" 
                                    data-id="{{ $lesson->id }}" 
                                    data-toggle="modal" 
                                    data-target="#editCourseMaterialModal">
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-danger deleteButton" 
                                    data-id="{{ $lesson->id }}" 
                                    data-toggle="modal" 
                                    data-target="#deleteCourseMaterialModal">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    
        @endforeach
    @endif

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSectionModal">
        Add Section
    </button>
    
    <!-- Section Modal -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSectionTitle">Add Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addSection" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="modal-body">
                        <label>Section Name</label>
                        <input type="text" class="w-100" name="title" required placeholder="Enter Section Name">
                        <input type="hidden" name="course_id" id="course_id" data-id="{{ $subject->id }}" value="{{ $subject->id }}">
                        <label class="mt-3">Description</label>
                        <textarea name="description" id="description" class="w-100" placeholder="Enter Section Description"></textarea>
                        
                        <div class="colum mt-2">
                            <label for="">Presentation</label>
                            <input type="file" class="form-control-input w-100" name="presentation" id="inputFile1" accept=".ppt, .pptx, .pdf, .doc, .docx">
                        </div>

                        <div class="colum mt-2">
                            <label for="">Video</label>
                            <input type="file" class="form-control-input w-100" name="video" id="inputFile2" accept=".mp4, .mov, .org">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p class="message"></p>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary add-section">Add</button>
                    </div>
                </form>
            </div>
            
        
        </div>
    </div>

    <!-- Edit Course Material Modal -->
    <div class="modal fade" id="editCourseMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseMaterialTitle">Edit Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCourseMaterial">
                @csrf
                    <div class="modal-body">

                        <label>Section Name</label>
                        <input type="text" class="w-100" name="title" id="edit_title" required placeholder="Enter Section Name">
                        <input type="hidden" name="id" id="edit_course_material_id">

                        <label class="mt-3">Description</label>
                        <textarea name="description" id="edit_description" class="w-100" placeholder="Enter Section Description"></textarea>
                        
                        <div class="colum mt-2">
                            <label for="">Presentation</label>
                            <input type="file" class="form-control-input w-100" name="presentation" id="edit_presentation" required accept=".ppt, .pptx, .pdf, .jpeg, .jpg, .png">
                        </div>

                        <div class="colum mt-2">
                            <label for="">Video</label>
                            <input type="file" class="form-control-input w-100" name="video" id="edit_video" required accept="video/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
        
    <!-- Delete Course Material Modal -->
    <div class="modal fade" id="deleteCourseMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCourseMaterialTitle">Delete Course Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteCourseMaterial">
                @csrf
                    <div class="modal-body">
                        <p>Are you sure to delete this Section?</p>
                        <input type="hidden" name="id" id="delete_course_material_id">
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
            $("#addSection").on('submit', function(event){
                event.preventDefault();
                $('.add-section').html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                $.ajax({
                    url:"{{ route('teacherAddCourseMaterials') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    cache:false,
                    processData:false,
                    success:function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            }); 

            // edit course material
            $(".editButton").click(function() {
                var id = $(this).attr('data-id');

                $("#edit_course_material_id").val(id);

                var url = '{{ route("teacherGetCourseMaterial", "id") }}';
                url = url.replace('id', id);

                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(data) {
                        if (data.success == true) {
                            var course_material = data.data;
                            $("#edit_title").val(course_material[0].title);
                            $("#edit_description").val(course_material[0].description);
                            console.log(course_material[0].video);
                            $("#edit_presentation").val(course_material[0].presentation);
                            $("#edit_video").val(course_material[0].video);
                        } else {
                            alert(data.msg);
                        }
                    }

                });
            });

            $("#editCourseMaterial").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url:"{{ route('teacherEditCourseMaterial') }}",
                    type:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    cache:false,
                    processData:false,
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
                var id = $(this).attr('data-id');

                $("#delete_course_material_id").val(id);
            });

            $("#deleteCourseMaterial").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url:"{{ route('teacherDeleteCourseMaterial') }}",
                    type:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    cache:false,
                    processData:false,
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