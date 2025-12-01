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
import {deleteState} from '@/composables/useState'

defineProps({
    states: {
        type: Array,
        required: true,
    },
});

const breadcrumbs = [
    {
        title: 'Municipios',
        href: '/municipios',
    },
];




</script>

<template>
    <Head title="Estados" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >

               <div class="mt-3">
            <Link href="/estados/create" :class="buttonVariants({variant:'outline'})">Agregar Estado</Link>
        </div>
        
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Slug</TableHead>

                        <TableHead class="w-120px">Opciones</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow v-for="state in states" :key="state.id">
                        <TableCell>{{ state.name }}</TableCell>
                        <TableCell>{{ state.slug }}</TableCell>
                        <TableCell class="space-x-2">
                            <Link
                                :href="`/estados/${state.id}`"
                                :class="
                                    buttonVariants({ variant: 'secondary' })
                                "
                                >Show</Link
                            >

                             <Link
                                :href="`/estados/${state.id}/edit`"
                                :class="
                                    buttonVariants({ variant: 'default' })
                                "
                                >Edit</Link
                            >

                            <Button
                                variant="destructive"
                                @click="deleteState(state.id)"
                                class="ml-2"
                                >Delete</Button
                            >
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
