<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specie extends Model
{
    use HasFactory;

    protected $table='sc_rna_species';

    protected $fillable = [
        'name'
    ];

    /*
        Get the all the dev stages involved in a dataset
    */
    public function datasets()
    {
        return $this->hasMany(Dataset::class, 'specie_id');
    }
    
}
