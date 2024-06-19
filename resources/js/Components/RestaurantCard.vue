<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6">
        <div class="mt-4">
          <img :src="'storage/restaurantes/' + restaurant.imagem" alt="Imagem do Restaurante" class="w-full h-48 object-cover rounded-md text-gray-800 dark:text-gray-200">
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ restaurant.nome }}</h3>
        <p class="text-gray-500 dark:text-gray-400">{{ restaurant.descricao }}</p>
        <div class="mt-2">
          <!-- Botão para visualizar o cardápio (ou outras ações) -->
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ver Cardápio
          </button>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  defineProps({
    restaurant: {
      type: Object,
      required: true
    }
  });
  </script>
