
import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});
import PreBookComponent from './components/PreBookComponent.vue';
app.component('pre-book-component', PreBookComponent);
app.mount('#app');
