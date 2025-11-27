<script setup lang="ts">
import { login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="DonadorRapido.mx" />

    <!-- NAVBAR -->
    <header class="w-full border-b bg-[#fca5a5] text-[#4a1f1f]">
    <div class="max-w-7xl mx-auto flex items-center justify-between p-6">

        <!-- IZQUIERDA: LOGO / NOMBRE -->
        <div class="text-lg font-bold">
            DonadorRapido.mx
        </div>

        <!-- CENTRO: MENU PRINCIPAL -->
        <nav class="hidden md:flex items-center gap-8 text-sm">
            <Link href="/" class="hover:opacity-70 transition">Inicio</Link>
            <Link href="/nosotros" class="hover:opacity-70 transition">Nosotros</Link>
            <Link href="/mision" class="hover:opacity-70 transition">Misión</Link>
            <Link href="/vision" class="hover:opacity-70 transition">Visión</Link>
        </nav>

        <!-- DERECHA: AUTH / ANUNCIOS -->
        <nav class="flex items-center gap-4 text-sm">

            <Link
                v-if="$page.props.auth.user"
                href="/anuncios"
                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 hover:border-[#1915014a]"
            >
                Anuncios
            </Link>

            <template v-else>
                <Link
                    :href="login()"
                    class="inline-block rounded-sm border border-transparent px-5 py-1.5 hover:border-[#19140035]"
                >
                    Iniciar Sesión
                </Link>

                <Link
                    v-if="canRegister"
                    :href="register()"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 hover:border-[#1915014a]"
                >
                    Registrarse
                </Link>
            </template>

        </nav>
    </div>
</header>

    <!-- CONTENIDO COMPLETO DE LA LANDING -->
    <div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-neutral-200">

        <!-- HERO -->
         <section class="min-h-[70vh] flex flex-col justify-center items-center bg-gradient-to-b from-white to-gray-100 dark:from-black dark:to-neutral-900 px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-neutral-900 dark:text-neutral-100 mb-4 animate-fadeIn">
                Publica tus anuncios<br />
                de forma rápida y segura
            </h1>

            <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-300 max-w-2xl mb-8 animate-fadeIn delay-150">
                Conecta con personas que necesitan ayuda urgente.
                Rápido, confiable y con opciones para destacar tu solicitud.
            </p>

            <div class="flex gap-4 animate-fadeIn delay-300">
                <Link href="/anuncios">
                    <Button class="px-6 py-3 text-lg">Ver anuncios</Button>
                </Link>

                <Link href="/register">
                    <Button variant="secondary" class="px-6 py-3 text-lg">
                        Crear cuenta
                    </Button>
                </Link>
            </div>
        </section>

        <!-- CÓMO FUNCIONA -->
         <section class="min-h-[70vh] flex flex-col justify-center items-center bg-gradient-to-b from-white to-gray-100 dark:from-black dark:to-neutral-900 px-6 text-center">

            <h2 class="text-3xl md:text-4xl font-bold text-center mb-16">
                ¿Cómo funciona?
            </h2>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <Card class="rounded-2xl shadow-lg dark:bg-neutral-900">
                    <CardHeader>
                        <CardTitle class="text-xl">1. Regístrate</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-neutral-600 dark:text-neutral-300">
                            Crea una cuenta en segundos para publicar solicitudes de donación.
                        </p>
                    </CardContent>
                </Card>

                <Card class="rounded-2xl shadow-lg dark:bg-neutral-900">
                    <CardHeader>
                        <CardTitle class="text-xl">2. Crea tu anuncio</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-neutral-600 dark:text-neutral-300">
                            Describe tu caso, el tipo de sangre necesario y la ubicación.
                        </p>
                    </CardContent>
                </Card>

                <Card class="rounded-2xl shadow-lg dark:bg-neutral-900">
                    <CardHeader>
                        <CardTitle class="text-xl">3. Hazlo visible</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-neutral-600 dark:text-neutral-300">
                            Activa un plan premium para llegar a más personas rápidamente.
                        </p>
                    </CardContent>
                </Card>
            </div>
        </section>

        <!-- PLANES PREMIUM -->
         <section class="min-h-[70vh] flex flex-col justify-center items-center bg-gradient-to-b from-white to-gray-100 dark:from-black dark:to-neutral-900 px-6 text-center">

            <h2 class="text-3xl md:text-4xl font-bold text-center mb-14">
                Planes para destacar tu solicitud
            </h2>

            <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">

                <!-- ORO -->
                <Card class="border-yellow-500 border-2 rounded-2xl shadow-xl dark:bg-neutral-900">
                    <CardHeader>
                        <CardTitle class="text-2xl font-bold">🥇 Oro</CardTitle>
                    </CardHeader>
                    <CardContent class="text-neutral-700 dark:text-neutral-300">
                        <p class="mb-3">✔ 10 días visible</p>
                        <p class="mb-3">✔ Prioridad alta</p>
                        <p class="mb-6">✔ Máxima exposición</p>

                        <Button class="w-full py-3 text-lg">
                            Elegir plan
                        </Button>
                    </CardContent>
                </Card>

                <!-- PLATA -->
                <Card class="border-gray-400 border-2 rounded-2xl shadow-xl dark:bg-neutral-900">
                    <CardHeader>
                        <CardTitle class="text-2xl font-bold">🥈 Plata</CardTitle>
                    </CardHeader>
                    <CardContent class="text-neutral-700 dark:text-neutral-300">
                        <p class="mb-3">✔ 7 días visible</p>
                        <p class="mb-3">✔ Prioridad media</p>
                        <p class="mb-6">✔ Más alcance</p>

                        <Button class="w-full py-3 text-lg">
                            Elegir plan
                        </Button>
                    </CardContent>
                </Card>

                <!-- BRONCE -->
                <Card class="border-orange-600 border-2 rounded-2xl shadow-xl dark:bg-neutral-900">
                    <CardHeader>
                        <CardTitle class="text-2xl font-bold">🥉 Bronce</CardTitle>
                    </CardHeader>
                    <CardContent class="text-neutral-700 dark:text-neutral-300">
                        <p class="mb-3">✔ 5 días visible</p>
                        <p class="mb-3">✔ Prioridad baja</p>
                        <p class="mb-6">✔ Económico</p>

                        <Button class="w-full py-3 text-lg">
                            Elegir plan
                        </Button>
                    </CardContent>
                </Card>

            </div>
        </section>

    </div>
</template>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn .8s ease forwards;
}
.delay-150 { animation-delay: .15s; }
.delay-300 { animation-delay: .3s; }
</style>
