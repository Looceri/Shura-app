<template>

    <Head title="Restaurantes" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <div class="flex flex-col">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">Restaurantes
                    </h2>
                </div>

                <div class="flex flex-row">
                    <div class="flex flex-col">
                        <button @click="currentTab = 'register'"
                            class="glow-button font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Registar
                        </button>
                    </div>

                    <div class="flex flex-col ml-2">
                        <button @click="currentTab = 'edit'"
                            class="glow-button font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Editar
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <div v-if="currentTab === 'register'">
            <RestauranteForm @success="reloadRestaurantes" />
        </div>
        <div v-if="currentTab === 'edit'">
            <RestauranteList :restaurantes="restaurantes" @edit="handleEdit" />
            <div v-if="selectedRestaurante">
                <RestauranteForm :restaurante="selectedRestaurante" editMode @success="reloadRestaurantes" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.glow-button {
    transition: duration-300 ease-in-out;
    /* Add your desired button styles here */
}

.glow-button:hover {
    background-color: #E2E8F0;
    color: #2D3748;
}

.glow-button.dark:hover {
    color: #2D3748;
}
</style>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import RestauranteForm from './RestauranteForm.vue';
import RestauranteList from './RestauranteList.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';

export default {
    props: {
        restaurantes: Array,
    },
    components: {
        AuthenticatedLayout,
        Head,
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
