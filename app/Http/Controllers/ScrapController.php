<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ScrapController extends Controller
{
    public function scrap(){
        $urls = ['http://www.mocky.io/v2/5e400f423300005500b04d0c','http://www.mocky.io/v2/5e4010ad3300004200b04d15'];

        $all_data = [];         
        $all_error = [];
        foreach($urls as $url){
            $response = Http::get($url);
            if($response->status() == 200){
                foreach($response->json() as $res){
                    array_push($all_data, $res);
                }
            }else{
                array_push($all_error, $response->body());
            }
        }         
		
		 $rate = array_column($all_data, 'Rate');
        foreach ($rate as $k => $row)
        {
            if($row == '*'){
                $rate[$k] = 1;

            }elseif ($row == '**'){
                $rate[$k] = 2;

            }elseif ($row == '***'){
                $rate[$k] = 3;

            }elseif ($row == '****'){
                $rate[$k] = 4;

            }elseif ($row == '*****'){
                $rate[$k] = 5;

            }
        }  
        array_multisort($rate, SORT_DESC, $all_data);
        return response($all_data);
    }
}
