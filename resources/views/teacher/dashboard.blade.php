@extends('layout/teacher-layout')

@section('space-work')
    <h2>My Subjects</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Subject</th>
                <th scope="col">Teacher</th>
            </tr>
        </thead>
        <tbody>
            @if (count($subjects) > 0)

                @foreach ($subjects as $subject)
                @if ($subject->teacher_id === Auth::user()->id)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>
                            <a href="/teacher/course-{{ $subject->id }}" id="go_subject" data-id="{{ $subject->id }}">{{ $subject->subject }}</a>
                        </td>
                        <td>
                            {{ Auth::user()->name }} (You)
                        </td>
                    </tr>
                @endif
                @endforeach
            @else
                <tr>
                    <td colspan="4">Subjects not found...</td>
                </tr>
            @endif
        </tbody>
    </table>

@endsection