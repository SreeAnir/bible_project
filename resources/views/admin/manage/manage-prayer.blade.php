
@extends('layouts.admin.inner')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Manage Prayers </h3>
                    @if(Session::get('flash_message'))
                    <div class=" alert alert-info {{ Session::get('flash_message') }}">
                          {{ Session::get('flash_message') }}
                      </div>
                      @endif

                     @include('admin.manage.add-prayer')
                    <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Prayer</th>
                        <th>Title</th>
                        <th>Sub title</th>
                        <th>Text</th>
                        <th  width="30px">Order</th>
                        <!-- <th class="audio_stream">Audio</th> -->
                        <th width="30px">Status</th>
                        <th width="30px"></th>
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
        columnDefs:[{targets:4,className:"truncate"}],
        ajax: "{{ route('admin.prayer-list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'prayer', name: 'prayer'},
            {data: 'title', name: 'title'},
            {data: 'subtitle', name: 'subtitle'},
            {data: 'text', name: 'text'},
            {data: 'orderno', name: 'orderno'},
            // {data: 'prayer_audio', name: 'prayer_audio'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });
  }
     
   function togDiv(){
    var x = document.getElementById("formPrayer");
              if (x.style.display === "none") {
                x.style.display = "block";
              } else {
                x.style.display = "none";
              }
   }
  $( document ).ready(function() {
        
       $('.toggleForm').bind('click',function(){
        togDiv();
       });
       $('.toggleForm-dismiss').bind('click',function(){
        togDiv();
       });
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
        $('.error-class').removeClass("error-class");
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
    $('.overlay').show(); 
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
                    $('form .alert-danger').html(data.message).fadeIn();
                 }else{
                    $('.form-success').html(data.message).fadeIn();
                     document.getElementById("formPrayer").reset();
                     $('.clear-audio').trigger('click');
                 }
                 $('.overlay').fadeOut("slow"); 
                 $('#title').focus();
               }
            });
            }
        }); 

    });
</script>
@stop