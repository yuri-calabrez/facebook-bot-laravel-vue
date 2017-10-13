<template>
    <div>
        <div v-if="products.length > 0">
            <div v-for="product in products" class="chip">
                {{product.title}}
                <a href="#" class="btn-floating red" @click.prevent="removeProduct(product.id)">
                    <i class="material-icons">close</i>
                </a>
            </div>
        </div>
        <div v-if="products.length === 0">
            <div class="card red">
                <div class="card-content white-text">Não existem produtos</div>
            </div>

        </div>

        <form class="grey lighten-4" @submit.prevent="newProduct()" id="formProduct">
            <strong>Novo produto</strong>
            <div class="input-filter">
                <select class="browser-default" v-model="newProductData" style="margin-bottom: 20px;">
                    <option value="" disabled selected>Escolha um produto</option>
                    <option v-for="product in productsList.data" :value="product">{{product.title}}</option>
                </select>
            </div>
            <input type="submit" value="+" id="elementSaveBtn" class="btn">
        </form>
    </div>
</template>

<script>
    export default {
        props: ['messageData'],
        data(){
          return {
              message: this.messageData,
              dataToSave: {},
              newProductData: {},
              products: []
          }
        },
        methods: {
            newProduct(){
                let data = {
                    id: this.message.id,
                    product_id: this.newProductData.id
                };
                this.$store.dispatch('setMessageProduct', data).then(() => {
                    this.$store.dispatch('getMessageProduct', this.message.id).then((res) => {
                        this.products = res.data;
                        this.newProductData = '';
                    });
                });
            },
            removeProduct(productId){
                let data = {
                    id: this.message.id,
                    product_id: productId
                };
                this.$store.dispatch('removeMessageProduct', data).then(() => {
                    this.$store.dispatch('getMessageProduct', this.message.id).then((res) => {
                        this.products = res.data;
                    });
                })
            }
        },
        computed: {
            productsList(){
                return this.$store.state.product.products;
            }
        },
        mounted(){
            this.$store.dispatch('getProducts');
            this.$store.dispatch('getMessageProduct', this.message.id).then((res) => {
                this.products = res.data;
            });
        }
    }
</script>

<style>
    #formProduct{
        margin-top: 40px;
        padding: 10px;
        border-radius: 2px;
    }
</style>