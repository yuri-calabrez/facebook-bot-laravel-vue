<template>
    <div>
        <h3>Postback: {{postback.value}}</h3>
        <p>
            <router-link :to="{path: '/'}" class="btn">Voltar</router-link>
            <a href="#" @click.prevent="addGetStartedButton()" v-if="!postback.get_started"
               class="btn green">definir como botão começar</a>
            <a href="#" @click.prevent="removeGetStartedButton()" v-if="postback.get_started"
               class="btn green">remover botão começar</a>
            <a href="#" @click.prevent="showEditForm = !showEditForm" class="btn blue">Editar</a>
            <a href="#" @click.prevent="remove()" class="btn red">Remover</a>
        </p>
        <br>
        <form @submit.prevent="save()" id="form-new-postback" v-if="showEditForm">
            <div class="input-field">
                <input type="text" name="value" id="value" v-model="postback.value" required>
                <label for="value" class="active">Indentificação do Postback</label>
            </div>
            <input type="submit" value="Atualizar" class="btn">
        </form>

    </div>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        data(){
          return {
              showEditForm: false
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
            }
        },
        mounted(){
            let id = this.$route.params.id;
            this.$store.dispatch('getPostback', id);
        }
    }
</script>