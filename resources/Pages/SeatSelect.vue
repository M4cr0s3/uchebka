<script setup>
import {SeatSelection, SeatRegisterForm, Heading} from "../Components";
import {DefaultLayout} from "../Layouts";
import {onMounted, ref} from "vue";
import {api} from "../API/index.js";
import {useRoute} from "vue-router";

const flight = ref();
const visible = ref(false);
const route = useRoute();

onMounted(async () => {
    flight.value = (await api(`/flights/${route.params.id}`)).data.flight;
})

</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <div class="p-8">
                <Heading title="Выбор места" class="mb-8"/>
                <SeatSelection v-if="flight" :flight="flight" @chosen-seat="(isVisible) => visible = isVisible"/>
                <div class="flex flex-col" v-if="visible">
                    <Heading title="Регистрация на рейс" class="mt-8 mb-4"/>
                    <SeatRegisterForm/>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<style scoped>

</style>
