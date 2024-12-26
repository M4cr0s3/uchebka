<script setup>
import {BurgerMenu} from "./";
</script>

<template>
    <div class="bg-gradient-to-r from-[#2a27cb] to-[#4bc4f9] px-10 py-3">
        <div class="container mx-auto flex items-center justify-between">
            <RouterLink class="font-bold text-5xl text-white" to="/">
                airlines
            </RouterLink>
            <BurgerMenu/>
        </div>
    </div>
</template>

<style scoped>

</style>
