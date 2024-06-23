<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-2 bg-orange-400 dark:bg-orange-500 border border-orange-400 dark:border-orange-500 rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest shadow-sm hover:bg-orange-500 dark:hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
        <CommentIcon class="icone" />
        <slot />
    </button>
  </template>

  <script>
  import CommentIcon from "./CommentIcon.vue"; // Certifique-se de ter o componente CommentIcon

  export default {
    components: {
      CommentIcon,
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
