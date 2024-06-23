
<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-2 bg-green-500 dark:bg-green-600 border border-green-500 dark:border-green-600 rounded-md font-semibold text-xs text-black dark:text-white uppercase tracking-widest shadow-sm hover:bg-green-600 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
        <MenuIcon class="icone" />
        <slot />
    </button>
</template>

<script>
import MenuIcon from "./MenuIcon.vue"
export default {
    components: {
        MenuIcon,
    },
    // ... suas props e outros métodos
};
</script>

<style scoped>
/* Estilos para o botão */

/* Estilos para o ícone (opcional) */
.icone {
    width: 16px;
    height: 16px;
    /* ou a cor que você preferir */
    margin-right: 5px;
}
</style>
