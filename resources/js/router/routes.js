function page(path) {
    return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
    {path: '/', name: 'home', component: page('home.vue')},
    {path: '/temperature', name: 'temperature', component: page('temperature.vue')},
    {path: '/light', name: 'light', component: page('light.vue')},
    {path: '/sound', name: 'sound', component: page('sound.vue')},
    {path: "/login", name: "login", component:page("login.vue")}
]
