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
    plan:{
        type: Object,
        required:true
    }
})

const plan = props.plan;


const form = useForm({
    name: plan.name,
    description: plan.description,
    duration: plan.duration,
    price: plan.price,
    priority:plan.priority,
    active:plan.active,
})

const handleSubmit =()=> {
    form.patch(`/planes/${plan.id}`),{
        preserveScroll:true,
        onSuccess:()=> toast.success('Categoria actualizada correctamente')
        
    }
}



const breadcrumbs = [
    {
        title: 'Planes',
        href: '/planes',
    },

    {
        title: 'Editar Plan',
        href: '/#',
    },
];
</script>

<template>
    <Head title="Editar Plan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
          
        <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">
                    <CardHeader>
                        <CardTitle> Editar Plan </CardTitle>
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
                                <Label for="duration">Dias de Duración</Label>
                                <Input id="duration" v-model="form.duration"></Input>
                                <InputError
                                    :message="form.errors.duration"
                                ></InputError>
                            </div>
                              <div class="grid w-full gap-2">
                                <Label for="price">Precio</Label>
                                <Input id="price" v-model="form.price"></Input>
                                <InputError
                                    :message="form.errors.price"
                                ></InputError>
                            </div>

                               <div class="grid w-full gap-2">
                                <Label for="priority">Prioridad</Label>
                                <Input id="priority" v-model="form.priority"></Input>
                                <InputError
                                    :message="form.errors.priority"
                                ></InputError>
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
