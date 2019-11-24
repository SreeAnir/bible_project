
@extends('layouts.admin.inner')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Manage User </h3>
                    <p >
                        Here you can Add / Edit / Delete Categories 
                    </p> 

                    <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
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
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
  }
     
   $( document ).ready(function() {
        setTimeout(function(){
           $(".alertBox").slideUp();
        }, 8000);
        loadData();
    });
</script>
@stop