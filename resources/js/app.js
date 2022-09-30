import './bootstrap';

import { createApp, onMounted } from 'vue';
import LaravelVuePagination from 'laravel-vue-pagination';
import router from './routes/index'
import VueSweetalert2 from "vue-sweetalert2";
import useAuth from "./composables/auth";
import { abilitiesPlugin } from '@casl/vue';
import ability from './services/ability';
import Select2 from 'vue3-select2-component';


const app = createApp({
    setup() {
        const { getUser } = useAuth()
        onMounted(getUser)
    }
});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);


app.use(router)
app.use(VueSweetalert2)
app.use(abilitiesPlugin, ability)
app.component('Pagination', LaravelVuePagination)
app.component('Select2', Select2)
app.mount('#app')
