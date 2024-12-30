<?php

namespace App\Domain;

use App\Repositories\CompraItemKardexRepository;
use App\Repositories\CompraRepository;
use App\Repositories\Factory\RepositoryFactory;
use App\Repositories\KardexRepository;
use Carbon\Carbon;
use PhpParser\Node\Expr\Cast\Double;

class CompraDomain extends BaseDomain {

    private CompraItemKardexRepository $compraItemKardexRepository;
    private KardexRepository $kardexRepository;

    function __construct()
    {
        $this->setRepoInstance(RepositoryFactory::make(CompraRepository::class));
        $this->compraItemKardexRepository = RepositoryFactory::make(CompraItemKardexRepository::class);
        $this->kardexRepository = RepositoryFactory::make(KardexRepository::class);
    }


    /**
     * Registra la auditoría de la compra, a quién se le compró y realiza movimientos de inventario
     *
     * @param array $materialesCompra [[material_id: 5, cantidad: 10, valor_unitario: 500], [...]]
     * @param int $terceroId
     * @param Date $fechaCompra
     *
     * @return object
     *
     */
    function registrarCompra($materialesCompra, $terceroId, $fechaCompra = null){

        if($fechaCompra == null){
            $fechaCompra = Carbon::now();
        }

        $compraParams = [
            'fecha_compra' => $fechaCompra,
            'tercero_id' => $terceroId,
        ];

        $compraObj = $this->create($compraParams);
        $total = 0;

        foreach($materialesCompra as $mc){

            // Registra movimiento de Kardex, aumentando la cantidad de existencias del material en el inventario
            $movimientoKardex = $this->kardexRepository->registrarMovimientoKardex($mc['material_id'], $mc['cantidad']);

            $valorUnitario = doubleval($mc['valor_unitario']);
            $cantidad = doubleval($mc['cantidad']);
            $compraItemKardexParams = [
                'kardex_id' => $movimientoKardex->id,
                'compra_id' => $compraObj->id,
                'valor_unitario' => $valorUnitario,
                'cantidad' => $cantidad
            ];

            $total += ($valorUnitario * $cantidad);

            // Registra la auditoría de la compra (el detalle)
            $this->compraItemKardexRepository->create($compraItemKardexParams);
        }

        $compraObj->total = $total;
        $compraObj->save();

        return $compraObj;
    }


}
