
<?php
$class="edit-form";
 if(( $bibleData ) == "" ){
 $class="add-form";
  ?>
<form id="formBibleData" method="POST">
     @csrf
<div class="form-group row is-empty">
    
 <div class="alert alert-info" role="alert">
Nothing added yet . You can fill it down for the date. 
  </div>
 
</div>
 <?php  } ?>
 <div id="{{$class}}"> 
<input name="dataId" id="dataId" type="hidden" value="{{@$bibleData->dataId}}">
<input name="date" id="date" type="hidden" value="{{@$bibleData->date}}">
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Ribbon Color</label>
    <div class="col-md-6">
        <input id="ribbonColor" value="{{@$bibleData->ribbonColor}}" type="text" class="form-control" name="ribbonColor" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Week Description</label>
    <div class="col-md-6">
        <input value="{{@$bibleData->weekDescription}}"  id="weekDescription" type="text" class="form-control" name="weekDescription" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Psalter</label>
    <div class="col-md-6">
        <input value="{{@$bibleData->psalter}}"  id="psalter" type="text" class="form-control" name="psalter" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Saint Of The Day</label>
    <div class="col-md-6">
        <input value="{{@$bibleData->saintOfTheDay}}"  id="saintOfTheDay" type="text" class="form-control" name="saintOfTheDay" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Significance Of The Day</label>
    <div class="col-md-6">
        <input value="{{@$bibleData->significanceOfTheDay}}" id="significanceOfTheDay" type="text" class="form-control" name="significanceOfTheDay" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">First Reading Reference</label>
    <div class="col-md-6">
        <textarea id="firstReadingReference"  class="form-control" name="firstReadingReference" required="" autocomplete="" >
        {{@$bibleData->firstReadingReference}}
        </textarea>
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">First Reading Title</label>
    <div class="col-md-6">
        <input id="firstReadingTitle" value="{{@$bibleData->firstReadingTitle}}"  type="text" class="form-control" name="firstReadingTitle" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">First Reading Text</label>
    <div class="col-md-6">
        <textarea  id="firstReadingText"  class="form-control" name="firstReadingText" required="" autocomplete="" autofocus="">
           {{@$bibleData->firstReadingText}}
        </textarea>
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty" value="{{@$bibleData->firstReadingText}}">
    <label for="" class="col-md-4 col-form-label text-md-right">Psalm Reference</label>
    <div class="col-md-6">
        <input value="{{@$bibleData->psalmReference}}"  id="psalmReference" type="text" class="form-control" name="psalmReference" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Psalm Text</label>
    <div class="col-md-6">
        <textarea id="psalmText" type="text" class="form-control" name="psalmText" required="" autocomplete="" autofocus="">
            {{@$bibleData->psalmText}}
        </textarea>
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Psalm Response</label>
    <div class="col-md-6">
        <input value="{{@$bibleData->psalmResponse}}" id="psalmResponse" type="text" class="form-control" name="psalmResponse" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Second Reading Reference</label>
    <div class="col-md-6">
        <input value="{{@$bibleData->secondReadingReference}}" id="secondReadingReference" type="text" class="form-control" name="secondReadingReference" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Second Reading Title</label>
    <div class="col-md-6">
        <input value="{{@$bibleData->secondReadingTitle}}"  id="secondReadingTitle" type="text" class="form-control" name="secondReadingTitle" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Second Reading Text</label>
    <div class="col-md-6">
        <textarea id="secondReadingText" type="text" class="form-control" name="secondReadingText" required="" autocomplete="" autofocus="">
             {{@$bibleData->secondReadingText}}
        </textarea>
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Gospel Reference</label>
    <div class="col-md-6">
        <input value="{{@$bibleData->gospelReference}}"  id="gospelReference" type="text" class="form-control" name="gospelReference" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Gospel Title</label>
    <div class="col-md-6">
        <input  value="{{@$bibleData->gospelTitle}}" id="gospelTitle" type="text" class="form-control" name="gospelTitle" required="" autocomplete="" autofocus="">
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Gospel Text</label>
    <div class="col-md-6">
        <textarea id="gospelText" class="form-control" name="gospelText" required="" autocomplete="" autofocus="">
            {{@$bibleData->gospelText}}
        </textarea>
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Reflection Text</label>
    <div class="col-md-6">
        <textarea id="reflectionText"  class="form-control" name="reflectionText" required="" autocomplete="" autofocus="">
        {{@$bibleData->reflectionText}}
        </textarea>
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Read Text</label>
    <div class="col-md-6">
        <textarea id="readText" class="form-control" name="readText" required="" autocomplete="" autofocus="">
        {{@$bibleData->readText}}
        </textarea>
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Reflect Text</label>
    <div class="col-md-6">
        <textarea id="reflectText"  class="form-control" name="reflectText" required="" autocomplete="" autofocus="">
        {{@$bibleData->reflectText}}
        </textarea>
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Pray Text</label>
    <div class="col-md-6">
        <textarea id="prayText"  class="form-control" name="prayText" required="" autocomplete="" autofocus="">
       {{@$bibleData->prayText}}
        </textarea>
    </div>
 <span class="material-input"></span>
</div>
<div class="form-group row is-empty">
    <label for="" class="col-md-4 col-form-label text-md-right">Act Text</label>
    <div class="col-md-6">
        <textarea id="actText"  class="form-control" name="actText" required="" autocomplete="" autofocus="">
         {{@$bibleData->actText}}
        </textarea> 
    </div>
 <span class="material-input"></span>
</div>

</div>
</form>