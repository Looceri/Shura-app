<template>
    <div>
      <div>
        <button @click="currentTab = 'register'">Register</button>
        <button @click="currentTab = 'edit'">Edit</button>
      </div>
      <div v-if="currentTab === 'register'">
        <RestauranteForm @success="reloadRestaurantes" />
      </div>
      <div v-if="currentTab === 'edit'">
        <RestauranteList :restaurantes="restaurantes" @edit="handleEdit" />
        <div v-if="selectedRestaurante">
          <RestauranteForm :restaurante="selectedRestaurante" editMode @success="reloadRestaurantes" />
        </div>
      </div>
    </div>
  </template>

  <script>
  import { ref } from 'vue';
  import RestauranteForm from './RestauranteForm.vue';
  import RestauranteList from './RestauranteList.vue';
  import { Inertia } from '@inertiajs/inertia';

  export default {
    props: {
      restaurantes: Array,
    },
    components: {
      RestauranteForm,
      RestauranteList,
    },
    setup(props) {
      const currentTab = ref('register');
      const selectedRestaurante = ref(null);

      function handleEdit(restaurante) {
        selectedRestaurante.value = restaurante;
        currentTab.value = 'edit';
      }

      function reloadRestaurantes() {
        Inertia.reload();
      }

      return { currentTab, selectedRestaurante, handleEdit, reloadRestaurantes };
    },
  };
  </script>
