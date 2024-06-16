<script setup>
/**
 * This script setup block is used to import necessary components and modules for the layout.
 */

// Importing ApplicationLogo component from the Components folder
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

// Importing Link component from the Inertia.js library for Vue.js 3
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <!-- This is the main layout component. It contains the application logo and a slot for other content. -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <!-- Link component to navigate to the home page -->
            <Link href="/">
                <!-- ApplicationLogo component with custom styles -->
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <!-- Container for the content, with responsive design and custom styles -->
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
        >
            <!-- Slot for other content to be inserted here -->
            <slot />
        </div>
    </div>
</template>
