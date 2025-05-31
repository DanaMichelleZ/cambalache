<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    publicaciones: Array,
});

// Función para obtener la URL correcta de la imagen
function getImagenUrl(publicacion) {
    const imagen = publicacion.imagenes?.[0];
    if (!imagen) return '';

    if (imagen.ruta === 'images/remera.png') {
        return '/images/remera.png';
    }

    return `/storage/${imagen.ruta.replace('public/', '')}`;
}
</script>

<template>
    <Head title="Inicio" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Inicio
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div
                        v-for="publicacion in publicaciones"
                        :key="publicacion.id"
                        class="bg-white p-4 rounded shadow"
                    >
                        <img
                            v-if="publicacion.imagenes.length"
                            :src="getImagenUrl(publicacion)"
                            alt="Imagen publicación"
                            class="w-full h-48 object-cover rounded mb-2"
                        />
                        <h3 class="text-lg font-bold">{{ publicacion.titulo }}</h3>
                        <p class="text-sm text-gray-600 mb-1">Estado: {{ publicacion.estado }}</p>
                        <p class="text-sm text-gray-700 mb-1">{{ publicacion.descripcion }}</p>
                        <p class="text-xs text-gray-500">Zona: {{ publicacion.user.zona.nombre }}</p>
                        <p class="text-xs text-gray-500">Publicado por: {{ publicacion.user.name }}</p>

                        <Link
                            :href="route('publicaciones.show', publicacion.id)"
                            class="mt-3 inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded"
                        >
                            Ver más
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
