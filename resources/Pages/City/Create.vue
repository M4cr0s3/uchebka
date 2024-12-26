<script setup>
import {CityCreateForm, Heading} from "../../Components";
import {DefaultLayout} from "../../Layouts";
</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <Heading title="Создание города" class="mt-8 mb-4"/>
            <CityCreateForm/>
        </div>
    </DefaultLayout>
</template>

<style scoped>

</style>
