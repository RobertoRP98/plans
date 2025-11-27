<script setup>
import { Button, buttonVariants } from '@/components/ui/button';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {ref} from 'vue';
import Create from '@/pages/Posts/Create.vue';
import { DataTable } from 'datatables.net-vue3';

defineProps({
    posts: {
        type: Array,
        required: true,
    },

    categories:{
        type: Array,
        required:true,
    },
    states:{
        type:Array,
        required: true,
    },
    municipios:{
        type:Array,
        required:true
    },
    plans:{
        type:Array,
        required:true
    },
    phone:{
        type:String,
        required:true
    }
});


const columns = [
    {data: 'id', title:'#'},
    {data:'title', title: 'Titulo'},
    {data:'start',title:'Inicio'},
    {data:'end', title:'Fin'},
    {data:'views', title:'Vistas'},
    {data:'active_text',title:'Activo'},
    {data:'premium_text',title:'Premium'},
    {data:'status',title:'Status'},
      {
        data: null,
        title: 'Opciones',
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
            return `
            <div class="flex gap-2 justify-center">
                <a href="/anuncios/${row.slug}" class="px-2 py-1 text-sm bg-blue-500 text-white rounded">Ver</a>
                <a href="/anuncios/${row.slug}/edit" class="px-2 py-1 text-sm bg-amber-500 text-white rounded">Editar</a>
            </div>
        `;
        },
    },
];

const openModal = ref(false);

const breadcrumbs = [
    {
        title: 'Planes',
        href: '/planes',
    },

    {
        title: 'Anuncios',
        href: '/#',
    },
];


</script>

<template>
    <Head title="Anuncios" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="mt-3">
                <Button variant="outline" @click="openModal = true">
                    Agregar Anuncio
                </Button>

                <Create
                :open="openModal"
                @close="openModal = false"
                :categories="categories"
                :states="states"
                :plans="plans"
                :municipios="municipios"
                :phone="phone"
                ></Create>
            </div>

            <div class="div p-6 text-gray-900">
                <DataTable
                id="anuncios"
                :columns="columns"
                class="display w-full stripe"
                :options="{
                    responsive:true,
                    serverSide:true,
                    processing:true,
                    ajax:'api/anuncios/datos',
                    order:[0,'desc'],
                }">

                </DataTable>
            </div>
         
        </div>
    </AppLayout>
</template>
