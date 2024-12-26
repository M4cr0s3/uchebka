<template>
    <div class="p-4 border border-zinc-200 rounded-lg">
        <div class="flex justify-between items-center">
            <div class="text-xl font-bold text-blue-600">ТУ-92</div>
            <div class="text-gray-600">Нижний Новгород → Москва</div>
        </div>
        <div class="mt-2 text-sm text-gray-500">28 января 2023</div>
        <div class="flex justify-between items-center mt-2">
            <div>
                <div class="text-3xl font-bold text-primary">01:25</div>
                <div class="text-sm text-gray-500">Нижний Новгород</div>
            </div>
            <div class="text-gray-500">11 ч 20 мин</div>
            <div>
                <div class="text-3xl font-bold text-primary">12:45</div>
                <div class="text-sm text-gray-500">Москва</div>
            </div>
        </div>
        <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-500">
                <div>Цена места: <span class="font-bold text-primary">10000 руб.</span></div>
                <div>Количество свободных: <span class="font-bold text-primary">5 мест</span></div>
                <div>Взимаемый процент: <span class="font-bold text-primary">25%</span></div>
            </div>
            <div class="text-2xl font-bold text-blue-600">12500 руб.</div>
            <RouterLink :to="`/flights/1/seat-select`" class="px-4 py-2 bg-yellow-400 text-white rounded-lg text-center shadow-md hover:bg-yellow-500">
                выбрать место
            </RouterLink>
        </div>
    </div>
</template>

<script setup>
</script>
