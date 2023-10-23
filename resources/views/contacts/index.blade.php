@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Address</th>
                <th>Number</th>
                <th width="200px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });


        var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('contacts.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'address', name: 'address'},
            {data: 'number', name: 'number'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('body').on('click', '.deleteContact', function () {
     
        var id = $(this).data("id");
        confirm("Are You sure want to delete !");
        
        $.ajax({
            method:"POST",
            url: "{{ route('contacts.store') }}"+'/'+id,
            //url:"{{ route('contacts.store') }}",
            data:{
                'id': id,
                '_token': '{{ csrf_token() }}',
                _method: 'delete'
            },
            success: function (data) {
               // console.log('x');
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    });
</script>


@endsection