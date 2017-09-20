
export default [
{
    path: '/',
    component: require('./components/Bot/Postback.vue'),
    meta: {
        requireAuth: true
    }
},
{
    path: '/login',
    component: require('./components/Auth/Login.vue'),
    meta: {
        requireAuth: false
    }
},
{
    path: '/cadastro',
    component: require('./components/Auth/Register.vue'),
    meta: {
        requireAuth: false
    }
}
]