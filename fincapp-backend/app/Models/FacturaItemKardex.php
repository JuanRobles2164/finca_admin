<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FacturaItemKardex extends Pivot
{
    protected $table = "factura_items_kardex";
    protected $guarded = [];
}
