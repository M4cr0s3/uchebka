import {api} from "../API";

export class CityService {
    static getPopularCities = async () => {
        return (await api('/cities/popular')).data;
    }
}
