import { createApp } from 'vue'
import axios from 'axios';
import App from './App.vue';
import router from './router';
import store from './store'

import VueVideoPlayer from '@videojs-player/vue'
import 'video.js/dist/video-js.css'


window.axios = axios;

let token = localStorage.getItem('access_token') ?? null;
window.axios.create({
    baseURL: 'http://127.0.0.1:8000',
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
if(token != null) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}` ;
}



createApp(App)
.use(VueVideoPlayer)
.use(router)
.use(store)
.mount('#app')