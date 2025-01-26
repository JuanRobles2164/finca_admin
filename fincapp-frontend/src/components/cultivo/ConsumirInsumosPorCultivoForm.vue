<template>
    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Consumir Insumos por Cultivo</h2>
        <form @submit.prevent="submitForm">
            <!-- Seleccionar cultivo -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cultivo</label>
                <select v-model="form.material_id_cultivo"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                    <option v-for="cultivo in cultivosVigentes" :key="cultivo.id" :value="cultivo.id">
                        {{ cultivo.nombre }}
                    </option>
                </select>
            </div>

            <!-- Insumos consumidos -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Insumos Consumidos</label>
                <div v-for="(insumo, index) in form.insumos_consumidos" :key="index" class="flex gap-2 mb-2">
                    <select v-model="insumo.material_id" class="w-1/2 p-2 border border-gray-300 rounded-md" required>
                        <option v-for="material in materialesCultivables" :key="material.id" :value="material.id">
                            {{ material.nombre }}
                        </option>
                    </select>
                    <input v-model.number="insumo.cantidad" type="number"
                        class="w-1/2 p-2 border border-gray-300 rounded-md" placeholder="Cantidad" required />
                </div>
                <button type="button" @click="addInsumo"
                    class="mt-2 bg-green-500 text-white p-1 rounded-md hover:bg-green-600">
                    + Agregar Insumo
                </button>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                Consumir Insumos
            </button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useCultivoStore } from '@/store/CultivoStore';
import { ConsumirInsumosPorCultivoRequest } from '@/models/request/cultivo/ConsumirInsumosPorCultivoRequest';
import { CultivoVigente } from '@/models/response/cultivo/CultivosVigente';
import { Material } from '@/models/Material';
import { useNotificationStore } from '@/store/components/NotificationStore';

const notificationStore = useNotificationStore();
const cultivoStore = useCultivoStore();
const cultivosVigentes = ref<CultivoVigente[]>([]);
const materialesCultivables = ref<Material[]>([]);

const form = ref<ConsumirInsumosPorCultivoRequest>({
    material_id_cultivo: 0,
    insumos_consumidos: [{ material_id: 0, cantidad: 0, nombre: '' }],
});

// Cargar cultivos vigentes y materiales cultivables
onMounted(async () => {
    await cultivoStore.fetchCultivosVigentes();
    await cultivoStore.listarMaterialesDisponiblesParaCultivo();
    cultivosVigentes.value = cultivoStore.cultivos_vigentes;
    materialesCultivables.value = cultivoStore.cultivables;
});

// Agregar un nuevo insumo
const addInsumo = () => {
    form.value.insumos_consumidos.push({ material_id: 0, cantidad: 0, nombre: '' });
};

// Enviar el formulario
const submitForm = async () => {
    try {
        await cultivoStore.consumirInsumosPorCultivo(form.value);
        notificationStore.addNotification("success", "Exitoso", "Operación exitosa");
        form.value = { material_id_cultivo: 0, insumos_consumidos: [{ material_id: 0, cantidad: 0, nombre: '' }] }; // Resetear formulario
    } catch (error) {
        notificationStore.addNotification("error", "Error", "Error al realizar operación");
    }
};
</script>