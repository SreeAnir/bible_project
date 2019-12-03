<?php 
$style_hide='display: none;';
$title="Add New Prayer" ;
if(isset($form_edit) && @$form_edit==1){
$style_hide="";
$title="" ;
// print_r($details) ; die();
} 
?>
<div class="card">
                <div class="card-body">
                   
                   <div class="form-group row col-md-12">
                   @if($title!="")  <label class="toggleForm" class="col-md-10"><a class="btn">{{$title}}</a></label> @endif 
                    <div class="alert alert-success form-success" role="alert">
                      This is a success alert—check it out!
                    </div>
                     <div class="alert alert-danger validation-div" role="alert">
            Please enter all fields
            </div>
                </div>
               
                    <form style="{{$style_hide}}"  id="formPrayer" method="POST" action="{{ route('save-prayer') }}">
                       @if(@$details->idprayers!="")
                    <input value="{{@ trim($details->idprayers)}}" id="idprayers" type="hidden"  name="idprayers"   >
                        @endif
                        @csrf
                      <div class="form-group row col-md-12">
                    <div class="alert alert-danger" role="alert">
                      Error
                    </div>
                    </div>
                        <div class="form-group row">
                            <label for="prayer" class="col-md-4 col-form-label text-md-right">{{ __('Prayer') }}</label>
                            <div class="col-md-6">
                            <select id="prayer"  class="form-control" name="prayer"  required>
                            @foreach ($prayer_type as $type)
                                <option 
                                @if( $type->id == @$details->prayer ) selected="selected" @endif
                                value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                                </select>
                            </div>
                        </div>
<div class="form-group row">
                            <label for="" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input value="{{@ trim($details->title)}}" id="title" type="text" class="form-control" name="title"  required autocomplete  autofocus>
                            </div>
                        </div>
<div class="form-group row">
                            <label for="subtitle" class="col-md-4 col-form-label text-md-right">{{ __('Sub Title') }}</label>
                            <div class="col-md-6">
                                <input value="{{@ trim($details->subtitle)}}" id="subtitle" type="text" class="form-control" name="subtitle"  required autocomplete  autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Text') }}</label>
                            <div class="col-md-6">
                                <textarea id="text" class="form-control" name="text"  required autocomplete  autofocus>{{@trim($details->text)}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="orderno" class="col-md-4 col-form-label text-md-right">{{ __('Orderno') }}</label>
                            <div class="col-md-6">
                                <input value="{{@ $details->orderno}}" id="orderno" type="number" class="form-control" name="orderno"  required autocomplete  autofocus>
                            </div>
                        </div>
                        <div class="form-group row form-file-upload form-file-multiple">
                        <label for="orderno" class="col-md-4 col-form-label text-md-right">{{ __('Audio') }}</label>
                            <input accept="audio/mp3,audio/*;capture=microphone"   id="prayer_audio"  name="prayer_audio"  type="file" multiple="" class="inputFileHidden">
                            <div class="input-group col-md-6">
                                <input id="prayer_audio_invisible"  type="text" class="form-control inputFileVisible" 
                                @if(@$details->prayer_audio!="") placeholder="{{$details->prayer_audio}}" @else  placeholder="Single File"   @endif >
                                
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-fab btn-round btn-primary">
                                        <i class="material-icons">attach_file</i>
                                    </button>
                                </span>
                            </div>

                        </div>
                        @if(@$details->prayer_audio!="")
                         
                           <div class="form-group row" >
                        <label for="audio" class="col-md-4 col-form-label text-md-right">Audio Uploaded</label>
                        <div class="col-md-4">
                          <audio src="{{@public_path('storage/upload/files/audio/').$details->prayer_audio}}" id="prev" controls></audio>
                        </div>
                       
                        </div>
                         @endif 
                        <div class="form-group row" id="audio-preview">
                        <label for="audio" class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-4">
                          <audio  id="sound" controls></audio>
                        </div>
                        <div class="col-md-2">
                          <a class="material-icons clear-audio">delete</a>
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

      