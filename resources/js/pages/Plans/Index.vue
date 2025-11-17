<script setup>
import { buttonVariants } from '@/components/ui/button';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { dashboard } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { DataTable } from 'datatables.net-vue3';

const columns = [
    { data: 'name', title: 'Nombre' },
    { data: 'description', title: 'Descripción' },
    { data: 'duration', title: 'Duración' },
    { data: 'price', title: 'Precio' },
    { data: 'priority', title: 'prioridad' },
    { data: 'active_text', title: 'Activo' },
    {
        data: null,
        title: 'Opciones',
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
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
                    :columns="columns"
                    class="display w-full"
                    :options="{
                        responsive: true,
                        serverSide: true,
                        processing: true,
                        ajax: 'api/planes/datos',
                    }"
                >
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Duración</th>
                            <th>Precio</th>
                            <th>Prioridad</th>
                            <th>Activo</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>
