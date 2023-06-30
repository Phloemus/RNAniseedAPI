<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gene;

class GeneController extends Controller
{
    
    // allow to get all the genes from the database
    public function index() {
        return Gene::all();
    }


    public function getOneGene($id) {
        return Gene::find($id);
    }


    public function getGeneByName($name) {
        return Gene::where('name', $name)->first();
    }


}
