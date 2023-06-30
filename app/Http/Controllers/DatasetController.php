<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dataset;

class DatasetController extends Controller
{
    
    // get the cell stages having data related to the datasetId provided
    // its a bit more complicated because we should pass by the cell.
    // A cell has one cellstage and a dataset has many cells
    public function getCellStagesByDataset($id) {
        $stages = Dataset::find($id)->cells()->get()->groupBy('stage')->all();
        $keys = array_keys($stages);
        $response = [];
        for($i = 0; $i < count($stages); $i++) {
            $resp = [
                "id" => $i + 1,
                "name" => $keys[$i] . " cells stage",
                "description" => "Development stage corresponding to embryos having " . $keys[$i] . " cells"
            ];
            array_push($response, $resp);
        }
        return response($response, 200);
    }

}
