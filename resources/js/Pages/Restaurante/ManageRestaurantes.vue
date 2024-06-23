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


                    <div class="flex flex-col ml-2">
                        <button @click="currentTab = 'pedidos'"
                            class="glow-button font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Pedidos
                        </button>
                    </div>

                </div>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8c dark:bg-gray-800 shadow sm:rounded-lg">

                    <div v-if="currentTab === 'register'">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                            Criar Restaurantes
                        </h2>
                        <RestauranteForm @success="reloadRestaurantes" />
                    </div>
                    <div v-if="currentTab === 'edit'">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                            Editar Restaurantes
                        </h2>
                        <RestauranteList :restaurantes="restaurantes" :totalUsers="totalUsers" :likes="likes"
                            @edit="handleEdit" />
                        <div v-if="selectedRestaurante">
                            <RestauranteForm :restaurante="selectedRestaurante" editMode
                                @success="reloadRestaurantes" />
                        </div>
                    </div>
                    <div v-if="currentTab === 'pedidos'">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                            Pedidos de Restaurantes
                        </h2>
                        <RestaurantePedidos :restaurantes="restaurantes" @success="reloadRestaurantes" />
                    </div>
                </div>
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
    background-color: #e5e7eb;
    color: #2D3748;
}
</style>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import RestauranteForm from './RestauranteForm.vue';
import RestaurantePedidos from './RestaurantePedidos.vue';
import RestauranteList from './RestauranteList.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';

export default {
    props: {
        restaurantes: Array,
        likes: Array,
        totalUsers: Number
    },
    components: {
        AuthenticatedLayout,
        Head,
        RestauranteForm,
        RestauranteList,
        RestaurantePedidos
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
