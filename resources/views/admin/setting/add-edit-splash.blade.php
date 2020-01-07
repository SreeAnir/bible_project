
@extends('layouts.admin.inner')
@section('content')
  <div class="content">
            <div class="container-fluid">
                <div class="row">   
                     <h3 class="title">Update Splash</h3>
                     @if(Session::get('flash_message_splash'))
                    <div class=" alert alert-info {{ Session::get('flash_message_splash') }}">
                          {{ Session::get('flash_message_splash') }}
                      </div>
                      @endif
                      <div class="card">
                <div class="card-body">
                    <form  enctype="multipart/form-data"  id="formcategory" method="POST" action="{{ route('save-splash') }}">
                         @csrf
                             <input type="hidden" value="{{@$splash->id}}" name="id" id="id">
                             <div class="form-group row">
                            <label for="ShortName" class="col-md-4 col-form-label text-md-right">{{ __('splash Name') }}</label>

                            <div class="col-md-6">
                            <input  value="{{@$splash->message}}"  id="message" type="text" class="form-control" name="message"  required autocomplete  autofocus>
                            <div style="display: none" class="alert alert-warning" role="alert">
                            Enter name
                            </div>
                            </div>
                            </div>
 
                         <div class="form-group row">
                            <label for="ShortName" class="col-md-4 col-form-label text-md-right">{{ __('splash Photo') }}</label>
                            
                            <div class="col-md-6">
                               <div class="form-group form-file-upload row">
                            <input type="file" name="image"  id="image_save" class="inputFileHidden">
                            <div class="input-group">
                                <input type="text" class="form-control inputFileVisible" id="image" placeholder="Single File">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-fab btn-round btn-primary">
                                        <i class="material-icons">attach_file</i>
                                    </button>
                                </span>
                            </div>
                          </div>
                        
                            </div>
                        </div>
                         @if(@$splash->image!="")
                         <div class="form-group row ">
                           <label for="ShortName" class="col-md-4 col-form-label text-md-right">{{ __('Current splash Photo') }}</label>

                            <div class="col-md-4"  >
                           
                           <img  style="max-width:250px; "  src="{{URL::asset('storage/upload/files/image/'.$splash->image)}}"    >
                           </div>
                           
                        </div>
                         @endif
                         
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="submitbtn" type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                                <button id="resetbtn" type="reset" class="btn btn-primary">
                                    {{ __('Reset') }}
                                </button>
                                 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
 </div>


            </div>
        </div>

       


@stop

@section('js')
<script type="text/javascript">
    $('#image_save').on('change',function(){
        $('#image_name').val(this.value) ;

    }) ;
</script>
    @stop
      