import {defineStore} from "pinia";
import {AuthService} from "../Services";
import {api} from "../API";

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuth: false,
        role: '',
    }),
    actions: {
        async register(credentials) {
            return await api.post('/auth/register', credentials);
        },
        async login(credentials) {
            return AuthService.login(credentials)
        },
        async getIsAuth() {
            return AuthService.getIsAuth()
        },
        async logout() {
            return await api('/auth/logout');
        },
    }
})
