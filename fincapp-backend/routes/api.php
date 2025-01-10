<?php

use App\Http\Controllers\ComprasController;
use App\Http\Controllers\CultivosController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\KardexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\TercerosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('materiales')->group(function () {
    Route::get('/', [MaterialController::class, 'get'])->name('materials.get');
    Route::get('find/{id}', [MaterialController::class, 'find'])->name('materials.find');
    Route::get('find-by-params', [MaterialController::class, 'findByParams'])->name('materials.findByParams');
    Route::post('create', [MaterialController::class, 'create'])->name('materials.create');
    Route::put('update', [MaterialController::class, 'update'])->name('materials.update');
});

Route::prefix('terceros')->group(function () {
    Route::get('/', [TercerosController::class, 'get'])->name('terceros.get');
    Route::get('find/{id}', [TercerosController::class, 'find'])->name('terceros.find');
    Route::get('find-by-params', [TercerosController::class, 'findByParams'])->name('terceros.findByParams');
    Route::post('create', [TercerosController::class, 'create'])->name('terceros.create');
    Route::put('update', [TercerosController::class, 'update'])->name('terceros.update');
});

Route::prefix('compras')->group(function () {
    Route::get('/', [ComprasController::class, 'get'])->name('compras.get');
    Route::post('/create', [ComprasController::class, 'create'])->name('compras.create');
    Route::get('find/{id}', [ComprasController::class, 'find'])->name('compras.find');
});

Route::prefix('facturas')->group(function () {
    Route::get('/', [FacturasController::class, 'get'])->name('facturas.get');
    Route::post('/create', [FacturasController::class, 'create'])->name('facturas.create');
    Route::get('find/{id}', [FacturasController::class, 'find'])->name('facturas.find');
});

Route::prefix('kardexes')->group(function () {
    Route::get('listar-existencia-materiales', [KardexController::class, 'listarExistenciaMateriales'])->name('kardexes.listarExistenciaMateriales');
    Route::put('editar-ultimo-kardex-por-material', [KardexController::class, 'editarUltimoKardexPorMaterial'])->name('kardexes.editarUltimoKardexPorMaterial');
    Route::post("registrar-movimiento-kardex", [KardexController::class, 'registrarMovimientoKardex'])->name('kardexes.registrarMovimientoKardex');
});

Route::prefix('cultivos')->group(function () {
    Route::get('materiales-disponibles', [CultivosController::class, 'listarMaterialesDisponiblesParaCultivo'])->name('cultivos.listarMaterialesDisponiblesParaCultivo');
    Route::post('agregar', [CultivosController::class, 'agregarCultivo'])->name('cultivos.agregarCultivo');
    Route::post('consumir-insumos', [CultivosController::class, 'consumirInsumosPorCultivo'])->name('cultivos.consumirInsumosPorCultivo');
    Route::post('recoger-cosecha', [CultivosController::class, 'recogerCosecha'])->name('cultivos.recogerCosecha');
    Route::get('materiales-procesables', [CultivosController::class, 'listarMaterialesProcesables'])->name('cultivos.listarMaterialesProcesables');
    Route::post('finalizar-cosecha', [CultivosController::class, 'finalizarCosecha'])->name('cultivos.finalizarCosecha');
});
