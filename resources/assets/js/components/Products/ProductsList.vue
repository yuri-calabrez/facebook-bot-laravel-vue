<template>
    <div>
        <h3>Meus produtos</h3>
        <div v-if="products.data.length > 0">
            <div class="card horizontal" v-for="product in products.data">
                <div class="card-image">
                    <img :src="product.image_full_url">
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="card-title">{{product.title}}</span>
                        <p>{{product.subtitle}}</p>
                        <p><a :href="product.url" target="_blank" title="Ver produto">{{product.url}}</a></p>
                    </div>
                    <div class="card-action">
                        <a :href="'#/products/'+product.id+'/edit'">Editar</a>
                        <a :href="'#/products/'+product.id+'/remove'">Remover</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card red" v-if="products.data.length === 0">
            <div class="card-content white-text">Não existem produtos</div>
        </div>

        <hr>

        <form enctype="multipart/form-data" @submit.prevent="save()">
            <h5>Novo produto</h5>

            <div v-if="!newProduct">
                <a href="" class="waves-effect waves-light btn" @click.prevent="newProduct = true">+</a>
            </div>

            <div v-if="newProduct">
               <div class="input-field">
                   <input type="text" placeholder="Título" v-model="product.title" required>
               </div>

                <div class="input-field">
                    <input type="text" placeholder="subtitulo" v-model="product.subtitle" required>
                </div>

                <div class="file-field input-field">
                   <div class="btn">
                       <span>File</span>
                       <input type="file" required @change="imageUploader($event)">
                   </div>
                    <div class="file-path-wrapper">
                        <input type="text" class="file-path validate" placeholder="Imagem">
                    </div>
                </div>

                <div class="input-field">
                    <input type="text" placeholder="Link do produto" v-model="product.url" required>
                </div>
                <input type="submit" value="+" class="waves-effect waves-light btn">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                product: {},
                newProduct: false
            }
        },
        methods: {
            save(){
                let formData = new FormData();
                formData.append('title', this.product.title);
                formData.append('subtitle', this.product.subtitle);
                formData.append('image_url', this.product.image_url);
                formData.append('url', this.product.url);

                this.$store.dispatch('newProduct', formData).then(() => {
                    this.$store.dispatch('getProducts');
                    this.product = {};
                    this.newProduct = false;
                })
            },
            imageUploader($event){
                if($event.target.files.length > 0) {
                    this.product.image_url = $event.target.files[0];
                }
            }
        },
        computed:{
            products(){
                return this.$store.state.product.products;
            }
        },
        mounted(){
            this.$store.dispatch('getProducts');
        }
    }
</script>