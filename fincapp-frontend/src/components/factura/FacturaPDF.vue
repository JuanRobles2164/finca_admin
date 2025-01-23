<template>
    <div>
        <div ref="pdfContent" class="factura-container" v-if="factura_id != 0">
            <div class="factura-header">
                <img :src="facturaData.logo_empresa" alt="Logo Empresa" class="logo" />
                <div>
                    <p>{{ facturaData.direccion_empresa }}</p>
                    <p>{{ facturaData.telefono_empresa }}</p>
                </div>
            </div>

            <h2>Factura</h2>

            <div class="cliente-info">
                <p><strong>Cliente:</strong> {{ facturaData.cliente ? facturaData.cliente.nombre : "" }}</p>
                <p><strong>NIT:</strong> {{ facturaData.cliente ? facturaData.cliente.nit : "" }}</p>
                <p><strong>Contacto:</strong> {{ facturaData.cliente ? facturaData.cliente.contacto : "" }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Valor Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in facturaData.venta_materiales" :key="index">
                        <td>{{ item.nombre }}</td>
                        <td>{{ item.cantidad }}</td>
                        <td>${{ item.valor_unitario }}</td>
                        <td>${{ item.cantidad * item.valor_unitario }}</td>
                    </tr>
                </tbody>
            </table>

            <h3>Total: ${{ facturaData.factura ? facturaData.factura.total : "" }}</h3>
            <p><strong>Fecha de Venta:</strong> {{ facturaData.factura ? facturaData.factura.fecha_venta : "" }}</p>
            <p><strong>Estado:</strong> {{ facturaData.factura ? (facturaData.factura.fecha_pago ? "Pagada" : "Pendiente") : "" }}</p>

            <div v-if="facturaData.evidencia != null && facturaData.evidencia.length > 0">
                <h3>Evidencia</h3>
                <div class="evidencias">
                    <img v-for="(img, index) in facturaData.evidencia" :key="index" :src="img" alt="Evidencia"
                        class="evidencia-img" />
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, computed, watch } from "vue";
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import { useFacturaStore } from "@/store/FacturaStore";

pdfMake.vfs = pdfFonts.pdfMake.vfs;

export default defineComponent({
    props: {
        factura_id: {
            required: true,
            type: Number,
        },
    },
    setup(props, { emit }) {
        const facturaStore = useFacturaStore();
        const facturaData = computed(() => facturaStore.factura_details);

        const pdfContent = ref<HTMLElement | null>(null);

        const consultarDataFactura = async (factura_id: number) => {
            await facturaStore.facturaDetails(factura_id);
        };

        // Watch para detectar cambios en factura_id
        watch(() => props.factura_id, async (newFacturaId) => {
            await consultarDataFactura(newFacturaId);
            generatePDF();
        });

        const generatePDF = () => {
            if (!facturaData.value) return;

            const docDefinition = {
                content: [
                    {
                        columns: [
                            {
                                image: facturaData.value.logo_empresa,
                                width: 80
                            },
                            [
                                { text: facturaData.value.direccion_empresa, style: 'subheader' },
                                { text: facturaData.value.telefono_empresa, style: 'subheader' }
                            ]
                        ]
                    },
                    { text: 'Factura', style: 'header' },
                    { 
                        style: 'tableExample',
                        table: {
                            body: [
                                ['Material', 'Cantidad', 'Valor Unitario', 'Total'],
                                ...facturaData.value.venta_materiales.map(item => [
                                    item.nombre, 
                                    item.cantidad, 
                                    `$${item.valor_unitario}`, 
                                    `$${item.cantidad * item.valor_unitario}`
                                ])
                            ]
                        }
                    },
                    { text: `Total: $${facturaData.value.factura.total}`, style: 'header' },
                    { text: `Fecha de Venta: ${facturaData.value.factura.fecha_venta}`, style: 'subheader' },
                    { text: `Estado: ${facturaData.value.factura.fecha_pago ? "Pagada" : "Pendiente"}`, style: 'subheader' },
                    facturaData.value.evidencia.length > 0 ? { text: 'Evidencia', style: 'header' } : {},
                    ...facturaData.value.evidencia.map(img => ({
                        image: img,
                        width: 100,
                        margin: [0, 5]
                    }))
                ],
                styles: {
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 10, 0, 10]
                    },
                    subheader: {
                        fontSize: 14,
                        margin: [0, 5, 0, 5]
                    },
                    tableExample: {
                        margin: [0, 5, 0, 15]
                    }
                }
            };

            pdfMake.createPdf(docDefinition).download(`factura_${props.factura_id}.pdf`);

            emit("pdfGenerated");
        };

        return { facturaData, consultarDataFactura, generatePDF };
    }
});
</script>

<style scoped>
.factura-container {
    width: 100%;
    padding: 20px;
    background: white;
    font-family: Arial, sans-serif;
}

.factura-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #000;
    padding-bottom: 10px;
}

.logo {
    width: 80px;
    height: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th,
td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
}

.evidencias {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.evidencia-img {
    width: 100px;
    height: auto;
}
</style>