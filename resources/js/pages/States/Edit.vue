<script setup>
import { Button, buttonVariants } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
 
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import {toast} from 'vue-sonner';



const props = defineProps({
    state:{
        type: Object,
        required:true
    }
})

const state = props.state;


const form = useForm({
    name: state.name
})

const handleSubmit =()=> {
    form.patch(`/estados/${state.id}`),{
        preserveScroll:true,
        onSuccess:()=> toast.success('Estado agregado correctamente')
        
    }
}



const breadcrumbs = [
    {
        title: 'Estados',
        href: '/estados',
    },

    {
        title: 'Editar Estado',
        href: '/#',
    },
];
</script>

<template>
    <Head title="Editar Estado" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
          
        <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">
                    <CardHeader>
                        <CardTitle> Agregar Estado </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                       <form class="space-y-6" @submit.prevent="handleSubmit">
                        <div class="grid w-full gap-2">
                            <Label form="name">Nombre</Label>
                            <Input id="name" v-model="form.name"></Input>
                            <InputError :message="form.errors.name"></InputError>
                        </div>

                        <div class="flex justify-between items-center">
                            <Button variant="default" :disabled="form.processing">Editar</Button>
                            <Link :class="buttonVariants({variant:'ghost'})" href="/estados">Cancelar</Link>
                        </div>
                       </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
