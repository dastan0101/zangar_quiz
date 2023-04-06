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
                        <td>
                            <button class="btn btn-primary editMarks" 
                            data-id="{{ $exam->id }}" data-marks="{{ $exam->marks }}" 
                            data-totalq="{{ count($exam->getQnaExam) }}" data-toggle="modal" 
                            data-target="#editMarksModel">Edit</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">Exams not found</td>
                </tr>
            @endif

        </tbody>
    </table>

    <!-- Exam Modal -->
    <div class="modal fade" id="editMarksModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMarksTitle">Marks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editMarks">
                @csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-3">
                                <label>Marks/Q</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="hidden" name="exam_id" id="exam_id">
                                <input type="text" id="marks" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode <= 46" name="marks" placeholder="Enter merks per question" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <label>Total Marks</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Total marks" id="tmarks" disabled>
                            </div>
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
    
    <script>
        $(document).ready(function() {

            var totalQna = 0;

            $('.editMarks').click(function() {
                var exam_id = $(this).attr('data-id');
                var marks = $(this).attr('data-marks');
                var totalq = $(this).attr('data-totalq');

                $('#exam_id').val(exam_id);

                $('#marks').val(marks);
                $('#tmarks').val((marks * totalq).toFixed(1)); 

                totalQna = totalq;
            });

            $('#marks').keyup(function() {
                
                $('#tmarks').val(($(this).val() * totalQna).toFixed(1)); 
            });

            $('#editMarks').submit(function() {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('editMarks') }}",
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