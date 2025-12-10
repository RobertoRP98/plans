<script setup>
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import { route } from 'ziggy-js';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
} from '@/components/ui/select';
import SelectValue from '@/components/ui/select/SelectValue.vue';

const props = defineProps({
    stateSearch: Array,
    categoriesSearch: Array,
    state: String,
    municipio: String,
    category: String,
    searchquery: String,
    anuncios: Object,
});

// sentinel para placeholder de municipio (no debe coincidir con ningún slug real)
const MUNICIPIO_NULL = '__all__';

// Función que nunca deja valores vacíos para estado/categoría
const normalize = (val) => {
    if (!val || val === '') return '_';
    return val;
};

// Valores iniciales seguros
const selectedState = ref(props.state || '');
/** municipio usa placeholder diferente: si no viene por prop usamos el sentinel */
const selectedMunicipio = ref(props.municipio || null);
const selectedCategory = ref(normalize(props.category));
const searchquery = ref(props.searchquery || '');

// Municipios dinámicos
const municipios = ref([]);

// Cargar municipios cuando cambia estado
watch(selectedState, async (value) => {
    value = normalize(value);

    if (value === '_') {
        municipios.value = [];
        // Si no hay estado seleccionado, dejamos el placeholder de municipio
        selectedMunicipio.value = MUNICIPIO_NULL;
        return;
    }

    const res = await fetch(`/api/municipiosSelect/${value}`);
    municipios.value = await res.json();

    // Si el municipio actual no existe en la lista (o es placeholder), dejar placeholder
    const exists = municipios.value.some(
        (m) => m.slug === selectedMunicipio.value,
    );
    if (!exists) selectedMunicipio.value = MUNICIPIO_NULL;
});

// Botón buscar
//  let urlParams = [selectedState.value];

const buscar = () => {
    let urlParams = [];

    // 1) Estado solo si existe
    if (selectedState.value) {
        urlParams.push(selectedState.value);
    }

    // 2) Categoría (usa '_' para todas)
    if (selectedCategory.value && selectedCategory.value !== '_') {
        urlParams.push(selectedCategory.value);
    }

    // 3) Municipio: null = todos → NO se agrega
    if (selectedMunicipio.value !== '__all__') {
        urlParams.push(selectedMunicipio.value);
    }

     const currentSearchQuery = searchquery.value || '';

     router.get(
        // Primer argumento: URL/Ruta con parámetros de ruta
        route('index.public', urlParams), 
        
        // Segundo argumento: Objeto de datos (query parameters)
        {
            searchquery: currentSearchQuery,
        },
        
        // Tercer argumento: Opciones de Inertia (aquí va onFinish)
        {
            replace: true,
            preserveState: true, // Para mantener el estado de Vue (e.g., scroll)
            onFinish: () => {
                // Limpiamos el valor del input *después* de que Inertia termina la visita
                searchquery.value = '';
            },
        }
    );
};

// Cargar municipios si ya había estado seleccionado (on mount)
onMounted(async () => {
    if (selectedState.value && selectedState.value !== '_') {
        const res = await fetch(`/api/municipiosSelect/${selectedState.value}`);
        const data = await res.json();
        municipios.value = data
            .filter((m) => m.slug && m.slug !== '') // <-- evita valores vacíos
            .map((m) => ({
                ...m,
                slug: String(m.slug), // <-- asegura que siempre sea string
            }));

        const exists = municipios.value.some(
            (m) => m.slug === selectedMunicipio.value,
        );
        if (!exists) selectedMunicipio.value = MUNICIPIO_NULL;
    } else {
        // sin estado seleccionado -> placeholder
        selectedMunicipio.value = MUNICIPIO_NULL;
    }
});
</script>

<template>
    <Head title="Solicitantes" />

    <AppLayout>
        <!-- SELECT ESTADO -->
        <Select v-model="selectedState">
            <SelectTrigger>
                <SelectValue placeholder="Selecciona un Estado" />
            </SelectTrigger>

            <SelectContent>
                <SelectItem
                    v-for="estado in stateSearch"
                    :key="estado.slug"
                    :value="estado.slug"
                >
                    {{ estado.name }}
                </SelectItem>
            </SelectContent>
        </Select>

        <!-- SELECT MUNICIPIO SIN OPCIONES FALSAS -->
        <Select v-model="selectedMunicipio">
            <SelectTrigger>
                <SelectValue placeholder="Selecciona Municipio" />
            </SelectTrigger>
            <SelectContent>
                <SelectItem :value="MUNICIPIO_NULL"
                    >Todos los municipios</SelectItem
                >
                <SelectItem
                    v-for="m in municipios"
                    :key="m.slug || m.name"
                    :value="m.slug"
                >
                    {{ m.name }}
                </SelectItem>
            </SelectContent>
        </Select>

        <!-- SELECT CATEGORÍA -->
        <Select v-model="selectedCategory">
            <SelectTrigger>
                <SelectValue placeholder="Seleccione una categoría" />
            </SelectTrigger>

            <SelectContent>
                <SelectItem value="_">Todas las categorías</SelectItem>

                <SelectItem
                    v-for="c in categoriesSearch"
                    :key="c.slug"
                    :value="c.slug || '_'"
                >
                    {{ c.name }}
                </SelectItem>
            </SelectContent>
        </Select>

        <!-- INPUT BUSCADOR -->
        <label class="mt-4 mb-1 block">Buscar</label>
        <Input
            id="searchquery"
            v-model="searchquery"
            type="text"
            placeholder="Ej. 'se necesita sangre'"
            class="w-full rounded border p-2"
        />

        <!-- BOTÓN -->
        <Button
            @click="buscar"
            class="mt-4 w-full rounded bg-blue-600 px-4 py-2 text-white"
        >
            Buscar
        </Button>

        <!-- DEBUG -->
        <pre>{{ props.anuncios.data }}</pre>
    </AppLayout>
</template>
