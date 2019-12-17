 

<?php 
use App\Language;
?>

<div class="card">
                <div class="card-body">
                   
               
                    <form   id="formPrayer" method="POST" action="{{ route('save-user') }}">
                        @csrf
                      <div class="form-group row col-md-12">
                    <div class="alert alert-danger" role="alert">
                      Error
                    </div>
                    </div>
                    <label> Default Password : user@123</label>
                    <div class="form-group row">
                        <div class="form-group col-md-6">
                            <label for="prayer" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-8">
                            <input value="{{@ trim($details->name)}}" id="title" type="text" class="form-control" name="name"  required autocomplete  autofocus>
                             <input value="{{@ trim($details->id)}}" id="id" type="hidden" class="form-control" name="id"  required autocomplete  autofocus>
                            </div>
                        </div>
<div class="form-group col-md-6">
                            <label for="" class="col-md-2 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-8">
                                <input value="{{@ trim($details->email)}}" id="email" type="text" class="form-control" name="email"  required autocomplete  autofocus>
                            </div>
                        </div>
                        </div>
                        <div class="form-group row">

                        <div class="form-group row col-md-6">
                            <label for="subtitle" class="col-md-2 col-form-label text-md-right">{{ __('Type') }}</label>
                            <div class="col-md-8">
                                
                                 <select id="type" class="form-control" name="type"  required autocomplete  autofocus> 

                                    <option value="3">User</option>
                                    <option value="2">Content Manager</option>
                                 </select>
                            </div>
                        </div>

                        <div class="form-group row col-md-6">
                            <label for="text" class="col-md-2 col-form-label text-md-right">{{ __('Language') }}</label>
                            <div class="col-md-8">

                                <select id="language" class="form-control" name="language"  required autocomplete  autofocus>
                                    <?php  $language=Language::all() ; ?>
                                     @foreach ($language as $lan)
                                     <option 
                                     @if( $lan->id == @$details->language ) selected="selected" @endif
                                  value="{{ $lan->id }}">{{ $lan->name }}</option>
                                 @endforeach
                                  
                                </select>
                            </div>
                        </div>
                         </div>
                        
                         
                        <div class="form-group row mb-0">
                            <div class="col-md-10 offset-md-4">
                                <button id="submitbtn" type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                                <button type="reset" class="btn btn-primary">
                                    {{ __('Reset') }}
                                </button>
                                 
                            </div>
                            <div class="col-md-2 offset-md-4 float-right">
                                 <button type="reset" class="btn btn-secondary toggleForm-dismiss">
                                    {{ __('Dismiss') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

      