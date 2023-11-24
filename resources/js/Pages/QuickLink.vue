<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import BreezeNavQL from '@/Components/NavQL.vue';

import CurrentAwareness from '@/Pages/QuickLinks/CurrentAwareness.vue';

export default {
     

     components: {
         BreezeAuthenticatedLayout,
         Head,
         CurrentAwareness,
      
 
         
     }
 };

</script>

<template>
    <Head title="QuickLink" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h1>
                QUICK LINKS
            </h1>
        </template>
        
        <CurrentAwareness />
        
    </BreezeAuthenticatedLayout>
</template>

<style>
h1{
    color: #0C4B05;
    font-size: 50px;
    font-weight: bold;
    font-family: Calibri;
}

</style>