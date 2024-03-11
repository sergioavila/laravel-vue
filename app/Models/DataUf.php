<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUf extends Model
{
    use HasFactory;
    protected $table = 'data_ufs'; // protegido para que no se pueda modificar
    protected $fillable = ['date', 'value']; // campos que se pueden modificar desde el front

}
