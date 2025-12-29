<script setup>
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button, buttonVariants } from '@/components/ui/button';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    post: {
        type: Object,
        required: true,
    },
});


const breadcrumbs = [
    {
        title: 'Mis anuncios',
        href: '/mis-anuncios',
    },

    {
        title: 'Detalle del Anuncio',
        href: '/#',
    },
];
</script>

<template>
    <Head title="Detalle Anuncio" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">
                    <CardHeader>
                        <CardTitle> Detalle del Anuncio </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <p><strong>Titulo:</strong> {{ post.title }}</p>
                        <p>
                            <strong>Descripción:</strong> {{ post.description }}
                        </p>

                         <p>
                            <strong>Fecha de inicio:</strong> {{ post.start }}
                        </p>

                         <p>
                            <strong>Fecha final:</strong> {{ post.end }}
                        </p>

                         <p>
                            <strong>Premium:</strong> {{ post.is_premium ? 'Si':'No' }}
                        </p>


                        <p>
                            <strong>Activo:</strong>
                            {{ post.active ? 'Sí' : 'No' }}
                        </p>

                               <p>
                            <strong>Telefono:</strong> {{ post.user.phone }}
                        </p>

                          <p>
                            <strong>Vistas:</strong> {{ post.views }}
                        </p>


                         <div
                            class="flex items-center justify-between space-x-4"
                        >
                            <Link href="/mis-anuncios" :class="buttonVariants({variant: 'ghost'})">
                                Ver Mis Anuncios
                            </Link>

                            <div>
                            <!-- <Button @click="deleteState(state.id)" class="ml-2" variant="destructive">Delete</Button> -->
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
