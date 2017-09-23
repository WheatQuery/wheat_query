import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: "index",
            path: '/home',
            component: resolve =>void(require(['./Home.vue'], resolve))
        },
    ]
})