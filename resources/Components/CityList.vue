<script setup>
import {ref, onMounted} from 'vue';
import {useRouter} from 'vue-router';
import {api} from "../API";
import {DefaultLayout} from "../Layouts/";
import {Heading} from "./";

const cities = ref([]);
const router = useRouter();

const fetchCities = async () => {
    const response = await api.get('/cities');
    cities.value = response.data;
};

const deleteCity = async (id) => {
    await api.delete(`/cities/${id}`);
    await fetchCities();
};

onMounted(fetchCities);
</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <Heading title="Список городов" class="mt-8 mb-4"/>
            <RouterLink to="/admin/cities/create" class="mt-8 block bg-primary font-medium py-2 px-4 rounded-lg text-white text-center">Добавить</RouterLink>
            <div class="grid grid-cols-4 gap-4">
                <div v-for="city in cities" :key="city.id"
                     class="flex flex-col items-center p-4 border rounded-lg border-zinc-200 mt-8">
                    <img :src="`/${city.img}`" :alt="city.title" class="">
                    <div class="font-bold text-primary text-2xl mt-2">{{ city.title }}</div>
                    <div class="flex gap-4">
                        <button @click="deleteCity(city.id)"
                                class="mt-4 px-4 py-2 font-medium bg-red-400 text-white rounded-lg shadow-md hover:bg-red-500">
                            Удалить
                        </button>
                        <RouterLink
                            :to="`/admin/cities/${city.id}/edit`"
                            class="mt-4 px-4 py-2 font-medium bg-yellow-400 text-white rounded-lg shadow-md hover:bg-yellow-500"
                        >
                            Редактировать
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>
