<script setup>

</script>

<template>
    <div class="p-4 border rounded-lg border-zinc-200 mt-8">
        <p class="text-sm mb-4">
            Заполните личные данные для покупки и оформления билета<br>
            <span class="font-bold">ВНИМАНИЕ! Если вы покупаете билет не для себя, введите данные человека, на которого оформляете билет</span>
        </p>
        <div class="grid grid-cols-2 gap-4">
            <input type="text" placeholder="ФИО" class="p-2 border rounded-lg">
            <input type="date" placeholder="дата рождения" class="p-2 border rounded-lg">
            <input type="text" placeholder="номер свидетельства о рождении" class="p-2 border rounded-lg">
            <input type="text" placeholder="серия и номер паспорта" class="p-2 border rounded-lg">
            <input type="text" placeholder="номер места - 3" class="p-2 border rounded-lg" readonly>
            <input type="text" placeholder="номер рейса" class="p-2 border rounded-lg" readonly>
            <input type="password" placeholder="введите пароль" class="p-2 border rounded-lg">
        </div>
        <div class="flex items-center mt-4">
            <input type="checkbox" id="agreement" class="mr-2">
            <label for="agreement" class="text-sm">
                Я знаком с политикой конфиденциальности и даю своё согласие на обработку персональных данных.
            </label>
        </div>
        <button class="mt-4 px-4 py-2 bg-yellow-400 text-white rounded-lg shadow-md hover:bg-yellow-500">
            оформить
        </button>
    </div>
</template>

<style scoped>

</style>
