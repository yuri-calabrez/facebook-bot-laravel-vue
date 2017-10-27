const state = {
    menuButtons:{
        data: []
    },
    menuButton: {}
};

const mutations = {
    menuButtons(state, data) {
        state.menuButtons = data;
    },
    menuButton(state, data) {
        state.menuButton = data;
    }
};

const actions = {
    getmenuButtons(context) {
        return window.axios.get('api/v1/menu-buttons').then(response => {
            context.commit('menuButtons', response.data);
        });
    },
    newMenuButton(context, data) {
        return window.axios.post('api/v1/menu-buttons', data);
    },
    getMenuButton(context, id) {
        return window.axios.get('api/v1/menu-buttons/'+id).then(response => {
            context.commit('menuButton', response.data);
        });
    },
    updateMenuButton(context, data) {
        return window.axios.post('api/v1/menu-buttons/'+data.id, data.data);
    },
    removeMenuButton(context, id) {
        return window.axios.delete('api/v1/menu-buttons/'+id);
    }
};

export default {
    state, mutations, actions
}