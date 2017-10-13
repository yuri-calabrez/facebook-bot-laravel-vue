const state = {
    messages:{
        data: []
    },
    message: {}
};

const mutations = {
    messages(state, data) {
        state.messages = data;
    },
    message(state, data) {
        state.message = data;
    }
};

const actions = {
    getMessages(context) {
        return window.axios.get('api/v1/messages').then(response => {
            context.commit('messages', response.data);
        });
    },
    newMessage(context, data) {
        return window.axios.post('api/v1/messages', data);
    },
    getMessage(context, id) {
        return window.axios.get('api/v1/messages/'+id).then(response => {
            context.commit('message', response.data);
        });
    },
    updateMessage(context, data) {
        return window.axios.put('api/v1/messages/'+data.id, data.data);
    },
    removeMessage(context, id) {
        return window.axios.delete('api/v1/messages/'+id);
    },
    setMessageProduct(context, params){
        return window.axios.post('api/v1/messages/'+params.id+'/product', {product_id: params.product_id});
    },
    getMessageProduct(context, id) {
        return window.axios.get('api/v1/messages/'+id+'/product');
    },
    removeMessageProduct(context, params){
        return window.axios.delete('api/v1/messages/'+params.id+'/product/'+params.product_id);
    }
};

export default {
    state, mutations, actions
}