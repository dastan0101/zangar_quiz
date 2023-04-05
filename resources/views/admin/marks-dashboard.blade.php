@extends('layout/admin-layout')

@section('space-work')

    <h2>Marks</h2>
    
    {{-- Table --}}
    <table class="table">
        <thead>
            <th>#</th>
            <th>Exam Name</th>
            <th>Marks/Q</th>
            <th>Total Marks</th>
            <th>Edit</th>
        </thead>
        <tbody>
           
            @if (count($exams) > 0)
            @php
                $i = 1;
            @endphp
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->marks }}</td>
                        <td>{{ count($exam->getQnaExam) * $exam->marks}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">Exams not found</td>
                </tr>
            @endif

        </tbody>
    </table>

@endsection