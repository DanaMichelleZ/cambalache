<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    publicacion: Object,
});
</script>

<template>
    <Head :title="publicacion.titulo" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ publicacion.titulo }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
                <img
                    v-if="publicacion.imagenes.length"
                    :src="getImagenUrl(publicacion.imagenes[0].ruta)"
                    alt="Imagen publicación"
                    class="w-full h-64 object-cover rounded mb-4"
                />

                <p class="text-gray-600 mb-2">
                    <strong>Estado:</strong> {{ publicacion.estado }}
                </p>
                <p class="text-gray-700 mb-4">
                    {{ publicacion.descripcion }}
                </p>
                <p class="text-sm text-gray-500">
                    <strong>Zona:</strong> {{ publicacion.user.zona.nombre }}
                </p>
                <p class="text-sm text-gray-500">
                    <strong>Publicado por:</strong> {{ publicacion.user.name }}
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    <strong>Intereses de trueque:</strong>
                    <span v-for="(item, index) in publicacion.interes_trueque" :key="index">
                        {{ item }}<span v-if="index < publicacion.interes_trueque.length - 1">, </span>
                    </span>
                </p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>

function getImagenUrl(ruta) {
    if (ruta === 'images/remera.png') {
        return '/images/remera.png';
    }
    return `/storage/${ruta.replace('public/', '')}`;
}
</script>
