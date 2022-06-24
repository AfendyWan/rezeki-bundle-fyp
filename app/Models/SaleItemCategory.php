<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class SaleItemCategory extends Model
{
    use HasFactory;
    use Sortable;
    protected $fillable = ['name', 'description','quantity'];
    // public $sortable = ['id', 'name', 'description', 'quantity'];
}
