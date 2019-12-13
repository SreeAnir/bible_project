<form id="formBibleData" method="POST">
     <div class="alert alert-danger validation-div" role="alert">
    Please enter the fields
    </div>
    @csrf
    <?php
    $class="edit-form";
    if(( $bibleData ) == "" ||  $bibleData->ribbonColor==""){
    $class="add-form";
      ?>

    <div class="form-group row is-empty">
        
    <div class="alert alert-info" role="alert">
    Nothing added yet . You can fill it down for the date. 
    </div>
     
    </div>
    <?php  }
    if(isset( $bibleData->ribbonColor )){
    $class="edit-form";
    }
     ?>
    <div id="{{$class}}"> 
    <input name="dataId" id="dataId" type="hidden" value="{{@$bibleData->dataId}}">
    <input name="date" id="date" type="hidden" value="{{@$bibleData->date}}">
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Ribbon Color</label>
        <div class="col-md-6">
            <input id="ribbonColor" value="{{@$bibleData->ribbonColor}}" type="text" class="form-control required" name="ribbonColor" required autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Week Description</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->weekDescription}}"  id="weekDescription" type="text" class="form-control required" name="weekDescription" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Psalter</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->psalter}}"  id="psalter" type="text" class="form-control required" name="psalter" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Saint Of The Day</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->saintOfTheDay}}"  id="saintOfTheDay" type="text" class="form-control required" name="saintOfTheDay" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Significance Of The Day</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->significanceOfTheDay}}" id="significanceOfTheDay" type="text" class="form-control required" name="significanceOfTheDay" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">First Reading Reference</label>
        <div class="col-md-6">
            <textarea rows="5" id="firstReadingReference"  class="form-control required" name="firstReadingReference" required="" autocomplete=""  rows="5">{{@$bibleData->firstReadingReference}}</textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">First Reading Title</label>
        <div class="col-md-6">
            <input id="firstReadingTitle" value="{{@$bibleData->firstReadingTitle}}"  type="text" class="form-control required" name="firstReadingTitle" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">First Reading Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="firstReadingText"  class="form-control required" name="firstReadingText" required="" autocomplete="" autofocus="">{{@$bibleData->firstReadingText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty" value="{{@$bibleData->firstReadingText}}">
        <label for="" class="col-md-4 col-form-label text-md-right">Psalm Reference</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->psalmReference}}"  id="psalmReference" type="text" class="form-control required" name="psalmReference" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Psalm Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="psalmText" type="text" class="form-control required" name="psalmText" required="" autocomplete="" autofocus="">{{@$bibleData->psalmText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Psalm Response</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->psalmResponse}}" id="psalmResponse" type="text" class="form-control required" name="psalmResponse" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Second Reading Reference</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->secondReadingReference}}" id="secondReadingReference" type="text" class="form-control required" name="secondReadingReference" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Second Reading Title</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->secondReadingTitle}}"  id="secondReadingTitle" type="text" class="form-control required" name="secondReadingTitle" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Second Reading Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="secondReadingText" type="text" class="form-control required" name="secondReadingText" required="" autocomplete="" autofocus="">{{@$bibleData->secondReadingText}}</textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Gospel Reference</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->gospelReference}}"  id="gospelReference" type="text" class="form-control required" name="gospelReference" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Gospel Title</label>
        <div class="col-md-6">
            <input  value="{{@$bibleData->gospelTitle}}" id="gospelTitle" type="text" class="form-control required" name="gospelTitle" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Gospel Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="gospelText" class="form-control required" name="gospelText" required="" autocomplete="" autofocus="">{{@$bibleData->gospelText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Reflection Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="reflectionText"  class="form-control required" name="reflectionText" required="" autocomplete="" autofocus="">{{@$bibleData->reflectionText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Read Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="readText" class="form-control required" name="readText" required="" autocomplete="" autofocus="">{{@$bibleData->readText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Reflect Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="reflectText"  class="form-control required" name="reflectText" required="" autocomplete="" autofocus="">{{@$bibleData->reflectText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Pray Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="prayText"  class="form-control required" name="prayText" required="" autocomplete="" autofocus="">{{@$bibleData->prayText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Act Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="actText"  class="form-control required" name="actText" required="" autocomplete="" autofocus="">{{@$bibleData->actText}}
            </textarea> 
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button id="submitbtn" type="button" onclick="updateFormData();" class="btn btn-primary save-data">
                {{ __('Save') }}
            </button>
            <button onclick="clearForm();" type="reset" class="btn btn-primary">
                {{ __('Reset') }}
            </button>
             
        </div>
    </div>
    </div>
</form>