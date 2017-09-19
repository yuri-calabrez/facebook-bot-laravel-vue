const state = {
    listPostbacks: []
};

const mutations = {
    listPostbacks(state, data) {
        state.listPostbacks = data;
    }
};

const actions = {
    getPostbacks(context) {
        return window.axios.get('/postbacks').then(response => {
            context.commit('listPostbacks', response.data);
        });
    }
};

export default {
    state, mutations, actions
}