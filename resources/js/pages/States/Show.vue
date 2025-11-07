<script setup>
import { Button, buttonVariants } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {deleteState} from '@/composables/useState';

defineProps({
    state: {
        type: Object,
        required: true,
    },
});

const breadcrumbs = [
    {
        title: 'Estados',
        href: '/estados',
    },

    {
        title: 'Detalle Estado',
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
                        <CardTitle> Detalle del Estado </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Nombre</div>
                            <div>{{ state.name }}</div>
                        </div>

                        <div
                            class="flex items-center justify-between space-x-4"
                        >
                            <Link href="/estados" :class="buttonVariants({variant: 'ghost'})">
                                Ver Estados
                            </Link>

                            <div>
                            <Link :href="`/estados/${state.id}/edit`" :class="buttonVariants({variant:'default'})">Editar</Link> 
                            <Button @click="deleteState(state.id)" class="ml-2" variant="destructive">Delete</Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
