<template>
    <div>
        <ul class="item-grid">
            <li v-for="item in items" :key="item.id" class="item-card">
                <div class="card-image">
                    <img :src="'storage/items/' + item.imagem" alt="Item Image">
                </div>
                <div class="card-content">
                    <div class="w-full">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                            Nome:
                        </h2>
                        <h2 class="text-gray-800 dark:text-gray-200">{{ item.nome }}</h2>
                    </div>
                    <br>
                    <div class="w-full">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                            Restaurante:
                        </h2>
                        <p class="text-gray-800 dark:text-gray-200">{{ item.restaurante_nome }}</p>
                    </div>
                    <br>
                    <div class="w-full">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                            Descrição:
                        </h2>
                        <p class="text-gray-800 dark:text-gray-200">{{ item.descricao }}</p>
                    </div>
                    <br>
                    <div class="w-full">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                            Preço:
                        </h2>
                        <p class="text-gray-800 dark:text-gray-200">{{ item.preco }}</p>
                    </div>
                    <br>
                    <PrimaryButton @click="editItem(item)">Edit</PrimaryButton>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import PrimaryButton from '@/Components/PrimaryButton.vue';

export default {
    components: {
        PrimaryButton,
    },
    props: {
        items: Array,
        restaurantes: Array
    },
    emits: ['edit'],
    setup(props, { emit }) {
        function editItem(item) {
            emit('edit', item);
        }

        return { editItem };
    },
};
</script>

<style scoped>
.item-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 10px;
    padding: 10px;
}

.item-card {
    display: flex;
    flex-direction: column;
    width: 300px;
    margin: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    padding: 2px;
    /* Add padding to the item card */
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
</style>
