<script setup>
import {CityEditForm, Heading} from "../../Components";
import {DefaultLayout} from "../../Layouts";
</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <Heading title="Редактирование города" class="mt-8 mb-4"/>
            <CityEditForm/>
        </div>
    </DefaultLayout>
</template>

<style scoped>

</style>
