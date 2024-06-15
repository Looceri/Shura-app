<template>
    <div>
      <h1>Restaurant List</h1>
      <ul>
        <li v-for="restaurante in restaurantes" :key="restaurante.id">
          {{ restaurante.name }} - {{ restaurante.location }}
          <button @click="editRestaurante(restaurante)">Edit</button>
        </li>
      </ul>
    </div>
  </template>

  <script>
  export default {
    props: {
      restaurantes: Array,
    },
    emits: ['edit'],
    setup(props, { emit }) {
      function editRestaurante(restaurante) {
        emit('edit', restaurante);
      }

      return { editRestaurante };
    },
  };
  </script>
