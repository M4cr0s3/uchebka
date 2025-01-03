<script setup>
import {Button, Column, DataTable, DatePicker, Message, Select, Toast, usePrimeVue, useToast} from 'primevue'
import DefaultLayout from "../Layouts/DefaultLayout.vue";
import {onMounted, reactive, ref, watchEffect} from "vue";
import dayjs from "dayjs";
import {CityService} from "../Services";
import {CityCard, Heading} from "../Components";
import {transformHeaderName} from '../Shared/utils'
import {Form} from "@primevue/forms";
import {zodResolver} from "@primevue/forms/resolvers/zod";
import {z} from "zod";
import {api} from "../API/index.js";
import {useRouter} from "vue-router";
import {encode} from 'js-base64';

const data = reactive({
    departure_city_id: 0,
    arrival_city_id: 0,
    arrival_date: dayjs(new Date()).format('DD.MM.YYYY'),
})
const cities = ref([]);
const popularCities = ref([]);
const toast = useToast();
const {push} = useRouter();
const resolver = ref(zodResolver(
    z.object({
        departure_city_id: z.number({
            required_error: 'Данное поле должно быть заполнено.'
        }),
        arrival_city_id: z.number({
            required_error: 'Данное поле должно быть заполнено.'
        }),
        arrival_date: z.date({
            message: 'Некорректная дата.'
        }),
    })
))
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

const searchFlight = async () => {
    try {
        const response = await api.post('/flights/search', data);
        if (response.data.success) {
            await push({
                path: '/flights',
                query: { flights: encode(JSON.stringify(response.data.flights)) }
            });
        }
    } catch (e) {
        console.log(e)
        // toast.add({
        //     severity: 'error',
        //     summary: 'Ошибка!',
        //     detail: Object.values(e.response.data.errors).flat().map((err) => err + '\n').join(''),
        //     life: 3000,
        //     closable: true,
        // });
    }
};
watchEffect(() => {
    if (flights.value.length) {
        columns.value = Object.keys(flights.value[0]).map((key) => ({
            field: key,
            header: transformHeaderName(key)
        })).filter(obj => obj.field !== 'id');
    }
})

onMounted(async () => {
    const primeVue = usePrimeVue();
    primeVue.config.locale.dayNamesMin = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
    primeVue.config.locale.monthNames = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь']
    primeVue.config.locale.monthNamesShort = ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Нояб', 'Дек']
    popularCities.value = (await CityService.getPopularCities());
    cities.value = await CityService.getCities();
})

</script>

<template>
    <DefaultLayout>
        <Toast/>
        <div class="bg-gradient-to-r from-[#2a27cb] to-[#4bc4f9] h-[70vh]">
            <div class="container mx-auto pt-36">
                <h2 class="text-white text-6xl font-medium mb-10">Поиск авиабилетов</h2>
                <Form v-slot="$form" @submit="searchFlight" :resolver="resolver" class="flex justify-between">
                    <div class="flex flex-col gap-2">
                        <label for="from" class="text-white text-2xl"
                               :class="{'!text-red-500': $form.departure_city_id?.invalid}">Откуда</label>
                        <Select
                            id="from"
                            name="departure_city_id"
                            class="xl:min-w-[390px] !p-2 text-zinc-800 font-medium"
                            :options="cities"
                            option-label="title"
                            option-value="id"
                            placeholder="Выберите город вылета"
                            v-model="data.departure_city_id"
                        />
                        <Message v-if="$form.departure_city_id?.invalid" severity="error" size="small" variant="simple">
                            {{ $form.departure_city_id.error.message }}
                        </Message>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="arrival_city_id" class="text-white text-2xl"
                               :class="{'!text-red-500': $form.arrival_city_id?.invalid}">Куда</label>
                        <Select
                            id="arrival_city_id"
                            name="arrival_city_id"
                            class="xl:min-w-[390px] !p-2 text-zinc-800 font-medium"
                            :options="cities"
                            option-label="title"
                            option-value="id"
                            placeholder="Выберите город назначения"
                            v-model="data.arrival_city_id"
                        />
                        <Message v-if="$form.arrival_city_id?.invalid" severity="error" size="small" variant="simple">
                            {{ $form.arrival_city_id.error.message }}
                        </Message>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="date" class="text-white text-2xl">Когда</label>
                        <DatePicker id="date" v-model="data.arrival_date" input-class="!p-4" class="xl:min-w-[390px]"/>
                    </div>
                    <Button class="min-w-[200px] !bg-secondary" type="submit">
                        <span class="text-xl">Найти</span>
                    </Button>
                </Form>
            </div>
        </div>
        <div class="container mx-auto mt-20 flex flex-col">
            <Heading title="Популярные направления"/>
            <div class="flex justify-between mt-16">
                <CityCard v-for="city in popularCities" :city/>
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
.p-button:not(:disabled):hover {
    background-color: #265BE3 !important;
    border-color: #265BE3 !important;
    transition: .5s ease-in-out;
}
</style>
