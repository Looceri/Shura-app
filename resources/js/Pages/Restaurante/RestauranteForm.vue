<template>
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="nome" value="Nome" />
            <TextField id="nome" v-model="form.name" />
        </div>
        <div>
            <InputLabel for="endereco" value="Endereço" />
            <TextField id="endereco" v-model="form.location" />
        </div>
        <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Criar</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        <button type="submit">{{ editMode ? 'Update' : 'Register' }}</button>
    </form>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { ref, watch } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

export default {
    components: {
        InputLabel,
        TextInput,
        PrimaryButton
    },
    props: {
        restaurante: Object,
        editMode: {
            type: Boolean,
            default: false,
        },
    },
    setup(props) {
        const form = ref({
            name: '',
            location: '',
        });

        watch(
            () => props.restaurante,
            (newRestaurante) => {
                if (newRestaurante) {
                    form.value.name = newRestaurante.name;
                    form.value.location = newRestaurante.location;
                }
            },
            { immediate: true }
        );

        function submit() {
            if (props.editMode) {
                Inertia.put(route('restaurantes.update', props.restaurante.id), form.value);
            } else {
                Inertia.post(route('restaurantes.store'), form.value);
            }
        }

        return { form, submit };
    },
};
</script>
