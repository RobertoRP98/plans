<script setup>
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { MapPin } from 'lucide-vue-next';

defineProps({
    states: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Selecciona un Estado" />

    <AppLayout>
        <!-- <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        > -->
        <div class="mx-auto max-w-6xl px-4 py-10">
            <h1 class="mb-6 text-center text-3xl font-bold">
                Selecciona tu Estado
            </h1>
            <p class="mb-10 text-center text-white/90">
                Elige el estado donde deseas ayudar a los solicitantes.
            </p>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                <Card
                    v-for="state in states"
                    :key="state.id"
                    class="cursor-pointer rounded-xl border bg-white transition hover:shadow-lg"
                >
                    <!-- <Link :href="`/solicitantes/${state.slug}`" class="block"> -->
                    <Link
                        :href="
                            route('index.public', {
                                state: state.slug,
                                municipio: null,
                                category: null,
                                search: null,
                            })
                        "
                        class="block"
                    >
                        <CardHeader class="flex items-center gap-2 p-4">
                            <MapPin class="h-5 w-5 text-red-500" />
                            <CardTitle class="text-lg font-medium dark:text-black">
                                {{ state.name }}
                            </CardTitle>
                        </CardHeader>

                        <CardContent class="px-4 pb-4 text-sm text-gray-600">
                            Ver solicitudes en {{ state.name }}
                        </CardContent>
                    </Link>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
