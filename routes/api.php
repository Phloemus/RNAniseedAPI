<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmbryoController;
use App\Http\Controllers\CellController;
use App\Http\Controllers\GeneController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SpecieController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\VisualizationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


/********************** Simple routes ******************************** /
 * 
 * Routes allowing give simple data to the database, the structure of 
 * the queries in there only imply a single table in the database and 
 * only give simple json to work with 
 * 
 * 
 * --- Cell Routes ------------------------------------------------
 * 
 *  GET: /cells         : get all the cells from the cell table 
 *                        in the database
 * 
 * 
 * --- Gene Routes ------------------------------------------------
 * 
 *  GET: /genes         : get all the genes from the gene table
 *                        in the database
 * 
 * 
 * */
Route::get('/species', [SpecieController::class, 'index']);
Route::get('/species/{id}/datasets', [SpecieController::class, 'getDatasetBySpecie']);

Route::get('/datasets/{id}/stages', [DatasetController::class, 'getCellStagesByDataset']);

##! Route::get('/embryos', [EmbryoController::class, 'index']);
##! Route::get('/embryos/{id}/cells', [EmbryoController::class, 'getEmbryoCells']);

Route::get('/cells', [CellController::class, 'index']);
Route::get('/cells/{id}', [CellController::class, 'getOneCell']);

Route::get('/genes', [GeneController::class, 'index']);
Route::get('/genes/{id}', [GeneController::class, 'getOneGene']);
Route::get('/genes/name/{name}', [GeneController::class, 'getGeneByName']);

Route::post('/visualize/explore', [VisualizationController::class, 'explore']);




/********************** Searching routes ******************************** /
 * 
 * Routes allowing to execute complex search queries to the database
 * 
 * */
Route::get('/genes/cells/{id}', [SearchController::class, 'searchGenesTranscriptionByCellId']);
Route::get('/genes/embryos/{id}', [SearchController::class, 'searchGenesTranscriptionByEmbryoId']);
