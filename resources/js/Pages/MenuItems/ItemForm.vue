<template>

    <form @submit.prevent="submit" enctype="multipart/form-data">
        <div>
            <InputLabel for="imagem">Imagem</InputLabel>
            <div>
                <div  class="card-image">
                    <img :src="'storage/items/' + form.imagem" id="imagem_iluistartiva" alt="Escolha a sua imagem" class="text-gray-800 dark:text-gray-200">
                    <br>
                </div>
                <input type="file" id="imagem" name="imagem" accept="image/*" @change="trocarImagens"
                    class="form-control-file dark:bg-gray-800 dark:text-white">
            </div>
        </div>
        <br>
        <div>
            <InputLabel for="nome" value="Nome" />
            <TextInput id="nome" type="text" class="mt-1 block w-full" v-model="form.nome" required autofocus
                autocomplete="nome" />
        </div>
        <br>
        <div>
            <InputLabel for="preco" value="Preço" />
            <TextInput id="preco" type="number" class="mt-1 block w-full" v-model="form.preco" required autofocus
                autocomplete="preco" step="0.01" />
        </div>
        <br>
        <br>
        <div>
            <InputLabel for="restaurant_id">Restaurante</InputLabel>
            <div>
                <select :id="id" v-model="form.restaurante_id" @change="emitChange"
                    class="form-select block w-full mt-1 dark:bg-gray-800 dark:text-gray-300" :class="inputClass">
                    <option disabled value="">{{ placeholder }}</option>
                    <option v-for="restaurante in restaurantes" :key="restaurante.id" :value="restaurante.id">
                        {{ restaurante.nome }}
                    </option>
                </select>
            </div>
        </div>
        <br>
        <div>
            <InputLabel for="descricao">Descrição</InputLabel>
            <textarea id="descricao" class="mt-1 block w-full dark:bg-gray-800 dark:text-white" v-model="form.descricao"
                rows="5"></textarea>
        </div>
        <br>
        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing" type="submit">{{ editMode ? 'Update' : 'Registrar' }}
            </PrimaryButton>
            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
            </Transition>
        </div>
        <input type="hidden" id="user_id" name="user_id" v-model="userId">
    </form>
</template>

<script>
import { useForm, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref, watch } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';

export default {
    components: {
        InputLabel,
        TextInput,
        PrimaryButton,
        SelectInput,
    },
    methods: {
        onRestauranteSelecionado(valorSelecionado) {
            form.restaurante_id = valorSelecionado
            id.value = valorSelecionado
            console.log('Restaurante selecionado:', id);
            // Utilize o valorSelecionado para realizar ações no seu componente pai
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
    props: {
        restaurantes: Array,
        item: Object,
        editMode: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
            default: 'Por favor selecione um restaurante'
        },
    },
    setup(props) {
        const form = useForm({
            id: '',
            nome: '',
            preco: 0,
            restaurante_id: '',
            descricao: '',
            imagem: null,
        });

        const page = usePage();
        const userId = ref(page.props.auth.user.id);
        const id = '';
        const imagem = ''

        watch(
            () => props.item,
            (newItem) => {
                if (newItem) {
                    form.id = newItem.id;
                    form.nome = newItem.nome;
                    form.restaurante_id = newItem.restaurante_id;
                    form.preco = newItem.preco;
                    form.descricao = newItem.descricao;
                    form.imagem = newItem.imagem ? newItem.imagem : null;
                }
            },
            { immediate: true }
        );




        async function submit() {
            const formData = new FormData();
            formData.append('nome', form.nome);
            formData.append('restaurante_id', form.restaurante_id);
            formData.append('descricao', form.descricao);
            formData.append('preco', form.preco);
            if (form.imagem) {
                formData.append('imagem', form.imagem);
            }
            formData.append('user_id', userId.value);
            if (props.editMode) {
                await Inertia.post(route('items.update', props.item.id), formData, {
                    forceFormData: true,
                    onFinish: () => form.reset(),
                });
            } else {
                await Inertia.post(route('items.store'), formData, {
                    forceFormData: true,
                });
            }
        }

        return { form, imagem, userId, submit };
    },
};
</script>
<style scoped>

.card-image {
    width: 100%;
    height: 10cm;
    overflow: hidden;
    margin-top: 10px;
    margin-bottom: 10px;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
