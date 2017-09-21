<template>
    <div>
        <h3>Postback: {{postback.value}}</h3>
        <p>
            <router-link :to="{path: '/'}" class="btn">Voltar</router-link>
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
            }
        },
        mounted(){
            let id = this.$route.params.id;
            this.$store.dispatch('getPostback', id);
        }
    }
</script>