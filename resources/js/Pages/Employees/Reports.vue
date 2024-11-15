<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/Selectinput.vue';

import DataTable from 'datatables.net-vue3';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';  
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5'; 
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-responsive-dt';
import 'datatables.net-responsive-dt/css/responsive.dataTables.min.css';
import JsZip from 'jszip';
import pdfmake from "pdfmake/build/pdfmake";
import * as pdfFonts from "pdfmake/build/vfs_fonts";

pdfmake.vfs = pdfFonts.pdfMake ? pdfFonts.pdfMake.vfs : pdfmake.vfs;
window.JSZip = JsZip;
DataTable.use(ButtonsHtml5);


const props = defineProps({
    employees: { type: Object },departments: { type: Object }, places: { type: Object },
});

const columns1 = ref([]);
const columns2 = ref([]);
const columns3 = ref([]);
const columns4 = ref([]);
const buttons1 = ref([]);
const buttons2 = ref([]);
const buttons3 = ref([]);
const buttons4 = ref([]);
const report = ref('1');
const types = ref([{'id':'1','name':'Estudiantes'},{'id':'2','name':'Carreras'},{'id':'3','name':'Lugares'},{'id':'4','name':'Estudiantes/Horas'}]);

columns1.value= [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'name'},
    {data:'email'},
    {data:'phone'},
    {data:'carnet'},
    {data:'department'},
    {data:'place'},
    {data:'description'},
    {data:'total_hours'},
    {data:'student_hours'},
]

columns2.value= [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'name'}
]

columns3.value= [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'name'}
]

columns4.value= [{data:null, render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'name'},
    {data:'carnet'},
    {data:'department'},
    {data:'place'},
    {data:'description'},
    {data:'total_hours'},
    {data:'student_hours'},
]
buttons1.value= [
    {
        title:'Estudiantes',extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"</i> Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Estudiantes',extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"</i> PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Estudiantes',extend:'print',
        text:'<i class="fa-solid fa-print"</i> Imprimir',
        className:'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Estudiantes',extend:'copy',
        text:'<i class="fa-solid fa-copy"</i> Copiar',
        className:'inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-800 rounded-md font-semibold text-xs  uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
]

buttons2.value= [
    {
        title:'Carreras',extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"</i> Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Carreras',extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"</i> PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Carreras',extend:'print',
        text:'<i class="fa-solid fa-print"</i> Imprimir',
        className:'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Carreras',extend:'copy', 
        text:'<i class="fa-solid fa-copy"</i> Copiar',
        className:'inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-800 rounded-md font-semibold text-xs  uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
]

buttons3.value= [
    {
        title:'Lugares',extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"</i> Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Lugares',extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"</i> PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Lugares',extend:'print',
        text:'<i class="fa-solid fa-print"</i> Imprimir',
        className:'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Lugares',extend:'copy', 
        text:'<i class="fa-solid fa-copy"</i> Copiar',
        className:'inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-800 rounded-md font-semibold text-xs  uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
]

buttons4.value= [
    {
        title:'Lugares',extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"</i> Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Lugares',extend:'pdfHtml5',
        text:'<i class="fa-solid fa-file-pdf"</i> PDF',
        className:'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Lugares',extend:'print',
        text:'<i class="fa-solid fa-print"</i> Imprimir',
        className:'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
    {
        title:'Lugares',extend:'copy', 
        text:'<i class="fa-solid fa-copy"</i> Copiar',
        className:'inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-800 rounded-md font-semibold text-xs  uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'    
    },
]

</script>

<template>
  <Head title="Reports" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <InputLabel for="rep" Value="Report:"></InputLabel>
            <SelectInput id="rep" class="mt-1 block w-3/4"
            v-model="report" :options="types"></SelectInput>
        </div>
        <div v-if="report == '1'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <DataTable :data="employees" :columns="columns1"
            class="w-full border border-gray-400"
            :options="{responsive:true, autoWidth:false,dom:'Bfrtip',buttons:buttons1}">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-2 py-2">N#</th>
                    <th class="px-2 py-2">Nombre</th>
                    <th class="px-2 py-2">Correo</th>
                    <th class="px-2 py-2">Teléfono</th>
                    <th class="px-2 py-2">Carnet</th>
                    <th class="px-2 py-2">Carrera</th>
                    <th class="px-2 py-2">Lugar</th>
                    <th class="px-2 py-2">Descripción</th>
                    <th class="px-2 py-2">Hours</th>
                    <th class="px-2 py-2">Worked</th>
                </tr>
            </thead>
            </DataTable>
        </div>
        <div v-else-if="report == '2'"  class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <DataTable :data="departments" :columns="columns2"
            class="w-full border border-gray-400"
            :options="{responsive:true, autoWidth:false,dom:'Bfrtip',buttons:buttons2}">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-2 py-2">N#</th>
                    <th class="px-2 py-2">Nombre</th>
                </tr>
            </thead>
            </DataTable>
        </div>
        <div v-else-if="report == '3'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <DataTable :data="places" :columns="columns3"
            class="w-full border border-gray-400"
            :options="{responsive:true, autoWidth:false,dom:'Bfrtip',buttons:buttons3}">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-2 py-2">N#</th>
                    <th class="px-2 py-2">Nombre</th>
                </tr>
            </thead>
            </DataTable>
        </div>

        <div v-if="report == '4'" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <DataTable :data="employees" :columns="columns4"
            class="w-full border border-gray-400"
            :options="{responsive:true, autoWidth:false,dom:'Bfrtip',buttons:buttons1}">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-2 py-2">N#</th>
                    <th class="px-2 py-2">Nombre</th>
                    <th class="px-2 py-2">Carnet</th>
                    <th class="px-2 py-2">Carrera</th>
                    <th class="px-2 py-2">Lugar</th>
                    <th class="px-2 py-2">Descripción</th>
                    <th class="px-2 py-2">Hours</th>
                    <th class="px-2 py-2">Worked</th>
                </tr>
            </thead>
            </DataTable>
        </div>

      </div>
    </div>
  </AuthenticatedLayout>
</template>
