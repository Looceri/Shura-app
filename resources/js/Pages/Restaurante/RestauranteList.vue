<template>
    <div :class="{ 'dark-mode': isDarkMode }">
        <ul class="restaurant-grid">
            <li v-for="restaurante in restaurantes" :key="restaurante.id" class="restaurant-card">
                <div class="card-image">
                    <img :src="'storage/restaurantes/' + restaurante.imagem" alt="Restaurant Image">
                </div>
                <div class="card-content">
                    <h2>{{ restaurante.nome }}</h2>
                    <p>{{ restaurante.endereco }}</p>
                    <p>{{ restaurante.descricao }}</p>
                    <br>
                    <PrimaryButton @click="editRestaurante(restaurante)">Edit</PrimaryButton>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import PrimaryButton from '@/Components/PrimaryButton.vue';

export default {
    components: {
        PrimaryButton
    },
    props: {
        restaurantes: Array,
        isDarkMode: Boolean, // Add a new prop to indicate the dark mode status
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
    margin: 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
}

.card-image {
    width: 100%;
    height: 200px;
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

/* Dark mode styles */
.dark-mode {
    background-color: #333;
    color: #fff;
}

.dark-mode .restaurant-card {
    border-color: #666;
}

.dark-mode .card-content h2,
.dark-mode .card-content p {
    color: #fff;
}

.dark-mode .card-content button {
    background-color: #666;
    color: #fff;
}
</style>
