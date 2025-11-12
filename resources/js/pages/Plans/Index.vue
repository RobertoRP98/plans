<script setup>
import { buttonVariants } from '@/components/ui/button';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { dashboard } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { DataTable } from 'datatables.net-vue3';

defineProps({
    plans: {
        type: Array,
        required: true,
    },
});

const columns = [
    { data: 'name' },
    { data: 'description' },
    { data: 'duration' },
    { data: 'price' },
    { data: 'priority' },
    {
        data: 'active',
        title: 'Activo',
        render: (data) => {
            return data
                ? '<span class="text-green-600 font-medium">Si</span>'
                : '<span class="text-red-600 font-medium">No</span>';
        },
    },

    {
        data: null,
        title: 'Opciones',
        orderable: false,
        searchable: false,
        render: (data, type, row) => {
            return `
                <div class="flex gap-2 justify-center">
                    <a href="/planes/${row.id}" class="px-2 py-1 text-sm bg-blue-500 text-white rounded">Ver</a>
                    <a href="/planes/${row.id}/edit" class="px-2 py-1 text-sm bg-amber-500 text-white rounded">Editar</a>
                </div>
            `;
        },
    },
];

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Planes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="mt-3">
                <Link
                    href="/planes/create"
                    :class="buttonVariants({ variant: 'outline' })"
                    >Agregar Plan
                </Link>
            </div>

            <div class="div p-6 text-gray-900">
                <DataTable
                    :data="plans"
                    :columns="columns"
                    class="display w-full"
                    :options="{ responsive: true }"
                >
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Duración</th>
                            <th>Precio</th>
                            <th>Prioridad</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>
