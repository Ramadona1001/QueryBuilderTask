<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class HomeController extends Controller
{
    public function index(){
        $client = new Client();
        $data = json_decode(file_get_contents('http://querybuilder.test/api/json_file/input'), true);
        $operation = ['$eq'=>'is_equal','$ne'=>'not_equal','$gt'=>'greater_than','$lt'=>'less_than','$gte'=>'greater_than_or_equal','$lte'=>'less_than_or_equal','$and'=>'and','$or'=>'or'];
        $result = '';
        $result ='{"'.array_search('or',$operation).'":';
        for ($i = 0; $i < count($data); $i++){
            $result .='[{"'.array_search($data[$i]['sub_operation'],$operation).'":[{'.'"'.$data[$i]['column'].'":{ "'.array_search($data[$i]['operation'],$operation).'": "'.$data[$i]['value'][0].'"}},';
            $i++;
            $result .='{'.'"'.$data[$i]['column'].'":{ "'.array_search($data[$i]['operation'],$operation).'": "'.$data[$i]['value'][0].'"}'.'},';
        }
        $result .= ']}';

        return response($result)->withHeaders([
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'attachment; filename="output.txt',
        ]);

        
    }
}
