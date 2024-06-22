<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-red-500 border border-red-500 rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
    >
    <BrokenHeartIcon class="icone-coracao" />
    <slot />
    </button>
</template>

<script>
import BrokenHeartIcon from './CoracaoPartidoIcon.vue';
// Ajuste o caminho se necessário

export default {
  components: {
    BrokenHeartIcon,
  },
  // ... suas props e outros métodos
};
</script>
<style scoped>
/* Estilos para o botão */

/* Estilos para o ícone (opcional) */
.icone-coracao {
  width: 16px;
  height: 16px;
  fill: white; /* ou a cor que você preferir */
  margin-right: 5px;
}
</style>
