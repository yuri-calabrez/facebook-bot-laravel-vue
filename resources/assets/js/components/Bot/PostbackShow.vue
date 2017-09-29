<template>
    <div>
        <h3>Postback: {{postback.value}}</h3>
        <form @submit.prevent="save()" id="form-new-postback" v-if="showEditForm">
            <div class="input-field">
                <input type="text" name="value" id="value" v-model="postback.value" required>
                <label for="value" class="active">Indentificação do Postback</label>
            </div>
            <input type="submit" value="Atualizar" class="btn">
        </form>
        <br>
        <p>
            <router-link :to="{path: '/'}" class="btn">Voltar</router-link>
            <a href="#" @click.prevent="addGetStartedButton()" v-if="!postback.get_started"
               class="btn green">definir como botão começar</a>
            <a href="#" @click.prevent="removeGetStartedButton()" v-if="postback.get_started"
               class="btn green">remover botão começar</a>
            <a href="#" @click.prevent="showEditForm = !showEditForm" class="btn blue">Editar</a>
            <a href="#" @click.prevent="remove()" class="btn red">Remover</a>
        </p>

        <message v-for="message in postback.messages" :message-data="message"></message>

        <div class="card light-green">
            <div class="card-content">
                <form @submit.prevent="newMessage()">
                    <h5 class="white-text">Nova mensagem</h5>
                    <div class="input-filter">
                        <select class="browser-default" required v-model="dataToSave.type">
                            <option value="" disabled>Tipo da mensagem</option>
                            <optgroup label="Mensagem">
                                <option value="text">Texto</option>
                                <option value="file">Arquivo</option>
                                <option value="audio">Audio</option>
                                <option value="image">Imagem</option>
                                <option value="video">Vídeo</option>
                            </optgroup>
                            <optgroup label="Mensagem">
                                <option value="buttons">Botões</option>
                            </optgroup>
                        </select>
                    </div>

                    <div id="message-field" class="input-field">
                        <input type="text" required v-model="dataToSave.message">
                        <label>Mensagem</label>
                    </div>
                    <input id="messageSaveBtn" type="submit" value="+" class="btn blue">
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    import Message from './Message';
    import swal from 'sweetalert';

    export default {
        components: {
          'message': Message
        },
        data(){
          return {
              showEditForm: false,
              dataToSave: {type: ''}
          }
        },
        computed: {
            postback(){
                return this.$store.state.postback.postback;
            }
        },
        methods: {
            save(){
                let data = {
                    id: this.$route.params.id,
                    data: {
                        value: this.postback.value
                    }
                };

                this.$store.dispatch('updatePostback', data).then(() => {
                    swal('Salvo com sucesso!', 'O bot ja deve responder a este postback!', 'success');
                    this.showEditForm = false;
                });
            },
            remove(){
                swal(
                    {
                        title: "Removendo!!",
                        text: "Deseja realmente remover este postback? Você não podera sefazer esta ação",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Confirmar",
                        cancelButtonText: "Cancelar"
                    },
                    () => {
                        this.$store.dispatch('removePostback', this.$route.params.id).then(() => {
                            swal('Removido!', 'Removido com sucesso!', 'success');
                            this.$router.push('/');
                        });

                    }
                )
            },
            addGetStartedButton(){
                swal(
                    {
                        title: "Botão começar!!",
                        text: "Você tem certeza que quer definir este postback como ação do botão começar?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Sim",
                        cancelButtonText: "Não"
                    },
                    () => {
                        this.$store.dispatch('addGetStarted', this.$route.params.id).then(() => {
                            swal('Processo concluído!', 'Botão começar vai responder a este postback', 'success');
                            let id = this.$route.params.id;
                            this.$store.dispatch('getPostback', id);
                        });

                    }
                )
            },
            removeGetStartedButton(){
                swal(
                    {
                        title: "Removendo botão começar!!",
                        text: "Você esta desativando o botão começar",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Sim",
                        cancelButtonText: "Não"
                    },
                    () => {
                        this.$store.dispatch('removeGetStarted').then((res) => {
                            let err = res.data.error || null;
                            if(err) {
                                let message = 'Ocorreu algo inesperado';
                                if(err.code === 100){
                                    message = 'Você precisa manter o botão começar, ele é necessario para a exibiçãodo menu. Remova o menu primeiro';
                                }
                                swal('Erro', message, 'error');

                            } else {
                                swal('Botão começar desativado!', '', 'success');
                            }

                            let id = this.$route.params.id;
                            this.$store.dispatch('getPostback', id);
                        });

                    }
                )
            },
            newMessage(){
                let $ = window.jQuery;
                $('#messageSaveBtn').val('Aguarde...').attr('disabled', true);

                let data = {
                    type: this.dataToSave.type || 'text',
                    message: this.dataToSave.message,
                    template: false,
                    postback_id: this.$route.params.id
                };

                let messagesType = [
                    'text',
                    'file',
                    'audio',
                    'image',
                    'video',
                ];

                if(messagesType.indexOf(data.type) === -1) {
                    data.template = true;
                }
                this.$store.dispatch('newMessage', data).then(() => {
                    $('#messageSaveBtn').val('+').attr('disabled', false);
                    swal('Salvo com sucesso!', 'O bot ja deve responder com a sua mensagem!', 'success');
                    this.dataToSave = {type: 'text'};
                    this.$store.dispatch('getPostback', this.$route.params.id);
                });

            }
        },
        mounted(){
            let id = this.$route.params.id;
            this.$store.dispatch('getPostback', id);
        }
    }
</script>

<style>
    #message-field{
        background-color: rgba(255, 255, 255, 0.9);
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 2px;
    }

    #message-field input{
        margin-bottom: 0;
        border-bottom: none;
    }

    #message-field label{
        left: 10px;
    }
</style>