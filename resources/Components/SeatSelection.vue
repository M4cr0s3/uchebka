<script setup>
import {ref} from "vue";

const seats = ref([
    { number: 1, status: 'free' },
    { number: 2, status: 'free' },
    { number: 3, status: 'selected' },
    { number: 4, status: 'free' },
    { number: 5, status: 'free' },
    { number: 6, status: 'free' },
    { number: 7, status: 'free' },
    { number: 8, status: 'free' },
    { number: 9, status: 'occupied' },
    { number: 10, status: 'free' },
    { number: 11, status: 'free' },
    { number: 12, status: 'free' },
    { number: 13, status: 'free' },
    { number: 14, status: 'free' },
    { number: 15, status: 'free' },
    { number: 16, status: 'occupied' },
    { number: 17, status: 'free' },
    { number: 18, status: 'free' },
    { number: 19, status: 'free' },
    { number: 20, status: 'occupied' },
    { number: 21, status: 'free' },
    { number: 22, status: 'free' },
    { number: 23, status: 'free' },
    { number: 24, status: 'free' },
    { number: 25, status: 'free' },
]);
</script>

<template>
    <div class="p-4 border rounded-lg border-zinc-200">
        <div class="flex justify-between items-center">
            <div class="text-xl font-bold text-blue-600">ТУ-92</div>
            <div class="text-gray-600">Нижний Новгород → Москва</div>
        </div>
        <div class="mt-2 text-sm text-gray-500">28 января 2023</div>
        <div class="flex justify-between items-center mt-2">
            <div>
                <div class="text-3xl text-primary font-bold">01:25</div>
                <div class="text-sm text-gray-500">Нижний Новгород</div>
            </div>
            <div class="text-gray-500">11 ч 20 мин</div>
            <div>
                <div class="text-3xl font-bold text-primary">12:45</div>
                <div class="text-sm text-gray-500">Москва</div>
            </div>
        </div>
        <div class="text-2xl font-bold text-blue-600 mt-4">12500 руб.</div>

        <div class="mt-4">
            <p>Выберите одно из предлагаемых мест.</p>
            <p class="text-sm text-gray-500">Выход из самолёта находится в левой части расположения мест:</p>
            <div class="grid grid-cols-6 gap-2 mt-4">
                <div v-for="seat in seats" :key="seat.number" class="cursor-pointer p-2 bg-blue-600 text-white text-center rounded-lg">
                    {{ seat.number }}
                </div>
            </div>
            <div class="flex justify-center items-center mt-2 space-x-8">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-600 rounded-full mr-2"></div> свободно
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-black rounded-full mr-2"></div> занято
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-yellow-400 rounded-full mr-2"></div> выбрано вами
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
