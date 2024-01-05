import { createRouter , createWebHistory} from 'vue-router';
import Home from '../pages/Home.vue'
import Products from '../pages/Products.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import CreateProduct from '../pages/CreateProduct.vue'
import ProductEdit from '../pages/EditProduct.vue'
import Videos from '../pages/Videos.vue'

const Router = createRouter({
    history: createWebHistory(),
    routes : [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/products',
            name: 'products',
            component: Products
        },
        {
            path: '/products-create',
            name: 'products-create',
            component: CreateProduct
        },
        {
            path: '/products/:id/edit',
            name: 'products-edit',
            component: ProductEdit
        },
        {
            path: '/videos',
            name: 'videos',
            component: Videos
        }
    ]

})

export default Router