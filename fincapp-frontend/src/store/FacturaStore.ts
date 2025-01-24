import { Factura } from "@/models/Factura";
import FacturaService from "@/services/FacturaService";
import { defineStore } from "pinia";

const facturaService = new FacturaService();

export const useFacturaStore = defineStore('factura', {
    state: () => ({
        facturas: [] as Factura[],
        loading: false,
        error: null as string | null,
        factura: {} as Factura,
        factura_details: {} as Blob | MediaSource,
    }),
    actions: {
        async fetchFacturas() {
            this.loading = true;
            this.error = null;
            try {
                this.facturas = await facturaService.getExistenciaFacturas();
            } catch (error) {
                this.error = 'Error al consultar';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        async registrarVenta(formData: FormData) {
            this.loading = true;
            this.error = null;
            try {
                await facturaService.postRegistrarVenta(formData);
                await this.fetchFacturas();
            } catch (error) {
                this.error = 'Error al registrar la factura';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        async facturaDetails(factura_id: number){
            this.loading = true;
            this.error = null;
            try {
                this.factura_details = await facturaService.getFacturaDetails(factura_id);
            } catch (error) {
                this.error = "Error al consultar los detalles";
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    }
})