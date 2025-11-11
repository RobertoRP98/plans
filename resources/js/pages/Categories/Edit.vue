<script setup>
import { Button, buttonVariants } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
 
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import {toast} from 'vue-sonner';
import {Switch} from '@/components/ui/switch';



const props = defineProps({
    category:{
        type: Object,
        required:true
    }
})

const category = props.category;


const form = useForm({
    name: category.name,
    description: category.description,
    active: category.active
})

const handleSubmit =()=> {
    form.patch(`/categorias/${category.id}`),{
        preserveScroll:true,
        onSuccess:()=> toast.success('Categoria actualizada correctamente')
        
    }
}



const breadcrumbs = [
    {
        title: 'Categorias',
        href: '/categorias',
    },

    {
        title: 'Editar Categoria',
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
                        <CardTitle> Editar Categoria </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                       <form class="space-y-6" @submit.prevent="handleSubmit">
                        <div class="grid w-full gap-2">
                            <Label for="name">Nombre</Label>
                            <Input id="name" v-model="form.name"></Input>
                            <InputError :message="form.errors.name"></InputError>
                        </div>

                         <div class="grid w-full gap-2">
                            <Label for="description">Descripción</Label>
                            <Input id="description" v-model="form.description"></Input>
                            <InputError :message="form.errors.description"></InputError>
                        </div>

                         <div class="grid w-full gap-2">
                            <Label for="active">Activo</Label>
                            <Switch id="active" v-model="form.active"></Switch>
                        </div>


                        <div class="flex justify-between items-center">
                            <Button variant="default" :disabled="form.processing">Editar</Button>
                            <Link :class="buttonVariants({variant:'ghost'})" href="/categorias">Cancelar</Link>
                        </div>
                       </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
