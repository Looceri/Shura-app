<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-2 bg-yellow-400 dark:bg-yellow-500 border border-yellow-400 dark:border-yellow-500 rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest shadow-sm hover:bg-yellow-500 dark:hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
        <StarIcon class="icone" />
        <slot />
    </button>
  </template>

  <script>
  import StarIcon from "./StarIcon.vue"; // Certifique-se de ter o componente StarIcon

  export default {
    components: {
      StarIcon,
    },
  };
  </script>

  <style scoped>
  /* Estilos para o botão */

  /* Estilos para o ícone (opcional) */
  .icone {
    width: 16px;
    height: 16px;
    fill: currentColor;
    margin-right: 5px;
  }
  </style>
