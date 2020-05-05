<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\Controllers;
use  Illuminate\Http\segments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
//use Facades\App\Repository\Producs;
use Illuminate\Support\Facades\Cache;
class CatController extends Controller
{


        static public function allCats(Request $request)
        {
            $b = fopen('storage/cats.txt', "rb");

            $lines = array();
            while (($line = fgets($b)) !== false)
                array_push($lines, $line);
            //$cats = array($lines[rand(0, 66)], $lines[rand(0, 66)], $lines[rand(0, 66)]);
            $cats = array(substr($lines[rand(0, 66)],0, -1),substr($lines[rand(0, 66)],0, -1),substr($lines[rand(0, 66)],0, -1));
             $arrtostring= implode(" , ",$cats);


                $time = date("Y/m/d H:m:s");
                $url =  $request->path();

                    DB::table('visitors')->insert(
                        ['url' => $url, 'visitors' => 1]
                    );

                        $countN=  DB::table('visitors')->where('url',$url)->sum(value('visitors'));
                        $countAll=  DB::table('visitors')->sum(value('visitors'));
                        $info = array ( 'time'=> $time, 'url'=> $url, 'cat' => $cats , 'countN'=>$countN, 'countAll'=>$countAll);
                        $c = fopen('storage/stats.json', 'a+');
                        fwrite($c, json_encode($info, 1, JSON_PRETTY_PRINT) . PHP_EOL);



            return json_encode($arrtostring);


    }




}
