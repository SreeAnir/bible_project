<div class="card">
                <div class="card-body">
                    <form  id="formcategory" method="GET" action="{{ route('save-category') }}">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>
                            @if(@$form_edit==1)
                            <input type="hidden" value="{{@$prayer_type->id}}" name="id" id="id">
                            @endif
                            <div class="col-md-6">
                                <input  value="{{@$prayer_type->name}}"  id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name"  required autocomplete  autofocus>

                           <div style="display: none" class="alert alert-warning" role="alert">
                          Enter Category Title
                        </div>
                       <div style="display: none"  class="alert alert-success" role="alert">
                      This is a success alert—check it out!
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

      