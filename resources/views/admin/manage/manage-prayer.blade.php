
@extends('layouts.admin.inner')
@section('content')


        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>

            </div>
        </nav>

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
                        <th>text</th>
                        <th>orderno</th>
                        <th>status</th>
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