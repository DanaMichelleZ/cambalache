<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    zonas: Array,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    tipoZona: '',
    zona_id: '',
    partido: '',
});

const zonasFiltradas = computed(() =>
    props.zonas.filter(z => z.tipo === form.tipoZona)
);

// Sincronizar el campo partido con el nombre de la zona seleccionada
watch(() => form.zona_id, (nuevoId) => {
    const zona = props.zonas.find(z => z.id === parseInt(nuevoId));
    form.partido = zona?.nombre || '';
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="tipoZona" value="Zona" />
                <select
                    id="tipoZona"
                    v-model="form.tipoZona"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required
                >
                    <option value="" disabled>Selecciona</option>
                    <option value="CABA">CABA</option>
                    <option value="AMBA">AMBA</option>
                </select>
                <InputError class="mt-2" :message="form.errors.tipoZona" />
            </div>

            <div class="mt-4" v-if="form.tipoZona">
                <InputLabel for="zona_id" :value="form.tipoZona === 'CABA' ? 'Barrio' : 'Partido'" />
                <select
                    id="zona_id"
                    v-model="form.zona_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required
                >
                    <option value="" disabled>Selecciona una opción</option>
                    <option
                        v-for="zona in zonasFiltradas"
                        :key="zona.id"
                        :value="zona.id"
                    >
                        {{ zona.nombre }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.zona_id" />
            </div>

            <!-- Campo oculto para enviar el partido/barrio al backend -->
            <input type="hidden" v-model="form.partido" />

            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar contraseña" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    ¿Ya estás registrado?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Registrarse
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
