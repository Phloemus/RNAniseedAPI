<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cell;
use App\Models\Gene;
use App\Models\Embryo;

class SearchController extends Controller
{

    // Get all the genes their transcription level for the cell 
    // having a certain identifier
    public function searchGenesTranscriptionByCellId($id) {
        $start = microtime(true);
        $cell = Cell::find($id);
        $genes = $cell->genes()->orderByDesc('value')->get(['gene_id', 'name', 'function', 'value']);
        $deltaTime = microtime(true) - $start;
        $response = [
            'cell_id' => $cell['id'],
            'genes' => $genes,
            'nb_genes' => count($genes),
            'delta_time' => $deltaTime*1000
        ];
        return response($response, 200);
    }

    public function searchGenesTranscriptionByEmbryoId($id) {
        $cells = Embryo::find($id)->cells;
        $response = [];
        foreach($cells as $cell) {
            $resp = [
                'cell_id' => $cell['id'],
                'genes' => $cell->genes()->orderByDesc('value')->get(['gene_id', 'name', 'function', 'value']),
            ];
            array_push($response, $resp);
        }
        return response($response, 200);
    }

}
