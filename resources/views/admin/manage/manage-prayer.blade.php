
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
                        <th>Audio</th>
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
            {data: 'prayer_audio', name: 'prayer_audio'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
  }
     
  $( document ).ready(function() {
     $('.alert').hide();
      prayer_audio.onchange = function(e){
          var sound = document.getElementById('sound');
          sound.src = URL.createObjectURL(this.files[0]);
          // not really needed in this exact case, but since it is really important in other cases,
          // don't forget to revoke the blobURI when you don't need it
          $('#prayer_audio_invisible').val(this.files[0].name);
          $('#audio-preview').show();
          sound.onend = function(e) {
            URL.revokeObjectURL(this.src);
          }
        }
        setTimeout(function(){
           $(".alertBox").slideUp();
        }, 8000);
        loadData();

        //delete audio
        $('.clear-audio').on( 'click',function( event ) {
            $('#audio-preview').hide();
            $('#prayer_audio').val('');
            $('#prayer_audio_invisible').val('');
        });
    function validateForm(){
    var retBool=1;
     $("#formPrayer input:text[required]").each(function() {
      (this.value) = (this.value).trim() ;
      // dataArray.push(data);
      if((this.value).trim() ==""){
        $('.validation-div').fadeIn();
        retBool=0;  
        $(this).addClass("error-class");
        $('#prayer').focus();
      }
    });
     return retBool;
  }
    $( "#submitbtn" ).on( 'click',function( event ) {
     $('.alert').hide();
         event.preventDefault();
         if(validateForm()){
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
            }
        }); 

    });
</script>
@stop