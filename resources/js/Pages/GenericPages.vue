<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';

import GenericList from '@/Pages/Generic/GenericList.vue';


export default {
     

    components: {
        BreezeAuthenticatedLayout,
        Head,
        GenericList,
     

        
    }
};
</script>

<template>
    <Head title="Generic Pages" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h1>
            Generic Pages
            </h1>
        </template>

        

        <GenericList />

       
    </BreezeAuthenticatedLayout>
</template>
