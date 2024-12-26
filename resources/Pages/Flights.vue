<script setup>

import {FlightCard} from "../Components";
import {DefaultLayout} from "../Layouts";
import {Heading} from "../Components/index.js";
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
                                <input type="number" placeholder="от" class="w-1/2 p-2 border rounded-lg">
                                <input type="number" placeholder="до" class="w-1/2 p-2 border rounded-lg">
                            </div>
                        </div>
                    </div>
                    <div class="w-3/4 ml-4">
                        <Heading title="Рейсы" class="mb-4"/>
                        <p class="mb-4 font-medium">По вашему запросу найдены следующие рейсы</p>
                        <FlightCard/>
                        <FlightCard class="mt-4"/>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>

</template>

<style scoped>

</style>
