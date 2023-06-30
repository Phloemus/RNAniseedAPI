<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;

    protected $table='sc_rna_datasets';

    protected $fillable = [
        'specie_id',
        'name',
        'description'
    ];

    /**
     * Get cells associated with the dataset
     */
    public function cells()
    {
        return $this->hasMany(Cell::class);
    }


}
