import {api} from "../API";

export class GeoService {
    static getUserLocation = async () => {
        return (await api('/geo/user')).data;
    }
}
