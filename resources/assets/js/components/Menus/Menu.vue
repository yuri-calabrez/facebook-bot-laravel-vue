<template>
    <div>
        <h3>Menus do Bot</h3>

        <button class="btn red margin-botton" @click="removeMenu()">Limpar menu no Facebook</button>
        <div v-if="menus.data.length > 0" class="margin-botton row">
            <router-link v-for="menu in menus.data"
                         class="col s12 waves-effect waves-light btn-large light-green margin-botton"
                         :to="{path: 'menu/'+menu.id}">
                {{menu.locale}}
                <small>Campo de mensagem: {{menu.composer_input_disabled ? 'ativado' : 'desativado'}}</small>
            </router-link>
        </div>
        <div v-if="menus.data.length === 0" class="card red">
            <div class="card-content white-text">Não existem menus cadastrados</div>
        </div>

        <form @submit.prevent="save()">
            <legend>Novo menu</legend>
            <div class="row">
                <div class="input-group col s6">
                    <input type="text" placeholder="Locale" v-model="locale" required>
                </div>
                <div class="input-group col s6">
                    <p>
                        <a target="_blank"
                           href="https://developers.facebook.com/docs/messenger-platform/messenger-profile/supported-locales">
                            Clique aqui para ver os locales suportados
                        </a>
                    </p>
                </div>
                <div class="input-group col s12 margin-botton">
                    <input id="composer_input_disabled" type="checkbox" v-model="composer_input_disabled" checked>
                    <label for="composer_input_disabled">Exibir campo de mensagem?</label>
                </div>
                <div class="input-group col s12">
                    <input type="submit" value="+" class="btn">
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import swal from 'sweetalert';
    export default {
        data() {
            return {
                locale: 'default',
                composer_input_disabled: false
            }
        },
        methods: {
            save() {
                let data = {
                    locale: this.locale,
                    composer_input_disabled: this.composer_input_disabled
                };
                this.$store.dispatch('newMenu', data).then(() => {
                    this.$store.dispatch('getMenus');
                    this.locale = 'default';
                    this.composer_input_disabled = true;
                });
            },
            removeMenu(){
                swal(
                    {
                        title: "Removendo TODOS OS MENUS no Facebook!!",
                        text: "Você esta removendo todos os menus no Facebook. Você tera que sincronizar um por um novamente",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Confirmar",
                        cancelButtonText: "Cancelar"
                    },
                    () => {
                        this.$store.dispatch('removeFromFacebook').then(() => {
                            swal('Removido!', 'Removido com sucesso!', 'success');
                            this.$store.dispatch('getMenus');
                        });

                    }
                )
            }
        },
        computed: {
            menus() {
                return this.$store.state.menu.menus;
            }
        },
        mounted() {
            this.$store.dispatch('getMenus');
        }
    }
</script>

<style>
    .margin-botton {
        margin-bottom: 20px;
    }
</style>