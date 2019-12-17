<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Prayer;
use App\Bibledata ;
use Config;
use DB;
class FileController extends Controller {
    public function importExportExcelORCSV(){
        return view('file_import_export');
    }
    public function importFileIntoDB(Request $request){
        if($request->hasFile('sample_file')){
            $path = $request->file('sample_file')->getRealPath();
            $data = \Excel::load($path)->get();
            if($data->count()){
                foreach ($data as $key => $value) {
                    $arr[] = ['name' => $value->name, 'details' => $value->details];
                }
                if(!empty($arr)){
                    \DB::table('products')->insert($arr);
                    dd('Insert Record successfully.');
                }
            }
        }
        dd('Request data does not have any files to import.');      
    } 
    public function downloadExcelFile($type){
        $products = Product::get()->toArray();
        return \Excel::create('expertphp_demo', function($excel) use ($products) {
            $excel->sheet('sheet name', function($sheet) use ($products)
            {
                $sheet->fromArray($products);
            });
        })->download($type);
    }
    //prayer upload
    public function downloadExcelFilePrayer($type='xlsx'){
        $type='xlsx';
        // print_r( Auth::user()->lang['ShortName']);die();
        $lang= Auth::user()->lang['ShortName']; 
        $products = Prayer::get()->toArray();
        return \Excel::create('prayer_list_'.$lang, function($excel) use ($products) {
            $excel->sheet('sheet name', function($sheet) use ($products)
            {
                $sheet->fromArray($products);
            });
        })->download($type);
    }  
    public function importExcelFilePrayer(Request $request){
         $lang= Auth::user()->lang['ShortName'] ;
        if($request->hasFile('prayer_excel')){
            $path = $request->file('prayer_excel')->getRealPath();
            $data = \Excel::load($path)->get();
            $last_id=0;
            if($data->count()){
                foreach ($data as $key => $value) {
                    if( $value->prayer_audio==""){
                         $value->prayer_audio=null ;
                    }
              if($value->idprayers!=""){

              DB::insert(
            'insert into prayers_'.$lang.'(`idprayers`, `prayer`, `title`,`subtitle`,`text`,`prayer_audio`) values (?,?,?,?,?,?)
            on duplicate key update `idprayers`=values(`idprayers`), `title`=values(`title`), `prayer`=values(`prayer`), `text`=values(`text`), `prayer_audio`=values(`prayer_audio`), `subtitle`=values(`subtitle`)',
            array($value->idprayers, $value->prayer, $value->title, $value->subtitle,$value->text,$value->prayer_audio)
            );
              $last_id =$value->idprayers;
            
                }
              }          

            return redirect('admin/manage-prayer')->with('message-fileupload','Updated Prayer List upto ID '.$last_id);    
            }
        }

        return redirect('admin/manage-prayer')->with('message-fileupload','Request data does not have any files to import');

              
    }  
       
     //prayer upload
    public function downloadExcelFileBibleDate($type='xlsx'){
       
        try{
        $type='xlsx';
       
        // print_r( Auth::user()->lang['ShortName']);die();
        $lang= Auth::user()->lang['ShortName']; 
        $products = Bibledata::get()->toArray();
        ob_start(); //At the very top of your program (first line)


         \Excel::create('bibledata_'.$lang, function($excel) use ($products) {
            $excel->sheet('sheet_name', function($sheet) use ($products)
            {
                $sheet->fromArray($products);
        if (ob_get_level() > 0) { ob_end_clean(); }
                
            });
        })->download($type);
        
            $out = ob_get_contents();

            //Routing the output to the error_log
            error_log($out);                

            //Cleaning the ouput buffer
            ob_end_clean();

         return ;
        }  catch (Exception $e) {
        report($e);
        echo $e->getMessage();
        return false;
    }
    }     

    public function importExcelFileBibleData(Request $request){
        try{
            $lang= Auth::user()->lang['ShortName'] ;
            if($request->hasFile('bible_data_excel')){
                $path = $request->file('bible_data_excel')->getRealPath();
                $data = \Excel::load($path)->get();
                $last_id=0;
    
                if($data->count()){
                    foreach ($data as $key => $value) {
                      $value->dataId= $value->dataid ;
                  if($value->dataId!=""){
    
                  DB::insert(
                'insert into bibledata_'.$lang.'(`dataId`, `date`, `ribbonColor`, `weekDescription`, `psalter`, `saintOfTheDay`, `significanceOfTheDay`, `firstReadingReference`, `firstReadingTitle`, `firstReadingText`, `psalmReference`, `psalmText`, `psalmResponse`, `secondReadingReference`, `secondReadingTitle`, `secondReadingText`, `gospelReference`, `gospelTitle`, `gospelText`, `reflectionText`, `readText`, `reflectText`, `prayText`, `actText`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                on duplicate key update 
                 `dataId`=values(`dataId`), `date`=values(`date`), `ribbonColor`=values(`ribbonColor`), `weekDescription`=values(`weekDescription`), `psalter`=values(`psalter`), `saintOfTheDay`=values(`saintOfTheDay`),`significanceOfTheDay`= values(`significanceOfTheDay`),`firstReadingReference`=values(`firstReadingReference`),`firstReadingTitle`=values(`firstReadingTitle`),`psalmReference`=values(`psalmReference`),
                 `psalmText`=values(`psalmText`),`psalmResponse`=values(`psalmResponse`),`secondReadingReference`=values(`secondReadingReference`),`secondReadingTitle`=values(`secondReadingTitle`),`gospelReference`=values(`gospelReference`),`gospelTitle`=values(`gospelTitle`),`gospelText`=values(`gospelText`),`reflectionText`=values(`reflectionText`),
                 `readText`=values(`readText`),
                 `reflectText`=values(`reflectText`),`prayText`=values(`prayText`),`actText`=values(`actText`)',
                array($value->dataId, $value->date, $value->ribbonColor, $value->weekDescription,$value->psalter,$value->saintOfTheDay,
                    $value->significanceOfTheDay, $value->firstReadingReference, $value->firstReadingTitle, $value->firstReadingText,$value->psalmReference,$value->psalmText,
                $value->psalmResponse, $value->secondReadingReference, $value->secondReadingTitle, $value->secondReadingText,$value->gospelReference,$value->gospelTitle,
                $value->gospelText,$value->reflectionText,$value->readText ,
                $value->reflectText,$value->prayText,$value->actText  )
                );
                $last_id =$value->dataId;
                    }
                  }          
    
                return redirect('admin/manage-dates')->with('message-fileupload','Updated Bibledata upto ID '.$last_id);    
                }
            }
    
            return redirect('admin/manage-dates')->with('message-fileupload','Request data does not have any files to import');
    
                  
        }  catch (Exception $e) {
            report($e);
    
            return false;
        }
        
    }  
}
?>