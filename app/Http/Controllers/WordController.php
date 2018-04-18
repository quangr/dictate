<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;

class WordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
    }
    public function generate(Request $request,$word)
    {
        $exe=$word;
        exec('python /home/ftp/www/storage/scripts/audio.py '.$exe.' '.$request->auth->id.' 2>&1', $result);
        return view('words.dictating',['audios'=>$result]);
    }
    public function dictate(Request $request)
    {
        $words= new Word();
        return view('words.dictate',['results'=>$words->word($request->auth->id)]);
    }
    public function showadd(Request $request)
    {
        $words= new Word();
        return view('words.show',['results'=>$words->word($request->auth->id)]);
    }

    public function delete(Request $request)
    {
        $word= new Word();
        if ($word->checkdelete($request->auth->id,$request->input('id'))) 
        {
            $word->deleteword($request->input('id'));
        }
        return response()->json(['message'=>'delete successfully'], 200);
    }

    public function add(Request $request)
    {
        $words=explode(";", $request->input('data'));
        foreach ($words as $a) {
            $word= new Word();        
            $word->word=$a;
            $word->date=$request->input('date');
            $word->userid=$request->auth->id;
            $word->save();
        }
        return 'sccc';
    }


    public function showlist(Request $request,$date)
    {
        $words= new Word();
        return view('words.show',['words'=>$words->datalist($date,$request->auth->id)]);
    }
    public function show($word)
    {
        exec('python /home/ftp/www/storage/scripts/lyrics.py '.$word.' 2>&1', $result);
        foreach ($result as $a) {
            print_r($a);
    print_r('<br>');

        }
}

    }


