<template>
    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Recoger Cosecha</h2>
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

            <!-- Material recogido -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Material Recogido</label>
                <select v-model="form.material_id_recoge"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                    <option v-for="material in materialesCultivables" :key="material.id" :value="material.id">
                        {{ material.nombre }}
                    </option>
                </select>
            </div>

            <!-- Cantidad recogida -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad Recogida</label>
                <input v-model.number="form.cantidad_material_recogido" type="number"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                Recoger Cosecha
            </button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useCultivoStore } from '@/store/CultivoStore';
import { RecogerCosechaRequest } from '@/models/request/cultivo/RecogerCosechaRequest';
import { CultivoVigente } from '@/models/response/cultivo/CultivosVigente';
import { Material } from '@/models/Material';

const cultivoStore = useCultivoStore();
const cultivosVigentes = ref<CultivoVigente[]>([]);
const materialesCultivables = ref<Material[]>([]);

const form = ref<RecogerCosechaRequest>({
    material_id_cultivo: 0,
    material_id_recoge: 0,
    cantidad_material_recogido: 0,
});

// Cargar cultivos vigentes y materiales cultivables
onMounted(async () => {
    await cultivoStore.fetchCultivosVigentes();
    await cultivoStore.listarMaterialesDisponiblesParaCultivo();
    cultivosVigentes.value = cultivoStore.cultivos_vigentes;
    materialesCultivables.value = cultivoStore.cultivables;
});

// Enviar el formulario
const submitForm = async () => {
    try {
        await cultivoStore.recogerCosecha(form.value);
        alert('Cosecha recogida exitosamente');
        form.value = { material_id_cultivo: 0, material_id_recoge: 0, cantidad_material_recogido: 0 }; // Resetear formulario
    } catch (error) {
        alert('Error al recoger la cosecha');
    }
};
</script>