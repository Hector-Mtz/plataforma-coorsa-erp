<script setup>
import { computed } from '@vue/runtime-core';
const props = defineProps({
    ubicacion: {
        type: Object,
        required: true
    }
});

const total = computed(() => {
    let totalActivos = 0
    let totalRequeridos = 0
    props.ubicacion.plantillas_autorizadas.forEach(plantilla => {
        totalActivos += plantilla.cantidad_activa;
        totalRequeridos += plantilla.cantidad;
    })
    return totalActivos + '/' + totalRequeridos
})

</script>
<template>
    <th scope="col" class="px-2 py-1 text-xs text-center">
        <span>{{ ubicacion.name }}</span>
        <span class="block"> {{ total }} </span>
    </th>
</template>

