@extends('layout/student-layout')

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
                <td>
                    {{ $teacher->name }}
                </td>
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
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title">{{ $lesson->title }}</h3>
                            <p class="card-text">{{ $lesson->description }}</p>
                            <h6><a href="{{ url('/download-presentation', $lesson->presentation) }}"><i class="fa-solid fa-file-powerpoint"></i>  {{ $lesson->presentation }}</a></h6>
                            <p class="card-text"><small class="text-muted">{{ $lesson->updated_at }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
    
        @endforeach
    @endif

@endsection