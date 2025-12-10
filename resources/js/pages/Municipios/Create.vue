<script setup>
import InputError from '@/components/InputError.vue';
import { Button, buttonVariants } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Switch } from '@/components/ui/switch';
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

const form = useForm({
    name: '',
    state_id: '',
    active: true,
});

defineProps({
    states: {
        type: Array,
        required: true,
    },
});

const handleSubmit = () => {
    form.post('/municipios', {
        preserveScroll: true,
        onSuccess: () => toast.success('Municipio agregado desde front correctamente'),
    });
};

const breadcrumbs = [
    {
        title: 'Municipios',
        href: '/municipios',
    },

    {
        title: 'Crear Municipio',
        href: '/#',
    },
];

</script>

<template>
    <Head title="Crear Municipio" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">
                    <CardHeader>
                        <CardTitle> Crear Municipio </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <form class="space-y-6" @submit.prevent="handleSubmit">
                            <div class="grid w-full gap-2">
                                <Label for="name">Nombre</Label>
                                <Input id="name" v-model="form.name"></Input>
                                <InputError
                                    :message="form.errors.name"
                                ></InputError>
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="state_id">Estado</Label>
                                <Select
                                    id="state_id"
                                    :modelValue="form.state_id"
                                    @update:modelValue="
                                        (val) => (form.state_id = val)
                                    "
                                >
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Selecciona un Estado"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem
                                            v-for="state in states"
                                            :key="state.id"
                                            :value="state.id"
                                        >
                                            {{ state.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.state_id" />
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="active">Activo</Label>
                                <Switch id="active" v-model="form.active" />
                                <InputError
                                    :message="form.errors.active"
                                ></InputError>
                            </div>

                            <div class="flex items-center justify-between">
                                <Button
                                    variant="default"
                                    :disabled="form.processing"
                                    >Guardar</Button
                                >
                                <Link
                                    :class="buttonVariants({ variant: 'ghost' })"
                                    href="/municipios"
                                    >Cancelar</Link
                                >
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
