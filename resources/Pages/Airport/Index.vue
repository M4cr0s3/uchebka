<script setup>
import {DefaultLayout} from "../../Layouts";
import {Heading} from "../../Components";
import {onMounted, reactive, ref} from "vue";
import {DataTable, Column, Tag, InputText, Select, Button, Dialog, FloatLabel} from 'primevue'
import {api} from "../../API";

const airports = ref();
const editingRows = ref([]);
const cities = ref([]);
const visible = ref(false);
const data = reactive({
    title: '',
    city_id: 0,
})

const onRowEditSave = async (event) => {
    const {title, city_id} = event.newData
    if (title === event.data.title && city_id === event.data.city_id) {
        return;
    }
    await api.patch(`/airports/${event.data.id}`, {
        title,
        city_id,
    });
    airports.value = (await api('/airports')).data;
};

const onSubmit = async () => {
    const response = await api.post('/airports', data);
    if (response.data.success) {
        data.title = '';
        data.city_id = 0;
        airports.value = (await api('/airports')).data;
        visible.value = false;
    }
}

const onRowDelete = async (data) => {
    await api.delete(`/airports/${data.id}`);
    airports.value = (await api('/airports')).data;
}

onMounted(async () => {
    airports.value = (await api('/airports')).data;
    cities.value = (await api('/cities')).data;
});

</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <Heading title="Список аэропортов" class="mt-8 mb-6"/>
            <Button
                @click="visible = true"
                class="!mt-2 !mb-6 w-full !bg-primary !font-medium !py-1.5 !rounded-lg !text-center !border-0"
            >
                Добавить
            </Button>
            <div class="card">
                <DataTable v-model:editingRows="editingRows" :value="airports" editMode="row" dataKey="id"
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
                    <Column field="title" header="Название" style="width: 20%">
                        <template #editor="{ data, field }">
                            <InputText v-model="data[field]" fluid/>
                        </template>
                    </Column>
                    <Column field="city_id" header="Город" style="width: 20%">
                        <template #editor="{ data, field }">
                            <Select v-model="data[field]" :options="cities" option-label="title" option-value="id"
                                    placeholder="Выберите город" fluid>
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
                            <Tag :value="slotProps.data.city.title"/>
                        </template>
                    </Column>
                    <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"/>
                    <Column :exportable="false" style="width: 10%; min-width: 8rem">
                        <template #body="slotProps">
                            <Button icon="pi pi-trash" outlined rounded severity="danger"
                                    @click="onRowDelete(slotProps.data)"/>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
        <Dialog v-model:visible="visible" @submit.prevent="onSubmit" modal header="Создание аэропорта"
                :style="{ width: '25rem' }">
            <form class="flex flex-col justify-center space-y-4">
                <FloatLabel variant="in">
                    <InputText id="title" v-model="data.title" class="w-full"/>
                    <label for="title">Название</label>
                </FloatLabel>
                <Select v-model="data.city_id" :options="cities" option-label="title" option-value="id"
                        placeholder="Выберите город" fluid>
                    <template #option="slotProps">
                        <Tag :value="slotProps.option.id">
                            <div class="flex items-center gap-2 px-1">
                                <span class="text-base">{{ slotProps.option.title }}</span>
                            </div>
                        </Tag>
                    </template>
                </Select>
                <Button
                    type="submit"
                    class="w-full !bg-primary !font-medium !py-1.5 !rounded-lg !text-center !border-0"
                >
                    Добавить
                </Button>
            </form>
        </Dialog>
    </DefaultLayout>

</template>

<style scoped>

</style>
