import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: "index",
            path: '/',
            component: resolve =>void(require(['./Home.vue'], resolve))
        },
        {
            name: "import",
            path: '/import',
            component: resolve =>void(require(['./admin/Import.vue'], resolve))
        },
    ]
})