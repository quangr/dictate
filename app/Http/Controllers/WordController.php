<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Dictate;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        return view('words.dictating',['audios'=>$result,'word'=>$word]);
    }
    public function recordfault(Request $request)
    {
        $json=base64_decode($request->input('data'));
        $ids=json_decode($json,1);
        foreach ($ids as $id) {
            $word = Word::find($id)->word;
            try {
                $model = Dictate::where('word', '=', $word)->where('userid','=',$request->auth->id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $dictate= new Dictate();
                $dictate->word=$word;
                $dictate->last_dictate_date=date("Ymd");
                $dictate->userid=$request->auth->id;
                $dictate->score=1;
                $dictate->save();
                continue;
            }
            $model->last_dictate_date=date("Ymd");
            $model->score=$model->score+1;
            $model->save();
        }
        return 'record success';
    }
    public function dictated(Request $request,$word)
    {
        $words= new Word();
        $dictate= new Dictate();
        $word_c=collect();
        $json=base64_decode($word);
        $dates=json_decode($json,1);
        foreach ($dates as $date) {
            if ($date!='0') {
            $word_c=$word_c->merge($words->datalist($date,$request->auth->id));
            }
            else{
                $word_u=$dictate->wordlist($request->auth->id,20);
                foreach ($word_u as $word) {
                    $word->id=$words->where('word','=',$word->word)->where('userid','=',$request->auth->id)->first()->id;
                }
                $word_c=$word_c->merge($word_u);
            }

        }
        return view('words.dictated',['words'=>$word_c]);
    }
    public function record_d(Request $request)
    {
        $word=$request->input('data');
        $words= new Word();
        $dictate= new Dictate();
        $word_c=collect();
        $json=base64_decode($word);
        $dates=json_decode($json,1);
        foreach ($dates as $date) {
            if ($date!='0') {
            $word_c=$word_c->merge($words->datalist($date,$request->auth->id));
            }
            else{
                $word_c=$word_c->merge($dictate->wordlist($request->auth->id,20));
            }

        }
        foreach ($word_c as $word) {
                        try {
                $model = Dictate::where('word', '=', $word->word)->where('userid','=',$request->auth->id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $dictate= new Dictate();
                $dictate->word=$word->word;
                $dictate->last_dictate_date=date("Ymd");
                $dictate->userid=$request->auth->id;
                $dictate->score=$dictate->score-1;
                $dictate->save();
                continue;
            }
            $model->last_dictate_date=date("Ymd");
            if ($model->score<=0) {
                    $model->score=0;
            }else $model->score=$model->score-1;
            $model->save();
        }
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
        $dictate= new Dictate();
        if ($word->checkdelete($request->auth->id,$request->input('id'))) 
        {
            $dictate->deleteword($request->auth->id,Word::find($request->input('id'))->word);
            $word->deleteword($request->input('id'));
        }
        return response()->json(['message'=>'delete successfully'], 200);
    }

    public function add(Request $request)
    {
        $words=explode(";", $request->input('data'));

        foreach ($words as $a) {
            if ($a=="") continue;
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
        if ($date!='0') {
            $words= new Word();
            return view('words.show',['words'=>$words->datalist($date,$request->auth->id)]);
        }
        else{
            $dictate= new Dictate();
            return view('words.show',['words'=>$dictate->wordlist($request->auth->id,20)]);
        }
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


