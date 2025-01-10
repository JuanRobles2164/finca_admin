import { CONSTANTS } from "@/common/Constants";
import { PostRegistrarMovimientoKardex } from "@/models/request/kardex/PostRegistrarMovimientoKardexRequest";
import { KardexMaterial } from "@/models/response/kardex/KardexMaterial";
import KardexService from "@/services/KardexService";
import { defineStore } from "pinia";

const kardexService = new KardexService();

export const KardexStore = defineStore('kardex', {
    state: () => ({
        kardexes: [] as KardexMaterial[],
        loading: false,
        error: null as string | null,
        kardex: {} as KardexMaterial,
    }),
    actions: {
        async fetchExistenciaMateriales() {
            this.loading = true;
            this.error = null;
            this.kardexes = [] as KardexMaterial[];
            try {
                this.kardexes = await kardexService.getExistenciaMateriales();
            } catch (error) {
                this.error = 'Error al actualizar consultar la existencia de materiales';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        async registrarMovimientoKardex(cantidad : number, material_id : number, tipo_movimiento : any){
            this.loading = true;
            this.error = null;
            const requestParams : PostRegistrarMovimientoKardex = {
                cantidad: cantidad,
                material_id: material_id,
                tipo_movimiento: tipo_movimiento 
            };
            try {
                await kardexService.postRegistrarMovimientoKardex(requestParams);
            } catch (error) {
                this.error = 'Error al registrar movimiento de kardex';
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    }
});