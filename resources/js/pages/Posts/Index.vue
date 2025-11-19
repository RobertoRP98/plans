<script setup>
import { Button, buttonVariants } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {ref} from 'vue';
import Create from '@/pages/Posts/Create.vue';

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
    }
});

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
                ></Create>
            </div>

            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Titulo</TableHead>
                        <TableHead>Inicio</TableHead>
                        <TableHead>Fin</TableHead>
                        <TableHead>Vistas</TableHead>
                        <TableHead>Activo</TableHead>
                        <TableHead>Premium</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead class="w-120px">Opciones</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow v-for="post in posts" :key="post.id">
                        <TableCell>{{ post.id }}</TableCell>
                        <TableCell>{{ post.title }}</TableCell>
                        <TableCell>{{ post.start }}</TableCell>
                        <TableCell>{{ post.end }}</TableCell>
                        <TableCell>{{ post.views }}</TableCell>
                        <TableCell>{{ post.active ? 'Si' : 'No' }}</TableCell>
                        <TableCell>{{
                            post.is_premium ? 'Si' : 'No'
                        }}</TableCell>
                        <TableCell>{{ post.status }}</TableCell>
                        <TableCell class="space-x-2">
                            <Link
                                :href="`/anuncios/${post.id}`"
                                :class="
                                    buttonVariants({ variant: 'secondary' })
                                "
                                >Show</Link
                            >

                            <Link
                                :href="`/anuncios/${post.id}/edit`"
                                :class="buttonVariants({ variant: 'default' })"
                                >Edit</Link
                            >

                            <!-- <Button
                                variant="destructive"
                                @click="deleteState(municipio.id)"
                                class="ml-2"
                                >Delete</Button
                            > -->
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
