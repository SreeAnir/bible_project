
@extends('layouts.admin.inner')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Manage User </h3>
                    <p >
                        Here you can Add / Edit / Delete Users 
                    </p> 
                    @if(Session::get('flash_success'))
                    <div class="show alert alert-info {{ Session::get('flash_success') }}">
                          {{ Session::get('flash_success') }}
                      </div>
                      @endif
                       @if(Session::get('flash_error'))
                    <div class="show alert alert-danger {{ Session::get('flash_error') }}">
                          {{ Session::get('flash_error') }}
                      </div>
                      @endif
                        @include('admin.manage.add-user')
                    <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="30px">Status</th>
                        <th width="30px">Action</th>
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
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
  }
     function userDeletConfirm(itm){
       var link =$(itm).attr('data-rel');
        var cnf = confirm("User will be deleted,but you can activate again.Press OK To preceed");
            if (cnf== true) {
                window.location=link;  
            } else {
               return false;
            }
     }
   $( document ).ready(function() {
       
        setTimeout(function(){
           $(".alertBox").slideUp();
        }, 8000);
        loadData();
    });
</script>
@stop