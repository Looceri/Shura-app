<template>
    <form @submit.prevent="submit" enctype="multipart/form-data">
        <div>
            <InputLabel for="nome" value="Nome" />
            <TextInput id="nome" type="text" class="mt-1 block w-full" v-model="form.nome" required autofocus
                autocomplete="nome" />
        </div>
        <br>
        <div>
            <InputLabel for="restaurant_id">Restaurante</InputLabel>
            <SelectInput id="restaurant_id" v-model="form.restaurante_id" :options="restaurantes" />
        </div>
        <br>
        <div>
            <InputLabel for="descricao">Descrição</InputLabel>
            <textarea id="descricao" class="mt-1 block w-full dark:bg-gray-800 dark:text-white" v-model="form.descricao"
                rows="5"></textarea>
        </div>
        <br>
        <div>
            <InputLabel for="image">Imagem</InputLabel>
            <input type="file" id="image" name="image" accept="image/*" @change="handleImageUpload"
                class="form-control-file dark:bg-gray-800 dark:text-white">
            <div v-if="form.image">
                <img :src="form.image ? URL.createObjectURL(form.image) : ''" alt="Imagem do Item"
                    class="mt-2 rounded-md w-48 h-48 object-cover">
            </div>
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
    props: {
        restaurantes: Array,
        item: Object,
        editMode: {
            type: Boolean,
            default: false,
        },
    },
    setup(props) {
        const form = useForm({
            id: '',
            nome: '',
            restaurante_id: '',
            descricao: '',
            image: null,
        });

        const page = usePage();
        const userId = ref(page.props.auth.user.id);

        watch(
            () => props.item,
            (newItem) => {
                if (newItem) {
                    form.id = newItem.id;
                    form.nome = newItem.nome;
                    form.restaurante_id = newItem.restaurante_id;
                    form.descricao = newItem.descricao;
                    form.image = newItem.image ? newItem.image : null;
                }
            },
            { immediate: true }
        );

        function handleImageUpload(event) {
            form.image = event.target.files[0];
        }


        async function submit() {
            const formData = new FormData();
            formData.append('nome', form.nome);
            formData.append('restaurante_id', form.restaurante_id);
            formData.append('descricao', form.descricao);
            if (form.image) {
                formData.append('image', form.image);
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
                    onFinish: () => form.reset(),
                });
            }
        }

        return { form, userId, handleImageUpload, submit };
    },
};
</script>
