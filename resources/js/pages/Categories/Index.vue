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
import { Head, Link} from '@inertiajs/vue3';

defineProps({
    categories: {
        type: Array,
        required: true,
    }
})

const breadcrumbs = [
    {
        title: 'Anuncios',
        href: "/anuncios",
    },
];

</script>

<template>
    <Head title="Categorias" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >

               <div class="mt-3">
            <Link href="/categorias/create" :class="buttonVariants({variant:'outline'})">Agregar Categoria</Link>
        </div>
        
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Slug</TableHead>
                        <TableHead>Descripción</TableHead>
                        <TableHead>Activo</TableHead>
                        <TableHead class="w-120px">Opciones</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow v-for="category in categories" :key="category.id">
                        <TableCell>{{ category.name }}</TableCell>
                        <TableCell>{{ category.slug }}</TableCell>
                        <TableCell>{{ category.description }}</TableCell>
                        <TableCell>{{ category.active ? 'SI':'NO' }}</TableCell>

                        <TableCell class="space-x-2">
                            <Link
                                :href="`/categorias/${category.id}`"
                                :class="
                                    buttonVariants({ variant: 'secondary' })
                                "
                                >Show</Link
                            >

                             <Link
                                :href="`/categorias/${category.id}/edit`"
                                :class="
                                    buttonVariants({ variant: 'default' })
                                "
                                >Edit</Link
                            >
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
