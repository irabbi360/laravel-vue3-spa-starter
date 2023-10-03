import './bootstrap';

import { createApp } from 'vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import store from './store'
import router from './routes/index'
import VueSweetalert2 from "vue-sweetalert2";
import { abilitiesPlugin } from '@casl/vue';
import ability from './services/ability';
import vSelect from "vue-select";
import useAuth from './composables/auth';
import i18n from "./plugins/i18n";

import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue-select/dist/vue-select.css';

const app = createApp({
    created() {
        useAuth().getUser()
    }
});

import ExampleComponent from './components/ExampleComponent.vue';

app.component('example-component', ExampleComponent);


app.use(router)
app.use(store)
app.use(VueSweetalert2)
app.use(i18n)
app.use(abilitiesPlugin, ability)
app.component('Pagination', Bootstrap5Pagination)
app.component("v-select", vSelect);
app.mount('#app')
