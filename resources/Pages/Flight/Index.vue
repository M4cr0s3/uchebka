<script setup>
import {DefaultLayout} from "../../Layouts";
import {Heading} from "../../Components";
import {computed, onMounted, reactive, ref} from "vue";
import {
    DataTable,
    Column,
    Tag,
    Select,
    Button,
    DatePicker,
    usePrimeVue,
    InputNumber,
    FloatLabel,
    Dialog,
} from 'primevue'
import {api} from "../../API";
import {PrimeIcons} from "@primevue/core/api";
import dayjs from "dayjs";

const flights = ref([]);
const editingRows = ref([]);
const airports = ref([]);
const planes = ref([])
const visible = ref(false);
const data = reactive({
    departure_airport_id: 0,
    arrival_airport_id: 0,
    departure_time: '',
    arrival_time: '',
    status: '',
    plane_id: 0,
    additional_price: 0,
});

const flightsWithDate = computed(() => {
    return flights.value.map(flight => ({
        ...flight,
        arrival_time: new Date(flight.arrival_time),
        departure_time: new Date(flight.departure_time),
    }))
})

const onRowEditSave = async (event) => {
    await api.patch(`/flights/${event.data.id}`, {
        ...event.newData,
        arrival_time: dayjs(event.newData.arrival_time).format('YYYY-MM-DD HH:mm:ss'),
        departure_time: dayjs(event.newData.departure_time).format('YYYY-MM-DD HH:mm:ss')
    });
    flights.value = (await api('/flights')).data;
};

const onRowDelete = async (data) => {
    await api.delete(`/flights/${data.id}`);
    flights.value = (await api('/flights')).data;
}

const onSubmit = async () => {
    const response = await api.post('/flights', {
        ...data,
        arrival_time: dayjs(data.arrival_time).format('YYYY-MM-DD HH:mm:ss'),
        departure_time: dayjs(data.departure_time).format('YYYY-MM-DD HH:mm:ss')
    })
    if (response.data.success) {
        flights.value = (await api('/flights')).data;
        data.plane_id = 0;
        data.departure_time = '';
        data.arrival_airport_id = 0;
        data.status = '';
        data.departure_airport_id = 0;
        data.arrival_time = '';
        visible.value = false;
    }
}

const getSeverity = (status) => {
    switch (status) {
        case 'Готов':
            return 'success';

        case 'В полете':
            return 'warn';

        case 'Прибыл':
            return 'info';

        case 'ТО':
            return 'danger';

        default:
            break;
    }
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', {style: 'currency', currency: 'RUB'}).format(value);
};

onMounted(async () => {
    const primeVue = usePrimeVue();
    primeVue.config.locale.dayNamesMin = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
    primeVue.config.locale.monthNames = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь']
    primeVue.config.locale.monthNamesShort = ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Нояб', 'Дек']
    flights.value = (await api('/flights')).data;
    airports.value = (await api('/airports')).data;
    planes.value = (await api('/planes')).data;
});

</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <Heading title="Список рейсов" class="mt-8 mb-6"/>
            <Button
                @click="visible = true"
                class="!mt-2 !mb-6 w-full !bg-primary !font-medium !py-1.5 !rounded-lg !text-center !border-0"
            >
                Добавить
            </Button>
            <div class="card">
                <DataTable v-model:editingRows="editingRows" :value="flightsWithDate" editMode="row" dataKey="id"
                           @row-edit-save="onRowEditSave"
                           paginator
                           :rows="10"
                           :pt="{
                table: { style: 'min-width: 50rem' },
                column: {
                    bodycell: ({ state }) => ({
                        style:  state['d_editing'] && 'padding-top: 0.75rem; padding-bottom: 0.75rem'
                    })
                }
            }"
                >
                    <Column field="departure_airport_id" header="Аэропорт вылета" style="width: 15%">
                        <template #editor="{ data, field }">
                            <Select v-model="data[field]" :options="airports" option-label="title" option-value="id"
                                    placeholder="Выберите аэропорт" fluid>
                                <template #option="slotProps">
                                    <Tag :value="slotProps.option.id">
                                        <div class="flex items-center gap-2 px-1">
                                            <span class="text-base">{{ slotProps.option.title }}</span>
                                        </div>
                                    </Tag>
                                </template>
                            </Select>
                        </template>
                        <template #body="slotProps">
                            <Tag :value="slotProps.data.departure_airport.title" severity="secondary"/>
                        </template>
                    </Column>
                    <Column field="arrival_airport_id" header="Аэропорт прилета" style="width: 15%">
                        <template #editor="{ data, field }">
                            <Select v-model="data[field]" :options="airports" option-label="title" option-value="id"
                                    placeholder="Выберите id аэропорта" fluid>
                                <template #option="slotProps">
                                    <Tag :value="slotProps.option.id">
                                        <div class="flex items-center gap-2 px-1">
                                            <span class="text-base">{{ slotProps.option.title }}</span>
                                        </div>
                                    </Tag>
                                </template>
                            </Select>
                        </template>
                        <template #body="slotProps">
                            <Tag :value="slotProps.data.arrival_airport.title"/>
                        </template>
                    </Column>
                    <Column field="plane_id" header="Самолет" style="width: 15%">
                        <template #editor="{ data, field }">
                            <Select v-model="data[field]" :options="planes" option-label="model" option-value="id"
                                    placeholder="Выберите самолет" fluid>
                                <template #option="slotProps">
                                    <Tag :value="slotProps.option.id">
                                        <div class="flex items-center gap-2 px-1">
                                            <span class="text-base">{{ slotProps.option.model }}</span>
                                        </div>
                                    </Tag>
                                </template>
                            </Select>
                        </template>
                        <template #body="slotProps">
                            <Tag :value="slotProps.data.plane.model" severity="info"/>
                        </template>
                    </Column>
                    <Column field="departure_time" header="Время отбытия" style="width: 15%">
                        <template #editor="{ data, field }">
                            <DatePicker v-model="data[field]" class="min-w-52" showTime/>
                        </template>
                        <template #body="slotProps">
                            <div class="flex items-center gap-2 text-zinc-600 font-medium">
                                <i :class="PrimeIcons.CLOCK"/>
                                <span>{{ dayjs(slotProps.data.departure_time).format("YYYY-MM-DD HH:mm:ss") }}</span>
                            </div>
                        </template>
                    </Column>
                    <Column field="arrival_time" header="Время прибытия" style="width: 15%">
                        <template #editor="{ data, field }">
                            <DatePicker v-model="data[field]" class="min-w-52" showTime/>
                        </template>
                        <template #body="slotProps">
                            <div class="flex items-center gap-2 text-zinc-600 font-medium">
                                <i :class="PrimeIcons.CLOCK"/>
                                <span>{{ dayjs(slotProps.data.arrival_time).format("YYYY-MM-DD HH:mm:ss") }}</span>
                            </div>
                        </template>
                    </Column>
                    <Column field="status" header="Статус" style="width: 10%">
                        <template #editor="{ data, field }">
                            <Select v-model="data[field]" :options="['Готов', 'В полете', 'Прибыл', 'ТО']">
                                <template #option="slotProps">
                                    <Tag :value="slotProps.option" :severity="getSeverity(slotProps.option)"/>
                                </template>
                            </Select>
                        </template>
                        <template #body="slotProps">
                            <Tag :value="slotProps.data.status" :severity="getSeverity(slotProps.data.status)"/>
                        </template>
                    </Column>
                    <Column field="additional_price" header="Доп. цена" style="width: 10%">
                        <template #editor="{ data, field }">
                            <InputNumber v-model="data[field]" mode="currency" currency="RUB" locale="ru-RU"/>
                        </template>
                        <template #body="slotProps">
                            <div class="flex items-center gap-2 text-zinc-600 font-medium">
                                <i :class="PrimeIcons.MONEY_BILL"/>
                                <span>{{ formatCurrency(slotProps.data.additional_price) }}</span>
                            </div>
                        </template>
                    </Column>
                    <Column :rowEditor="true" style="width: 5%" bodyStyle="text-align:center"/>
                    <Column :exportable="false" style="width: 5%;">
                        <template #body="slotProps">
                            <Button icon="pi pi-trash" outlined rounded severity="danger"
                                    @click="onRowDelete(slotProps.data)"/>
                        </template>
                    </Column>
                </DataTable>
            </div>
            <Dialog v-model:visible="visible" @submit.prevent="onSubmit" modal header="Создание рейса"
                    :style="{ width: '50rem' }">
                <form class="flex flex-col justify-center space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <FloatLabel variant="in">
                            <Select id="departure" v-model="data.departure_airport_id" :options="airports"
                                    option-label="title"
                                    option-value="id"
                                    placeholder="Выберите аэропорт отправления" fluid>
                                <template #option="slotProps">
                                    <Tag :value="slotProps.option.id">
                                        <div class="flex items-center gap-2 px-1">
                                            <span class="text-base">{{ slotProps.option.title }}</span>
                                        </div>
                                    </Tag>
                                </template>
                            </Select>
                            <label for="departure">Аэропорт отправления</label>
                        </FloatLabel>
                        <FloatLabel variant="in">
                            <Select id="departure" v-model="data.arrival_airport_id" :options="airports"
                                    option-label="title"
                                    option-value="id"
                                    placeholder="Выберите аэропорт прибытия" fluid>
                                <template #option="slotProps">
                                    <Tag :value="slotProps.option.id">
                                        <div class="flex items-center gap-2 px-1">
                                            <span class="text-base">{{ slotProps.option.title }}</span>
                                        </div>
                                    </Tag>
                                </template>
                            </Select>
                            <label for="departure">Аэропорт прибытия</label>
                        </FloatLabel>
                        <FloatLabel variant="in">
                            <DatePicker id="departure_time" v-model="data.departure_time" fluid showTime/>
                            <label for="departure_time">Время отправления</label>
                        </FloatLabel>
                        <FloatLabel variant="in">
                            <DatePicker id="arrival_time" v-model="data.arrival_time" fluid showTime/>
                            <label for="arrival_time">Время прибытия</label>
                        </FloatLabel>
                        <FloatLabel variant="in">
                            <Select v-model="data.status" :options="['Готов', 'В полете', 'Прибыл', 'ТО']" fluid>
                                <template #option="slotProps">
                                    <Tag :value="slotProps.option" :severity="getSeverity(slotProps.option)"/>
                                </template>
                            </Select>
                            <label for="status">Статус</label>
                        </FloatLabel>
                        <FloatLabel variant="in">
                            <InputNumber id="price" mode="currency" currency="RUB" locale="ru-RU"
                                         v-model="data.additional_price" class="w-full"/>
                            <label for="price">Доп. цена</label>
                        </FloatLabel>
                    </div>
                    <FloatLabel variant="in">
                        <Select id="plane" v-model="data.plane_id" :options="planes"
                                option-label="model"
                                option-value="id"
                                placeholder="Выберите самолет" fluid>
                            <template #option="slotProps">
                                <Tag :value="slotProps.option.id">
                                    <div class="flex items-center gap-2 px-1">
                                        <span class="text-base">{{ slotProps.option.model }}</span>
                                    </div>
                                </Tag>
                            </template>
                        </Select>
                        <label for="plane">Самолет</label>
                    </FloatLabel>
                    <Button
                        type="submit"
                        class="w-full !bg-primary !font-medium !py-1.5 !rounded-lg !text-center !border-0"
                    >
                        Добавить
                    </Button>
                </form>
            </Dialog>
        </div>
    </DefaultLayout>
</template>

<style scoped>

</style>
