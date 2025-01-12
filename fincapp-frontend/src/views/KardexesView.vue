<template>
    <CreateKardexForm />

    <FetchKardexList class="w-auto"/>
</template>
<script lang="ts">
import CreateKardexForm from '@/components/kardex/CreateKardexForm.vue';
import FetchKardexList from '@/components/kardex/FetchKardexList.vue';
import { defineComponent } from 'vue';

export default defineComponent({
    name: "KardexesView",
    components: {
        CreateKardexForm,
        FetchKardexList
    }
});
</script>
<style lang="">
    
</style>