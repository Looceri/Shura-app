<template>
    <div>
      <ul>
        <li v-for="restaurante in restaurantes" :key="restaurante.id">
          <h2>{{ restaurante.name }}</h2>
          <p>{{ restaurante.address }}</p>
          <p>{{ restaurante.description }}</p>
          <img :src="restaurante.image" alt="Restaurant Image">
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
