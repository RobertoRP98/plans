<script setup>
import { buttonVariants } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {Switch} from '@/components/ui/switch';

defineProps({
    category: {
        type: Object,
        required: true,
    },
});

const breadcrumbs = [
    {
        title: 'Categorias',
        href: '/categorias',
    },

    {
        title: 'Detalle de la categoria',
        href: '/#',
    },
];
</script>

<template>
    <Head title="Detalle Categoria" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
          
        <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">
                    <CardHeader>
                        <CardTitle> Detalle de la categoria </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Nombre</div>
                            <div>{{ category.name }}</div>
                        </div>

                          <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Descripción</div>
                            <div>{{ category.description }}</div>
                        </div>

                          <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Activo</div>
                               <p>
                            {{ category.active ? 'Sí' : 'No' }}
                        </p>
                        </div>



                        <div
                            class="flex items-center justify-between space-x-4"
                        >
                            <Link href="/categorias" :class="buttonVariants({variant: 'ghost'})">
                                Ver Categorias
                            </Link>

                            <div>
                            <Link :href="`/categorias/${category.id}/edit`" :class="buttonVariants({variant:'default'})">Editar</Link> 
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
