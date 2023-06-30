<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embryo extends Model
{
    
    use HasFactory;

    protected $table='sc_rna_embryos';


    protected $fillable = [
        'type'
    ];


    /**
     * Get all the cells from the embryo 
     */
    public function cells()
    {
        return $this->hasMany(Cell::class);
    }

}
