<template>
    <div>
        <label :for="id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ label }}</label>
        <select
            :id="id"
            v-model="internalValue"
            @change="emitChange"
            class="form-select block w-full mt-1 dark:bg-gray-800 dark:text-gray-300"
            :class="inputClass">
            <option disabled value="">{{ placeholder }}</option>
            <option v-for="option in options" :key="option.id" :value="option.id">
                {{ option.name }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            required: true
        },
        value: {
            type: [String, Number],
            required: true
        },
        options: {
            type: Array,
            required: true
        },
        label: {
            type: String,
            default: ''
        },
        placeholder: {
            type: String,
            default: 'Por favor selecione um restaurante'
        },
        inputClass: {
            type: String,
            default: ''
        }
    },
    emits: ['update:value'],
    computed: {
        internalValue: {
            get() {
                return this.value;
            },
            set(value) {
                this.$emit('update:value', value);
            }
        }
    },
    methods: {
        emitChange(event) {
            this.$emit('update:value', event.target.value);
        }
    }
}
</script>

<style scoped>
.form-select {
    /* Customize the select input style if needed */
}
</style>
