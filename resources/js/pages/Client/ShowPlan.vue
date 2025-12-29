<script setup>
import { Button, buttonVariants } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    plans: {
        type: Array,
        required: true,
    },
});

const selectPlan = (planId) => {
    router.post(
        route('anuncios.premium.select', props.post.slug),
        {
            plan_id: planId,
        },
        {
            preserveState: true,
        },
    );
};

const breadcrumbs = [
    {
        title: 'Mis anuncios',
        href: '/mis-anuncios',
    },

    {
        title: 'Seleccionar Plan',
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
                        <CardTitle> Seleccionar un plan </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <p><strong>Titulo:</strong> {{ post.title }}</p>
                        <p>
                            <strong>Descripción:</strong> {{ post.description }}
                        </p>

                        <div class="space-y-2">
                            <div
                                v-for="plan in plans"
                                :key="plan.id"
                                class="flex items-center justify-between border p-4"
                            >
                                <div>
                                    <h3 class="text-lg font-medium">
                                        {{ plan.name }}
                                    </h3>
                                    <p class="text-sm text-muted-foreground">
                                        {{ plan.description }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-end space-y-2">
                                    <span class="text-xl font-semibold">
                                        ${{ plan.price }}
                                    </span>

                                     <Button type="submit"
                                            @click="selectPlan(plan.id)"
                                            >Seleccionar</Button
                                        >
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between space-x-4"
                        >
                            <Link
                                href="/mis-anuncios"
                                :class="
                                    buttonVariants({ variant: 'secondary' })
                                "
                            >
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
