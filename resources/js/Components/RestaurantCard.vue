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

                <div class="absolute top-2 right-2 px-2 py-1 rounded-md text-white font-bold"
                    :class="corDeFundoDasReviews">
                    <span v-if="mediaNotas >= 4.5">👑 </span>
                    {{ mediaNotas.toFixed(1) }}
                </div>

                <div class="absolute bottom-2 right-2 px-2 py-1 rounded-md text-white font-bold"
                    :class="corDeFundoDosLikes">
                    <span v-if="porcentagemLikes >= 90">👑 </span>
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
                    <CardapioButton @click="abrirCardapio"
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
                <div class="mt-2 flex-1">
                    <CommentsButton @click="showCommentsPanel = true"
                        class="flex items-center justify-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Comentários
                    </CommentsButton>
                </div>
            </div>

            <!-- Cardápio -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 relative">
                    <!-- ... (código anterior para informações do restaurante) ... -->
                </div>
            </div>

            <div v-if="mostrarCardapio"
                class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-90"
                @click="fecharCardapio">
                <div class="cardapio-panel bg-white dark:bg-gray-800 rounded-lg p-6 shadow-xl w-full max-w-3xl"
                    @click.stop>
                    <h2 class="text-2xl font-bold mb-4 dark:text-gray-100">Cardápio</h2>
                    <ul v-if="restaurante.itens.length" class="list-inside">
                        <li v-for="item in restaurante.itens" :key="item.id" class="mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img :src="'storage/items/' + item.imagem" :alt="'imagem de ' + item.nome"
                                        class="w-16 h-16 object-cover rounded-md mr-4">
                                    <div>
                                        <span class="text-lg font-medium dark:text-gray-100">{{ item.nome }}</span>
                                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ item.descricao }}</p>
                                    </div>
                                </div>
                                <span class="text-gray-600 dark:text-gray-100">{{ item.preco }}</span>
                            </div>
                            <div class="mt-2 flex items-center">
                                <button @click="decrementarQuantidade(item)"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold py-1 px-2 rounded-l">
                                    -
                                </button>
                                <input type="number" v-model.number="item.quantidade" min="0"
                                    class="w-16 text-center border-t border-b focus:outline-none" />
                                <button @click="incrementarQuantidade(item)"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold py-1 px-2 rounded-r">
                                    +
                                </button>
                            </div>
                        </li>
                        <div class="mt-6 flex justify-between items-center">
                            <span v-if="precoTotal > 0" class="text-lg font-medium dark:text-gray-100">
                                Total: {{ precoTotal.toFixed(2) }}
                            </span>
                            <div>
                                <SecondaryButton @click="fecharCardapio"
                                    class="mr-2 px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                                    Cancelar
                                </SecondaryButton>
                                <PrimaryButton @click="fazerPedido"
                                    class="px-4 py-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                                    Fazer Pedido
                                </PrimaryButton>
                            </div>
                        </div>
                    </ul>
                    <div v-else>
                        <p class="text-gray-500 dark:text-gray-400">
                            Nenhum item no cardápio ainda.
                        </p>
                        <div class="mt-2 flex-1">
                            <SecondaryButton @click="fecharCardapio"
                                class="mr-2 px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                                Cancelar
                            </SecondaryButton>
                        </div>
                    </div>
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
                        class="mt-1 p-2 w-full border rounded-md dark:bg-gray-900 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500"
                        required />
                </div>

                <div class="mb-4">
                    <InputLabel for="descricao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Descrição
                    </InputLabel>
                    <textarea v-model="descricao" id="descricao" rows="3"
                        class="mt-1 p-2 w-full border rounded-md dark:bg-gray-900 dark:border-gray-700 text-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        required></textarea>
                </div>

                <div class="mb-4">
                    <InputLabel for="nota" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nota (0-5)
                    </InputLabel>
                    <select v-model.number="nota" id="nota"
                        class="mt-1 p-2 w-full border rounded-md dark:bg-gray-900 text-gray-700 dark:text-gray-300 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500"
                        required>
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

    <transition name="slide-fade">
        <div v-if="showCommentsPanel"
            class="comments-panel fixed inset-0 flex justify-center z-50 bg-gray-900 bg-opacity-90"
            @click="hideCommentsPanel">
            <div class="comments-panel-content bg-gray-800 text-white p-6 shadow-xl w-96" @click.stop>
                <h2 class="text-2xl font-bold mb-4">Comentários</h2>
                <div v-if="reviewsForRestaurant.length > 0" class="reviews">
                    <div v-for="review in reviewsForRestaurant" :key="review.id"
                        class="review p-4 rounded-lg shadow-md mb-4 bg-gray-700">
                        <div class="flex items-start mb-2">
                            <span class="font-bold">{{ review.user.name }}</span>
                            <span class="text-gray-400 text-sm ml-auto">{{
                                formatDate(review.created_at)
                            }}</span>
                        </div>
                        <p class="text-gray-300">{{ review.descricao }}</p>
                        <div class="flex items-center mt-2">
                            <StarRating :rating="review.nota" />
                        </div>
                    </div>
                    <PrimaryButton @click="showCommentsPanel = false" class="mt-4">
                        Fechar
                    </PrimaryButton>
                </div>
                <div v-else>
                    <p class="text-gray-400">Seja o primeiro a comentar!</p>
                    <div class="mt-2 flex-1">
                        <ReviewButton @click="abrirPainel"
                            class="flex items-center justify-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Review
                        </ReviewButton>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import PrimaryButton from './PrimaryButton.vue';
import SecondaryButton from './SecondaryButton.vue';
import ReviewButton from './ReviewButton.vue';
import CardapioButton from './CardapioButton.vue';
import LikeButton from './LikesButton.vue';
import DislikeButton from './DislikesButton.vue';
import CommentsButton from './CommentsButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import StarRating from './StarRating.vue';

export default {
    components: {
        PrimaryButton,
        SecondaryButton,
        LikeButton,
        CardapioButton,
        DislikeButton,
        ReviewButton,
        TextInput,
        InputLabel,
        CommentsButton,
        StarRating,
    },
    props: {
        restaurante: Object,
        likes: Array,
        reviews: Array,
        totalUsers: Number, // Adicione a prop totalUsers
    },
    setup(props) {
        const page = usePage();
        const userId = computed(() => page.props.auth.user.id);
        const isLiked = computed(() => {
            return props.likes.some(
                (like) =>
                    like.restaurante_id === props.restaurante.id &&
                    like.user_id === userId.value
            );
        });

        return { userId, isLiked };
    },
    computed: {
        mediaNotas() {
            const notas = this.reviews
                .filter((review) => review.restaurante_id === this.restaurante.id)
                .map((review) => review.nota);

            if (notas.length === 0) {
                return 0;
            }

            const somaDasNotas = notas.reduce((total, nota) => total + nota, 0);
            return somaDasNotas / notas.length;
        },
        likesCount() {
            return this.likes.filter(
                (like) => like.restaurante_id === this.restaurante.id
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
        corDeFundoDasReviews() {
            if (this.mediaNotas >= 4.0) {
                return 'bg-green-500';
            } else if (this.mediaNotas >= 2.5) {
                return 'bg-yellow-400';
            } else {
                return 'bg-gray-400';
            }
        },
        reviewsForRestaurant() {
            return this.reviews.filter(
                (review) => review.restaurante_id === this.restaurante.id
            );
        },
        precoTotal() {
            return this.restaurante.itens.reduce((total, item) => {
                return total + (item.preco * (item.quantidade || 0));
            }, 0);
        },
        userId() {
            return computed(() => page.props.auth.user.id);
        },
    },
    data() {
        return {
            mostrarPainel: false,
            titulo: '',
            descricao: '',
            nota: null,
            showCommentsPanel: false,
            mostrarCardapio: false, // Controla a visibilidade do cardápio
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
                }
            );
        },
        removerDosFavoritos() {
            Inertia.post(
                route('restaurantes.unlike'),
                {
                    user_id: this.userId,
                    restaurante_id: this.restaurante.id,
                },
                {
                    forceFormData: true,
                    onSuccess: () => {
                        // Remove o like do array local para atualização da interface
                        const likeIndex = this.likes.findIndex(
                            (like) =>
                                like.restaurante_id === this.restaurante.id &&
                                like.user_id === this.userId
                        );
                        if (likeIndex > -1) {
                            this.likes.splice(likeIndex, 1);
                        }
                    },
                }
            );
        },
        abrirPainel() {
            this.mostrarPainel = true;
            this.showCommentsPanel = false;
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
            formData.append('user_id', this.userId);

            Inertia.post(route('restaurantes.review'), formData, {
                forceFormData: true,
            });

            this.fecharPainel();
        },
        limparFormulario() {
            this.titulo = '';
            this.descricao = '';
            this.nota = null;
        },
        formatDate(dateString) {
            // Formata a data para exibição (ajuste o formato conforme necessário)
            const date = new Date(dateString);
            return date.toLocaleDateString();
        },
        hideCommentsPanel(event) {
            // Verifica se o clique foi fora do conteúdo do painel
            if (!event.target.closest('.comments-panel')) {
                this.showCommentsPanel = false;
            }
        },
        abrirCardapio() {
            // Inicializa a quantidade de cada item como 0 ao abrir o cardápio
            this.restaurante.itens.forEach((item) => {
                item.quantidade = 0;
            });
            this.mostrarCardapio = true;
        },
        fecharCardapio() {
            this.mostrarCardapio = false;
        },
        incrementarQuantidade(item) {
            item.quantidade++;
        },
        decrementarQuantidade(item) {
            if (item.quantidade > 0) {
                item.quantidade--;
            }
        },
        fazerPedido() {
            // Implemente a lógica para enviar o pedido para o backend
            // Utilize Inertia.post para enviar os dados do pedido
            const itensPedido = this.restaurante.itens.filter(
                (item) => item.quantidade > 0
            );

            // Exemplo de dados a serem enviados:
            const dadosPedido = {
                restaurante_id: this.restaurante.id,
                user_id: this.userId,
                itens: itensPedido,
                preco_total: this.precoTotal,
            };

            Inertia.post(route('pedidos.store'), dadosPedido, {
                forceFormData: true,
                onSuccess: () => {
                    // Lógica após o pedido ser feito com sucesso
                    this.fecharCardapio(); // Fecha o cardápio
                    // Exibe mensagem de sucesso, limpa o carrinho, etc.
                },
            });
        },
    },
};
</script>

<style scoped>
.comments-panel {
    position: fixed;
    top: 0;
    left: 0;
    padding: 0;
    width: 300px;
    height: 100vh;
    background-color: #f5f5f5;
    padding: 20px;
    overflow-y: auto;
    z-index: 9999;
}

.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter,
.slide-fade-leave-to {
    transform: translateX(-100%);
    opacity: 0;
}

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

.comments-panel {
    position: fixed;
    top: 0;
    right: -300px;
    padding: 0;
    /* Start off-screen to the right */
    width: 300px;
    height: 100vh;
    background-color: #f5f5f5;
    overflow-y: auto;
    z-index: 9999;
    transition: right 0.3s ease;
    /* Add a transition effect */
}

.comments-panel.show {
    right: 0;
    /* Slide in from the right */
}

.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter,
.slide-fade-leave-to {
    transform: translateX(100%);
    opacity: 0;
}

.cardapio-panel {
    position: relative;
    z-index: 1000;
}
</style>
