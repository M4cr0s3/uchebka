<template>
    <div class="p-4 border border-zinc-200 rounded-lg">
        <div class="flex justify-between items-center">
            <div class="text-xl font-bold text-blue-600">{{ flight.plane.model }}</div>
            <div class="text-gray-600">{{ flight.departure_airport.city.title }} →
                {{ flight.arrival_airport.city.title }}
            </div>
        </div>
        <div class="mt-2 text-sm text-gray-500">
            {{
                new Intl.DateTimeFormat('ru-RU', {
                    month: 'long',
                    day: '2-digit',
                    year: 'numeric'
                }).format(new Date(flight.departure_time))
            }}
        </div>
        <div class="flex justify-between items-center mt-2">
            <div>
                <div class="text-3xl font-bold text-primary">
                    {{
                        new Intl.DateTimeFormat('ru-RU', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }).format(new Date(flight.departure_time))
                    }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ flight.departure_airport.city.title }}
                </div>
            </div>
            <div class="text-gray-500">{{ totalTimeInTrip(flight) }}</div>
            <div>
                <div class="text-3xl font-bold text-primary">
                    {{
                        new Intl.DateTimeFormat('ru-RU', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }).format(new Date(flight.arrival_time))
                    }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ flight.arrival_airport.city.title }}
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-500">
                <div>Цена места: <span class="font-bold text-primary">{{ flight.additional_price }} руб.</span></div>
                <div>Количество свободных: <span class="font-bold text-primary">5 мест</span></div>
            </div>
            <div class="text-2xl font-bold text-blue-600">12500 руб.</div>
            <RouterLink :to="`/flights/${flight.id}/seat-select`"
                        class="px-4 py-2 bg-yellow-400 text-white rounded-lg text-center shadow-md hover:bg-yellow-500">
                выбрать место
            </RouterLink>
        </div>
    </div>
</template>

<script setup>
import dayjs from "dayjs";

defineProps({
    flight: {
        type: Object,
        required: true
    }
})

const totalTimeInTrip = (flight) => {
    const hoursWithMinutes = dayjs(new Date(flight.arrival_time)).diff(dayjs(new Date(flight.departure_time)), 'hours', true);
    const hours = Math.floor(hoursWithMinutes);
    const minutes = Math.round((hoursWithMinutes - hours) * 60);
    return `${hours} ч ${minutes} мин`;
}
</script>
