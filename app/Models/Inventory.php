<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory;
    protected $table = 'inventories';
    protected $fillable = [
        'serial',
        'barcode',
        'itemname',
        'description',
        'category',
        'placelocated',
        'receivedby',
        'receivedfrom',
        'status',
    ];
}
