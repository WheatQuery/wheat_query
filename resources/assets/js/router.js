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
        {

            name:'add',
            path:'/add',
            component: resolve =>void(require(['./admin/add.vue'], resolve))
        },
        {
            name: "query",
            path: '/query',
            component: resolve =>void(require(['./admin/Query.vue'], resolve))
        },
        {

            name:'repass',
            path:'/repass',
            component: resolve =>void(require(['./admin/repassword.vue'], resolve))
        },
    ]
})