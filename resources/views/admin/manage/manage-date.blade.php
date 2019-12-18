
@extends('layouts.admin.inner')
@section('content')

        <div class="content"> 
            <div class="container-fluid">
                <div class="row">
                     <h3 class="title">Manage Bible Date</h3>
                       @if(session('message-fileupload'))
                   <div class="alert global-infor alert-info {{ Session::get('message-fileupload') }}">
                         {{ session('message-fileupload') }}
                      </div>
                    @endif
                       {!! Form::open(array('route' => 'import-bibledata','method'=>'POST','files'=>'true')) !!}
                      <div class="card-body col-md-12">
                         <div class="col-xs-12 col-sm-12 col-md-12">
                          
                    
                              <div class="col-md-3">
                                     {!! Form::label('bible_data_excel','Upload .xlsx File',['class'=>'btn btn-primary']) !!}
                                  {!! Form::file('bible_data_excel', array('class' => 'form-control' ,'accept'=> '.xlsx')) !!}
                                  {!! $errors->first('bible_data_excel', '<p class="alert alert-danger">:message</p>') !!}
                                  
                              </div>
                              <div class="col-md-3">
                             {!! Form::submit('Save',['class'=>'btn btn-success save-file']) !!}
                          </div>
                              <div class="col-md-3">
                          <a href="/download-bibledata-file/xlsx" class="btn btn-primary">Download Excel</a>
                          </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-12">
                      <p>
                       <b> You can download the Excel and add the content in the same.Only excel files with "xlsx" will be accepted.</b>
                       <br/><b>Please follow the field heading in excel.Column dataId is unique,so for new record , +1 to the dataId. </b> <br/> 
                       <i>For example,the downloaded excel has last dataId as 100,you have to begin with  101 in dataId to add  new prayer.</i>
                    </p>
         </div>
                          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <label id="file-name"> </label>
                               
                          
                          </div>
                      </div>
                     {!! Form::close() !!}

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
  function checkRequired(){

    var datechosen=$('#date-chosen').val();
     datechosen = new Date(datechosen);
     console.log("datechosen.getDay()",datechosen.getDay());
     if($('#solemnityDate').val()){
        var ret=true;
        var txt='';
        if($.trim($('#psalmResponse').val())==""){
          txt+=("Responsorial Psalm,");
          ret=false ;
        }
         if($.trim($('#intercessoryPrayer').val())==""){
          txt+=("Intercessory Prayers / Prayer of the Faithful ,");
         ret=false ;
        }     

        if($.trim($('#secondReadingReference').val())==""){
          txt+=("Second Reading Reference,");
         ret=false ;
        }
        if($.trim($('#secondReadingTitle').val())==""){
          txt+=("Second Reading Title,");
          ret=false ;
        }
         if($.trim($('#secondReadingText').val())==""){
         txt+=("Second Reading Text , ");
          ret=false ;
        }
        
        if(ret ==false){
          txt+=(" required for solemnity date");
          alert(txt);
          return false;
        }

      return true;
     }
     if(datechosen.getDay() === 0){ 
      if($('#psalmResponse').val()==""){
        alert("Responsorial Psalm is required for Sunday");
        return false;
      }
       if( $.trim($('#intercessoryPrayer').val())==""){
        alert("Intercessory Prayers / Prayer of the Faithful required for Sunday");
        return false;
      }     

      if($.trim($('#secondReadingReference').val())==""){
        alert("Second Reading Reference is required for Sunday");
        return false;
      }
      if($.trim($('#secondReadingTitle').val())==""){
        alert("Second Reading Title is required for Sunday");
        return false;
      }
       if($.trim($('#secondReadingText').val())==""){
        alert("Second Reading Text is required for Sunday");
        return false;
      }
       
      return true;
              //sunday
      }
  return true;
  }
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
     if(! checkRequired() ){
      return false;
     }
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
                 $('.show-message').remove();
                 if(!data.status){
                  $('.show-message').fadeOut(2000);
                   $('#bible-date-content').prepend('<div class="show-message alert alert-danger">'+data.message+'</div>');
                 }else{
                 $('.show-message').fadeOut(2000);
                   $('#bible-date-content').prepend('<div class="show-message alert alert-success">'+data.message+'</div>');
                     ///loadData();
                 }
                 $('.show-message').show();
                    $('#ribbonColor').focus();

                  $('#edit-form input').prop('readonly', true);

               }
            });
        }
  }
  $( document ).ready(function() {
 $('.save-file').hide(); 
        $('#bible_data_excel').on('change',function(){
          $('.save-file').show(); 
        }) ;
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
     $('.alert').not('.global-infor').hide();
        setTimeout(function(){
           $(".alertBox").slideUp();
        }, 10);
        loadDateData();
       
    });
</script>
@stop
