<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';

import AddImage from '@/Pages/AddImage/AddImage.vue';

import axios from 'axios';
export default {
    data(){
        return{
            faqs:[],
            is_edit:false,
            edit_id:0,
        }
    },
  
 

    components: {
        BreezeAuthenticatedLayout,
        Head,
        AddImage,
     

        
    },
    

    
};
</script>

<template>
    <Head title="Images" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <p class="font-bold" style="font-family: Calibri; font-size: 50px; font-weight: bold; ">
               IMAGES
            </p>
        </template>

        

        <AddImage/>

       
    </BreezeAuthenticatedLayout>
</template>
