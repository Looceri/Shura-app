<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="mt-4 relative">
                <div
                    class="absolute top-0 left-0 p-2 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-sm font-medium rounded-bl">
                    {{ restaurante.nome }}
                </div>
                <img :src="'storage/restaurantes/' + restaurante.imagem" alt="Imagem do Restaurante"
                    class="w-full h-48 object-cover rounded-md text-gray-800 dark:text-gray-200">
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ restaurante.endereco }}</h3>
            <p class="text-gray-500 dark:text-gray-400">{{ restaurante.descricao }}</p>
            <div class="mt-2">
                <!-- Botão para adicionar aos favoritos -->
                <button @click="addToFavorites"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 font-bold py-2 px-4 rounded">
                    Adicionar aos Favoritos
                </button>
            </div>
            <div class="mt-2">
                <!-- Botão para visualizar o cardápio (ou outras ações) -->
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ver Cardápio
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        restaurante: Array,
    },
};
</script>
