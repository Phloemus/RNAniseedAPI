<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devstage extends Model
{
    use HasFactory;

    protected $table='sc_rna_devstages';

    protected $fillable = [
        'name',
        'nb_cells'
        'description'
    ];

}
