/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';

window.axios = axios;

let token = localStorage.getItem('access_token') ?? null;

window.axios.create({
    baseURL: 'http://127.0.0.1:8000',
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}` ;
