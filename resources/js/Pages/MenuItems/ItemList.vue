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
                    <PrimaryButton @click="showEditBox(item)">Editar</PrimaryButton>
                </div>
            </li>
        </ul>

        <!-- Edit box with click-outside directive -->
        <div v-if="showEditBoxVisible" class="edit-box bg-gray-100 dark:bg-gray-900" @click="hideEditBox">
            <div class="edit-box-content bg-gray-100 dark:bg-gray-900" @click.stop>
                <!-- Add your edit form here -->
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edite o Item</h2>
                <!-- ... existing form fields ... -->
                <form @submit.prevent="submit" enctype="multipart/form-data">

                    <div>
                        <div class="card-image">
                            <img :src="'storage/items/' + form.imagem" id="imagem_iluistartiva" alt="Item Image">
                        </div>
                        <br>
                        <input type="file" id="imagem" name="imagem" accept="image/*" @change="trocarImagens"
                            class="form-control-file dark:bg-gray-800 dark:text-white">
                    </div>

                    <br>
                    <div>
                        <InputLabel for="nome" value="Nome" />
                        <TextInput id="nome" type="text" class="mt-1 block w-full" v-model="form.nome" required
                            autofocus autocomplete="nome" />
                    </div>
                    <br>
                    <div>
                        <InputLabel for="preco" value="Preço" />
                        <TextInput id="preco" type="number" class="mt-1 block w-full" v-model="form.preco" required
                            autofocus autocomplete="preco" step="0.01" />
                    </div>
                    <br>
                    <br>
                    <div>
                        <InputLabel for="restaurant_id">Restaurante</InputLabel>
                        <div>
                            <select :id="id" v-model="form.restaurante_id" @change="emitChange"
                                class="form-select block w-full mt-1 dark:bg-gray-800 dark:text-gray-300"
                                :class="inputClass">
                                <option disabled value="">{{ placeholder }}</option>
                                <option v-for="restaurante in restaurantes" :key="restaurante.id"
                                    :value="restaurante.id">
                                    {{ restaurante.nome }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div>
                        <InputLabel for="descricao">Descrição</InputLabel>
                        <textarea id="descricao" class="mt-1 block w-full dark:bg-gray-800 dark:text-white"
                            v-model="form.descricao" rows="5"></textarea>
                    </div>
                    <br>
                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing" type="submit">Update
                        </PrimaryButton>
                        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.
                            </p>
                        </Transition>
                    </div>
                </form>

            </div>
        </div>

    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

export default {
    components: {
        PrimaryButton,
        TextInput,
        InputLabel,
    },
    props: {
        items: Array,
        restaurantes: Array,
        placeholder: {
            type: String,
            default: 'Por favor selecione um restaurante'
        },
    },
    emits: ['edit'],
    data() {
        return {
            selectedItem: null,
            showEditBoxVisible: false, // Controla a visibilidade da caixa de edição
        };
    },
    methods: {
        showEditBox(item) {
            this.selectedItem = item;
            this.form = this.selectedItem;
            this.showEditBoxVisible = true; // Mostra a caixa de edição
        },
        hideEditBox(event) {
            // If the click is outside the .edit-box-content, hide the box
            if (!event.target.closest('.edit-box-content')) {
                this.showEditBoxVisible = false;
            }
        },
        hideEditBox() {
            this.showEditBoxVisible = false; // Esconde a caixa de edição
        },
        trocarImagens(event) {
            this.imagem = event.target.files[0];
            const imagemElement = document.getElementById('imagem_iluistartiva');
            if (imagemElement) {
                imagemElement.src = URL.createObjectURL(this.imagem);
                form.imagem = this.imagem;
            }
        }
    },
    setup() {
        const form = useForm({
            id: '',
            nome: '',
            preco: 0,
            restaurante_id: '',
            descricao: '',
            imagem: null,
        });
        const imagem = ''

        async function submit() {
            console.log(this.imagem)
        }

        return { form, imagem, submit };

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
