const state = {
    menus:{
        data: []
    },
    menu: {}
};

const mutations = {
    menus(state, data) {
        state.menus = data;
    },
    menu(state, data) {
        state.menu = data;
    }
};

const actions = {
    getMenus(context) {
        return window.axios.get('api/v1/menus').then(response => {
            context.commit('menus', response.data);
            return response;
        });
    },
    newMenu(context, data) {
        return window.axios.post('api/v1/menus', data);
    },
    getMenu(context, id) {
        return window.axios.get('api/v1/menus/'+id).then(response => {
            context.commit('menu', response.data);
        });
    },
    updateMenu(context, data) {
        return window.axios.put('api/v1/menus/'+data.id, data.data);
    },
    removeMenu(context, id) {
        return window.axios.delete('api/v1/menus/'+id);
    },
    setToFacebook(context, id) {
        return window.axios.get('api/v1/menus/set-menu/'+id);
    },
    removeToFacebook(context) {
        return window.axios.get('api/v1/menus/remove-menu');
    }
};

export default {
    state, mutations, actions
}