
@extends('layouts.admin.inner')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Prayer Details </h3>
                     @include('admin.manage.add-prayer')
                </div>


            </div>
        </div>
@stop
@section('js')
<script type="text/javascript">
    $( document ).ready(function() {
     $('.alert').hide();
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
               url:"/admin/save-prayer",
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
                 $('#title').focus();
               }
            });
            }
        }); 

    });
</script>
@stop