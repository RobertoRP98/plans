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
import {usePage} from '@inertiajs/vue3'
import { onMounted } from 'vue';
import { toast } from 'vue-sonner';

const page = usePage()

onMounted(() => {
     if (page.props.flash?.success) {
        toast.success(page.props.flash.success)
    }
})

defineProps({
    municipios: {
        type:Array,
        required: true,
    }
})

const breadcrumbs = [
    {
        title: 'Estados',
        href: '/estados',
    },

     {
        title: 'Municipios',
        href: '/#',
    },
];




</script>

<template>
    <Head title="Municipios" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >

               <div class="mt-3">
            <Link href="/municipios/create" :class="buttonVariants({variant:'outline'})">Agregar Municipio </Link>
        </div>
        
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Slug</TableHead>
                        <TableHead>Estado</TableHead>
                        <TableHead>Activo</TableHead>
                        <TableHead class="w-120px">Opciones</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow v-for="municipio in municipios" :key="municipio.id">
                        <TableCell>{{ municipio.name }}</TableCell>
                        <TableCell>{{ municipio.slug }}</TableCell>
                        <TableCell>{{ municipio.state.name }}</TableCell>
                        <TableCell>{{ municipio.active ? 'Si':'No'}}</TableCell>
                        <TableCell class="space-x-2">
                            <Link
                                :href="`/municipios/${municipio.id}`"
                                :class="
                                    buttonVariants({ variant: 'secondary' })
                                "
                                >Show</Link
                            >

                             <Link
                                :href="`/municipios/${municipio.id}/edit`"
                                :class="
                                    buttonVariants({ variant: 'default' })
                                "
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
