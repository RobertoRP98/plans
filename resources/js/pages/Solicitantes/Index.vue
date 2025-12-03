<script setup>
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import { route } from 'ziggy-js';

console.log(window.Ziggy);

const props = defineProps({
    stateSearch: Array,
    categoriesSearch: Array,
    state: String,
    municipio: String,
    category: String,
    searchquery: String,
    anuncios: Object,
});

//VALORES A BUSCAR - SELECCIONANDO
const stateSearch = props.stateSearch;
const categoriesSearch = props.categoriesSearch;

//VALORES SELECCIONADOS PREVIAMENTE
const selectedState = ref(props.state || '');
const selectedMunicipio = ref(props.municipio || '');
const selectedCategory = ref(props.category || '');
const searchquery = ref(props.searchquery || '');

//Municipios de forma dinamica
const municipios = ref([]);

//cargar municipios cuando cambie el estado - observar con watch

watch(selectedState, async (value) => {
    if (!value) {
        municipios.value = [];
        selectedMunicipio.value = '';
        return;
    }
    const res = await fetch(`/api/municipiosSelect/${value}`);
    municipios.value = await res.json();
});


const buscar = () => {
    let urlParams = [selectedState.value];

    if (selectedCategory.value) {
        urlParams.push(selectedCategory.value);
    }

    if (selectedMunicipio.value) {
        urlParams.push(selectedMunicipio.value);
    }

 

    router.get(route('index.public', urlParams)+  `?searchquery=${encodeURIComponent(searchquery.value || '')}`);
};


onMounted(async () => {
    if (selectedState.value) {
        const res = await fetch(`/api/municipiosSelect/${selectedState.value}`);
        municipios.value = await res.json();
    }
});
</script>

<template>
    <Head title="Solicitantes en" />

    <AppLayout>
        <!-- <pre>{{ anuncios }}</pre>
<pre>{{ state }}</pre>
<pre>{{ municipio }}</pre>
<pre>{{ category }}</pre>
<pre>{{ searchquery }}</pre> -->

        <!-- Select Estado -->
        <label class="mb-1 block">Estado</label>
        <select v-model="selectedState" class="w-full rounded border p-2">
            <option value="">Selecciona un estado</option>
            <option
                v-for="estado in stateSearch"
                :key="estado.slug"
                :value="estado.slug"
            >
                {{ estado.name }}
            </option>
        </select>

        <!-- Select Municipio -->
        <label class="mt-4 mb-1 block">Municipio</label>
        <select v-model="selectedMunicipio" class="w-full rounded border p-2">
            <option value="">Todos los municipios</option>
            <option v-for="m in municipios" :key="m.slug" :value="m.slug">
                {{ m.name }}
            </option>
        </select>

        <!-- Select Categoría -->
        <label class="mt-4 mb-1 block">Categoría</label>
        <select v-model="selectedCategory" class="w-full rounded border p-2">
            <option value="">Todas</option>
            <option v-for="c in categoriesSearch" :key="c.slug" :value="c.slug">
                {{ c.name }}
            </option>
        </select>

        <!-- Input Search -->
        <label class="mt-4 mb-1 block">Buscar</label>
        <input
            v-model="searchquery"
            type="text"
            class="w-full rounded border p-2"
            placeholder="Ej. 'se necesita sangre'"
        />

        <!-- Botón -->
        <button
            @click="buscar"
            class="mt-4 w-full rounded bg-blue-600 px-4 py-2 text-white"
        >
            Buscar
        </button>

        <pre>{{ props.anuncios.data }}</pre>
    </AppLayout>
</template>
