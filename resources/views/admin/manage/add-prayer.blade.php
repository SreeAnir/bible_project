<div class="card">
                <div class="card-body">
               <div class="alert alert-danger validation-div" role="alert">
            Please enter all fields
            </div>
                    <form  id="formPrayer" method="POST" action="{{ route('save-category') }}">
                        @csrf
                    <div class="alert alert-success" role="alert">
                      This is a success alert—check it out!
                    </div>  
                    <div class="alert alert-danger" role="alert">
                      Error
                    </div>
                        <div class="form-group row">
                            <label for="prayer" class="col-md-4 col-form-label text-md-right">{{ __('Prayer') }}</label>
                            <div class="col-md-6">
                            <select id="prayer"  class="form-control" name="prayer"  required>
                            @foreach ($prayer_type as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                                </select>
                            </div>
                        </div>
<div class="form-group row">
                            <label for="" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title"  required autocomplete  autofocus>
                            </div>
                        </div>
<div class="form-group row">
                            <label for="subtitle" class="col-md-4 col-form-label text-md-right">{{ __('Sub Title') }}</label>
                            <div class="col-md-6">
                                <input id="subtitle" type="text" class="form-control" name="subtitle"  required autocomplete  autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Text') }}</label>
                            <div class="col-md-6">
                                <textarea id="text" class="form-control" name="text"  required autocomplete  autofocus>
</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="orderno" class="col-md-4 col-form-label text-md-right">{{ __('Orderno') }}</label>
                            <div class="col-md-6">
                                <input id="orderno" type="text" class="form-control" name="text"  required autocomplete  autofocus>
                            </div>
                        </div>
                        <div class="form-group row form-file-upload form-file-multiple">
                        <label for="orderno" class="col-md-4 col-form-label text-md-right">{{ __('Audio') }}</label>
                            <input accept="audio/mp3,audio/*;capture=microphone" required id="prayer_audio"  name="prayer_audio"  type="file" multiple="" class="inputFileHidden">
                            <div class="input-group col-md-6">
                                <input id="prayer_audio_invisible"  type="text" class="form-control inputFileVisible" placeholder="Single File">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-fab btn-round btn-primary">
                                        <i class="material-icons">attach_file</i>
                                    </button>
                                </span>
                            </div>

                        </div>

                        <div class="form-group row" id="audio-preview">
                        <label for="orderno" class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-4">
                          <audio id="sound" controls></audio>
                        </div>
                        <div class="col-md-2">
                          <a class="material-icons clear-audio">delete</a>
                        </div>
                       
                        </div>
                         
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="submitbtn" type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                                <button type="reset" class="btn btn-primary">
                                    {{ __('Reset') }}
                                </button>
                                 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

      