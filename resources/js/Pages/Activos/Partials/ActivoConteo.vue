<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref } from "@vue/reactivity";
import axios from 'axios';
import TableActivos from '../Partials/TableActivos.vue';
import ModalAddItem from '../Partials/ModalAddItem.vue';


var props = defineProps(
    {
        tipoActivo:Object
    }
);

const visible = ref(false);
const activos = ref([]);

const open = (id) => 
{
    visible.value = !visible.value ;

    axios.get('/activosxtipo/'+id).then((response)=> 
    {
      //console.log(response);
      activos.value = response.data;
    });
    //console.log(visible.value);
    //console.log(props.tipoActivo.id);
    /*
    Inertia.visit(route("activo.index"),
        {
            data: {
                id:props.tipoActivo.id
            },
            replace: true,
            only: ['activos'],
            preserveScroll: true,
            preserveState: true,
        });}
    */
}

/*Funciones modal*/
const itemModal = ref(false);

const openItemModal = () => 
{
   itemModal.value = true;
}

const closeItemModal = () =>
{
    itemModal.value = false;
}
</script>
<template>
    <div class="col-start-2 col-end-7">
         <div @click="open(tipoActivo.id)" class="flex space-x-8 p-4  bg-white w-full overflow-hidden drop-shadow-xl sm:rounded-lg">
            <div class="w-96 flex space-x-8 p-4">
                <img alt="pc" :src="tipoActivo.imagen">
                <h1 class="text-xl" style="font-family: 'Montserrat';"> {{ tipoActivo.nombre }}</h1>
            </div>
            <div class="w-64">
            </div>
            <div class="w-64">
                <table class="" style="font-family: 'Montserrat';">
                    <thead>
                      <tr class="">
                        <th class="uppercase font-extralight">Uso</th>
                        <th class="uppercase font-extralight">Libres</th>
                        <th class="uppercase font-extralight">Baja</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="pr-4 text-center text-4xl border-r-8 border-[#EC2944]">80</td>
                            <td class="pr-4 pl-4 text-center text-4xl border-r-8 border-[#EC2944]">20</td>
                            <td class="pl-4 text-center text-4xl">10</td>
                            <td class="pl-4">
                                <button @click="openItemModal" class="bg-[#EC2944] text-white rounded-full w-10">+</button>
                                <ModalAddItem :show="itemModal" :campos="tipoActivo.tipo_activo_campos" @close="closeItemModal"></ModalAddItem>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
         </div>
         <div class="w-full mt-2 mb-8"  :class="{ 'visible': visible, 'invisible': !visible }">
           <TableActivos :activos="activos" :campos="tipoActivo.tipo_activo_campos"></TableActivos>
        </div>
    </div>
</template>