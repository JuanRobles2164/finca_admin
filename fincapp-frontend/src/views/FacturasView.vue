<template>
    <CreateFacturaForm />
    <FetchFacturaList/>
</template>

<script lang="ts">
import CreateFacturaForm from '@/components/factura/CreateFacturaForm.vue';
import FetchFacturaList from '@/components/factura/FetchFacturaList.vue';
import { defineComponent } from 'vue';

export default defineComponent({
    name:'FacturasView',
    components: {
        FetchFacturaList,
        CreateFacturaForm
    }
})
</script>

<style lang="css" scoped>
    
</style>