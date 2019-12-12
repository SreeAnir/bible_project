
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
                        <a style="display: none;" class="material-icons loader-class">autorenew</a>
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
  $('.loader-class').show();
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
                  $('.loader-class').hide();
                  $('#edit-form input').prop('readonly', true);
               }
            });

  }
  function validateForm(){
    var retBool=1;
     $("#formBibleData").find('.required').each(function() {
      var data = {};
      (this.value) = (this.value).trim() ;
      // dataArray.push(data);
      if((this.value).trim() ==""){
        $('.validation-div').fadeIn();
        retBool=0;  
        $(this).addClass("error-class");
        $('#date-chosen').focus();
      }
    });
     return retBool;
  }
  function clearForm(){
   $("#formBibleData input,#formBibleData textarea").val("");
  }
  function updateFormData(){
     $('.validation-div').hide();
    if($('#date').val()==""){
      $('#date').val( $('#date-chosen').val());
    }
    if(validateForm()){ 
    
   // var dataArray = []
   //  $("#formBibleData").find('input').each(function() {
   //    var data = {};
   //    data[this.name] = this.value
   //    dataArray.push(data);
   //    console.log("this.name",this.name);
   //  });
      // dataArray.push({"_token" : "{{ csrf_token() }}" }); 
      // console.log("dataArray",dataArray);
         var formDa= $('#formBibleData');
         var data_send=formDa.serialize();
          $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
           $('.error-class').removeClass("error-class");
        $.ajax({
                type:'POST',
                url:"save-bible-date",
                data: data_send,
                type: 'POST',
                success:function(data) {
                 data=(JSON.parse(data));
                 if(!data.status){
                  $('.show-message').fadeOut(2000);
                   $('#bible-date-content').prepend('<div class="show-message alert alert-danger">'+data.message+'</div>');
                 }else{
                 $('.show-message').fadeOut(2000);
                   $('#bible-date-content').prepend('<div class="show-message alert alert-success">'+data.message+'</div>');
                     ///loadData();
                 }
                 $('.alert-success').show();
                    $('#ribbonColor').focus();

                  $('#edit-form input').prop('readonly', true);

               }
            });
        }
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
    $('.save-data').bind('click',function(){
      console.log("Updaed Called");
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
