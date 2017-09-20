const state = {
    listPostbacks:{
        data: []
    }
};

const mutations = {
    listPostbacks(state, data) {
        state.listPostbacks = data;
    }
};

const actions = {
    getPostbacks(context) {
        return window.axios.get('api/v1/postbacks').then(response => {
            context.commit('listPostbacks', response.data);
        });
    },
    newPostback(context, data) {
        return window.axios.post('api/v1/postbacks', data);
    }
};

export default {
    state, mutations, actions
}