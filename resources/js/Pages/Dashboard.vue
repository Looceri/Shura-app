<template>
    <Head title="Menu" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Restaurantes</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <RestaurantCard v-for="restaurante in restaurantes" :key="restaurante.id" :restaurant="restaurante" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RestaurantCard from '@/Components/RestaurantCard.vue'; // Importe o componente RestaurantCard
import { Head } from '@inertiajs/vue3';

defineProps({
    restaurantes: Array
});
</script>
