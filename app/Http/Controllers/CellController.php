<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cell;

class CellController extends Controller
{

    public function index() {
        return Cell::all();
    }


    public function getOneCell($id) {
        return Cell::find($id);
    }

}
