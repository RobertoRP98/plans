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
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { toast } from 'vue-sonner';
import { Textarea } from '@/components/ui/textarea';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    states: Array,
    categories:Array,
    phone:String,
});

const post = props.post;

const form = useForm({
    title: post.title,
    description: post.description,
    category_id: post.category_id,
    state_id: post.state_id,
    municipio_id: post.municipio_id,
});

const municipiosList = ref([]); // lista dinámica

const loadMunicipios = async (stateId) => {
    if (!stateId) {
        municipiosList.value = [];
        form.municipio_id = '';
        return;
    }
    const res = await fetch(`/api/municipios/${stateId}`);

    if (!res.ok) {
        console.error('Error HTTP:', res.status);
        return;
    }

    municipiosList.value = await res.json();

    //limpiar municipio
    form.municipio_id = '';
};

 onMounted(()=>{
        if(form.state_id){
            loadMunicipios(form.state_id).then(()=>{
                form.municipio_id = post.municipio_id;
            });
        }
    })

const handleSubmit = () => {
    form.patch(`/anuncios/${post.slug}`, {
        preserveScroll: true,
        onSuccess: () => toast.success('Anuncio actualizado correctamente'),
    });
};

const breadcrumbs = [
    {
        title: 'Mis anuncios',
        href: '/mis-anuncios',
    },

    {
        title: 'Detalle del Anuncio',
        href: '/#',
    },

   
];
</script>

<template>
    <Head title="Editar Anuncio" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex w-full max-w-2xl flex-col">
                <Card class="mt-3">
                    <CardHeader>
                        <CardTitle> Editar Anuncio </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <form class="space-y-6" @submit.prevent="handleSubmit">
                            <div class="grid w-full gap-2">
                                <Label for="state_id"
                                    >Selecciona un Estado</Label
                                >
                                <Select
                                    v-model="form.state_id"
                                    @update:modelValue="loadMunicipios"
                                >
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Selecciona un Estado"
                                        >
                                        </SelectValue>
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
                                <InputError
                                    :message="form.errors.state_id"
                                ></InputError>
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="municipio_id">Ciudad</Label>

                                <Select
                                    v-model="form.municipio_id"
                                    :disabled="municipiosList.length === 0"
                                >
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Selecciona municipio"
                                        ></SelectValue>
                                    </SelectTrigger>

                                    <SelectContent>
                                        <SelectItem
                                            v-for="municipio in municipiosList"
                                            :key="municipio.id"
                                            :value="municipio.id"
                                        >
                                            {{ municipio.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <InputError
                                    :message="form.errors.municipio_id"
                                />
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="category_id"
                                    >Selecciona una Categoria</Label
                                >
                                <Select v-model="form.category_id">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Presiona para ver las categorias"
                                        >
                                        </SelectValue>
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem
                                            v-for="category in categories"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <InputError
                                    :message="form.errors.category_id"
                                />
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="title">Titulo</Label>
                                <Input
                                    v-model="form.title"
                                    class="input"
                                    placeholder="Solicito donador para el Hospital General"
                                />
                                <InputError
                                    :message="form.errors.title"
                                ></InputError>
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="description">Descripción</Label>
                                <Textarea
                                    v-model="form.description"
                                    placeholder="Informacion de lo que necesitas y en donde, ejemplo: Solicito 10 donadores O+ para el Hospital General, Contactar al numero por llamada o whatsapp"
                                ></Textarea>
                                <InputError
                                    :message="form.errors.description"
                                ></InputError>
                            </div>

                            <div class="grid w-full gap-2">
                                <div class="w-64 font-semibold">
                                    Numero de contacto
                                </div>
                                <div>{{ phone }}</div>
                            </div>

                            <div class="flex items-center justify-between">
                                <Button
                                    variant="default"
                                    :disabled="form.processing"
                                    >Guardar</Button
                                >
                                <Link
                                    :class="
                                        buttonVariants({ variant: 'ghost' })
                                    "
                                    href="/mis-anuncios"
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
