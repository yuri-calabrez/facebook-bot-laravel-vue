require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);

const router = new VueRouter({
	routes
});

router.beforeEach((to, from, next) => {
	let requiresAuth = to.meta.requireAuth || false;
	if(requiresAuth) {
		return window.axios.get('/api/v1/users/me').then((res) => {
			if(res.data.id === undefined) {
                return next({path: 'login'})
			}
            return next();
		});
	}
	return next();
});

const app = new Vue({
	el: '#app',
	template: '<div class="container"><router-view></router-view></div>',
	router
});
