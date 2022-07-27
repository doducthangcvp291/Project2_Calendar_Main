import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './components/Login.vue'
import Calendar from './components/Calendar.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: '/',
            component: Calendar ,
            meta: { requiresAuth: true }
        },
        {
            path: '/login',
            component: Login,
            meta: { requiresAuth: false }
        }
    ]
})

export default router
