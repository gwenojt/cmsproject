<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import AddFAQModal from '@/Components/AddFAQModal.vue';
import FaqList from '@/Pages/Faqqs/FaqList.vue';

import axios from 'axios';
export default {
    data(){
        return{
            faqs:[],
            is_edit:false,
            edit_id:0,
            showModal: false,
        }
    },
  
 

    components: {
        BreezeAuthenticatedLayout,
        Head,
        FaqList,
        AddFAQModal
        
    },
    methods: {
        openModal(){
            this.showModal = true;
        },

        closeModal(){
            this.closeModal = false;
        }, 

        getter(){
            axios.get('/faqlist').then(({data})=>{
                this.faqs = data;
            })
        },
        editData(id){
            this.is_edit=true;
            this.edit_id=id;
        },
        successEdit(){
            this.is_edit=false;
            this.edit_id=0;
            this.getter();
        }

    },
    mounted(){
        this.getter();
    }
};
</script>

<template>
    <Head title="FAQs" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <p class="font-bold" style="font-family: Calibri; font-size: 50px; font-weight: bold; ">
               FAQs
            </p>
        </template>

        <button @click="openModal" class="mt-12w-52 shadow bg-green text-white hover:opacity-80 mr-4 focus:shadow-outline focus:outline-none font-bold py-2 px-4 rounded-lg ">Add FAQ</button>

        <add-faq-modal v-if="showModal" @close="closeModal" />
        
        <FaqList  @success="getter"/>

       
    </BreezeAuthenticatedLayout>
</template>
