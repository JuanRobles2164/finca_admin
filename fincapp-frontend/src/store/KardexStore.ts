import { PostRegistrarMovimientoKardex } from "@/models/request/kardex/PostRegistrarMovimientoKardexRequest";
import { KardexMaterial } from "@/models/response/kardex/KardexMaterial";
import KardexService from "@/services/KardexService";
import { defineStore } from "pinia";

/* eslint-disable */

const kardexService = new KardexService();

export const useKardexStore = defineStore('kardex', {
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
                await this.fetchExistenciaMateriales();
            } catch (error) {
                this.error = 'Error al registrar movimiento de kardex';
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    }
});