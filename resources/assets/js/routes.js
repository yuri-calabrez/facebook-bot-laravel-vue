import Example from './components/Example';

export default [
    {
        path: '/',
        component: Example,
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
        path: '/register',
        component: require('./components/Auth/Register.vue'),
        meta: {
            requireAuth: false
        }
    }
]