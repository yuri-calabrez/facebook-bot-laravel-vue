export default [
    {
        path: '/',
        component: require('./components/Bot/Postback.vue'),
        meta: {
            requireAuth: true
        }
    },
    {
        path: '/postback/:id',
        component: require('./components/Bot/PostbackShow.vue'),
        meta: {
            requireAuth: true
        }
    },
    {
        path: '/products',
        component: require('./components/Products/ProductsList'),
        meta: {
            requireAuth: true
        }
    },
    {
        path: '/products/:id/edit',
        component: require('./components/Products/ProductsEdit'),
        meta: {
            requireAuth: true
        }
    },
    {
        path: '/products/:id/remove',
        component: require('./components/Products/ProductsRemove'),
        meta: {
            requireAuth: true
        }
    },
    {
        path: '/suggestions',
        component: require('./components/Suggestions/SuggestionsList'),
        meta: {
            requireAuth: true
        }
    },
    {
        path: '/menus',
        component: require('./components/Menus/Menu'),
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
    },
]