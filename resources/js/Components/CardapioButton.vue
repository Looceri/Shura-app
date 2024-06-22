<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-green-500 dark:bg-green-600 border border-green-500 dark:border-green-600 rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest shadow-sm hover:bg-green-600 dark:hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.446-2.723A1 1 0 013 16.382V7.618a1 1 0 011.446-.882L9 5l5.446 2.723a1 1 0 01.554.882V16.382a1 1 0 01-.554.882L15 20z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.371V14.37a1 1 0 01-1 1h-6a1 1 0 01-1-1v-2.999c0-.538.217-1.055.595-1.433l4.19-4.19a1 1 0 011.414 0l4.19 4.19c.377.378.595.895.595 1.434z"></path>
        </svg>
        <slot />
    </button>
</template>
