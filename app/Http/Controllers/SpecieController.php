<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specie;

class SpecieController extends Controller
{
    
    public function index() {
        return Specie::all();
    }

    // get the datasets having data related to the specie having the id provided
    public function getDatasetBySpecie($id) {
        $datasets = Specie::find($id)->datasets()->get();
        return response($datasets, 200);
    }
    
}
