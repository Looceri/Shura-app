<template>
    <form @submit.prevent="submit">
      <div>
        <label for="nome">Name:</label>
        <input type="text" id="nome" v-model="form.name">
      </div>
      <div>
        <label for="endereco">Location:</label>
        <input type="text" id="endereco" v-model="form.location">
      </div>
      <button type="submit">{{ editMode ? 'Update' : 'Register' }}</button>
    </form>
  </template>

  <script>
  import { Inertia } from '@inertiajs/inertia';
  import { ref, watch } from 'vue';

  export default {
    props: {
      restaurante: Object,
      editMode: {
        type: Boolean,
        default: false,
      },
    },
    setup(props) {
      const form = ref({
        name: '',
        location: '',
      });

      watch(
        () => props.restaurante,
        (newRestaurante) => {
          if (newRestaurante) {
            form.value.name = newRestaurante.name;
            form.value.location = newRestaurante.location;
          }
        },
        { immediate: true }
      );

      function submit() {
        if (props.editMode) {
          Inertia.put(route('restaurantes.update', props.restaurante.id), form.value);
        } else {
          Inertia.post(route('restaurantes.store'), form.value);
        }
      }

      return { form, submit };
    },
  };
  </script>
