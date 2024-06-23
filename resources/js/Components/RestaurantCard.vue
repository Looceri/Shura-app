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
            <div>
                <div>
                    <div class="mt-2 flex-1">
                        <LikeButton v-if="!isLiked" @click="adicionarAosFavoritos"
                            class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 font-bold py-2 px-4 rounded">
                            Favoritar
                        </LikeButton>
                        <DislikeButton v-else @click="removerDosFavoritos"
                            class="flex items-center justify-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Desfavoritar
                        </DislikeButton>
                    </div>
                </div>
                <div class="mt-2 flex-1">
                    <CardapioButton @click="verCardapio(restaurante)"
                        class="flex items-center justify-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Cardápio
                    </CardapioButton>
                </div>
                <div class="mt-2 flex-1">
                    <ReviewButton @click="abrirPainel"
                        class="flex items-center justify-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Review
                    </ReviewButton>
                </div>
            </div>
        </div>
    </div>
    <div v-if="mostrarPainel" class="edit-box fixed inset-0 flex items-center justify-center z-50" @click="hideReview">
        <div class="edit-box-content bg-white dark:bg-gray-800 rounded-lg p-6 shadow-xl w-96">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Deixe sua Avaliação
            </h2>

            <form @submit.prevent="enviarAvaliacao">
                <div class="mb-4">
                    <InputLabel for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Título
                    </InputLabel>
                    <TextInput v-model="titulo" type="text" id="titulo"
                        class="mt-1 p-2 w-full border rounded-md dark:bg-gray-900 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500" required />
                </div>

                <div class="mb-4">
                    <InputLabel for="descricao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Descrição
                    </InputLabel>
                    <textarea v-model="descricao" id="descricao" rows="3"
                        class="mt-1 p-2 w-full border rounded-md dark:bg-gray-900 dark:border-gray-700 text-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500" required ></textarea>
                </div>

                <div class="mb-4">
                    <InputLabel for="nota" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nota (0-5)
                    </InputLabel>
                    <select v-model.number="nota" id="nota"
                        class="mt-1 p-2 w-full border rounded-md dark:bg-gray-900 text-gray-700 dark:text-gray-300 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500" required >
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <SecondaryButton type="button" @click="fecharPainel"
                        class="mr-2 px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                        Cancelar
                    </SecondaryButton>
                    <PrimaryButton type="submit"
                        class="px-4 py-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                        Enviar
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import PrimaryButton from './PrimaryButton.vue';
import SecondaryButton from './SecondaryButton.vue';
import ReviewButton from './ReviewButton.vue';
import CardapioButton from './CardapioButton.vue';
import LikeButton from './LikesButton.vue';
import DislikeButton from './DislikesButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

export default {
    components: {
        PrimaryButton,
        SecondaryButton,
        LikeButton,
        CardapioButton,
        DislikeButton,
        ReviewButton,
        TextInput,
        InputLabel
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
    data() {
        return {
            mostrarPainel: false,
            titulo: "",
            descricao: "",
            nota: null,
        };
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
        darReview(restaurante) {
            // Implemente a lógica para visualizar o cardápio aqui
            console.log('Visualizando review de:', restaurante.nome);
        },
        abrirPainel() {
            this.mostrarPainel = true;
        },
        hideReview(event) {
            if (!event.target.closest('.edit-box-content')) {
                this.mostrarPainel = false;
            }
        },
        fecharPainel() {
            this.mostrarPainel = false;
            this.limparFormulario();
        },
        enviarAvaliacao() {
            // Implemente aqui a lógica para enviar a avaliação (título, descrição, nota)
            // para o seu backend ou API.
            const formData = new FormData();

            formData.append('titulo', this.titulo);
            formData.append('descricao', this.descricao);
            formData.append('nota', this.nota);
            formData.append('restaurante_id', this.restaurante.id);
            formData.append('user_id',  this.userId,);

            Inertia.post(route('restaurantes.review'), formData, {
                forceFormData: true
            });

            this.fecharPainel();
        },
        limparFormulario() {
            this.titulo = "";
            this.descricao = "";
            this.nota = null;
        },
    },
};
</script>

<style scoped>
.edit-box {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.edit-box-content {
    padding: 20px;
    border-radius: 5px;
    width: 50%;
    max-width: 600px;
}
</style>
