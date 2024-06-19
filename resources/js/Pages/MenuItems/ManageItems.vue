<template>

    <Head title="Items" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <div class="flex flex-col">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">Items
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
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8c dark:bg-gray-800 shadow sm:rounded-lg">

                    <div v-if="currentTab === 'register'">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                            Criar Items
                        </h2>
                        <ItemForm @success="reloadItems" />
                    </div>
                    <div v-if="currentTab === 'edit'">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                            Editar Items
                        </h2>
                        <ItemList :items="items" @edit="handleEdit" />
                        <div v-if="selectedItem">
                            <ItemForm :item="selectedItem" editMode
                                @success="reloadItems" />
                        </div>
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
import ItemForm from './ItemForm.vue';
import ItemList from './ItemList.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';

export default {
    props: {
        items: Array,
        restaurantes: Array,
    },
    components: {
        AuthenticatedLayout,
        Head,
        ItemForm,
        ItemList,
    },
    setup(props) {
        const currentTab = ref('register');
        const selectedItem = ref(null);

        function handleEdit(item) {
            selectedItem.value = item;
            currentTab.value = 'edit';
        }

        function reloadItems() {
            Inertia.reload();
        }

        return { currentTab, selectedItem, handleEdit, reloadItems };
    },
};
</script>
