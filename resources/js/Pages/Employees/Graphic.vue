<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Bar, Pie } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  ArcElement
} from 'chart.js';

// Registrar los componentes de Chart.js
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

// Definición de las props
const props = defineProps({
  data: { type: Object }
});

// Variables reactivas
const departments = ref([]);
const employees = ref([]);
const chartData = ref([]);
const chartOptions = ref([]);
const colors = ref([]);

// Función para generar un color aleatorio
const random = () => {
  return Math.floor(Math.random() * 256);
};

// Procesar los datos de las props
props.data.map(row => (
  departments.value.push(row.name),
  employees.value.push(row.count),
  colors.value.push(`rgb(${random()},${random()},${random()})`)
));

// Configuración del gráfico
chartOptions.value = { responsive: true };
chartData.value = {
  labels: departments.value,
  datasets: [
    { label: 'Estudiantes', data: employees.value, backgroundColor: colors.value }
  ]
};
</script>

<template>
  <Head title="Graphic" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gráfica</h2>
    </template>

    <div class="py-12">
      <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <Bar :data="chartData" :options="chartOptions"></Bar>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
