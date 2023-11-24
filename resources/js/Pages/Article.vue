<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h1>
                ARTICLE
            </h1>
        </template>


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
