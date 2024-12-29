<script setup>
import {DefaultLayout} from "../../Layouts";
import {Heading} from "../../Components";
import {onMounted, ref} from "vue";
import {DataTable, Column, Tag, Select, Button, DatePicker, usePrimeVue, InputNumber} from 'primevue'
import {api} from "../../API";
import {PrimeIcons} from "@primevue/core/api";
import dayjs from "dayjs";

const flights = ref([]);
const editingRows = ref([]);
const airports = ref([]);
const planes = ref([])

onMounted(async () => {
    const primeVue = usePrimeVue();
    primeVue.config.locale.dayNamesMin = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
    primeVue.config.locale.monthNames = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь']
    flights.value = (await api('/flights')).data;
    airports.value = (await api('/airports')).data;
    planes.value = (await api('/planes')).data;
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', {style: 'currency', currency: 'RUB'}).format(value);
};

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

</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <Heading title="Список рейсов" class="mt-8 mb-6"/>
            <div class="card">
                <DataTable v-model:editingRows="editingRows" :value="flights" editMode="row" dataKey="id"
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
                            <DatePicker v-model="data[field]" date-format="yy-m-d" showTime/>
                        </template>
                        <template #body="slotProps">
                            <div class="flex items-center gap-2 text-zinc-600 font-medium">
                                <i :class="PrimeIcons.CLOCK"/>
                                <span>{{ slotProps.data.departure_time }}</span>
                            </div>
                        </template>
                    </Column>
                    <Column field="arrival_time" header="Время прибытия" style="width: 15%">
                        <template #editor="{ data, field }">
                            <DatePicker v-model="data[field]" date-format="yy-m-d" showTime/>
                        </template>
                        <template #body="slotProps">
                            <div class="flex items-center gap-2 text-zinc-600 font-medium">
                                <i :class="PrimeIcons.CLOCK"/>
                                <span>{{ slotProps.data.arrival_time }}</span>
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
        </div>
    </DefaultLayout>
</template>

<style scoped>

</style>
