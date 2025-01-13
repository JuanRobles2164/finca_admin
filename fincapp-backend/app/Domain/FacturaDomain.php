<?php

namespace App\Domain;

use App\Common\Constants;
use App\Repositories\Factory\RepositoryFactory;
use App\Repositories\FacturaItemKardexRepository;
use App\Repositories\FacturaRepository;
use App\Repositories\KardexRepository;
use Carbon\Carbon;

class FacturaDomain extends BaseDomain {

    private KardexRepository $kardexRepository;
    private FacturaItemKardexRepository $facturaItemKardexrepository;

    function __construct()
    {
        $this->setRepoInstance(RepositoryFactory::make(FacturaRepository::class));
        $this->kardexRepository = RepositoryFactory::make(KardexRepository::class);
        $this->facturaItemKardexrepository = RepositoryFactory::make(FacturaItemKardexRepository::class);
    }

    /**
     * Recibe un arreglo de materiales indicando cuales, cuantos, qué precio (cada uno) y a quiénes se vendieron
     *
     * @param array $materialesVenta
     * @param int $terceroId
     * @param bool $pagada
     * @param string $fechaVenta
     *
     * @return object
     *
     */
    function registrarVenta($materialesVenta, $terceroId, $pagada = true, $fechaVenta = null){
        if($fechaVenta == null){
            $fechaCompra = Carbon::now();
        }

        $fechaPago = $pagada ? Carbon::now() : null;
        $estado = $pagada ? Constants::FACTURA_ESTADOS_PAGADA : Constants::FACTURA_ESTADOS_DEBE;

        $facturaParams = [
            'fecha_venta' => $fechaVenta,
            'tercero_id' => $terceroId,
            'numero' => Carbon::now()->timestamp,
            'fecha_pago' => $fechaPago,
            'estado' => $estado,
        ];

        $facturaObj = $this->create($facturaParams);
        $total = 0;

        foreach($materialesVenta as $mv){

            // Registra movimiento de Kardex, removiendo la cantidad de existencias del material en el inventario
            $movimientoKardex = $this->kardexRepository->registrarMovimientoKardex($mv['material_id'], $mv['cantidad'], Constants::KARDEX_TIPO_MOVIMIENTO_SALE);

            $valorUnitario = doubleval($mv['valor_unitario']);
            $cantidad = doubleval($mv['cantidad']);
            $facturaItemKardexParams = [
                'kardex_id' => $movimientoKardex->id,
                'factura_id' => $facturaObj->id,
                'valor_unitario' => $valorUnitario,
                'cantidad' => $cantidad
            ];

            $total += ($valorUnitario * $cantidad);

            // Registra la auditoría de la compra (el detalle)
            $this->facturaItemKardexrepository->create($facturaItemKardexParams);
        }

        $facturaObj->total = $total;
        $facturaObj->save();

        return $facturaObj;
    }
}
