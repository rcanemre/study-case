import { createRouter, createWebHistory } from "vue-router";

//pages
import login from '../components/auth/login.vue'
import register from '../components/auth/register.vue'
import dashboard from '../components/pages/dashboard/index.vue'
import keys from '../components/pages/dashboard/keys/index.vue'
import data from '../components/pages/dashboard/data/index.vue'
import home from '../components/pages/home/index.vue'
import notFound from '../components/notFound.vue'

const routes = [
    { path: '/', name: 'home', component: home, meta: { requiresAuth: false } },
    { path: '/login', name: 'login', component: login, meta: { requiresAuth: false } },
    { path: '/register', name: 'register', component: register, meta: { requiresAuth: false } },
    { path: '/dashboard', name: 'dashboard', component: dashboard, meta: { requiresAuth: true } },
    { path: '/dashboard/keys', name: 'keys', component: keys, meta: { requiresAuth: true } },
    { path: '/dashboard/data', name: 'data', component: data, meta: { requiresAuth: true } },
    { path: '/:pathMatch(.*)*', name: 'notFound', component: notFound }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to,from) => {
    //home is not auth required
    if(to.name === 'home') {
        return
    }

    if(to.meta.requiresAuth && !localStorage.getItem('token')) {
        return { name: 'login' }
    }

    if(!to.meta.requiresAuth && localStorage.getItem('token')) {
        return { name: 'dashboard' }
    }
})

export default router
