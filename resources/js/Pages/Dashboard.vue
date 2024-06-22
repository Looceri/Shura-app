<template>
    <Head title="Menu" />
    <keep-alive>
        <AuthenticatedLayout>
            <template #header>
            </template>
            <RestaurantTab :restaurantes="restaurantes" :likes="likes" />

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <RestaurantCard v-for="restaurante in restaurantes" :key="restaurante.id" :restaurante="restaurante" :likes="likes" :totalUsers="totalUsers" />
                </div>
            </div>
        </AuthenticatedLayout>
    </keep-alive>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RestaurantCard from '@/Components/RestaurantCard.vue';
import RestaurantTab from '@/Components/RestaurantTab.vue'; // Import the RestaurantTab component
import { Head } from '@inertiajs/vue3';

defineProps({
    restaurantes: Array,
    likes: Array,
    totalUsers:Number
});
</script>
