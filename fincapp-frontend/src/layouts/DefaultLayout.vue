<template>
    <NotificationAlert />
    <DefaultHeader />
    <DefaultSidebar>
        <router-view />
        <DefaultFooter />
    </DefaultSidebar>
</template>

<script lang="ts">
/* eslint-disable */

import { defineComponent } from 'vue';
import DefaultSidebar from '@/components/common/DefaultSidebar.vue';
import DefaultFooter from '@/components/common/DefaultFooter.vue';
import DefaultHeader from '@/components/common/DefaultHeader.vue';
import CreateMaterialForm from '@/components/material/CreateMaterialForm.vue';
import NotificationAlert from '@/components/common/NotificationAlert.vue';

export default defineComponent({
    name: "DefaultLayout",
    components: {
        DefaultSidebar,
        DefaultFooter,
        DefaultHeader,
        CreateMaterialForm,
        NotificationAlert
    }
});
</script>
<style>

</style>