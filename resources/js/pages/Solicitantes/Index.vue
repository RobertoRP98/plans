<script setup>
import {Card, CardHeader, CardTitle, CardContent} from '@/components/ui/card';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link,usePage } from '@inertiajs/vue3';
import { MapPin } from 'lucide-vue-next';

const props = usePage().props;
console.log("PROPS:", props);

const { anuncios, state, municipio, categoria, search } = usePage().props;

</script>

<template>
    <Head title="Solicitantes en" />

    <AppLayout>

        <pre>{{ anuncios }}</pre>
<pre>{{ state }}</pre>
<pre>{{ municipio }}</pre>
<pre>{{ categoria }}</pre>
<pre>{{ search }}</pre>
       
    </AppLayout>
</template>
