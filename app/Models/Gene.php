<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gene extends Model
{
    use HasFactory;

    protected $table='sc_rna_genes';

    protected $fillable = [
        'enaId',
        'organism',
        'function',
        'name',
        'isCharacterized'
    ];

    protected $hidden = ['pivot'];

    /**
     * Get the cells associated with this gene
     */
    public function cells()
    {
        return $this->belongsToMany(Cell::class, 'sc_rna_counts', 'gene_id', 'cell_id')->withPivot('value');
    }

}
