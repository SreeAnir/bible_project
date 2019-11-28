
@extends('layouts.admin.inner')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Manage Prayers </h3>
                     @include('admin.manage.add-prayer')
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
     $('.alert').hide();
        setTimeout(function(){
           $(".alertBox").slideUp();
        }, 8000);
        loadData();


        $( "#submitbtn" ).on( 'click',function( event ) {
         $('.alert').hide().html('');
         event.preventDefault();
         
        var form = $('#formPrayer')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);

          $.ajax({
               url:"save-prayer",
               data: formData,
                type: 'POST',
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
               success:function(data) {
                 data=(JSON.parse(data));
                 if(!data.status){
                    $('form .alert-warning').html(data.message).fadeIn();
                 }else{
                    
                    $('form .alert-success').html(data.message).fadeIn();
                     document.getElementById("formPrayer").reset();
                     ///loadData();
                 }
               }
            });
        });       
    });
</script>
@stop