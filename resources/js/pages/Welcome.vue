<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import { logout } from '@/routes';


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
        <div class="mx-auto flex max-w-7xl items-center justify-between p-6">
            <!-- IZQUIERDA: LOGO / NOMBRE -->
            <div class="text-lg font-bold">
                <Link href="/solicitantes" class="flex items-center gap-x-2">
                    DonadorRapido.mx
                </Link>
            </div>

            <!-- CENTRO: MENU PRINCIPAL -->
            <nav class="hidden items-center gap-8 text-sm md:flex">
                <Link href="/" class="transition hover:opacity-70">Inicio</Link>
                <Link href="/nosotros" class="transition hover:opacity-70"
                    >Nosotros</Link
                >
                <Link href="/mision" class="transition hover:opacity-70"
                    >Misión</Link
                >
                <Link href="/vision" class="transition hover:opacity-70"
                    >Visión</Link
                >
            </nav>

            <!-- DERECHA: AUTH / ANUNCIOS -->
            <nav class="flex items-center gap-4 text-sm">
                <Link
                    v-if="$page.props.auth.user"
                    href="/mis-anuncios"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 hover:border-[#1915014a]"
                >
                    Mis Anuncios
                </Link>

                <Link
                    v-if="$page.props.auth.user"
                    :href="logout()"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 hover:border-[#1915014a]"
                >
                    Cerrar Sesión
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
    <div
        class="bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-neutral-200"
    >
        <!-- HERO -->
        <section
            class="flex min-h-[70vh] flex-col items-center justify-center bg-gradient-to-b from-white to-gray-100 px-6 text-center dark:from-black dark:to-neutral-900"
        >
            <h1
                class="animate-fadeIn mb-4 text-4xl font-extrabold text-neutral-900 md:text-6xl dark:text-neutral-100"
            >
                Publica tus anuncios<br />
                de forma rápida y segura
            </h1>

            <p
                class="animate-fadeIn mb-8 max-w-2xl text-lg text-neutral-600 delay-150 md:text-xl dark:text-neutral-300"
            >
                Conecta con personas que necesitan ayuda urgente. Rápido,
                confiable y con opciones para destacar tu solicitud.
            </p>

            <div class="animate-fadeIn flex gap-4 delay-300">
                <Link href="/solicitantes">
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
        <section
            class="flex min-h-[70vh] flex-col items-center justify-center bg-gradient-to-b from-white to-gray-100 px-6 text-center dark:from-black dark:to-neutral-900"
        >
            <h2 class="mb-16 text-center text-3xl font-bold md:text-4xl">
                ¿Cómo funciona?
            </h2>

            <div class="mx-auto grid max-w-6xl gap-8 md:grid-cols-3">
                <Card class="rounded-2xl shadow-lg dark:bg-neutral-900">
                    <CardHeader>
                        <CardTitle class="text-xl">1. Regístrate</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-neutral-600 dark:text-neutral-300">
                            Crea una cuenta en segundos para publicar
                            solicitudes de donación.
                        </p>
                    </CardContent>
                </Card>

                <Card class="rounded-2xl shadow-lg dark:bg-neutral-900">
                    <CardHeader>
                        <CardTitle class="text-xl"
                            >2. Crea tu anuncio</CardTitle
                        >
                    </CardHeader>
                    <CardContent>
                        <p class="text-neutral-600 dark:text-neutral-300">
                            Describe tu caso, el tipo de sangre necesario y la
                            ubicación.
                        </p>
                    </CardContent>
                </Card>

                <Card class="rounded-2xl shadow-lg dark:bg-neutral-900">
                    <CardHeader>
                        <CardTitle class="text-xl">3. Hazlo visible</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-neutral-600 dark:text-neutral-300">
                            Activa un plan premium para llegar a más personas
                            rápidamente.
                        </p>
                    </CardContent>
                </Card>
            </div>
        </section>

        <!-- PLANES PREMIUM -->
        <section
            class="flex min-h-[70vh] flex-col items-center justify-center bg-gradient-to-b from-white to-gray-100 px-6 text-center dark:from-black dark:to-neutral-900"
        >
            <h2 class="mb-14 text-center text-3xl font-bold md:text-4xl">
                Planes para destacar tu solicitud
            </h2>

            <div class="mx-auto grid max-w-6xl gap-10 md:grid-cols-3">
                <!-- ORO -->
                <Card
                    class="rounded-2xl border-2 border-yellow-500 shadow-xl dark:bg-neutral-900"
                >
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
                <Card
                    class="rounded-2xl border-2 border-gray-400 shadow-xl dark:bg-neutral-900"
                >
                    <CardHeader>
                        <CardTitle class="text-2xl font-bold"
                            >🥈 Plata</CardTitle
                        >
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
                <Card
                    class="rounded-2xl border-2 border-orange-600 shadow-xl dark:bg-neutral-900"
                >
                    <CardHeader>
                        <CardTitle class="text-2xl font-bold"
                            >🥉 Bronce</CardTitle
                        >
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
    from {
        opacity: 0;
        transform: translateY(12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fadeIn {
    animation: fadeIn 0.8s ease forwards;
}
.delay-150 {
    animation-delay: 0.15s;
}
.delay-300 {
    animation-delay: 0.3s;
}
</style>
