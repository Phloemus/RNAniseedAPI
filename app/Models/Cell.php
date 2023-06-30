<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cell extends Model
{
    use HasFactory;

    protected $table='sc_rna_cells';


    protected $fillable = [
        'embryoId',
        'type'
    ];

    protected $hidden = ['pivot'];


    /**
     * Get the genes associated with this cell
     */
    public function genes()
    {
        return $this->belongsToMany(Gene::class, 'sc_rna_counts', 'cell_id', 'gene_id')->withPivot('value');
    }

    /**
     * Get the embryo associated with the cell 
     */
    public function embryo()
    {
        return $this->belongsToOne(Embryo::class, 'embryo_id');
    }

    /**
     * Get the dataset associated with the cell 
     */
    public function dataset()
    {
        return $this->belongsToOne(Dataset::class, 'dataset_id');
    }

}
