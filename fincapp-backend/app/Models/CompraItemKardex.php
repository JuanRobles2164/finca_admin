<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CompraItemKardex extends Pivot
{
    protected $table = "compra_items_kardex";
    protected $guarded = [];
}
