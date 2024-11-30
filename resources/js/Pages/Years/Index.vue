<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head,Link,useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    years: {type:Object}
});
const form = useForm({
    id:''
});
const deleteYear = (id,name) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title: 'Estas seguro de eliminar ' + name+'?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Sí, eliminar',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((result) => {
        if(result.isConfirmed) {
            form.delete(route('years.destroy', id));
        }
    })
}
</script>

<template>
    <Head title="Years" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Años</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                <Link :href="route('years.create')"
                :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                <i class="fa-solid fa-plus-circle"></i> Agregar
                </Link>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">N#</th>
                            <th class="px-4 py-4">Año</th>
                            <th class="px-4 py-4">Editar</th>
                            <th class="px-4 py-4">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ye, i in years" :key="ye.id">
                        <td class="border border-gray-400 px-4 py-4">{{ (i+1) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ ye.name }}</td>
                        <td class="border border-gray-400 px-4 py-4">
                            <Link :href="route('years.edit',ye.id)"
                            :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                            <i class="fa-solid fa-edit"></i> 
                            </Link>
                        </td>
                        <td class="border border-gray-400 px-4 py-4">
                            <DangerButton @click="$event => deleteYear(ye.id,ye.name)">
                                <i class="fa-solid fa-trash"></i>
                            </DangerButton>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>