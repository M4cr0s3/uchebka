import {api} from "../API";

export class AuthService {
    static login = async (body) => {
        return await api.post('/auth/login', body);
    }

    static register = async (body) => {

    }

    static getIsAuth = async () => {
        return await api('/auth/me')
    }
}
