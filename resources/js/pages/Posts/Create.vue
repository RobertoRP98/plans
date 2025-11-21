<script setup>
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
} from '@/components/ui/select';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import { Textarea } from '@/components/ui/textarea';
import { useForm } from '@inertiajs/vue3';
import { ref,computed } from 'vue';

const props = defineProps({
    open: Boolean,
    categories: Array,
    states: Array,
    plans: Array,
    phone: String,
});

const phone = props.phone;

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

const emit = defineEmits(['close']);

const form = useForm({
    title: '',
    description: '',
    category_id: '',
    state_id: '',
    municipio_id: '',
    plan_id: '',
    phone: phone.phone,
});

const submitForm = () => {
    form.post('/anuncios', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit('close');
        },
    });
};

// --- PLAN SELECCIONADO ---
const selectedPlan = computed(() =>
    props.plans.find((p) => p.id == form.plan_id),
);
</script>

<template>
    <Dialog :open="open" @update:open="(val) => val || emit('close')">
        <DialogContent class="max-h-[80vh] overflow-y-auto">
            <DialogHeader>
                <DialogTitle>Crear Anuncio</DialogTitle>
                <DialogDescription>
                    Completa los siguientes campos para publicar tu anuncio.
                </DialogDescription>
            </DialogHeader>

            <!-- campos del formulario -->
            <div class="grid gap-4">
                <div class="grid w-full gap-2">
                    <Label for="state_id">Selecciona un Estado</Label>
                    <Select
                        v-model="form.state_id"
                        @update:modelValue="loadMunicipios"
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Selecciona un Estado">
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
                    <InputError :message="form.errors.state_id"></InputError>
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
                    <InputError :message="form.errors.municipio_id" />
                </div>

                <div class="grid w-full gap-2">
                    <Label for="category_id">Selecciona una Categoria</Label>
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
                    <InputError :message="form.errors.category_id" />
                </div>

                <div class="grid w-full gap-2">
                    <Label for="title">Titulo</Label>
                    <Input
                        v-model="form.title"
                        class="input"
                        placeholder="Solicito donador para el Hospital General"
                    />
                    <InputError :message="form.errors.title"></InputError>
                </div>

                <div class="grid w-full gap-2">
                    <Label for="description">Descripción</Label>
                    <Textarea
                        v-model="form.description"
                        placeholder="Informacion de lo que necesitas y en donde, ejemplo: Solicito 10 donadores O+ para el Hospital General, Contactar al numero por llamada o whatsapp"
                    ></Textarea>
                    <InputError :message="form.errors.description"></InputError>
                </div>

                <div class="grid w-full gap-2">
                    <div class="w-64 font-semibold">Numero de contacto</div>
                    <div>{{ phone }}</div>
                </div>

                <!-- PLANES -->
                <div class="grid w-full gap-2">
                    <Label for="plan_id">Plan</Label>
                    <Select v-model="form.plan_id">
                        <SelectTrigger>
                            <SelectValue placeholder="Selecciona un plan" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="p in plans"
                                :key="p.id"
                                :value="p.id"
                            >
                                {{ p.name }} – {{ p.description }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="form.errors.plan_id" />
                </div>

                <!-- PREVIEW DEL PLAN ELEGIDO -->
                <div
                    v-if="selectedPlan"
                    class="rounded-lg border bg-gray-50 p-4 shadow-sm"
                >
                    <h3 class="text-lg font-semibold">
                        {{ selectedPlan.name }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        {{ selectedPlan.description }}
                    </p>

                    <div class="mt-2 font-bold text-primary">
                        Precio:
                        {{
                            selectedPlan.price > 0
                                ? '$' + selectedPlan.price
                                : 'GRATIS'
                        }}
                    </div>

                    <p class="mt-1 text-xs text-gray-500">
                        Duración: {{ selectedPlan.duration }} días
                    </p>
                </div>
            </div>

              <DialogFooter>
                <Button variant="outline" @click="emit('close')">Cancelar</Button>
                <Button @click="submitForm" :disabled="form.processing">
                    <span v-if="form.processing">Guardando…</span>
                    <span v-else>Guardar</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
