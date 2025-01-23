<template>
  <div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Listado de Facturas</h2>
      <button @click="fetchFacturas"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out flex items-center">
        <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
          fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
          </path>
        </svg>
        {{ loading ? 'Cargando...' : 'Cargar Facturas' }}
      </button>
    </div>

    <div v-if="error" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
      <p class="font-bold">Error</p>
      <p>{{ error }}</p>
    </div>

    <div v-if="facturas.length" class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              ID
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Numero
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Fecha Pago
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Fecha Venta
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Total
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="factura in facturas" :key="factura.id"
            class="hover:bg-gray-50 transition duration-150 ease-in-out">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ factura.id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ factura.numero }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <span v-if="factura.fecha_pago"
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                {{ formatDate(factura.fecha_pago) }}
              </span>
              <span v-else
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                SIN PAGAR
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-orange-600 bg-orange-100">
                {{ formatDate(factura.fecha_venta) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ formatCurrency(factura.total ??
              0) }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
              <button @click="openModalAndDownloadPDF(factura.id)">
                📄 Descargar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else-if="!loading" class="text-center py-10">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        aria-hidden="true">
        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">No hay facturas</h3>
      <p class="mt-1 text-sm text-gray-500">Comienza creando una nueva factura.</p>
    </div>
  </div>

  <div ref="facturaComponentWrapper"></div>

  <div v-if="showModal" style="display: none;">
    <FacturaPDF :factura_id="facturaId" ref="FacturaPDF" @pdfGenerated="closeModal" />
  </div>

</template>

<script lang="ts">
import { computed, defineComponent, ref } from "vue";
import { useFacturaStore } from "@/store/FacturaStore";
import { useRouter } from 'vue-router';
import FacturaPDF from "@/components/factura/FacturaPDF.vue";

export default defineComponent({
  components: {
    FacturaPDF,
  },
  setup() {
    const facturaStore = useFacturaStore();
    const router = useRouter();
    const facturas = computed(() => facturaStore.facturas);
    const { fetchFacturas, loading, error } = facturaStore;

    const showModal = ref(false);
    const facturaId = ref<number>(0);

    const openModalAndDownloadPDF = (id: number) => {
      facturaId.value = id;
      showModal.value = true;
    };

    const closeModal = () => {
      showModal.value = false;
      facturaId.value = 0;
    };

    const formatDate = (dateString: string) => {
      return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    };

    const formatCurrency = (amount: number) => {
      return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'EUR'
      }).format(amount);
    };

    const verDetalles = (id: number) => {
      router.push({ name: 'DetalleFactura', params: { id: id.toString() } });
    };

    const editarFactura = (id: number) => {
      router.push({ name: 'EditarFactura', params: { id: id.toString() } });
    };

    return {
      fetchFacturas,
      facturas,
      loading,
      error,
      showModal,
      facturaId,
      openModalAndDownloadPDF,
      closeModal,
      formatDate,
      formatCurrency,
      verDetalles,
      editarFactura
    };
  },
});
</script>