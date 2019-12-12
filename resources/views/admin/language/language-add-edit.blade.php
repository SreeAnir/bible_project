
@extends('layouts.admin.inner')
@section('content')
  <div class="content">
            <div class="container-fluid">
                <div class="row">   
                     <h3 class="title">Add Language</h3>
                     @if(Session::get('flash_message_global'))
                    <div class=" alert alert-info {{ Session::get('flash_message_global') }}">
                          {{ Session::get('flash_message_global') }}
                      </div>
                      @endif
                      <div class="card">
                <div class="card-body">
                    <form  id="formcategory" method="GET" action="{{ route('save-language') }}">
                        @if(@$form_edit==1)
                            <input type="hidden" value="{{@$prayer_type->id}}" name="id" id="id">
                            @endif
                            <div class="form-group row">
                            <label for="ShortName" class="col-md-4 col-form-label text-md-right">{{ __('Language Name') }}</label>

                            <div class="col-md-6">
                            <input  value="{{@$prayer_type->name}}"  id="name" type="name" class="form-control" name="name"  required autocomplete  autofocus>
                            <div style="display: none" class="alert alert-warning" role="alert">
                            Enter name
                            </div>
                            </div>
                            </div>

                         <div class="form-group row">
                            <label for="ShortName" class="col-md-4 col-form-label text-md-right">{{ __('Language Short Name') }}</label>
                            
                            <div class="col-md-6">
                                <input  value="{{@$prayer_type->ShortName}}"  id="ShortName" type="ShortName" class="form-control" name="ShortName"  required autocomplete  autofocus>

                           <div style="display: none" class="alert alert-warning" role="alert">
                          Enter ShortName
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
</script>
    @stop
      