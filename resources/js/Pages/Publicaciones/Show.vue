<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';

const props = defineProps({
    publicacion: Object,
});

const page = usePage();
const user = page.props.auth.user;
const flash = page.props.flash;

const toast = ref(null);
const enviado = ref(false); // 🟢 Marca si ya fue enviada

onMounted(() => {
    if (flash.success) {
        toast.value = flash.success;
        enviado.value = flash.success.includes('Ya enviaste') || flash.success.includes('Solicitud enviada');
        setTimeout(() => (toast.value = null), 3000);
    }
});

const esDeOtroUsuario = computed(() => {
    return user && user.id !== props.publicacion.user.id;
});

function getImagenUrl(ruta) {
    if (ruta === 'images/remera.png') return '/images/remera.png';
    return `/storage/${ruta.replace('public/', '')}`;
}

function enviarSolicitud() {
    router.post('/notificaciones', {
        user_id: props.publicacion.user.id,
        publicacion_id: props.publicacion.id,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            enviado.value = true;
            toast.value = 'Solicitud enviada.';
            setTimeout(() => (toast.value = null), 3000);
        },
        onError: () => {
            toast.value = 'Error al enviar la solicitud.';
            setTimeout(() => (toast.value = null), 3000);
        }
    });
}
</script>

<template>
    <Head :title="publicacion.titulo" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ publicacion.titulo }}
            </h2>
        </template>

        <!-- Toast -->
        <div v-if="toast" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow z-50">
            {{ toast }}
        </div>

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

                <!-- Botón de solicitud -->
                <div v-if="esDeOtroUsuario" class="mt-6">
                    <button
                        @click="enviarSolicitud"
                        :disabled="enviado"
                        class="px-4 py-2 rounded font-semibold text-white"
                        :class="enviado ? 'bg-gray-400 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700'"
                    >
                        {{ enviado ? 'Solicitud enviada' : 'Enviar solicitud de trueque' }}
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
