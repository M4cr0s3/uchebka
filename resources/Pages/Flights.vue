<script setup>
import {FlightCard, Heading} from "../Components";
import {DefaultLayout} from "../Layouts";
import {InputNumber} from "primevue";
import {useRouter} from "vue-router";
import {computed, onMounted, reactive, ref} from "vue";
import {decode} from "js-base64";

const router = useRouter();
const price = reactive({
    min: null,
    max: null,
})
const flights = ref([]);

const sortedFlights = computed(() => {
    if (price.min === null && price.max === null) {
        return flights.value;
    }

    return flights.value.filter((flight) => {
        const flightPrice = flight.additional_price;

        const isMinValid = price.min === null || flightPrice >= price.min;

        const isMaxValid = price.max === null || flightPrice <= price.max;

        return isMinValid && isMaxValid;
    });
});

onMounted(() => {
    const query = router.currentRoute.value.query;
    if (query.flights) {
        try {
            flights.value = JSON.parse(decode(query.flights));
        } catch (error) {
            console.error("Ошибка при декодировании данных:", error);
        }
    }
});
</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <div class="p-8">
                <div class="flex justify-between items-start">
                    <div class="w-1/4 p-4 bg-white rounded-lg border border-zinc-200 mr-6">
                        <h2 class="text-xl font-bold text-primary mb-4">Фильтры</h2>
                        <div>
                            <h3 class="text-lg font-medium text-primary mb-2">Стоимость</h3>
                            <div class="flex space-x-2">
                                <InputNumber v-model="price.min" placeholder="от" fluid/>
                                <InputNumber v-model="price.max" placeholder="до" fluid/>
                            </div>
                        </div>
                    </div>
                    <div class="w-3/4 ml-4">
                        <Heading title="Рейсы" class="mb-4"/>
                        <div class="flex flex-col" v-if="sortedFlights.length">
                            <p class="mb-4 font-medium">По вашему запросу найдены следующие рейсы</p>
                            <FlightCard
                                class="mb-4"
                                v-for="flight in sortedFlights"
                                :flight="flight"
                                :key="flight.id"
                            />
                        </div>
                        <div v-else class="text-xl font-bold text-primary">
                            По вашему запросу ничего не нашлось.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>

</template>

<style scoped>

</style>
