<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="mt-4 relative">
                <div
                    class="absolute top-0 left-0 p-2 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-sm font-medium rounded-bl">
                    {{ restaurante.nome }}
                </div>
                <img :src="'storage/restaurantes/' + restaurante.imagem" alt="Imagem do Restaurante"
                    class="w-full h-48 object-cover rounded-md text-gray-800 dark:text-gray-200">
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ restaurante.endereco }}</h3>
            <p class="text-gray-500 dark:text-gray-400">{{ restaurante.descricao }}</p>
            <div class="flex gap-2">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="mt-2 flex-1">
                        <!-- Botão para adicionar aos favoritos -->
                        <LikeButton @click="adicionarAosFavoritos(restaurante)"
                            class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 font-bold py-2 px-4 rounded">
                            Favoritar
                        </LikeButton>
                    </div>
                </form>
                <div class="mt-2 flex-1">
                    <!-- Botão para visualizar o cardápio (ou outras ações) -->
                    <CardapioButton @click="verCardapio(restaurante)"
                        class="flex items-center justify-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Cardápio
                    </CardapioButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CardapioButton from './CardapioButton.vue';
import LikeButton from './LikesButton.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        LikeButton,
        CardapioButton
    },
    props: {
        restaurante: Object, // Ensure 'restaurante' is an object
    },
    setup() {
        async function submit(restaurante) {
            await Inertia.post(route('like'), { restaurante }, {
                forceFormData: true
            });
        }
        return { submit };
    },
};
</script>
