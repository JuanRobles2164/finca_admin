import { CreateTerceroRequest } from "@/models/request/tercero/CreateTerceroRequest";
import { UpdateTerceroRequest } from "@/models/request/tercero/UpdateTerceroRequest";
import { Tercero } from "@/models/Tercero";
import TerceroService from "@/services/TerceroService";
import { defineStore } from "pinia";

const terceroService = new TerceroService();

export const useTerceroStore = defineStore('tercero', {
    state: () => ({
        terceros: [] as Tercero[],
        loading: false,
        error: null as string | null,
        tercero : {} as Tercero,
    }),
    actions: {
        async fetch() {
            this.loading = true;
            this.error = null;
            try {
                this.terceros = await terceroService.getObjects();
            } catch (error) {
                this.error = 'Error al cargar';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        async createObject(createRequest: CreateTerceroRequest) {
            this.loading = true;
            this.error = null;
            try {
                const newObject = await terceroService.createObject(createRequest);
                this.terceros.push(newObject);
            } catch (error) {
                this.error = 'Error al crear';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        async updateObject(objectUpdateRequest: UpdateTerceroRequest) {
            this.loading = true;
            this.error = null;
            try {
                await terceroService.updateObject(objectUpdateRequest);
                const index = this.terceros.findIndex((m) => m.id === objectUpdateRequest.object_id);
                if (index !== -1) {
                    this.terceros[index] = { ...this.terceros[index], ...objectUpdateRequest.data };
                }
            } catch (error) {
                this.error = 'Error al actualizar';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        async findMaterial(materialId: number) {
            this.loading = true;
            this.error = null;
            this.tercero = {} as Tercero;
            try {
                this.tercero = await terceroService.findTercero(materialId);
            } catch (error) {
                this.error = 'Error al buscar';
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    }
})