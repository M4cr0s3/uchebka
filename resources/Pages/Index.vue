<script setup>
import {
    InputText,
    Button,
    DataTable,
    Column
} from 'primevue'
import DefaultLayout from "../Layouts/DefaultLayout.vue";
import {onMounted, ref, watchEffect} from "vue";
import dayjs from "dayjs";
import {CityService, GeoService} from "../Services";
import {CityCard, Heading} from "../Components";
import {transformHeaderName} from '../Shared/utils'

const userLocation = ref('');

const data = ref({
    from: userLocation.value,
    to: 'Москва',
    date: dayjs(new Date()).format('DD.MM.YYYY'),
})
const cities = ref([]);
const flights = ref(
    [
        {
            id: 1,
            from: 'Нижний Новгород',
            to: 'Москва',
            arrival_date: dayjs(new Date()).format('DD.MM.YYYY') + ' года',
            price: 15000,
        },
        {
            id: 2,
            from: 'Нижний Новгород',
            to: 'Москва',
            arrival_date: dayjs(new Date()).format('DD.MM.YYYY') + ' года',
            price: 17000,
        },
    ]
);
const columns = ref([]);

watchEffect(() => {
    data.value.from = userLocation.value;
});

watchEffect(() => {
    if (flights.value.length) {
        columns.value = Object.keys(flights.value[0]).map((key) => ({
            field: key,
            header: transformHeaderName(key)
        })).filter(obj => obj.field !== 'id');
    }
})

onMounted(async () => {
    // userLocation.value = (await GeoService.getUserLocation()).city;
    cities.value = (await CityService.getPopularCities()).splice(0, 4);
})

</script>

<template>
    <DefaultLayout>
        <div class="bg-gradient-to-r from-[#2a27cb] to-[#4bc4f9] h-[70vh]">
            <div class="container mx-auto pt-36">
                <h2 class="text-white text-6xl font-medium mb-10">Поиск авиабилетов</h2>
                <div class="flex justify-between">
                    <div class="flex flex-col gap-2">
                        <label for="from" class="text-white text-2xl">Откуда</label>
                        <InputText class="xl:min-w-[390px] !p-4 text-zinc-800 !focus:border-purple-800 font-medium"
                                   id="from"
                                   v-model="data.from"/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="to" class="text-white text-2xl">Куда</label>
                        <InputText class="xl:min-w-[390px] !p-4 text-zinc-800 !focus:border-purple-800 font-medium"
                                   id="to"
                                   v-model="data.to"/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="date" class="text-white text-2xl">Когда</label>
                        <InputText class="xl:min-w-[390px] !p-4 text-zinc-800 !focus:border-purple-800 font-medium"
                                   id="date"
                                   v-model="data.date"/>
                    </div>
                    <Button class="min-w-[200px] !bg-[#f4c82c]">
                        <span class="text-xl">Найти</span>
                    </Button>
                </div>
            </div>
        </div>
        <div class="container mx-auto mt-20 flex flex-col">
            <Heading title="Популярные направления"/>
            <div class="flex justify-between mt-16">
                <CityCard v-for="city in cities" :city/>
            </div>
            <Heading class="mt-24" title="Все рейсы"/>
            <DataTable class="mt-8" :value="flights" size="large"
                       :row-class="() => 'font-medium'">
                <Column
                    body-class="!border-0"
                    header-class="!border-b !border-[#265BE3] !text-[#265BE3]"
                    v-for="col of columns"
                    :key="col.field"
                    :field="col.field"
                    :header="col.header"
                />
            </DataTable>
        </div>
    </DefaultLayout>
</template>

<style scoped>
</style>
