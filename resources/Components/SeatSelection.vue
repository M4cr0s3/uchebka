<script setup>
import dayjs from "dayjs";
import {ref} from "vue";

defineProps({
    flight: {
        type: Object,
        required: true
    }
})

const emits = defineEmits(['chosenSeat'])

const chosenSeatId = ref(0)
const visible = ref(false)

const totalTimeInTrip = (flight) => {
    const hoursWithMinutes = dayjs(new Date(flight.arrival_time)).diff(dayjs(new Date(flight.departure_time)), 'hours', true);
    const hours = Math.floor(hoursWithMinutes);
    const minutes = Math.round((hoursWithMinutes - hours) * 60);
    return `${hours} ч ${minutes} мин`;
}

const chooseSeat = (seat) => {
    chosenSeatId.value = seat.id
    emits('chosenSeat', true)

}

</script>

<template>
    <div class="p-4 border rounded-lg border-zinc-200">
        <div class="flex justify-between items-center">
            <div class="text-xl font-bold text-blue-600">{{ flight.plane.model }}</div>
            <div class="text-gray-600">{{ flight.departure_airport.city.title }} →
                {{ flight.arrival_airport.city.title }}
            </div>
        </div>
        <div class="mt-2 text-sm text-gray-500">{{
                new Intl.DateTimeFormat('ru-RU', {
                    month: 'long',
                    day: '2-digit',
                    year: 'numeric'
                }).format(new Date(flight.departure_time))
            }}
        </div>
        <div class="flex justify-between items-center mt-2">
            <div>
                <div class="text-3xl text-primary font-bold">{{
                        new Intl.DateTimeFormat('ru-RU', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }).format(new Date(flight.departure_time))
                    }}
                </div>
                <div class="text-sm text-gray-500"> {{ flight.departure_airport.city.title }}</div>
            </div>
            <div class="text-gray-500">{{ totalTimeInTrip(flight) }}</div>
            <div>
                <div class="text-3xl font-bold text-primary"> {{
                        new Intl.DateTimeFormat('ru-RU', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }).format(new Date(flight.arrival_time))
                    }}
                </div>
                <div class="text-sm text-gray-500"> {{ flight.arrival_airport.city.title }}</div>
            </div>
        </div>
        <div class="text-2xl font-bold text-blue-600 mt-4">{{ flight.additional_price }} руб.</div>

        <div class="mt-4">
            <p>Выберите одно из предлагаемых мест.</p>
            <p class="text-sm text-gray-500">Выход из самолёта находится в левой части расположения мест:</p>
            <div class="grid grid-cols-6 gap-2 mt-4">
                <div
                    v-for="seat in flight.plane.seats"
                    :key="seat.id"
                    class="cursor-pointer p-2 bg-blue-600 text-white text-center rounded-lg"
                    :class="{'bg-yellow-400': chosenSeatId === seat.id}"
                    @click="chooseSeat(seat)"
                >
                    {{ seat.seat_number }} {{ seat.class }}
                </div>
            </div>
            <div class="flex justify-center items-center mt-2 space-x-8">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-600 rounded-full mr-2"></div>
                    свободно
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-black rounded-full mr-2"></div>
                    занято
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-yellow-400 rounded-full mr-2"></div>
                    выбрано вами
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
