import { Factura } from "@/models/Factura";
import { CreateFacturaRequest } from "@/models/request/factura/CreateFacturaRequest";
import FacturaService from "@/services/FacturaService";
import { defineStore } from "pinia";

const facturaService = new FacturaService();

export const useFacturaStore = defineStore('factura', {
    state: () => ({
        facturas: [] as Factura[],
        loading: false,
        error: null as string | null,
        factura: {} as Factura,
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
        async registrarVenta(createFacturaRequest: CreateFacturaRequest) {
            this.loading = true;
            this.error = null;
            try {
                await facturaService.postRegistrarVenta(createFacturaRequest);
                await this.fetchFacturas();
            } catch (error) {
                this.error = 'Error al registrar la factura';
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    }
})