<?php

namespace App\Domain;

use App\Common\Constants;
use App\Models\BiometricoMaterial;
use App\Models\HistoricoMaterial;
use App\Repositories\BiometricoMaterialRepository;
use App\Repositories\Factory\RepositoryFactory;
use App\Repositories\HistoricoMaterialRepository;
use App\Repositories\KardexRepository;
use App\Repositories\MaterialRepository;
use Exception;
use PHPUnit\TextUI\Configuration\Constant;

class CultivoDomain {
    private KardexRepository $kardexRepository;
    private MaterialRepository $materialRepository;
    private BiometricoMaterialRepository $biometricoMaterialRepository;
    private HistoricoMaterialRepository $historicoMaterialRepository;

    function __construct()
    {
        $this->kardexRepository = RepositoryFactory::make(KardexRepository::class);
        $this->materialRepository = RepositoryFactory::make(MaterialRepository::class);
        $this->biometricoMaterialRepository = RepositoryFactory::make(BiometricoMaterialRepository::class);
        $this->historicoMaterialRepository = RepositoryFactory::make(HistoricoMaterialRepository::class);
    }

    function materialesDisponiblesParaCultivo(){
        return $this->materialRepository->getMaterialesParaCultivar();
    }


    /**
     * Si el cultivo ya existe, creará un nuevo movimiento de Kardex
     * Si el cultivo no existe, creará todo de cero y dejará configurado el cultivo
     *
     * @param int $materialId
     *
     * @return object
     *
     */
    function agregarCultivo($materialId, $edad, $cantidad, $adquisicion = 'Compra',){
        $isSuccess = true;
        try{
            // Verifica si ya hay un registro de este material en biometrico_material
            $registroBiometrico = $this->biometricoMaterialRepository->verificaExistenciaCultivo($materialId);
            if($registroBiometrico == null){
                $biometrico_material_params = [
                    'edad' => $edad,
                    'sexo' => Constants::BIOMETRICOS_MATERIAL_SEXO_INDETERMINADO,
                    'adquisicion' => $adquisicion,
                    'material_id' => $materialId
                ];
                $registroBiometrico = $this->biometricoMaterialRepository->create($biometrico_material_params);
            }

            // Mueve el kardex, aumentando o creando las existencias de materiales
            $this->kardexRepository->registrarMovimientoKardex($materialId, $cantidad, Constants::KARDEX_TIPO_MOVIMIENTO_ENTRA);
        }catch(Exception $e){
            $isSuccess = false;
        }

        return $isSuccess;
    }


    /**
     * Recibe el id del cultivo que consumió los insumos y luego va moviendo del kardex los insumos que fué consumiendo
     *
     * @param mixed $materialIdCultivo
     * @param mixed $insumosConsumidos [['material_id' => 4, 'cantidad' => 20], []]
     *
     * @return [type]
     *
     */
    function consumirInsumosPorCultivo($materialIdCultivo, $insumosConsumidos){
        $isSuccess = true;
        try{
            $registroBiometrico = $this->biometricoMaterialRepository->verificaExistenciaCultivo($materialIdCultivo);
            foreach($insumosConsumidos as $ic){
                $materialObj = $this->materialRepository->find($ic['material_id']);
                // Actualiza las existencias en el Kardex
                $ultimoMovimientoKardex = $this->kardexRepository->obtenerUltimoMovimientoKardexPorMaterial($ic['material_id']);
                // Si hay suficientes existencias para realizar el movimiento...
                if($ultimoMovimientoKardex->total_inventario <= (doubleval($ic['cantidad']))){
                    $nuevoMovimientoKardex = $this->kardexRepository->registrarMovimientoKardex($ic['material_id'], $ic['cantidad'], Constants::KARDEX_TIPO_MOVIMIENTO_SALE);

                    // Audita el consumo de insumos
                    $historicoMaterialParams = [
                        'descripcion' => "CONSUMO DE INSUMOS: ".$ic['nombre']." - ".$ic['cantidad']." ".$materialObj->unidad,
                        'kardex_id' => $nuevoMovimientoKardex->id,
                        'biometrico_material_id' => $registroBiometrico->id
                    ];

                    $this->historicoMaterialRepository->create($historicoMaterialParams);
                }
            }

        }catch(Exception $e){
            $isSuccess = false;
        }

        return $isSuccess;
    }

    function recogerCosecha($materialIdCultivo, $materialIdRecoge, $cantidadMaterialRecogido){
        $isSuccess = true;
        try{
            $materialObjRecogido = $this->materialRepository->find($materialIdRecoge);
            $nuevoKardexMaterialRecogido = $this->kardexRepository->registrarMovimientoKardex($materialIdRecoge, $cantidadMaterialRecogido);

            $biometricoMaterialCultivo = $this->biometricoMaterialRepository->verificaExistenciaCultivo($materialIdCultivo);

            $historicoMaterialParams = [
                'descripcion' => "SE RECOGE COSECHA. ".$materialObjRecogido->nombre." - ".$cantidadMaterialRecogido." ".$materialObjRecogido->unidad,
                'kardex_id' => $nuevoKardexMaterialRecogido->id,
                'biometrico_material_id' => $biometricoMaterialCultivo->id
            ];

            $this->historicoMaterialRepository->create($historicoMaterialParams);
        }catch(Exception $e){
            $isSuccess = false;
        }

        return $isSuccess;
    }

    /**
     * Obtiene los materiales disponibles para procesar
     *
     * @return [type]
     *
     */
    function listarMaterialesProcesables(){
        return $this->materialRepository->getMaterialesParaProcesar();
    }


    /**
     * Toma una cosecha. Indica cuánta procesó primero. Después, indica en qué material se convirtió luego del proceso y cuánto de ese material
     *
     * @param int $materialIdCosechaSinFinalizar
     * @param double $cantidadCosechaSinFinalizarTotal
     * @param int $materialIdCosechaFinalizada
     * @param double $cantidadCosechaFinalizada
     *
     * @return [type]
     *
     */
    function finalizarCosecha($materialIdCosechaSinFinalizar, $cantidadCosechaSinFinalizarTotal, $materialIdCosechaFinalizada, $cantidadCosechaFinalizada){
        $kardexCosechaSinFinalizar = $this->kardexRepository->obtenerUltimoMovimientoKardexPorMaterial($materialIdCosechaSinFinalizar);
        if($kardexCosechaSinFinalizar->total_inventario <= doubleval($cantidadCosechaSinFinalizarTotal)){
            // Me dice cuánto es el nuevo total y cuánto material se procesó
            $diferenciaInventario = $kardexCosechaSinFinalizar->total_inventario - doubleval($cantidadCosechaSinFinalizarTotal);
            // Mueve el Kardex de la cosecha sin procesar
            $this->kardexRepository->registrarMovimientoKardex($materialIdCosechaSinFinalizar, $diferenciaInventario, Constants::KARDEX_TIPO_MOVIMIENTO_SALE);
            // Mueve el kardex de la cosecha procesada
            $this->kardexRepository->registrarMovimientoKardex($materialIdCosechaFinalizada, $cantidadCosechaFinalizada, Constants::KARDEX_TIPO_MOVIMIENTO_ENTRA);
        }
    }
}
