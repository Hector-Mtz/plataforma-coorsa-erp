<script setup>
import ColumnPlantilla from './ColumnPlantilla.vue';


const props = defineProps({
    ubicaciones: {
        type: Object,
        required: true,
    },
    puesto: {
        type: Object,
        required: true,
    },
});

</script>
<template>
    <tr>
        <td class="px-2 whitespace-nowrap">{{ puesto.name }}</td>
        <ColumnPlantilla v-for="ubicacion in ubicaciones" :key="ubicacion.id" :puestoId="puesto.id"
            :ubicacion="ubicacion" class="px-2 whitespace-nowrap" />
        <td></td>
    </tr>
</template>
