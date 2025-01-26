<?php

namespace App\Repositories;

use App\Common\Constants;
use App\Models\Material;
use Illuminate\Support\Facades\DB;

class MaterialRepository extends BaseRepository
{

    public function getModel()
    {
        return new Material();
    }

    public function getMaterialesParaCultivar()
    {
        return $this->getModel()
            ->where('tipo_material', Constants::MATERIALES_TIPO_MATERIAL_CULTIVO)
            ->where('unidad', Constants::MATERIALES_UNIDADES_TOTALIDAD)
            ->get();
    }

    public function getMaterialesParaProcesar()
    {
        return Material::select(
            'materiales.*',
            DB::raw('COALESCE(kardexes.total_inventario, 0) as total_inventario')
        )
            ->leftJoin('kardexes', function ($join) {
                $join->on('kardexes.material_id', '=', 'materiales.id')
                    ->whereIn('kardexes.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('kardexes')
                            ->groupBy('material_id');
                    });
            })
            ->where('materiales.tipo_material', Constants::MATERIALES_TIPO_MATERIAL_PRODUCIDO)
            ->get();
    }

    public function getCultivosVigentes()
    {
        return Material::select(
            'materiales.id as id',
            'materiales.nombre as nombre',
            'materiales.unidad',
            'materiales.tipo_material',
            'materiales.requiere_procesar',
            DB::raw('COALESCE(kardexes.total_inventario, 0) as total_inventario')
        )
            ->leftJoin('kardexes', function ($join) {
                $join->on('kardexes.material_id', '=', 'materiales.id')
                    ->whereIn('kardexes.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('kardexes')
                            ->groupBy('material_id');
                    });
            })
            ->where('materiales.tipo_material', Constants::MATERIALES_TIPO_MATERIAL_CULTIVO)
            ->where('materiales.unidad', Constants::MATERIALES_UNIDADES_TOTALIDAD)
            ->get();
    }
}
