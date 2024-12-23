<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory; 
    protected $table = 'property_types'; // Explicitly define the table name
    protected $fillable = ['type_name', 'type_icon']; // Allow mass assignment

}