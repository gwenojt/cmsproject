<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">

        <div class="w-full max-w-md mt-6 px-6 py-4 bg-green shadow-md rounded-lg overflow-hidden flex flex-col items-center">
            <Link href="/">
                <BreezeApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>

            <slot />
        </div>
    </div>
</template>
