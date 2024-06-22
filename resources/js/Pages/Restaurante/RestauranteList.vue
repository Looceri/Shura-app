<template>
    <div>
        <ul class="restaurant-grid">
            <div class="flex items-center">
                <li v-for="restaurante in restaurantes" :key="restaurante.id" class="restaurant-card">
                    <div class="card-image">
                        <img :src="'storage/restaurantes/' + restaurante.imagem" alt="Restaurant Image">
                    </div>
                    <div class="card-content">

                        <div class="w-1/2">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">Nome:
                            </h2>
                            <h2 class="text-gray-800 dark:text-gray-200">{{ restaurante.nome }}</h2>
                        </div>
                        <br>
                        <div class="w-1/2">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                                Endereço:
                            </h2>
                            <p class="text-gray-800 dark:text-gray-200">{{ restaurante.endereco }}</p>
                        </div>

                        <div
                            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-700 shadow-md overflow-hidden sm:rounded-lg">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                                Descrição:
                            </h2>
                            <p class="text-gray-800 dark:text-gray-200">{{ restaurante.descricao }}</p>
                        </div>
                        <br>

                        <PrimaryButton @click="editRestaurante(restaurante)">Edit</PrimaryButton>
                    </div>
                </li>
            </div>
        </ul>
    </div>
</template>

<script>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

export default {

    components: {
        PrimaryButton,
        GuestLayout
    },
    props: {
        restaurantes: Array,
    },
    emits: ['edit'],
    setup(props, { emit }) {
        function editRestaurante(restaurante) {
            emit('edit', restaurante);
        }

        return { editRestaurante };
    },
};
</script>

<style scoped>
.restaurant-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 10px;
    padding: 10px;
}

.restaurant-card {
    display: flex;
    flex-direction: column;
    width: 300px;
    margin: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    padding: 2px; /* Add padding to the restaurant card */
}

.card-image {
    width: 100%;
    height: 5cm;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-content {
    padding: 10px;
}

</style>
