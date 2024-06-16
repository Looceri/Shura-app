<template>
    <form @submit.prevent="submit">
        <div>
            <InputLabel htmlFor="nome">Name:</InputLabel>
            <TextField id="nome" v-model="form.name" />
        </div>
        <div>
            <InputLabel htmlFor="endereco">Location:</InputLabel>
            <TextField id="endereco" v-model="form.location" />
        </div>
        <button type="submit">{{ editMode ? 'Update' : 'Register' }}</button>
    </form>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { ref, watch } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

export default {
    components: {
        InputLabel,
        TextInput,
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
