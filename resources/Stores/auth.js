import {defineStore} from "pinia";
import {AuthService} from "../Services";
import {api} from "../API";

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuth: false,
        role: '',
    }),
    actions: {
        async login(credentials) {
            return AuthService.login(credentials)
        },
        async getIsAuth() {
            return AuthService.getIsAuth()
        },
        async logout() {
            return await api('/auth/logout');
        }
    }
})
