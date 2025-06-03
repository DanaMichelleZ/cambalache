<template>
    <div class="p-6">
        <div>
            <h1>Panel de Administración</h1>
            <p>Bienvenido, {{ $page.props.auth.user.name }} (Rol: {{ $page.props.auth.user.rol }})</p>
        </div>
        <div class="mt-6">
            <Link class="text-blue-500 underline" :href="route('usuarios.index')">Gestionar Usuarios</Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    auth: Object
});
const user = auth.user;
</script>