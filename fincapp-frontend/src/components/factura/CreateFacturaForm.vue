<template>
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-8xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Registrar Factura</h2>

        <form @submit.prevent="submitFactura" class="space-y-6">
            <!-- Contenedor dividido en dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Columna Izquierda: Materiales -->
                <div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tercero" class="block text-sm font-medium text-gray-700 mb-1">Tercero</label>
                            <select id="tercero" v-model="createFacturaRequest.tercero_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled selected>Seleccione un tercero</option>
                                <option v-for="tercero in terceros" :key="tercero.id" :value="tercero.id">
                                    {{ tercero.nombre }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha de
                                Venta</label>
                            <input type="date" id="fecha" v-model="createFacturaRequest.fecha_venta"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>
                    </div>

                    <div class="flex items-center mt-4">
                        <input type="checkbox" id="pagada" v-model="createFacturaRequest.pagada"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50" />
                        <label for="pagada" class="ml-2 block text-sm text-gray-900">¿Pagada?</label>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Materiales de Venta</h3>
                        <div class="space-y-4">
                            <div v-for="(materialVenta, index) in createFacturaRequest.materiales_venta" :key="index"
                                class="bg-gray-50 p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <CustomSelect v-model="materialVenta.material_obj" :options="materiales"
                                        :get-label="labelForSelectMaterial" placeholder="Buscar material" />

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                                        <input type="number" v-model="materialVenta.cantidad"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            min="1" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Valor
                                            Unitario</label>
                                        <input type="number" v-model="materialVenta.valor_unitario"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            min="0" step="0.01" />
                                    </div>
                                </div>
                                <button type="button" @click="removeMaterialVenta(index)"
                                    class="mt-2 text-red-600 hover:text-red-800 text-sm font-medium">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                        <button type="button" @click="addMaterialVenta"
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Agregar Material
                        </button>
                    </div>
                </div>

                <!-- Columna Derecha: Evidencias -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Evidencias</h3>

                    <div
                        class="relative w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                        <template v-if="createFacturaRequest.evidencias.length">
                            <img :src="evidenciaPreview"
                                class="object-cover w-full h-full transition-opacity duration-300" alt="Evidencia">
                        </template>
                        <p v-else class="text-gray-500">No hay evidencias</p>
                    </div>

                    <!-- Botones de navegación en el carrusel -->
                    <div class="flex justify-between mt-2">
                        <button @click="prevEvidencia" type="button"
                            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50"
                            :disabled="currentEvidenciaIndex === 0">⬅</button>
                        <button @click="nextEvidencia" type="button"
                            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50"
                            :disabled="currentEvidenciaIndex === createFacturaRequest.evidencias.length - 1">➡</button>
                    </div>

                    <!-- Botón para agregar evidencias -->
                    <input type="file" @change="handleEvidenciaUpload" accept="image/*"
                        class="mt-4 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200" />
                </div>
            </div>

            <div>
                <button type="submit"
                    class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    :disabled="loading">
                    <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    {{ loading ? "Registrando..." : "Registrar Factura" }}
                </button>
            </div>
        </form>

        <div v-if="error" class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
            role="alert">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline">{{ error }}</span>
        </div>
    </div>
</template>

<script setup lang="ts">
/* eslint-disable */
import { computed, reactive, ref } from "vue";
import { useFacturaStore } from "@/store/FacturaStore";
import { useMaterialStore } from "@/store/MaterialStore";
import { useTerceroStore } from "@/store/TerceroStore";
import { CreateFacturaRequest, MaterialesVenta } from "@/models/request/factura/CreateFacturaRequest";
import Multiselect from "vue-multiselect";
import CustomSelect from "../forms/CustomSelect.vue";

import { useNotificationStore } from "@/store/components/NotificationStore";

const facturaStore = useFacturaStore();
const materialStore = useMaterialStore();
const terceroStore = useTerceroStore();
const notificationStore = useNotificationStore();

const createFacturaRequest = reactive({
    materiales_venta: [] as any[],
    tercero_id: 0,
    fecha_venta: "",
    pagada: false,
    evidencias: [] as File[]
});

// Índice actual del carrusel
const currentEvidenciaIndex = ref(0);

// Computed para obtener la imagen actual
const evidenciaPreview = computed(() => {
    return createFacturaRequest.evidencias.length > 0
        ? URL.createObjectURL(createFacturaRequest.evidencias[currentEvidenciaIndex.value])
        : "";
});

// Función para cambiar a la siguiente evidencia
const nextEvidencia = () => {
    if (currentEvidenciaIndex.value < createFacturaRequest.evidencias.length - 1) {
        currentEvidenciaIndex.value++;
    }
};

// Función para volver a la evidencia anterior
const prevEvidencia = () => {
    if (currentEvidenciaIndex.value > 0) {
        currentEvidenciaIndex.value--;
    }
};

// Manejo de la carga de archivos
const handleEvidenciaUpload = (event: Event) => {
    const files = (event.target as HTMLInputElement).files;
    if (files && files.length > 0) {
        createFacturaRequest.evidencias.push(...Array.from(files));
        currentEvidenciaIndex.value = createFacturaRequest.evidencias.length - 1; // Mostrar la última imagen cargada
    }
};

const resetCreateFacturaRequest = () => {
    createFacturaRequest.materiales_venta = [];
    createFacturaRequest.tercero_id = 0;
    createFacturaRequest.fecha_venta = "";
    createFacturaRequest.pagada = false;
    createFacturaRequest.evidencias = [];
};

const addMaterialVenta = () => {
    createFacturaRequest.materiales_venta.push({
        material_id: 0,
        cantidad: 1,
        valor_unitario: 0,
        material_obj: {}
    } as MaterialesVenta);
};

const removeMaterialVenta = (index: number) => {
    createFacturaRequest.materiales_venta.splice(index, 1);
};

const submitFactura = async () => {
    createFacturaRequest.materiales_venta.forEach(el => {
        el.material_id = el.material_obj.id;
    });

    // Crear FormData para la petición
    const formData = new FormData();
    formData.append("tercero_id", createFacturaRequest.tercero_id.toString());
    formData.append("fecha_venta", createFacturaRequest.fecha_venta);
    formData.append("pagada", createFacturaRequest.pagada.toString());

    // Convertir `materiales_venta` en JSON y agregarlo a FormData
    formData.append("materiales_venta", JSON.stringify(createFacturaRequest.materiales_venta));

    // Adjuntar evidencias
    createFacturaRequest.evidencias.forEach((archivo, index) => {
        formData.append(`evidencias[${index}]`, archivo);
    });

    await facturaStore.registrarVenta(formData);

    notificationStore.addNotification("success", "Factura creada", "Se creó la factura exitosamente");
    resetCreateFacturaRequest();
};


const labelForSelectMaterial = (obj: any) => {
    return `${obj.nombre} - ${obj.unidad}`;
}

const handleSelect = (obj: any) => {
    console.log(obj);
}

materialStore.fetchMateriales();
terceroStore.fetch();

const materiales = computed(() => materialStore.materiales);
const terceros = computed(() => terceroStore.terceros);
const loading = computed(() => facturaStore.loading);
const error = computed(() => facturaStore.error);

</script>