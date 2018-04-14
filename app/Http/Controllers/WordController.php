<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class WordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        //
    }
        public function showadd()
    {
        $words= new Word();
        return view('words.show',['results'=>$words->word()]);
    }


    public function showlist()
    {
    }
    public function show($word)
    {
        exec('python /home/ftp/www/storage/lyrics.py '.$word.' 2>&1', $result);
        foreach ($result as $a) {
            print_r($a);
    print_r('<br>');

        }
}

    }


