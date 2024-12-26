<script setup>
import {reactive} from 'vue';
import {useRouter} from 'vue-router';
import {api} from "../API";
import {FileUpload} from "primevue";

const city = reactive({
    title: '',
    img: null,
});
const router = useRouter();

const onSelect = (event) => {
    city.img = event.files[0];
}

const saveCity = async () => {
    console.log(city)
    const formData = new FormData();
    formData.append('image', city.img);
    formData.append('title', city.title);
    await api.post('/cities', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
    await router.push('/admin/cities');
};
</script>

<template>
    <div class="p-4 border rounded-lg border-zinc-200 mt-8">
        <p class="text-primary font-bold text-2xl mb-4">Заполните данные города</p>
        <div class="flex flex-col">
            <input v-model="city.title" type="text" placeholder="Название" class="p-2 border rounded-lg">
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
            @click="saveCity"
            class="mt-4 px-4 py-2 bg-yellow-400 font-medium text-white rounded-lg shadow-md hover:bg-yellow-500"
            type="submit"
        >
            Сохранить
        </button>
    </div>
</template>
