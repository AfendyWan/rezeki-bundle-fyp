<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class SaleItemCategory extends Model
{
    use HasFactory;
    use Sortable;
    protected $fillable = ['name', 'description','quantity', 'updated_at'];
    // public $sortable = ['id', 'name', 'description', 'quantity'];
}
