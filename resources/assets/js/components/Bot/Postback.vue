<template>
    <div>
        <h3>Postbacks</h3>

        <div v-if="postbacks.data.length > 0">
            <router-link v-for="postback in postbacks.data" class="btn waves-effect waves-light light-green btn-postback"
                :to="{path: '/postback/'+postback.id}">
                <i class="material-icons" v-if="postback.get_started">done_all</i> {{postback.value}}
            </router-link>
        </div>

        <div v-if="postbacks.data.length === 0">
            <div class="card-content white-text">Não existem postbacks</div>
        </div>

        <form @submit.prevent="save()" id="form-new-postback">
            <legend>Novo postback</legend>
            <div class="input-field">
                <input type="text" name="value" id="value" v-model="title" required>
                <label for="value">Indentificação do Postback</label>
            </div>
            <input type="submit" value="+" class="btn">
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                title: ''
            }
        },
        computed: {
            postbacks(){
                return this.$store.state.postback.listPostbacks;
            }
        },
        methods: {
            save(){
                this.$store.dispatch('newPostback', {value: this.title}).then(() => {
                    this.$store.dispatch('getPostbacks');
                    this.title = '';
                });
            }
        },
        mounted(){
            this.$store.dispatch('getPostbacks');
        }
    }
</script>

<style>
    #form-new-postback{
        margin-top: 30px;
    }
    .btn-postback{
        display: block;
        text-align: left;
        margin-bottom: 10px;
    }
</style>