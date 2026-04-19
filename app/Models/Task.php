<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Task extends Model
{
 use HasFactory;
 // Champs autorisés à être remplis via formulaire
 protected $fillable = [
 'title',
 'description',
 'completed',
 ];
}
