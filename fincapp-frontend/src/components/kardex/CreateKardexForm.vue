<template>
    <div class="p-4 bg-gray-100 rounded shadow">
      <h2 class="text-xl font-bold mb-4 text-gray-700">Registrar Movimiento en Kardex</h2>
  
      <form @submit.prevent="registrarMovimiento" class="space-y-4">
        <!-- Selección de Material -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Material</label>
          <select
            v-model="selectedMaterialId"
            class="w-full border-gray-300 rounded p-2"
            required
          >
            <option value="" disabled>Seleccione un material</option>
            <option v-for="material in materiales" :key="material.id" :value="material.id">
              {{ material.nombre }}
            </option>
          </select>
        </div>
  
        <!-- Tipo de Movimiento -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Tipo de Movimiento</label>
          <select
            v-model="tipoMovimiento"
            class="w-full border-gray-300 rounded p-2"
            required
          >
            <option value="" disabled>Seleccione el tipo de movimiento</option>
            <option value="Entra">Entra</option>
            <option value="Sale">Sale</option>
          </select>
        </div>
  
        <!-- Cantidad -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Cantidad</label>
          <input
            type="number"
            v-model="cantidad"
            class="w-full border-gray-300 rounded p-2"
            min="1"
            required
          />
        </div>
  
        <!-- Botones -->
        <div class="flex justify-end space-x-2">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
          >
            Registrar
          </button>
          <button
            type="reset"
            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition"
          >
            Cancelar
          </button>
        </div>
      </form>
  
      <div v-if="loading" class="text-gray-500 mt-4">Registrando movimiento...</div>
      <div v-if="error" class="text-red-500 mt-4">{{ error }}</div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from "vue";
  import { useKardexStore } from "@/store/KardexStore";
  import { useMaterialStore } from "@/store/MaterialStore";
import { useNotificationStore } from "@/store/components/NotificationStore";
  
  const kardexStore = useKardexStore();
  const materialStore = useMaterialStore();
  
  const cantidad = ref(0);
  const selectedMaterialId = ref(null);
  const tipoMovimiento = ref("");
  
  onMounted(() => {
    materialStore.fetchMateriales();
  });
  
  const materiales = computed(() => materialStore.materiales);
  const { loading, error } = kardexStore;
  const notificationStore = useNotificationStore();
  
  const registrarMovimiento = async () => {
    if (!selectedMaterialId.value || !tipoMovimiento.value || cantidad.value <= 0) {
        notificationStore.addNotification("danger", "¡Campos incompletos!", "Complete primero todos los campos");
        return;
    }
  
    await kardexStore.registrarMovimientoKardex(
      cantidad.value,
      selectedMaterialId.value,
      tipoMovimiento.value
    );
  
    cantidad.value = 0;
    selectedMaterialId.value = null;
    tipoMovimiento.value = "";

    notificationStore.addNotification("success", "¡Movimiento agregado!", "Se registró con éxito el movimiento de Kardex");
  };
  </script>
  