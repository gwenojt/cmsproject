<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';

// Define a reactive variable to control the visibility of the navigation link
const showNav = false;
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <p class="font-bold" style="font-family: Calibri; font-size: 50px; font-weight: bold; ">
                CONTENT MANAGEMENT
            </p>
        </template>

        <div class="py-10">
            <div class="flex justify-center">
                <div class="flex justify-between">
                    <div class="px-20">
                        <button type="button" @click="navigateToPage" class="flex flex-col items-center justify-center bg-green text-white  max-w-xs transition duration-300 ease-in-out hover:scale-110 buttonStyle">
                            <div class="px-30">
                                <img src="/images/pages.svg" alt="" class="icon">
                            </div>
                            PAGES
                        </button>
                    </div>
                    <div class="px-20 h-50 w-50">     
                        <button type="button" @click="navigateToArticle" class="flex flex-col items-center justify-center bg-green text-white max-w-xs transition duration-300 ease-in-out hover:scale-110 buttonStyle">
                            <div class="px-30">
                                <img src="/images/articles.svg" alt="" class="icon">
                            </div>
                            ARTICLES
                        </button>
                    </div>
                    <div class="px-20 h-50 w-50">
                        <button type="button" @click="navigateToFaqs" class="flex flex-col items-center justify-center bg-green text-white max-w-xs transition duration-300 ease-in-out hover:scale-110 buttonStyle">
                            <div class="px-30">
                                <img src="/images/faqs.svg" alt="" class="icon">
                            </div>
                            FAQs
                        </button>
                    </div>
                </div>
            </div> 
        </div>

        <div class="py-2">
            <div class="flex justify-center">
                <div class="flex justify-between">
                    <div class="px-20">
                        <button type="button" @click="navigateToImages" class="flex flex-col items-center justify-center bg-green text-white max-w-xs transition duration-300 ease-in-out hover:scale-110 buttonStyle">
                            <div class="px-30">
                                <img src="/images/image.svg" alt="" class="icon">
                            </div>
                            IMAGES
                        </button>
                    </div>
                    <div class="px-20 h-50 w-50">     
                        <button type="button" @click="navigateToLinks" class="flex flex-col items-center justify-center bg-green text-white max-w-xs transition duration-300 ease-in-out hover:scale-110 buttonStyle">
                            <div class="px-30">
                                <img src="/images/link.svg" alt="" class="icon">
                            </div>
                            QUICK LINKS
                        </button>
                    </div>
                    <div class="px-20 h-50 w-50">
                        <button type="button" @click="navigateToAccounts" class="flex flex-col items-center justify-center bg-green text-white max-w-xs transition duration-300 ease-in-out hover:scale-110 buttonStyle">
                            <div class="px-30">
                                <img src="/images/account.svg" alt="" class="icon">
                            </div>
                            ACCOUNTS
                        </button>
                    </div>
                </div>
            </div> 
        </div>


    </BreezeAuthenticatedLayout>

    <template>
        <div>
            
        </div>
    </template>
</template>

<style>
    .buttonStyle{
        width: 200px; 
        height: 150px; 
        font-size: 25px;
        font-weight: bold;
        padding: 3%;
        border-radius: 20px;
        border-color: #FFCD00;
        border-width: 3px;
    }

    .icon{
        width: 60px; 
        height: 60px;

    }
</style>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    methods: {
        navigateToPage() {
            Inertia.visit(route('genericpages')); 
        },

        navigateToArticle(){
            Inertia.visit(route('article'));
        },

        navigateToFaqs(){
            Inertia.visit(route('faqs'));
        },

        navigateToImages(){
            Inertia.visit(route('image'));
        },
        
        navigateToLinks(){
            Inertia.visit(route('quickLink'));
        },

        navigateToAccounts(){
            Inertia.visit(route('manageacc'));
        },
    },
};
</script>