
@extends('layouts.admin.inner')
@section('content')
        <div class="content"> 
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Manage Bible Date</h3>
                      <div id="bibe-date-content" class="card">
                       <div class="card-body col-md-12">
                      <div class="form-group col-md-2">
                      <label class="label-control">Datetime </label>
                      <input value='{{ date("Y-m-d") }}' id="date-chosen" type="text" class="form-control datetimepicker" />
                      </div>
                       <div class="form-group col-md-2">
                       <a  class="edit-data material-icons">edit</a> 
                       <a style="display: none;" class="save-data material-icons">save</a> 
                      </div>

                      <div id="bible-date-content" class="card-body col-md-12"> 
                      <!-- content comes here -->
                      <p> No Data for this date.</p>
                    </div>
                     </div>
                </div>
            </div>
        </div>
@stop
@section('js')
<script type="text/javascript">

  function loadDateData(){
  $('#edit-form input').prop('readonly', true);  
  $('.save-data').hide();
  $('.edit-data').fadeIn();
  
  var datechosen=$('#date-chosen').val();
  if(datechosen==''){
    $('#date-chosen').val();
  }

   $.ajax({
               type:'POST',
               url:"load-date-content",
               data:  {
                  "_token": "{{ csrf_token() }}",
                  "date": datechosen,
                },
                type: 'POST',
               success:function(data) {
                 data=(JSON.parse(data));
                 if(!data.status){
                   $('#bible-date-content').html(data.message);
                 }else{
                    
                  $('#bible-date-content').html(data.message);
                     ///loadData();
                 }
                  $('#edit-form input').prop('readonly', true);

               }
            });

  }
  function updateFormData(){
    if($('#date').val()==""){
      $('#date').val( $('#date-chosen').val());
    }
    var form = $('#formBibleData')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        // formData.append('_token', "{{ csrf_token() }}");
        $.ajax({
               type:'POST',
              url:"save-bible-date",
               data: formData,
                type: 'POST',
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
               success:function(data) {
                 data=(JSON.parse(data));
                 if(!data.status){
                  $('.show-message').fadeOut(3000);
                   $('#bible-date-content').prepend('<div class="show-message alert alert-danger">'+data.message+'</div>');
                 }else{
                 $('.show-message').fadeOut(4000);
                   $('#bible-date-content').prepend('<div class="show-message alert alert-success">'+data.message+'</div>');
                     ///loadData();
                 }
                  $('#edit-form input').prop('readonly', true);

               }
            });
          // $.ajax({
          //      url:"save-bible-date",
          //      data: formData,
          //      type: 'POST',
          //      success:function(data) {
          //        data=(JSON.parse(data));
          //        if(!data.status){
          //           $('form .alert-warning').html(data.message).fadeIn();
          //        }else{
          //            $('.edit-data').fadeIn(); 
          //            $('.save-data').hide(); 
          //           $('form .alert-success').html(data.message).fadeIn();
          //            document.getElementById("formPrayer").reset();
          //            ///loadData();
          //        }
          //      }
          //   });
  }
  $( document ).ready(function() {

    $('#date-chosen').on("change",function(){
      loadDateData();
    });
    //edit btn click
    $('.edit-data').on('click',function(){
     $('#edit-form input').prop('readonly', false);
      $('.save-data').fadeIn(); 
      $('.edit-data').hide(); 
    });
    //eof eit btn click

    //save btn click
    $('.save-data').on('click',function(){
      updateFormData();
    });

    //eof save btn click

    $('#date-chosen').datepicker({  

       format: 'yyyy-mm-dd'

     }); 
     $('.alert').hide();
        setTimeout(function(){
           $(".alertBox").slideUp();
        }, 10);
        loadDateData();
       
    });
</script>
@stop