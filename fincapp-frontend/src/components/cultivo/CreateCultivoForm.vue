<template>
    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Agregar Nuevo Cultivo</h2>
        <form @submit.prevent="submitForm">
            <!-- Seleccionar material -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Material</label>
                <select v-model="form.material_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                    required>
                    <option v-for="material in materialesCultivables" :key="material.id" :value="material.id">
                        {{ material.nombre }}
                    </option>
                </select>
            </div>

            <!-- Edad del cultivo -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Edad (días)</label>
                <input v-model.number="form.edad" type="number"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
            </div>

            <!-- Cantidad -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input v-model.number="form.cantidad" type="number"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
            </div>

            <!-- Tipo de adquisición -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Adquisición</label>
                <select v-model="form.adquisicion" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                    required>
                    <option value="Compra">Compra</option>
                    <option value="Cría">Cría</option>
                </select>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                Agregar Cultivo
            </button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useCultivoStore } from '@/store/CultivoStore';
import { AgregarCultivoRequest } from '@/models/request/cultivo/AgregarCultivoRequest';
import { Material } from '@/models/Material';

const cultivoStore = useCultivoStore();
const materialesCultivables = ref<Material[]>([]);

const form = ref<AgregarCultivoRequest>({
    material_id: 0,
    edad: 0,
    cantidad: 0,
    adquisicion: 'Compra',
});

// Cargar materiales cultivables al montar el componente
onMounted(async () => {
    await cultivoStore.listarMaterialesDisponiblesParaCultivo();
    materialesCultivables.value = cultivoStore.cultivables;
});

// Enviar el formulario
const submitForm = async () => {
    try {
        await cultivoStore.agregarCultivo(form.value);
        alert('Cultivo agregado exitosamente');
        form.value = { material_id: 0, edad: 0, cantidad: 0, adquisicion: 'Compra' }; // Resetear formulario
    } catch (error) {
        alert('Error al agregar el cultivo');
    }
};
</script>