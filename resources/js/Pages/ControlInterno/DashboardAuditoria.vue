<script setup>
import { ref, computed, reactive, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ButtonAdd from '../../Components/ButtonAdd.vue';
import ButtonSeccion from '../../Components/ButtonSeccion.vue';
import Title from '../../Components/Title.vue';
import GraficaSection from './Partials/GraficaSection.vue';
import DocumentosSection from './Partials/DocumentosSection.vue';
import FormCalificacionModal from './Modals/FormCalificacionModal.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
let props = defineProps({
    departamentosAuditoria: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
    calificaciones: {
        type: Object,
        required: true,
    }
});


const showingFormCalificacion = ref(false);
const params = reactive({
    departamento_auditoria_id: props.filters.departamento_auditoria_id
})


const departamento = computed(() => {
    return props.departamentosAuditoria.find((dep) => dep.id == params.departamento_auditoria_id)
})

watch(params, (newParams) => {

    Inertia.visit(route("control-interno.departamentos-aditorias.index"),
        {
            data: newParams,
            replace: true,
            only: ['calificaciones'],
            preserveScroll: true,
            preserveState: true,
        });
})


</script>

<template>
    <AppLayout title="Dashboard">
      <section class="objetivo "  >
            <div class="text-center pt-14 objetivo_area" style="font-family: 'Montserrat';">
                <h1 class="text-4xl font-semibold text-white">Objetivo del área</h1>
                <span  class="w-16 h-1 bg-[#EC2944] mt-4" style="display:block; margin-left: 27.5rem;"></span>
            </div>
                <p class="mt-6 mb-16 text-xl text-white" style="margin-left: 27.5rem; font-family: 'Montserrat'; line-height: 1.8;">
                       Dentro de Control Interno, nos encargamos de la creación  y seguimiento del cumplimiento de los <br>
                       procesos, políticas, manuales, normas y métodos estratégicos de la empresa, todo con la finalidad de <br>
                       llegar al plan estratégico de esta, para poder lograrlo se realizan evaluaciones continuamente a las <br>
                       distintas áreas que la conforman.
                </p>
       </section>
       <section class="documentos">
        <div class="lateral">
            <header class="text-[#1A1A22]" style="font-family: 'Montserrat'; font-size: 0.8rem; margin-bottom:1rem;">DASHBOARD AUDITORIAS</header>
            <ul class="menuVert" v-for="dep in departamentosAuditoria" :key="'dep' + dep.id">
               <span class="absolute w-2 h-8 mt-2" style="float: left;" ></span>
               <li @click="params.departamento_auditoria_id = dep.id">
                 <a  class="font-semibold" :style="hover" @mouseenter="updateHoverState(true)" @mouseleave="updateHoverState(false)" >{{ dep.nombre  }}</a>
               </li>
            </ul> 
        </div>
        <div class="documentos_view" style="margin-right:5rem">
            <GraficaSection :calificaciones="calificaciones" class="sm:px-6" style="align-items:center">
                <ButtonAdd v-if="$page.props.can['calificacion.create'] && departamento != undefined"
                    @click="showingFormCalificacion = true">
                     AGREGAR
                </ButtonAdd>
            </GraficaSection>
            <DocumentosSection :documentos="calificaciones" class="my-3"></DocumentosSection>
        </div>
       </section>

        <!-- Modal Form Calificaciones -->
        <FormCalificacionModal v-if="departamento != undefined" :departamento="departamento"
            :show="showingFormCalificacion" @close="showingFormCalificacion = false" />

    </AppLayout>
</template>
