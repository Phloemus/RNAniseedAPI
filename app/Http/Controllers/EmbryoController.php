<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Embryo;


class EmbryoController extends Controller
{
    

    public function index() {
        return Embryo::all();
    }


    public function getEmbryoCells($id) {
        return Embryo::find($id)->cells;
    }

}
