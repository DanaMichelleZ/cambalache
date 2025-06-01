<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    notificaciones: Array,
});
</script>

<template>
    <Head title="Notificaciones" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tus notificaciones
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div v-if="notificaciones.length" class="space-y-4">
                    <div
                        v-for="noti in notificaciones"
                        :key="noti.id"
                        class="p-4 bg-white shadow rounded"
                    >
                        <p class="text-gray-800">
                            {{ noti.mensaje }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Enviada por: {{ noti.remitente.name }}
                        </p>
                        <Link
                            :href="route('publicaciones.show', noti.publicacion.id)"
                            class="inline-block mt-2 text-blue-600 hover:underline text-sm"
                        >
                            Ver publicación relacionada
                        </Link>
                    </div>
                </div>

                <div v-else class="text-gray-600 text-center">
                    No tenés notificaciones por el momento.
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
