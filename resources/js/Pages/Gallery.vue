
<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';

import UploadImage from '@/Pages/Gallery/UploadImage.vue';

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
        UploadImage,
     

        
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

        

        <UploadImage/>

       
    </BreezeAuthenticatedLayout>
</template>
