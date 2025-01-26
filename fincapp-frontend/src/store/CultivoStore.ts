import { Material } from "@/models/Material";
import { AgregarCultivoRequest } from "@/models/request/cultivo/AgregarCultivoRequest";
import { ConsumirInsumosPorCultivoRequest } from "@/models/request/cultivo/ConsumirInsumosPorCultivoRequest";
import { finalizarCosechaRequest } from "@/models/request/cultivo/FinalizarCosechaRequest";
import { RecogerCosechaRequest } from "@/models/request/cultivo/RecogerCosechaRequest";
import { CultivoVigente } from "@/models/response/cultivo/CultivosVigente";
import CultivoService from "@/services/CultivoService";
import { defineStore } from "pinia";

const cultivoService = new CultivoService();

export const useCultivoStore = defineStore('cultivo', {
    state: () => ({
        cultivables: [] as Material[],
        cultivo_obj: {} as Material[],
        materiales_procesables: [] as CultivoVigente[],
        cultivos_vigentes: [] as CultivoVigente[],

        loading: false,
        error: null as string | null,
    }),
    actions: {
        async listarMaterialesDisponiblesParaCultivo() {
            this.loading = true;
            this.error = null;
            try {
                this.cultivables = await cultivoService.listarMaterialesDisponiblesParaCultivo();
            } catch (error) {
                this.error = "Error al consultar los cultivables";
                console.log(error);
            }finally{
                this.loading = false;
            }
        },

        async agregarCultivo(agregarCultivoRequest: AgregarCultivoRequest) {
            this.loading = true;
            this.error = null;
            try {
                await cultivoService.agregarCultivo(agregarCultivoRequest);
            } catch (error) {
                this.error = "Error al agregar cultivos";
                console.log(error);
            } finally {
                this.loading = false;
            }
        },

        async consumirInsumosPorCultivo(consumirInsumosRequest: ConsumirInsumosPorCultivoRequest) {
            this.loading = true;
            this.error = null;
            try {
                await cultivoService.consumirInsumosPorCultivo(consumirInsumosRequest);
            } catch (error) {
                this.error = "Error al consumir los insumos";
                console.log(error);
            } finally {
                this.loading = false;
            }
        },

        async recogerCosecha(recogerCosechaRequest: RecogerCosechaRequest) {
            this.error = null;
            this.loading = true;
            try {
                await cultivoService.recogerCosecha(recogerCosechaRequest);
            } catch (error) {
                this.error = "Error al guardar la cosecha";
                console.log(error);
            } finally {
                this.loading = false;
            }
        },

        async listarMaterialesProcesables() {
            this.error = null;
            this.loading = true;
            try {
                this.materiales_procesables = await cultivoService.listarMaterialesProcesables();
            } catch (error) {
                this.error = "Error al listar los materiales procesables";
                console.log(error);
            } finally {
                this.loading = false;
            }
        },

        async finalizarCosecha(finalizarCosechaRequest: finalizarCosechaRequest) {
            this.error = null;
            this.loading = true;
            try {
                await cultivoService.finalizarCosecha(finalizarCosechaRequest);
            } catch (error) {
                console.log(error);
                this.error = "Error al procesar la cosecha";
            } finally {
                this.loading = false;
            }
        },

        async fetchCultivosVigentes(){
            this.error = null;
            this.loading = true;
            try {
                this.cultivos_vigentes = await cultivoService.listarCultivosVigentes();
            } catch (error) {
                console.log(error);
                this.error = "Error al consultar los cultivos vigentes";
            } finally {
                this.loading = false;
            }
        }
    }
});