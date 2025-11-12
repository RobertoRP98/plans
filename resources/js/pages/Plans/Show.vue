<script setup>
import { buttonVariants } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    plan: {
        type: Object,
        required: true,
    },
});

const breadcrumbs = [
    {
        title: 'Planes',
        href: '/planes',
    },

    {
        title: 'Detalle del plan',
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
                        <CardTitle> Detalle del plan</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Nombre</div>
                            <div>{{ plan.name }}</div>
                        </div>

                          <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Descripción</div>
                            <div>{{ plan.description }}</div>
                        </div>

                          <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Descripción</div>
                            <div>{{ plan.duration }}</div>
                        </div>

                          <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Precio</div>
                            <div>{{ plan.price }}</div>
                        </div>

                          <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Prioridad</div>
                            <div>{{ plan.priority }}</div>
                        </div>

                          <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Activo</div>
                               <p>
                            {{ plan.active ? 'Sí' : 'No' }}
                        </p>
                        </div>



                        <div
                            class="flex items-center justify-between space-x-4"
                        >
                            <Link href="/planes" :class="buttonVariants({variant: 'ghost'})">
                                Ver Categorias
                            </Link>

                            <div>
                            <Link :href="`/planes/${plan.id}/edit`" :class="buttonVariants({variant:'default'})">Editar</Link> 
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
