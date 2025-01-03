<script setup>

import {computed, onMounted, ref} from "vue";
import {api} from "../../API";
import {DefaultLayout} from "../../Layouts";
import {Button, Column, DataTable, InputText, DatePicker, Select, Tag} from "primevue";
import {Heading} from "../../Components";
import dayjs from "dayjs";

const users = ref([]);
const editingRows = ref([]);

const usersWithDate = computed(() => {
    return users.value.map((user) => ({
        ...user,
        birthday: new Date(user.birthday),
    }))
})

const onRowEditSave = async (event) => {
    const response = await api.patch(`/users/${event.data.id}`, getEditedFields(event.data, event.newData))
    if (response.data.success) {
        users.value = (await api('/users')).data;
    }
}

const onRowDelete = async (id) => {
    const response = await api.delete(`/users/${id}`);
    if (response.data.success) {
        users.value = (await api('/users')).data;
    }
}

const getEditedFields = (data, newData) => {
    const result = {};
    for (const i in data) {
        for (const j in newData) {
            if (i === j && data[i] !== newData[j]) {
                if (newData[j] instanceof Date) {
                    result[j] = dayjs(newData[j]).format('YYYY-MM-DD')
                } else {
                    result[j] = newData[j]
                }
            }
        }
    }

    return result;
}


onMounted(async () => {
    users.value = (await api('/users')).data;
})

</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <Heading title="Список пользователей" class="mt-8 mb-6"/>
            <div class="card">
                <DataTable v-model:editingRows="editingRows" :value="usersWithDate" editMode="row" dataKey="id"
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
                    <Column field="fio" header="ФИО" style="width: 15%">
                        <template #editor="{ data, field }">
                            <InputText v-model="data[field]"/>
                        </template>
                    </Column>
                    <Column field="birthday" header="Дата рождения" style="width: 15%">
                        <template #editor="{ data, field }">
                            <DatePicker v-model="data[field]" class="min-w-52"/>
                        </template>
                        <template #body="slotProps">
                            <span>{{ dayjs(slotProps.data.birthday).format('YYYY-MM-DD') }}</span>
                        </template>
                    </Column>
                    <Column field="passport" header="Паспорт" style="width: 15%">
                        <template #editor="{ data, field }">
                            <InputText v-model="data[field]"/>
                        </template>
                    </Column>
                    <Column field="login" header="Логин" style="width: 15%">
                        <template #editor="{ data, field }">
                            <InputText v-model="data[field]"/>
                        </template>
                    </Column>
                    <Column field="phone" header="Номер телефона" style="width: 15%">
                        <template #editor="{ data, field }">
                            <InputText v-model="data[field]"/>
                        </template>
                    </Column>
                    <Column field="email" header="Почта" style="width: 15%">
                        <template #editor="{ data, field }">
                            <InputText type="email" v-model="data[field]"/>
                        </template>
                    </Column>
                    <Column field="role" header="Роль" style="width: 15%">
                        <template #editor="{data, field}">
                            <Select v-model="data[field]" :options="['USER', 'ADMIN']">
                                <template #option="slotProps">
                                    <Tag :value="slotProps.option"
                                         :severity="slotProps.option === 'USER' ? 'success' : 'warn'"/>
                                </template>
                            </Select>
                        </template>
                    </Column>
                    <Column :rowEditor="true" style="width: 5%" bodyStyle="text-align:center"/>
                    <Column :exportable="false" style="width: 5%;">
                        <template #body="slotProps">
                            <Button icon="pi pi-trash" outlined rounded severity="danger"
                                    @click="onRowDelete(slotProps.data.id)"/>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </DefaultLayout>

</template>

<style scoped>

</style>
