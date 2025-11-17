<script setup>
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button, buttonVariants } from '@/components/ui/button';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    municipio: {
        type: Object,
        required: true,
    },
});

const breadcrumbs = [
    {
        title: 'Municipios',
        href: '/municipios',
    },

    {
        title: 'Detalle del Municipio',
        href: '/#',
    },
];
</script>

<template>
    <Head title="Detalle Estado" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">
                    <CardHeader>
                        <CardTitle> Detalle del Municipio </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <p><strong>Nombre:</strong> {{ municipio.name }}</p>
                        <p>
                            <strong>Estado:</strong> {{ municipio.state.name }}
                        </p>
                        <p>
                            <strong>Activo:</strong>
                            {{ municipio.active ? 'Sí' : 'No' }}
                        </p>

                         <div
                            class="flex items-center justify-between space-x-4"
                        >
                            <Link href="/municipios" :class="buttonVariants({variant: 'ghost'})">
                                Ver Municipios
                            </Link>

                            <div>
                            <Link :href="`/municipios/${municipio.id}/edit`" :class="buttonVariants({variant:'default'})">Editar</Link> 
                            <!-- <Button @click="deleteState(state.id)" class="ml-2" variant="destructive">Delete</Button> -->
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
