@extends('layout/student-layout')

@section('space-work')
    <h2>Subjects</h2>

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
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>
                            <a href="/student/course-{{ $subject->id }}" id="go_subject" data-id="{{ $subject->id }}">{{ $subject->subject }}</a>
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
                        
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">Subjects not found...</td>
                </tr>
            @endif
        </tbody>
    </table>

@endsection