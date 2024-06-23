<template>
    <div>
        <ul class="restaurant-grid">
                <li v-for="restaurante in restaurantes" :key="restaurante.id" class="restaurant-card">
                    <div class="p-6 relative">
                        <div class="relative">
                            <img :src="'storage/restaurantes/' + restaurante.imagem" alt="Imagem do Restaurante"
                                class="w-full h-48 object-cover rounded-md text-gray-800 dark:text-gray-200" />

                            <!-- Contador de likes sobre a imagem -->
                            <div class="absolute top-2 left-2 px-2 py-1 rounded-md text-white font-bold"
                                :class="corDeFundoDosLikes(restaurante.id)">
                                <span v-if="porcentagemLikes(restaurante.id) >= 100">👑</span>
                                {{ likesCount(restaurante.id) }}
                            </div>
                        </div>
                        <br>
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
        likes: Array,
        totalUsers: Number
    },
    emits: ['edit'],
    setup(props, { emit }) {
        function editRestaurante(restaurante) {
            emit('edit', restaurante);
        }

        return { editRestaurante };
    },
    computed: {
        likesCount() {
            return (restaurante_id) => {
                return this.likes.filter(
                    (like) => like.restaurante_id === restaurante_id,
                ).length;
            };
        },
        porcentagemLikes() {
            return (restaurante_id) => {
                const likesCount = this.likesCount(restaurante_id); // Assuming the first restaurant for example
                const totalUsers = this.totalUsers;
                if (typeof likesCount === 'number' && typeof totalUsers === 'number') {
                    return (likesCount / totalUsers) * 100;
                } else {
                    return 0; // Return 0 or any default value if either likesCount or totalUsers is not a number
                }
            }
        },
        corDeFundoDosLikes() {
            return (restaurante_id) => {
                const likesCount = this.likesCount(restaurante_id);
                const totalUsers = this.totalUsers;
                if (typeof likesCount === 'number' && typeof totalUsers === 'number') {
                    const percentage = (likesCount / totalUsers) * 100;
                    if (percentage >= 70) {
                        return 'bg-green-500';
                    } else if (percentage >= 35) {
                        return 'bg-yellow-400';
                    } else {
                        return 'bg-gray-400';
                    }
                } else {
                    return 'bg-gray-400'; // Default color if either likesCount or totalUsers is not a number
                }
            };
        },
    }
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
    padding: 2px;
    /* Add padding to the restaurant card */
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
