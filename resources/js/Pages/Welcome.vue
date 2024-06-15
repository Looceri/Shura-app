<template>
    <div class="container mx-auto px-4">
      <h1 class="text-3xl font-bold text-center mb-6">Restaurantes</h1>

      <div class="flex mb-4">
        <button
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"
          @click="selectedTab = 'todos'"
        >
          Todos
        </button>
        <button
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
          @click="selectedTab = 'favoritos'"
        >
          Favoritos
        </button>
      </div>

      <div v-if="selectedTab === 'todos'">
        <div
          v-for="restaurante in restaurantes"
          :key="restaurante.id"
          class="bg-white rounded-lg shadow-md p-4 mb-4"
        >
          <h2 class="text-xl font-bold mb-2">{{ restaurante.nome }}</h2>
          <p>{{ restaurante.endereco }}</p>
          <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            @click="verMenu(restaurante.id)"
          >
            Ver Menu
          </button>
          <button
            v-if="!restaurante.favorito"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2"
            @click="adicionarFavorito(restaurante.id)"
          >
            Adicionar aos Favoritos
          </button>
          <button
            v-else
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2"
            @click="removerFavorito(restaurante.id)"
          >
            Remover dos Favoritos
          </button>
        </div>
      </div>

      <div v-if="selectedTab === 'favoritos'">
        <div
          v-for="restaurante in restaurantesFavoritos"
          :key="restaurante.id"
          class="bg-white rounded-lg shadow-md p-4 mb-4"
        >
          <h2 class="text-xl font-bold mb-2">{{ restaurante.nome }}</h2>
          <p>{{ restaurante.endereco }}</p>
          <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            @click="verMenu(restaurante.id)"
          >
            Ver Menu
          </button>
          <button
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2"
            @click="removerFavorito(restaurante.id)"
          >
            Remover dos Favoritos
          </button>
        </div>
      </div>

      <div v-if="showMenu" class="bg-white rounded-lg shadow-md p-4">
        <h2 class="text-2xl font-bold mb-4">Menu do Restaurante</h2>
        <ul>
          <li
            v-for="item in menu"
            :key="item.id"
            class="mb-2"
          >
            {{ item.nome }} - R$ {{ item.preco }}
          </li>
        </ul>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue';

  const restaurantes = ref([
    { id: 1, nome: 'Restaurante A', endereco: 'Rua A, 123', favorito: false },
    { id: 2, nome: 'Restaurante B', endereco: 'Rua B, 456', favorito: true },
    { id: 3, nome: 'Restaurante C', endereco: 'Rua C, 789', favorito: false },
    // Adicione mais restaurantes aqui
  ]);

  const restaurantesFavoritos = computed(() =>
    restaurantes.value.filter((restaurante) => restaurante.favorito)
  );

  const selectedTab = ref('todos');

  const showMenu = ref(false);
  const menu = ref([]);

  const verMenu = (restauranteId) => {
    // Substitua esta lógica pela sua implementação real para buscar o menu
    const restaurante = restaurantes.value.find(
      (restaurante) => restaurante.id === restauranteId
    );
    if (restaurante) {
      menu.value = [
        { id: 1, nome: 'Prato A', preco: 20.0 },
        { id: 2, nome: 'Prato B', preco: 25.0 },
        // Adicione mais itens de menu aqui
      ];
      showMenu.value = true;
    }
  };

  const adicionarFavorito = (restauranteId) => {
    const restaurante = restaurantes.value.find(
      (restaurante) => restaurante.id === restauranteId
    );
    if (restaurante) {
      restaurante.favorito = true;
    }
  };

  const removerFavorito = (restauranteId) => {
    const restaurante = restaurantes.value.find(
      (restaurante) => restaurante.id === restauranteId
    );
    if (restaurante) {
      restaurante.favorito = false;
    }
  };
  </script>
