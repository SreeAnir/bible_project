<input type="hidden" id="solemnityDate" value="{{@$solemnityDate}}">
<form id="formBibleData" method="POST" onsubmit="return checkRequired()">
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
    <input required name="date" id="date" type="hidden" value="{{@$bibleData->date}}">
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Ribbon Color<span class="required_star">*</span></label>
        <div class="col-md-6" class="form-control required" >
            <select  name="ribbonColor" required class="form-control selectpicker" data-style="btn btn-link"  id="ribbonColor">
                <option  @if(@$bibleData->ribbonColor=="green") selected @endif value="green">green</option>
                <option  @if(@$bibleData->ribbonColor=="purple") selected="selected" @endif value="purple">purple</option>
                <option  @if(@$bibleData->ribbonColor=="red") selected @endif value="red">red</option>
                <option  @if(@$bibleData->ribbonColor=="white") selected @endif value="white">white</option>
            </select>
            <!-- <input id="ribbonColor" value="{{@$bibleData->ribbonColor}}" type="text" class="form-control required" name="ribbonColor" required autocomplete="" autofocus=""> -->
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Week Description<span class="required_star">*</span></label>
        <div class="col-md-6">
            <input value="{{@$bibleData->weekDescription}}"  id="weekDescription" type="text" class="form-control required" name="weekDescription" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Psalter<span class="required_star">*</span></label>
        <div class="col-md-6">
            <input value="{{@$bibleData->psalter}}"  id="psalter" type="text" class="form-control required" required name="psalter" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Saint Of The Day<span class="required_star">*</span></label>
        <div class="col-md-6">
            <input value="{{@$bibleData->saintOfTheDay}}"  id="saintOfTheDay" type="text" class="form-control required" name="saintOfTheDay" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Saint Of The Day Text<span class="required_star">*</span></label>
        <div class="col-md-6">
            <input value="{{@$bibleData->saintOfTheDayText}}"  id="saintOfTheDayText" type="text" class="form-control required" name="saintOfTheDayText" required="" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Significance Of The Day</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->significanceOfTheDay}}" id="significanceOfTheDay" type="text" class="form-control" name="significanceOfTheDay" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">First Reading Reference<span class="required_star">*</span></label>
        <div class="col-md-6">
            <textarea rows="5" id="firstReadingReference"  class="form-control required" name="firstReadingReference" required="" autocomplete=""  rows="5">{{@$bibleData->firstReadingReference}}</textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">First Reading Title</label>
        <div class="col-md-6">
            <input id="firstReadingTitle" value="{{@$bibleData->firstReadingTitle}}"  type="text" class="form-control" name="firstReadingTitle"  autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">First Reading Text<span class="required_star">*</span></label>
        <div class="col-md-6">
            <textarea rows="5" id="firstReadingText"  class="form-control required" name="firstReadingText" required="" autocomplete="" autofocus="">{{@$bibleData->firstReadingText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty" value="{{@$bibleData->firstReadingText}}">
        <label for="" class="col-md-4 col-form-label text-md-right">Psalm Reference</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->psalmReference}}"  id="psalmReference" type="text" class="form-control" name="psalmReference"  autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right"> Responsorial Psalm</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->psalmResponse}}" id="psalmResponse" type="text" class="form-control" name="psalmResponse" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Psalm Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="psalmText" type="text" class="form-control" name="psalmText" autocomplete="" autofocus="">{{@$bibleData->psalmText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Second Reading Reference</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->secondReadingReference}}" id="secondReadingReference" type="text" class="form-control" name="secondReadingReference"   autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Second Reading Title</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->secondReadingTitle}}"  id="secondReadingTitle" type="text" class="form-control " name="secondReadingTitle" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Second Reading Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="secondReadingText" type="text" class="form-control" name="secondReadingText"   autocomplete="" autofocus="">{{@$bibleData->secondReadingText}}</textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Gospel Acclamation</label>
        <div class="col-md-6">
            <textarea rows="5" id="gospel_accumulation"  class="form-control" name="gospel_accumulation" autocomplete="" autofocus="">{{@$bibleData->gospel_accumulation}}
            </textarea> 
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Gospel Reference</label>
        <div class="col-md-6">
            <input value="{{@$bibleData->gospelReference}}"  id="gospelReference" type="text" class="form-control" name="gospelReference"  autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Gospel Title </label>
        <div class="col-md-6">
            <input  value="{{@$bibleData->gospelTitle}}" id="gospelTitle" type="text" class="form-control" name="gospelTitle" autocomplete="" autofocus="">
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Gospel Text<span class="required_star">*</span></label>
        <div class="col-md-6">
            <textarea rows="5" id="gospelText" class="form-control required" name="gospelText" required="" autocomplete="" autofocus="">{{@$bibleData->gospelText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Prayer of the Faithful</label>
        <div class="col-md-6">
            <textarea rows="5" id="prayer_faith"  class="form-control" name="prayer_faith" autocomplete="" autofocus="">{{@$bibleData->prayer_faith}}
            </textarea> 
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Reflection Text<span class="required_star">*</span></label>
        <div class="col-md-6">
            <textarea rows="5" id="reflectionText"  class="form-control required" name="reflectionText" required="" autocomplete="" autofocus="">{{@$bibleData->reflectionText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Read Text </label>
        <div class="col-md-6">
            <textarea rows="5" id="readText" class="form-control" name="readText" autocomplete="" autofocus="">{{@$bibleData->readText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Reflect Text </label>
        <div class="col-md-6">
            <textarea rows="5" id="reflectText"  class="form-control" name="reflectText"   autocomplete="" autofocus="">{{@$bibleData->reflectText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Pray Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="prayText"  class="form-control" name="prayText" autocomplete="" autofocus="">{{@$bibleData->prayText}}
            </textarea>
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Act Text</label>
        <div class="col-md-6">
            <textarea rows="5" id="actText"  class="form-control" name="actText" autocomplete="" autofocus="">{{@$bibleData->actText}}
            </textarea> 
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <label for="" class="col-md-4 col-form-label text-md-right">Daily Quote<span class="required_star">*</span></label>
        <div class="col-md-6">
            <textarea rows="5" id="dailyQuote"  class="form-control required" name="dailyQuote" required="" autocomplete="" autofocus="">{{@$bibleData->dailyQuote}}
            </textarea> 
        </div>
     <span class="material-input"></span>
    </div>
    <div class="form-group row is-empty">
        <!-- <label for="" class="col-md-4 col-form-label text-md-right">Intercessory Prayers</label> -->
        <div class="col-md-6">
            <!-- <textarea rows="5" id="intercessoryPrayer"  class="form-control" name="intercessoryPrayer" autocomplete="" autofocus="">{{@$bibleData->intercessoryPrayer}}
            </textarea>  -->
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