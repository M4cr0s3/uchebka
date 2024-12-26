<script setup>
import {DefaultLayout} from "../Layouts";
import {Heading} from "../Components";
import {InputText, FloatLabel, Button} from "primevue";
import {ref} from "vue";
import {useAuthStore} from "../Stores";
import {router} from "../router";
import {ROUTES} from "../router/routes.js";

const authStore = useAuthStore()
const data = ref({
    login: '',
    password: '',
})

const onSubmit = async () => {
    const response = await authStore.login(data.value)
    if (response.data.success) {
        authStore.isAuth = true
        await router.push(ROUTES.HOME)
    }
}


</script>

<template>
    <DefaultLayout>
        <div class="h-[calc(100vh-72px)]">
            <div class="container max-w-2xl mx-auto flex flex-col justify-center h-full">
                <Heading class="w-full" title="Авторизация"/>
                <form class="space-y-3 mt-6" @submit.prevent="onSubmit">
                    <FloatLabel variant="in" class="mb-6">
                        <InputText
                            id="login"
                            v-model="data.login"
                            variant="filled"
                            fluid
                        />
                        <label for="login">Логин</label>
                    </FloatLabel>
                    <FloatLabel variant="in">
                        <InputText
                            type="password"
                            id="password"
                            v-model="data.password"
                            variant="filled"
                            class="!focus:text-3xl"
                            fluid
                        />
                        <label for="password">Пароль</label>
                    </FloatLabel>
                    <Button class="w-full !mt-4 !border-0 !bg-[#f4c82c] font-medium" type="submit">Войти</Button>
                </form>
            </div>
        </div>
    </DefaultLayout>
</template>

<style>
.p-inputtext:enabled:focus {
    border-color: #265BE3 !important;
}

.p-floatlabel:has(input:focus) label, .p-floatlabel:has(input:-webkit-autofill) label, .p-floatlabel:has(textarea:focus) label, .p-floatlabel:has(.p-inputwrapper-focus) label {
    color: #265BE3 !important;
}

.p-inputtext.p-variant-filled {
    background-color: #fff !important;
}
</style>
