<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/Selectinput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';

const nameInput = ref(null);
const modal = ref(false);
const viewModal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');
const selectedEmployee = ref({});

const props = defineProps({
    employees: { type: Object },
    departments: { type: Object },
    places: { type: Object }
});

const form = useForm({
    name: '', email: '', phone: '', carnet: '', total_hours: '', student_hours: '', department_id: '', place_id: ''
});

const formPage = useForm({});
const onPageClick = (event) => {
    formPage.get(route('employees.index', { page: event }));
}

const openModal = (op, name, email, phone, carnet, total_hours, student_hours, department, place, employee) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());
    operation.value = op;
    id.value = employee;
    if (op == 1) {
        title.value = 'Crear Estudiante';
        form.reset(); // Limpiar el formulario al abrir para crear
    } else {
        title.value = 'Editar Estudiante';
        form.name = name;
        form.email = email;
        form.phone = phone;
        form.carnet = carnet;
        form.total_hours = total_hours;
        form.student_hours = student_hours;
        form.department_id = department;
        form.place_id = place;
    }
}

const openViewModal = (emp) => {
    selectedEmployee.value = emp;
    viewModal.value = true;
}

const closeModal = () => {
    modal.value = false;
}

const closeViewModal = () => {
    viewModal.value = false;
}

const save = () => {
    if (operation.value == 1) {
        form.post(route('employees.store'), {
            onSuccess: () => { ok('Estudiante Created') }
        });
    } else {
        form.put(route('employees.update', id.value), {
            onSuccess: () => { ok('Estudiante Update') }
        });
    }
}

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: 'success' });
}

const deleteEmployee = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: 'Are you sure delete ' + name + '?',
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Yes, delete',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('employees.destroy', id), {
                onSuccess: () => { ok('Estudiante Deleted') }
            });
        }
    })
}
</script>

<template>
    <Head title="Students" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Estudiantes</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Agregar
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">N#</th>
                            <th class="px-2 py-2">Nombre</th>
                            <th class="px-2 py-2">Correo</th>
                            <th class="px-2 py-2">Teléfono</th>
                            <th class="px-2 py-2">Carnet</th>
                            <th class="px-2 py-2">Carrera</th>
                            <th class="px-2 py-2">Lugar</th>
                            <th class="px-2 py-2">Hours</th>
                            <th class="px-2 py-2">Worked</th>
                            <th class="px-2 py-2">Detail</th>
                            <th class="px-2 py-2">Editar</th>
                            <th class="px-2 py-2">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(emp, i) in employees.data" :key="emp.id">
                            <td class="border border-gray-400 px-2 py-2">{{ (i + 1) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.name }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.email }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.phone }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.carnet }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.department }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.place }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.total_hours }} hrs.</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.student_hours }} hrs.</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <button @click="openViewModal(emp)">
                                    <i class="fa-regular fa-eye fa-2xl" style="color: #24a0ff;"></i>
                                </button>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton 
                                    @click="$event => openModal(2, emp.name, emp.email, emp.phone, emp.carnet, emp.total_hours, emp.student_hours, emp.department_id, emp.place_id, emp.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton @click="$event => deleteEmployee(emp.id, emp.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <vueTailwindPaginationUmd
                    :current="employees.currentPage" :total="employees.total"
                    :per-page="employees.perPage"
                    @page-changed="$event => onPageClick($event)"
                ></vueTailwindPaginationUmd>
            </div>
        </div>

        <!-- Modal para agregar/editar empleado -->
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font-medium text-gray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="name" value="Nombre:" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    ref="nameInput"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div class="p-3">
                <InputLabel for="email" value="Correo:" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="p-3">
                <InputLabel for="phone" value="Teléfono:" />
                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>
            <div class="p-3">
                <InputLabel for="carnet" value="Carnet:" />
                <TextInput
                    id="carnet"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.carnet"
                />
                <InputError class="mt-2" :message="form.errors.carnet" />
            </div>
            <div class="p-3">
                <InputLabel for="total_hours" value="Total Horas:" />
                <TextInput
                    id="total_hours"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.total_hours"
                />
                <InputError class="mt-2" :message="form.errors.total_hours" />
            </div>
            <div class="p-3">
                <InputLabel for="student_hours" value="Horas Trabajadas:" />
                <TextInput
                    id="student_hours"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.student_hours"
                />
                <InputError class="mt-2" :message="form.errors.student_hours" />
            </div>
            <div class="p-3">
                <InputLabel for="department_id" value="Carrera:" />
                <SelectInput 
                    id="department_id"
                    class="mt-1 block w-full"
                    v-model="form.department_id"
                    :options="departments"
                />
                <InputError class="mt-2" :message="form.errors.department_id" />
            </div>
            <div class="p-3">
                <InputLabel for="place_id" value="Lugar:" />
                <SelectInput 
                    id="place_id"
                    class="mt-1 block w-full"
                    v-model="form.place_id"
                    :options="places"
                />
                <InputError class="mt-2" :message="form.errors.place_id" />
            </div>
            <div class="flex justify-end p-3">
                <PrimaryButton @click="save">{{ operation === 1 ? 'Crear' : 'Actualizar' }}</PrimaryButton>
                <SecondaryButton @click="closeModal">Cerrar</SecondaryButton>
            </div>
        </Modal>

        <!-- Modal para ver detalles del estudiante -->
        <Modal :show="viewModal" @close="closeViewModal">
            <h2 class="p-3 text-lg font-medium text-gray-900">Detalles del Estudiante</h2>
            <div class="p-3">
                <InputLabel for="name" value="Nombre:" />
                <div class="mt-1 block w-3/4">{{ selectedEmployee.name }}</div>
            </div>
            <div class="p-3">
                <InputLabel for="email" value="Correo:" />
                <div class="mt-1 block w-3/4">{{ selectedEmployee.email }}</div>
            </div>
            <div class="p-3">
                <InputLabel for="phone" value="Teléfono:" />
                <div class="mt-1 block w-3/4">{{ selectedEmployee.phone }}</div>
            </div>
            <div class="p-3">
                <InputLabel for="carnet" value="Carnet:" />
                <div class="mt-1 block w-3/4">{{ selectedEmployee.carnet }}</div>
            </div>
            <div class="p-3">
                <InputLabel for="department" value="Carrera:" />
                <div class="mt-1 block w-3/4">{{ selectedEmployee.department }}</div>
            </div>
            <div class="p-3">
                <InputLabel for="place" value="Lugar:" />
                <div class="mt-1 block w-3/4">{{ selectedEmployee.place }}</div>
            </div>
            <div class="p-3">
                <InputLabel for="total_hours" value="Total Horas:" />
                <div class="mt-1 block w-3/4">{{ selectedEmployee.total_hours }} hrs.</div>
            </div>
            <div class="p-3">
                <InputLabel for="student_hours" value="Horas Trabajadas:" />
                <div class="mt-1 block w-3/4">{{ selectedEmployee.student_hours }} hrs.</div>
            </div>
            <div class="flex justify-end p-3">
                <SecondaryButton @click="closeViewModal">Cerrar</SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
