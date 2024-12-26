import './bootstrap';
import {createApp} from "vue";
import App from "../App.vue";
import {router} from "../router";
import PrimeVue from 'primevue/config'
import Aura from '@primevue/themes/aura'
import Ripple from 'primevue/ripple';
import 'primeicons/primeicons.css'
import {createPinia} from "pinia";

const pinia = createPinia();
const app = createApp(App);

app.use(pinia);
app.use(router);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            darkModeSelector: false,
        },
    },
    ripple: true
});

app.directive('ripple', Ripple)


app.mount('#app');
