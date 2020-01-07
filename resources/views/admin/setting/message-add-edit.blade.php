
@extends('layouts.admin.inner')
@section('content')
  <div class="content">
            <div class="container-fluid">
                <div class="row">   
                     <h3 class="title">Update Message</h3>
                     @if(Session::get('flash_message_app'))
                    <div class=" alert alert-info {{ Session::get('flash_message_app') }}">
                          {{ Session::get('flash_message_app') }}
                      </div>
                      @endif
                      <div class="card">
                <div class="card-body">
                    <form  enctype="multipart/form-data"  id="formcategory" method="POST" action="{{ route('save-message') }}">
                         @csrf
                             <input type="hidden" value="{{@$app_message->id}}" name="id" id="id">
                             <div class="form-group row">
                            <label for="message" class="col-md-4 col-form-label text-md-right">{{ __('App Message') }}</label>

                            <div class="col-md-6">
                            <textarea  required="required" rows="5" name="text" class="form-control" >{{@$app_message->text}}</textarea>

                             
                            <div style="display: none" class="alert alert-warning" role="alert">
                            Enter name
                            </div>
                            </div>
                            </div>



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
      