<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JsonFileController extends Controller
{
    public function index($file)
    {
        $file = $file.".txt";
        $path = public_path() . "/json_files/".$file;
        $json = json_decode(file_get_contents($path), true);
        return $json;
    }
}
