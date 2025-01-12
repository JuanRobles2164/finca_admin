<template>
    <CreateTerceroForm />
    <FetchTerceroList />
</template>
<script lang="ts">

import CreateTerceroForm from '@/components/tercero/CreateTerceroForm.vue';
import FetchTerceroList from '@/components/tercero/FetchTerceroList.vue';
import { defineComponent } from 'vue';

export default defineComponent({
    name:"TercerosView",
    components: {
        CreateTerceroForm,
        FetchTerceroList
    }
});
</script>
<style scoped>
    
</style>