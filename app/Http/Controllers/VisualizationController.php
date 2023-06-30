<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VisualizationController extends Controller
{
    

    public function explore(Request $request) {
        $rdString = Str::random(12);

        // working : the h5ad file is created correctly
        exec("python3 " . app_path() . "/external/create_h5ad.py " . app_path() . "/external/cxg_data/".$rdString.".h5ad 2>&1", $output, $respCode);

        if($respCode == 0) {
            header("Location: http://127.0.0.1:5005/view/".$rdString.".h5ad", true, 200);
        } else {
            return response([
                "message" => "An error occured during the creation of the h5ad file",
                "py_error_code" => $respCode,
                "py_message" => $output
            ], 500);
        }

        return response([
            "message" => "visualization ready",
            "h5ad_file" => $rdString . ".h5ad"
        ], 200);
    }

}
