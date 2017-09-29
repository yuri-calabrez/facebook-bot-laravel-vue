const state = {
    elements:{
        data: []
    },
    element: {}
};

const mutations = {
    elements(state, data) {
        state.elements = data;
    },
    element(state, data) {
        state.element = data;
    }
};

const actions = {
    getElements(context, id) {
        return window.axios.get('api/v1/elements?where[message_id='+id+']').then(response => {
            context.commit('elements', response.data);
            return response;
        });
    },
    newElement(context, data) {
        return window.axios.post('api/v1/elements', data);
    },
    getElement(context, id) {
        return window.axios.get('api/v1/elements/'+id).then(response => {
            context.commit('element', response.data);
        });
    },
    updateElement(context, data) {
        return window.axios.put('api/v1/elements/'+data.id, data.data);
    },
    removeElement(context, id) {
        return window.axios.delete('api/v1/elements/'+id);
    }
};

export default {
    state, mutations, actions
}