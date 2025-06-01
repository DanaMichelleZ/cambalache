<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

const page = usePage();
const user = page.props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    zona_tipo: user.zona?.tipo || '',
    partido: user.partido || '',
});

const partidos = ref([]);

// Cargar partidos según la zona
async function buscarPartidos(zonaTipo) {
    partidos.value = [];

    try {
        if (zonaTipo === 'CABA') {
            const res = await axios.get('https://apis.datos.gob.ar/georef/api/departamentos?provincia=02&max=100');
            partidos.value = res.data.departamentos.map(d => d.nombre).filter(n => n.includes('Comuna'));
        } else if (zonaTipo === 'AMBA') {
            const res = await axios.get('https://apis.datos.gob.ar/georef/api/departamentos?provincia=Buenos Aires&max=135');
            partidos.value = res.data.departamentos.map(d => d.nombre);
        }
    } catch (err) {
        console.error('Error obteniendo partidos:', err);
    }
}

onMounted(() => {
    if (form.zona_tipo) buscarPartidos(form.zona_tipo);
});

watch(() => form.zona_tipo, (nuevaZona) => {
    form.partido = '';
    if (nuevaZona) buscarPartidos(nuevaZona);
});

function submit() {
    form.patch(route('profile.update'));
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Información del perfil</h2>
            <p class="mt-1 text-sm text-gray-600">Actualizá tu nombre, email y zona.</p>
        </header>

        <!-- FORMULARIO -->
        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="zona_tipo" value="Zona" />
                <select id="zona_tipo" v-model="form.zona_tipo" class="mt-1 block w-full rounded border-gray-300">
                    <option disabled value="">Seleccioná una zona</option>
                    <option value="CABA">CABA</option>
                    <option value="AMBA">AMBA</option>
                </select>
                <InputError class="mt-2" :message="form.errors.zona_tipo" />
            </div>

            <div v-if="form.zona_tipo">
                <InputLabel
                    for="partido"
                    :value="form.zona_tipo === 'CABA' ? 'Barrio' : 'Partido'"
                />
                <select id="partido" v-model="form.partido" class="mt-1 block w-full rounded border-gray-300">
                    <option disabled value="">Seleccioná una opción</option>
                    <option v-for="p in partidos" :key="p" :value="p">{{ p }}</option>
                </select>
                <InputError class="mt-2" :message="form.errors.partido" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
            </div>
        </form>
    </section>
</template>
