<script setup>
import {onMounted, reactive} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import {api} from "../API";
import {FileUpload} from "primevue";

const {city} = defineProps({
    city: {
        required: true,
        type: Object
    }
})

const data = reactive({
    title: '',
    img: null,
});
const router = useRouter();
const route = useRoute()

const onSelect = (event) => {
    data.img = event.files[0];
}

const updateCity = async () => {
    const formData = new FormData();
    formData.append('image', data.img);
    formData.append('title', data.title);
    formData.append('_method', 'PATCH')
    await api.post(`/cities/${route.params.id}`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
    await router.push('/admin/cities');
};


onMounted(() => {
    data.title = city.title
})
</script>

<template>
    <div class="p-4 border rounded-lg border-zinc-200 mt-8">
        <p class="text-primary font-bold text-2xl mb-4">Заполните данные города</p>
        <img :src="`/${city.img}`" :alt="data.title" class="mb-5">
        <div class="flex flex-col">
            <input v-model="data.title" type="text" placeholder="Название" class="p-2 border rounded-lg">
            <div class="flex items-center mt-5">
                <FileUpload
                    class="!bg-primary !border-0" mode="basic" accept="image/*"
                    @select="onSelect"
                    :customUpload
                    :maxFileSize="1000000"
                />
            </div>
        </div>
        <button
            @click="updateCity"
            class="mt-4 px-4 py-2 bg-yellow-400 font-medium text-white rounded-lg shadow-md hover:bg-yellow-500"
            type="submit"
        >
            Сохранить
        </button>
    </div>
</template>
