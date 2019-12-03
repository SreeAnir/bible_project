
@extends('layouts.admin.inner')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Prayer Type Details </h3>
                     @include('admin.manage.add-category')
                </div>


            </div>
        </div>
@stop
@section('js')
<script type="text/javascript">
     $( "#submitbtn" ).on( 'click',function( event ) {
         $('.alert').hide().html('');
         event.preventDefault();
        if ( $( "#name" ).val() == "" ) {
         $('form .alert-warning').html("Category Type is required").fadeIn();
            return false;
        }
        if ( $( "#id" ).val() == "" ) {
         $('form .alert-warning').html("Invalid Type").fadeIn();
            return false;
        }
          $.ajax({
               type:'POST',
               url:"/admin/save-category",
               data: {
                "_token": "{{ csrf_token() }}",
                "name": $('#name').val() ,
                "id": $('#id').val() 
                },
               success:function(data) {
                 data=(JSON.parse(data));
                 if(!data.status){
                    $('form .alert-warning').html(data.message).fadeIn();
                 }else{
                    $('form .alert-success').html(data.message).fadeIn();
                     
                     ///loadData();
                 }
               }
            });
        }); 
</script>
@stop