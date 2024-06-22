<template>
    <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-800 rounded-t-md">
        <h3 class="font-semibold text-gray-800 dark:text-gray-200">Restaurantes</h3>
        <div class="flex gap-2">
            <div v-for="restaurante in restaurantes" :key="restaurante.id" class="flex items-center gap-2">
                <span class="text-gray-600 dark:text-gray-400">{{ restaurante.nome }}</span>
                <span class="px-2 py-1 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs rounded-md">{{ getLikesCount(restaurante.id) }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        restaurantes: Array,
        likes: Array
    },
    methods: {
        getLikesCount(restaurantId) {
            return this.likes.filter(like => like.restaurante_id === restaurantId).length;
        }
    }
};
</script>
