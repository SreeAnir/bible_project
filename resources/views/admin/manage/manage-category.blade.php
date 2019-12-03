
@extends('layouts.admin.inner')
@section('content')

  <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Manage category </h3>
                     @if(Session::get('flash_message'))
                    <div class=" alert alert-info {{ Session::get('flash_message') }}">
                          {{ Session::get('flash_message') }}
                      </div>
                      @endif
                        @include('admin.manage.add-category')
                    <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Prayer Type</th>
                        <th>Status</th>
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
     var table = $('.data-table').DataTable();
  function loadData(){
        table.destroy();
        table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.category-list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
         
  }
     
   $( document ).ready(function() {
            setTimeout(function(){
           $(".alertBox").slideUp();
        }, 8000);
        loadData();

        
        $( "#submitbtn" ).on( 'click',function( event ) {
         $('.alert').hide().html('');
         event.preventDefault();
        if ( $( "#name" ).val() == "" ) {
         $('form .alert-warning').html("Category Type is required").fadeIn();
            return false;
        }
          $.ajax({
               type:'POST',
               url:"save-category",
               data: {
                "_token": "{{ csrf_token() }}",
                "name": $('#name').val() 
                },
               success:function(data) {
                 data=(JSON.parse(data));
                 if(!data.status){
                    $('form .alert-warning').html(data.message).fadeIn();
                 }else{
                    
                    $('form .alert-success').html(data.message).fadeIn();
                     document.getElementById("formcategory").reset();
                     ///loadData();
                     loadData();
                 }
               }
            });
        }); 

    });
</script>
@stop