<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 relative">
            <div class="mt-4 relative">
                <div
                    class="absolute top-0 left-0 p-2 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-sm font-medium rounded-bl">
                    {{ restaurante.nome }}
                </div>
                <img :src="'storage/restaurantes/' + restaurante.imagem" alt="Imagem do Restaurante"
                    class="w-full h-48 object-cover rounded-md text-gray-800 dark:text-gray-200" />

                <!-- Contador de likes com cores e coroa -->
                <div class="absolute bottom-2 right-2 px-2 py-1 rounded-md text-white font-bold"
                    :class="corDeFundoDosLikes">
                    <span v-if="porcentagemLikes >= 100">👑 </span>
                    {{ likesCount }}
                </div>
            </div>

            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ restaurante.endereco }}
            </h3>
            <p class="text-gray-500 dark:text-gray-400">
                {{ restaurante.descricao }}
            </p>
            <div class="flex gap-2">
                <div>
                    <div class="mt-2 flex-1">
                        <LikeButton v-if="!isLiked" @click="adicionarAosFavoritos"
                            class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 font-bold py-2 px-4 rounded">
                            Favoritar
                        </LikeButton>
                        <DislikeButton v-else @click="removerDosFavoritos"
                            class="flex items-center justify-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Remover Favorito
                        </DislikeButton>
                    </div>
                </div>
                <div class="mt-2 flex-1">
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
import DislikeButton from './DislikesButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

export default {
    components: {
        LikeButton,
        CardapioButton,
        DislikeButton,
    },
    props: {
        restaurante: Object,
        likes: Array,
        totalUsers: Number, // Adicione a prop totalUsers
    },
    setup(props) {
        const page = usePage();
        const userId = computed(() => page.props.auth.user.id);
        const isLiked = computed(() => {
            return props.likes.some(
                (like) =>
                    like.restaurante_id === props.restaurante.id &&
                    like.user_id === userId.value,
            );
        });

        return { userId, isLiked };
    },
    computed: {
        likesCount() {
            return this.likes.filter(
                (like) => like.restaurante_id === this.restaurante.id,
            ).length;
        },
        porcentagemLikes() {
            return (this.likesCount / this.totalUsers) * 100;
        },
        corDeFundoDosLikes() {
            if (this.porcentagemLikes >= 70) {
                return 'bg-green-500';
            } else if (this.porcentagemLikes >= 35) {
                return 'bg-yellow-400';
            } else {
                return 'bg-gray-400';
            }
        },
    },
    methods: {
        adicionarAosFavoritos() {
            Inertia.post(
                route('restaurantes.like'),
                {
                    user_id: this.userId,
                    restaurante_id: this.restaurante.id,
                },
                {
                    forceFormData: true,
                    onSuccess: () => {
                        // Adiciona o like ao array local para atualização da interface
                        this.likes.push({
                            user_id: this.userId,
                            restaurante_id: this.restaurante.id,
                        });
                    },
                },
            );
        },
        removerDosFavoritos() {
            Inertia.post(route('restaurantes.unlike'), {
                user_id: this.userId,
                restaurante_id: this.restaurante.id,
            },
                {
                    forceFormData: true,
                    onSuccess: () => {
                        // Remove o like do array local para atualização da interface
                        const likeIndex = this.likes.findIndex(
                            (like) => like.restaurante_id === this.restaurante.id && like.user_id === this.userId,
                        );
                        if (likeIndex > -1) {
                            this.likes.splice(likeIndex, 1);
                        }
                    },
                });
        },
        verCardapio(restaurante) {
            // Implemente a lógica para visualizar o cardápio aqui
            console.log('Visualizando cardápio de:', restaurante.nome);
        },
    },
};
</script>
