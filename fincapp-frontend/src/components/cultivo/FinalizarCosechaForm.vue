<template>
    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Finalizar Cosecha</h2>
        <form @submit.prevent="submitForm">
            <!-- Seleccionar material procesable -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Material Procesable</label>
                <select v-model="form.material_id_cosecha_sin_finalizar"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                    <option v-for="material in materialesProcesables" :key="material.id" :value="material.id">
                        {{ material.nombre }} ({{ material.total_inventario }} disponibles)
                    </option>
                </select>
            </div>

            <!-- Cantidad de cosecha sin finalizar -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad Sin Finalizar</label>
                <input v-model.number="form.cantidad_cosechas_sin_finalizar_total" type="number"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
            </div>

            <!-- Seleccionar material finalizado -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Material Finalizado</label>
                <select v-model="form.material_id_cosecha_finalizada"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                    <option v-for="material in materialesCultivables" :key="material.id" :value="material.id">
                        {{ material.nombre }}
                    </option>
                </select>
            </div>

            <!-- Cantidad de cosecha finalizada -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad Finalizada</label>
                <input v-model.number="form.cantidad_cosecha_finalizada" type="number"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                Finalizar Cosecha
            </button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useCultivoStore } from '@/store/CultivoStore';
import { finalizarCosechaRequest } from '@/models/request/cultivo/FinalizarCosechaRequest';
import { CultivoVigente } from '@/models/response/cultivo/CultivosVigente';
import { Material } from '@/models/Material';

const cultivoStore = useCultivoStore();
const materialesProcesables = ref<CultivoVigente[]>([]);
const materialesCultivables = ref<Material[]>([]);

const form = ref<finalizarCosechaRequest>({
    material_id_cosecha_sin_finalizar: 0,
    cantidad_cosechas_sin_finalizar_total: 0,
    material_id_cosecha_finalizada: 0,
    cantidad_cosecha_finalizada: 0,
});

// Cargar materiales procesables y cultivables
onMounted(async () => {
    await cultivoStore.listarMaterialesProcesables();
    await cultivoStore.listarMaterialesDisponiblesParaCultivo();
    materialesProcesables.value = cultivoStore.materiales_procesables;
    materialesCultivables.value = cultivoStore.cultivables;
});

// Enviar el formulario
const submitForm = async () => {
    try {
        await cultivoStore.finalizarCosecha(form.value);
        alert('Cosecha finalizada exitosamente');
        form.value = {
            material_id_cosecha_sin_finalizar: 0,
            cantidad_cosechas_sin_finalizar_total: 0,
            material_id_cosecha_finalizada: 0,
            cantidad_cosecha_finalizada: 0,
        }; // Resetear formulario
    } catch (error) {
        alert('Error al finalizar la cosecha');
    }
};
</script>