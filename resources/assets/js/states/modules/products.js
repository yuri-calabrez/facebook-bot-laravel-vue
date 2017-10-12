const state = {
    products:{
        data: []
    },
    product: {}
};

const mutations = {
    products(state, data) {
        state.products = data;
    },
    product(state, data) {
        state.product = data;
    }
};

const actions = {
    getProducts(context) {
        return window.axios.get('api/v1/products').then(response => {
            context.commit('products', response.data);
        });
    },
    newProduct(context, data) {
        return window.axios.post('api/v1/products', data, {headers: {"content-type": "multipart/form-data"}});
    },
    getProduct(context, id) {
        return window.axios.get('api/v1/products/'+id).then(response => {
            context.commit('product', response.data);
        });
    },
    updateProduct(context, data) {
        return window.axios.post('api/v1/products/'+data.id, data.data, {headers: {"content-type": "multipart/form-data"}});
    },
    removeProduct(context, id) {
        return window.axios.delete('api/v1/products/'+id);
    }
};

export default {
    state, mutations, actions
}