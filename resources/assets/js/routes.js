import Example from './components/Example';

export default [
    {
        path: '/',
        component: Example,
        meta: {
            requireAuth: false
        }
    },
    {
        path: '/login',
        component: require('./components/Login.vue'),
        meta: {
            requireAuth: false
        }
    }
]