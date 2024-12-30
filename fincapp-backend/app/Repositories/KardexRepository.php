<?php

namespace App\Repositories;

use App\Models\Kardex;
use Illuminate\Support\Facades\DB;

class KardexRepository extends BaseRepository
{

    public function getModel()
    {
        return new Kardex();
    }

    public function registrarMovimientoKardex($materialId, $cantidad, $tipoMovimiento = "Entra")
    {
        // Obtener el último movimiento del Kardex para calcular el total actualizado
        $ultimoMovimiento = $this->obtenerUltimoMovimientoKardexPorMaterial($materialId);

        // Determinar el total del inventario basado en el tipo de movimiento
        $totalInventario = $ultimoMovimiento ? $ultimoMovimiento->total_inventario : 0;

        if ($tipoMovimiento === "Entra") {
            $totalInventario += $cantidad;
        } else {
            $totalInventario -= $cantidad;
        }

        // Registrar el nuevo movimiento en la tabla kardex y retornar objeto
        return $this->getModel()->create([
            'material_id' => $materialId,
            'cantidad' => $cantidad,
            'tipo_movimiento' => $tipoMovimiento,
            'total_inventario' => $totalInventario,
        ]);
    }

    public function obtenerUltimoMovimientoKardexPorMaterial($materialId)
    {
        return $this->getModel()
            ->where('material_id', $materialId)
            ->orderBy('id', 'desc')
            ->first();
    }

    function listarExistenciaMateriales()
    {
        return Kardex::select('kardex.material_id', 'materiales.nombre as material', 'materiales.tipo_material', 'kardex.total_inventario')
            ->join('materiales', 'kardex.material_id', '=', 'materiales.id')
            ->whereIn('kardex.id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('kardex')
                    ->groupBy('material_id');
            })
            ->get();
    }
}
