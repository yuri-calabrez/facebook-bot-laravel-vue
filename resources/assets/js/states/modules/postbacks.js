const state = {
    listPostbacks:{
        data: []
    },
    postback: {}
};

const mutations = {
    listPostbacks(state, data) {
        state.listPostbacks = data;
    },
    postback(state, data) {
        state.postback = data;
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
    },
    getPostback(context, id) {
        return window.axios.get('api/v1/postbacks/'+id).then(response => {
            context.commit('postback', response.data);
        });
    },
    updatePostback(context, data) {
        return window.axios.put('api/v1/postbacks/'+data.id, data.data);
    },
    removePostback(context, id) {
        return window.axios.delete('api/v1/postbacks/'+id);
    }
};

export default {
    state, mutations, actions
}