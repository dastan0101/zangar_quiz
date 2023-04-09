@extends('layout/admin-layout')

@section('space-work')

    <h2>Student Exams</h2>
    
    {{-- Table --}}
    <table class="table">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Exam</th>
            <th>Status</th>
            <th>Review</th>
        </thead>
        <tbody>
            
            @if (count($attempts) > 0)
                @php
                    $i = 1;
                @endphp
                @foreach ($attempts as $attempt)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $attempt->user->name ?? "" }}</td>
                        <td>{{ $attempt->exam->exam_name }}</td>
                        <td>
                            @if ($attempt->status == 0)
                                <span style="color:red">Pending</span>
                            @else
                                <span style="color:green">Approved</span>
                            @endif
                        </td>
                        <td>
                            @if ($attempt->status == 0)
                                <a href="#" class="reviewExam" data-id="{{ $attempt->exam->id }}" data-toggle="modal" data-target="#reviewExamModal">Review & Approved</a>
                            @else
                                Completed
                            @endif
                        </td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="5">The students have not passed the exams yet</td>
                </tr>
            @endif

        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="reviewExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="reviewExamModalTitle">Review Exam</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="" id="reviewForm">
                <div class="modal-body review-exam">
                    Loading...
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Approved</button>
            </form>
            
            </div>
        </div>
        </div>
    </div>

@endsection