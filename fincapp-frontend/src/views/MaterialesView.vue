<template>
    <div>
        <CreateMaterialForm />
        <FetchMaterialList />
    </div>
</template>

<script lang="ts">
import CreateMaterialForm from '@/components/material/CreateMaterialForm.vue';
import FetchMaterialList from '@/components/material/FetchMaterialList.vue';
import { defineComponent } from 'vue';

export default defineComponent({
    name: "MaterialesView",
    components: {
        CreateMaterialForm,
        FetchMaterialList
    }
})
</script>

<style lang="css">
    
</style>