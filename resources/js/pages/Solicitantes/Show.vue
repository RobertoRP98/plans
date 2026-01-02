<script setup>
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';


const props = defineProps({
    post: Object,
    backUrl: String,
});

const breadcrumbs = computed(() => [
    {
        title: 'Anuncios',
        href: props.backUrl,
    },
    {
        title: props.post.data.title,
        href: null,
    },
]);
</script>

<template>
    <Head :title="post.data.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto max-w-6xl px-4 py-6 space-y-8">

            <!-- TÍTULO -->
            <div class="space-y-2">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    {{ post.data.title }}
                </h1>

                <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600 dark:text-white">
                    <span>
                        📍 {{ post.data.municipio.name }},
                        {{ post.data.state.name }}
                    </span>

                    <span class="rounded-md bg-blue-100 px-3 py-1 text-blue-700 font-medium">
                        {{ post.data.category.name }}
                    </span>
                </div>
            </div>

            <!-- DESCRIPCIÓN -->
            <div class="border-t">
                <p class="whitespace-pre-line text-lg leading-relaxed text-slate-800 dark:text-white">
                    {{ post.data.description }}
                </p>
            </div>

            <!-- CONTACTO -->
            <div class="border-t space-y-2 text-center">

                <p class="text-xl font-semibold">Contacto</p>

                <!-- TELÉFONO -->
                <a
                    :href="`tel:${post.data.contact.phone}`"
                    class="block text-2xl font-bold text-blue-600"
                >
                    📞 {{ post.data.contact.phone }}
                </a>

                <!-- BOTONES -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">

                    <!-- WHATSAPP -->
                    <a
                        :href="`https://api.whatsapp.com/send?phone=${post.data.contact.phone}&text=${encodeURIComponent(
                            'Hola, vi tu anuncio ' + post.data.title + ' y quisiera ayudarte'
                        )}`"
                        target="_blank"
                        class="flex items-center justify-center gap-3 rounded-xl bg-green-600 px-6 py-4 text-lg font-semibold text-white hover:bg-green-700 transition"
                    >
                        Enviar WhatsApp
                    </a>
                </div>


                <div class="flex justify-center">

                    <!-- COPIAR -->
                    <Button
                        variant="outline"
                        class="h-14 text-lg"
                        @click="navigator.clipboard.writeText(post.data.contact.phone)"
                    >
                        Copiar número
                    </Button>
                </div>
            </div>


            <!-- FOOTER -->
            <div class="flex items-center justify-between border-t text-sm text-slate-500">
                <span class="dark:text-white">👁 {{ post.data.views }} vistas</span>


                <Link :href="backUrl">
                <Button
                    variant="ghost"
                    class="px-3 py-1 text-sm dark:text-white"
                >
                    ← Regresar
                </Button>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
