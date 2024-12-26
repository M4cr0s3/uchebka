<template>
    <RouterLink :to="`/cities/${city.id}`" class="city-card">
        <img :src="city.img" :alt="city.title" class="city-image"/>
        <div class="text-3xl font-bold text-white absolute bottom-10 left-5">{{ city.title }}</div>
    </RouterLink>
</template>

<script setup>
defineProps({
    city: {
        type: Object,
        required: true
    },
});
</script>

<style scoped>
.city-card {
    position: relative;
    height: 345px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.city-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(50%);
}
</style>
