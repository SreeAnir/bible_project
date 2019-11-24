
@extends('layouts.admin.inner')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Manage Prayers </h3>
                    <p >
                        Here you can Add / Edit / Delete Prayers 
                    </p> 

                    <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Prayer</th>
                        <th>Title</th>
                        <th>Sub title</th>
                        <th>Text</th>
                        <th>Orderno</th>
                        <th>Status</th>
                        <th width="100px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    </table>
                </div>


            </div>
        </div>
@stop
@section('js')
<script type="text/javascript">
  function loadData(){
     var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.prayer-list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'prayer', name: 'prayer'},
            {data: 'title', name: 'title'},
            {data: 'subtitle', name: 'subtitle'},
            {data: 'text', name: 'text'},
            {data: 'orderno', name: 'orderno'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
  }
     
   $( document ).ready(function() {
        // $.extend( true, $.fn.dataTable.defaults, {
        //     "searching": false,
        //     "ordering": false
        // } );
        setTimeout(function(){
           $(".alertBox").slideUp();
        }, 8000);
        loadData();
    });
</script>
@stop