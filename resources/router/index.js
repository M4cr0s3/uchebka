import {createRouter, createWebHistory} from "vue-router";
import {ROUTES} from "./routes.js";
import {useAuthStore} from "../Stores/index.js";

const routes = [
    {
        path: ROUTES.HOME,
        name: 'home',
        component: () => import('../Pages/Index.vue'),
        meta: {
            isAuth: false,
        },
    },
    {
        path: ROUTES.REGISTER,
        name: 'register',
        component: () => import('../Pages/Register.vue'),
        meta: {
            isAuth: false,
        },
    },
    {
        path: ROUTES.LOGIN,
        name: 'login',
        component: () => import('../Pages/Login.vue'),
        meta: {
            isAuth: false,
        },
    },
    {
        path: ROUTES.FLIGHTS,
        name: 'flights',
        component: () => import('../Pages/Flights.vue'),
        meta: {
            isAuth: false,
        },
    },
    {
        path: ROUTES.SEAT_SELECT,
        name: 'seat_select',
        component: () => import('../Pages/SeatSelect.vue'),
        meta: {
            isAuth: true,
        }
    },
    {
        path: ROUTES.ADMIN_CITIES,
        name: 'admin_cities',
        component: () => import('../Pages/City/Index.vue'),
        meta: {
            isAuth: true,
        },

    },
    {
        path: '/admin/cities/create',
        name: 'admin_city_create',
        component: () => import('../Pages/City/Create.vue'),
        meta: {
            isAuth: true,
        }
    },
    {
        path: '/admin/cities/:id/edit',
        name: 'admin_city_edit',
        component: () => import('../Pages/City/Edit.vue'),
        meta: {
            isAuth: true,
        }
    },
    {
        path: '/admin/airports',
        name: 'admin_airports',
        component: () => import('../Pages/Airport/Index.vue'),
        meta: {
            isAuth: true,
        }
    },
    {
        path: '/admin/planes',
        name: 'admin_planes',
        component: () => import('../Pages/Plane/Index.vue'),
        meta: {
            isAuth: true,
        }
    },
    {
        path: '/admin/flights',
        name: 'admin_flights',
        component: () => import('../Pages/Flight/Index.vue'),
        meta: {
            isAuth: true,
        }
    },
    {
        path: '/admin/users',
        name: 'admin_users',
        component: () => import('../Pages/Users/Index.vue'),
        meta: {
            isAuth: true,
        }
    }
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    try {
        const response = await authStore.getIsAuth();
        if (response.data.isAuth) {
            authStore.isAuth = true;
            authStore.role = response.data.role
        }
    } catch (e) {
    }

    if ((to.path === ROUTES.LOGIN || to.path === ROUTES.REGISTER) && authStore.isAuth) {
        return next({path: ROUTES.HOME})
    } else if (to.meta.isAuth && !authStore.isAuth) {
        return next({path: ROUTES.LOGIN})
    }

    return next()
})
