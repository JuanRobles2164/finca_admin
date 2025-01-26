<template>
    <CreateCultivoForm></CreateCultivoForm>
    <RecogerCosechaForm></RecogerCosechaForm>
    <FinalizarCosechaForm></FinalizarCosechaForm>
    <ConsumirInsumosPorCultivoForm></ConsumirInsumosPorCultivoForm>
</template>

<script lang="ts">

import ConsumirInsumosPorCultivoForm from '@/components/cultivo/ConsumirInsumosPorCultivoForm.vue';
import CreateCultivoForm from '@/components/cultivo/CreateCultivoForm.vue';
import FinalizarCosechaForm from '@/components/cultivo/FinalizarCosechaForm.vue';
import RecogerCosechaForm from '@/components/cultivo/RecogerCosechaForm.vue';
import { defineComponent } from 'vue';

export default defineComponent({
    name:'CultivosView',
    components: {
        CreateCultivoForm,
        FinalizarCosechaForm,
        RecogerCosechaForm,
        ConsumirInsumosPorCultivoForm
    }
})
</script>

<style lang="css" scoped>
    
</style>