<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    }
})
</script>

<template>
    <div class="flex justify-between items-center">
        <h2 class="text-primary text-5xl font-bold">{{ title }}</h2>
        <div class="bg-primary h-1 w-1/2"></div>
    </div>
</template>

<style scoped>

</style>
