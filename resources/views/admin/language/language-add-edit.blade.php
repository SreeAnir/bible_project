
@extends('layouts.admin.inner')
@section('content')
  <div class="content">
            <div class="container-fluid">
                <div class="row">   
                     <h3 class="title">Add Language</h3>
                      
                       @if(Session::get('flash_error_language'))
                    <div class=" alert alert-info {{ Session::get('flash_error_language') }}">
                          {{ Session::get('flash_error_language') }}
                      </div>
                      @endif

                       @if(Session::get('flash_message_language'))
                    <div class=" alert alert-info {{ Session::get('flash_message_language') }}">
                          {{ Session::get('flash_message_language') }}
                      </div>
                      @endif

                      <div class="card">
                <div class="card-body">
                    <form  id="formcategory" method="POST" action="{{ route('save-language') }}">
                         @csrf
                            <input type="hidden" value="{{@$row_data->id}}" name="id" id="id">
                            <div class="form-group row">
                            <label for="ShortName" class="col-md-4 col-form-label text-md-right">{{ __('Language Name') }}</label>

                            <div class="col-md-6">
                            <input  value="{{@$row_data->name}}" placeholder="English"  id="name" type="name" class="form-control" name="name"  required autocomplete  autofocus>
                            <div style="display: none" class="alert alert-warning" role="alert">
                            Enter name
                            </div>
                            </div>
                            </div>

                         <div class="form-group row">
                            <label for="ShortName" class="col-md-4 col-form-label text-md-right">{{ __('Language Short Name') }}</label>
                            
                            <div class="col-md-6">
                                <input  value="{{@$row_data->ShortName}}" placeholder="en"  id="ShortName" type="ShortName" class="form-control" name="ShortName"  required autocomplete  autofocus>

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
                <div class="col-xs-12 col-sm-12 col-md-12">
                  
                  <table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Name</th>
            <th>ShortName</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $language)
    <tr>
            <td class="text-center">1</td>
            <td>{{$language->name}}</td>
            <td>{{$language->ShortName}}</td>
            <td class="td-actions text-right">
                <a  href="/admin/edit-language/{{$language->id}}" rel="tooltip" class="btn btn-success">
                <i class="material-icons">edit</i>
                </a>
                <button onclick="alert('Please Contact Admin')" type="button" rel="tooltip" class="btn btn-danger">
                <i class="material-icons">close</i>
                </button>
            </td>
        </tr>
@endforeach
        
    </tbody>
</table>
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
      