<script setup>
import {DefaultLayout} from "../../Layouts";
import {Heading} from "../../Components";
import {onMounted, ref} from "vue";
import {DataTable, Column, InputNumber, InputText, Button} from 'primevue'
import {api} from "../../API";

const planes = ref();
const editingRows = ref([]);

onMounted(async () => {
    planes.value = (await api('/planes')).data;
});

const onRowEditSave = async (event) => {
    const {model, capacity} = event.newData;
    if (model === event.data.model && capacity === event.data.capacity) {
        return;
    }

    await api.patch(`/planes/${event.data.id}`, {
        model,
        capacity,
    });
    planes.value = (await api('/planes')).data;
};

const onRowDelete = async (data) => {
    await api.delete(`/planes/${data.id}`);
    planes.value = (await api('/planes')).data;
}

</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <Heading title="Список аэропортов" class="mt-8 mb-6"/>
            <div class="card">
                <DataTable v-model:editingRows="editingRows" :value="planes" editMode="row" dataKey="id"
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
                    <Column field="model" header="Модель" style="width: 20%">
                        <template #editor="{ data, field }">
                            <InputText v-model="data[field]" fluid/>
                        </template>
                    </Column>
                    <Column field="capacity" header="Вместимость" style="width: 20%">
                        <template #editor="{ data, field }">
                            <InputNumber v-model="data[field]" fluid/>
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
    </DefaultLayout>

</template>

<style scoped>

</style>
