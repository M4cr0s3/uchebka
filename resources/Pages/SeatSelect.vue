<script setup>
import {SeatSelection, SeatRegisterForm, Heading} from "../Components";
import {DefaultLayout} from "../Layouts";
</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <div class="p-8">
                <Heading title="Выбор места" class="mb-8"/>
                <SeatSelection/>
                <Heading title="Регистрация на рейс" class="mt-8 mb-4"/>
                <SeatRegisterForm/>
            </div>
        </div>
    </DefaultLayout>
</template>

<style scoped>

</style>
