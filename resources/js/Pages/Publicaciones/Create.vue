<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from 'axios';

const form = useForm({
    titulo: '',
    descripcion: '',
    estado: 'usado',
    interes_trueque: [],
    partido: '',
    localidad: '',
    imagenes: [],
});

const partidos = ref([]);
const localidades = ref([]);

// Buscar partidos al cargar
async function buscarPartidos() {
    try {
        const response = await axios.get('https://apis.datos.gob.ar/georef/api/departamentos?provincia=02&max=100');
        partidos.value = response.data.departamentos.map(p => p.nombre);
    } catch (error) {
        console.error('Error obteniendo partidos:', error);
        partidos.value = [];
    }
}
buscarPartidos();

// Cargar localidades según partido
watch(() => form.partido, async (nuevoPartido) => {
    form.localidad = '';
    localidades.value = [];
    if (!nuevoPartido) return;

    try {
        const response = await axios.get(`https://apis.datos.gob.ar/georef/api/localidades?departamento=${encodeURIComponent(nuevoPartido)}&provincia=02&max=100`);
        localidades.value = response.data.localidades.map(l => l.nombre);
    } catch (error) {
        console.error('Error obteniendo localidades:', error);
    }
});

function submit() {
    form.post(route('publicaciones.store'), {
        forceFormData: true,
    });
}
</script>

<template>
    <Head title="Crear Publicación" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Publicación</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="space-y-6 bg-white p-6 rounded shadow">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Título</label>
                        <input v-model="form.titulo" type="text" class="mt-1 block w-full border-gray-300 rounded" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea v-model="form.descripcion" rows="4" class="mt-1 block w-full border-gray-300 rounded"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select v-model="form.estado" class="mt-1 block w-full border-gray-300 rounded">
                            <option value="nuevo">Nuevo</option>
                            <option value="usado">Usado</option>
                            <option value="roto">Roto</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Interés de Trueque (coma separados)</label>
                        <input
                            type="text"
                            @input="form.interes_trueque = $event.target.value.split(',').map(e => e.trim())"
                            class="mt-1 block w-full border-gray-300 rounded"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Partido</label>
                        <select v-model="form.partido" class="mt-1 block w-full border-gray-300 rounded">
                            <option disabled value="">Seleccione un partido</option>
                            <option v-for="p in partidos" :key="p" :value="p">{{ p }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Localidad</label>
                        <select v-model="form.localidad" class="mt-1 block w-full border-gray-300 rounded">
                            <option disabled value="">Seleccione una localidad</option>
                            <option v-for="l in localidades" :key="l" :value="l">{{ l }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Imágenes</label>
                        <input type="file" multiple @change="form.imagenes = $event.target.files" />
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                            :disabled="form.processing"
                        >
                            Publicar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
