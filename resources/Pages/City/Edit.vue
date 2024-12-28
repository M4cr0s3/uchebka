<script setup>
import {CityEditForm, Heading} from "../../Components";
import {DefaultLayout} from "../../Layouts";
import {onMounted, ref} from "vue";
import {api} from "../../API";
import {useRoute} from "vue-router";

const city = ref();
const route = useRoute();

onMounted(async () => {
    city.value = (await api(`/cities/${route.params.id}`)).data;
})
</script>

<template>
    <DefaultLayout>
        <div class="container mx-auto">
            <Heading title="Редактирование города" class="mt-8 mb-4"/>
            <CityEditForm :city="city" v-if="city"/>
        </div>
    </DefaultLayout>
</template>

<style scoped>

</style>
