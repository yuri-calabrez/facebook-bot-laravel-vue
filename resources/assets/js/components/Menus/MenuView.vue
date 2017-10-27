<template>
    <div>
        <h3>
            <small>Menu:</small>
            {{menu.locale}}
        </h3>

        <p>
            <router-link :to="{path: '/menus'}" class="btn">Voltar</router-link>
            <a href="" @click.prevent="sendToFacebook()" class="btn green">Sincronizar</a>
            <a href="" @click.prevent="remove()" class="btn red">Remover</a>
        </p>

        <div v-if="menu.menu_buttons.length > 0">
            <div v-for="menu_buttons in menu.menu_buttons" v-if="menu_buttons.parent_id == 0">
                <div class="waves-effect waves-light btn-large grey" style="margin-bottom: 10px;">
                    {{menu_buttons.title}}
                    <small>{{menu_buttons.type | menu_types}} {{menu_buttons.value}}</small>
                </div>
                <div class="waves-effect waves-light btn-large grey child"
                     v-for="child_menu_buttons in menu.menu_buttons"
                     v-if="child_menu_buttons.parent_id == menu_buttons.id">
                    {{child_menu_buttons.title}}
                    <small>{{child_menu_buttons.type | menu_types}} {{child_menu_buttons.value}}</small>
                </div>
            </div>
        </div>

        <div class="card red" v-if="menu.menu_buttons.length === 0">
            <div class="card-content white-text">
                Nenhum botão cadastrado
            </div>
        </div>

        <form @submit.prevent="createMenu()" id="addButton" class="gray lighten-5">
            <strong>Novo botão::</strong>
            <div class="input-filter s12">
                <select required v-model="newButton.type" class="browser-default">
                    <option value="" disabled>Tipo do botão</option>
                    <option value="nested">Aninhado</option>
                    <option value="postback">Postback</option>
                    <option value="web_url">Link</option>
                </select>
            </div>

            <div class="input-field s6">
                <input type="text" v-model="newButton.title" required maxlength="20">
                <label class="active">Título</label>
            </div>

            <div class="input-field s6" v-if="newButton.type === 'postback'">
                <input type="text" v-model="newButton.value" required maxlength="20">
                <label class="active">Postback destino</label>
            </div>

            <div class="input-field s6" v-if="newButton.type === 'web_url'">
                <input type="text" v-model="newButton.value" required>
                <label class="active">Link</label>
            </div>

            <div class="input-filter s12" style="margin-bottom: 20px;">
                <select required class="browser-default" v-model="newButton.parent_id">
                    <option value="" disabled>Botão pai</option>
                    <option value="0">Nenhum</option>
                    <option v-for="menu_buttons in menu.menu_buttons" :value="menu_buttons.id">{{menu_buttons.title}}
                    </option>
                </select>
            </div>

            <input type="submit" value="+" class="btn">
        </form>
    </div>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        data() {
            return {
                newButton: {
                    type: "",
                    parent_id: ""
                }
            }
        },
        methods: {
            createMenu() {
                let data = {
                    type: this.newButton.type,
                    title: this.newButton.title,
                    menu_id: this.$route.params.id,
                    parent_id: this.newButton.parent_id,
                };

                if (this.newButton.value) {
                    data.value = this.newButton.value;
                }
                if(!data.parent_id) {
                    data.parent_id = 0;
                }
                this.$store.dispatch('newMenuButton', data).then(() => {
                    let params = {
                        id: this.$route.params.id,
                        data: {
                            facebook_diff: true
                        }
                    };
                    this.newButton.title = "";
                    this.newButton.value = "";

                    this.$store.dispatch("updateMenu", params).then(() => {
                        this.$store.dispatch('getMenu', this.$route.params.id);
                    })
                })
            },
            remove(){
                swal(
                    {
                        title: "Removendo!!",
                        text: "Deseja realmente remover este menu? Você não podera defazer esta ação",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Confirmar",
                        cancelButtonText: "Cancelar"
                    },
                    () => {
                        this.$store.dispatch('removeMenu', this.$route.params.id).then(() => {
                            swal('Removido!', 'Removido com sucesso!', 'success');
                            this.$router.push('/menus');
                        });

                    }
                )
            },
            sendToFacebook(){
                this.$store.dispatch('sendToFacebook', this.$route.params.id).then(() => {
                    swal('Sincronizado!', 'O menu foi enviado para o Facebook!', 'success');
                })
            }
        },
        filters: {
            menu_types(value){
                if(value === 'nested') {
                    return 'Aninhado';
                }
                if(value === 'postback') {
                    return 'Postback';
                }
                if(value === 'web_url') {
                    return 'Link';
                }
            }
        },
        computed: {
            menu() {
                let menu = this.$store.state.menu.menu;
                return menu.menu_buttons ? menu : {menu_buttons: []};
            }
        },
        mounted() {
            this.$store.dispatch('getMenu', this.$route.params.id);
        }
    }
</script>

<style>
    #addButton {
        margin-top: 40px;
        padding: 10px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
    }

    .child.btn-large {
        margin-left: 30px;
    }
</style>