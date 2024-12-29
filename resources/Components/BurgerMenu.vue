<script setup>
import {Drawer} from "primevue";
import {ref} from 'vue';
import {ROUTES} from "../router/routes.js";
import {PrimeIcons} from '@primevue/core/api';
import {useAuthStore} from "../Stores";
import {router} from "../router";

const show = ref(false);
const links = [
    {
        label: 'Главная',
        icon: PrimeIcons.HOME,
        route: ROUTES.HOME
    },
    {
        label: 'Авторизация',
        icon: PrimeIcons.SIGN_IN,
        route: ROUTES.LOGIN,
    },
    {
        label: 'Регистрация',
        icon: PrimeIcons.USER_EDIT,
        route: ROUTES.REGISTER,
    },
];
const authStore = useAuthStore();

const toggleDrawer = () => {
    show.value = !show.value;
};

const logout = async () => {
    const response = await authStore.logout();
    console.log(response)
    if (!response.data.success) {
        return;
    }

    authStore.isAuth = false;
    await router.push(ROUTES.HOME);
}
</script>

<template>
    <div class="burger-menu grid grid-cols-2 gap-3 cursor-pointer" @click.stop="toggleDrawer">
        <div class="rounded-full h-3 w-3 bg-white"></div>
        <div class="rounded-full h-3 w-3 bg-white"></div>
        <div class="rounded-full h-3 w-3 bg-white"></div>
        <div class="rounded-full h-3 w-3 bg-white"></div>
        <Drawer v-model:visible="show" :close-button-props="{class: '!hidden'}" position="right">
            <template #header>
                <h2 class="text-2xl font-bold">
                    Меню
                </h2>
            </template>
            <template #default>
                <ul class="list-none p-0 m-0 overflow-hidden" v-for="link in links">
                    <li>
                        <RouterLink
                            v-ripple
                            class="flex items-center cursor-pointer p-3 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                            :class="{hidden: (authStore.isAuth && (link.route === ROUTES.LOGIN || link.route === ROUTES.REGISTER))}"
                            :to="link.route"
                        >
                            <i :class="link.icon" class="mr-2"/>
                            <span class="font-medium">{{ link.label }}</span>
                        </RouterLink>
                    </li>
                </ul>
                <ul class="list-none p-0 m-0 overflow-hidden">
                    <li>
                        <a
                            @click="logout"
                            v-ripple
                            class="flex items-center cursor-pointer p-3 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                            :class="{hidden: !authStore.isAuth}"

                        >
                            <i :class="PrimeIcons.SIGN_OUT" class="mr-2"/>
                            <span class="font-medium">Выход</span>
                        </a>
                    </li>
                </ul>
                <ul class="list-none p-0 m-0 overflow-hidden"
                    :class="{hidden: !authStore.isAuth || authStore.role === 'USER'}">
                    <li>
                        <RouterLink
                            to="/admin/cities"
                            v-ripple
                            class="flex items-center cursor-pointer p-3 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                        >
                            <i :class="PrimeIcons.BUILDING" class="mr-2"/>
                            <span class="font-medium">CRUD - города</span>
                        </RouterLink>
                    </li>
                    <li>
                        <RouterLink
                            to="/admin/airports"
                            v-ripple
                            class="flex items-center cursor-pointer p-3 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                        >
                            <i :class="PrimeIcons.SEND" class="mr-2"/>
                            <span class="font-medium">CRUD - аэропорта</span>
                        </RouterLink>
                    </li>
                    <li>
                        <RouterLink
                            to="/admin/flights"
                            v-ripple
                            class="flex items-center cursor-pointer p-3 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                        >
                            <i :class="PrimeIcons.TICKET" class="mr-2"/>
                            <span class="font-medium">CRUD - рейсы</span>
                        </RouterLink>
                    </li>
                </ul>
            </template>
        </Drawer>
    </div>
</template>

<style scoped>
.burger-menu {
    position: relative;
}
</style>
