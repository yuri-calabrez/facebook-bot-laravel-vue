<template>
    <div class="row">
        <div class="col s8 push-s2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Cadastre-se</span>

                    <form @submit.prevent="register()">
                        <div class="input-field">
                            <label for="name">Nome</label>
                            <input id="name" type="text" name="name" required autofocus v-model="credentials.name">
                        </div>
                        <div class="input-field">
                            <label for="email">E-mail</label>
                            <input id="email" type="email" name="email" required v-model="credentials.email">
                        </div>

                        <div class="input-field">
                            <label for="password">Senha</label>
                            <input id="password" type="password" name="password" required
                                   v-model="credentials.password">
                        </div>

                        <div class="input-field">
                            <label for="password_confirmation">Confirmar senha</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   v-model="credentials.password_confirmation">
                        </div>

                        <button class="btn" type="submit">Cadastre-se</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        data() {
            return {
                credentials: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }
            }
        },
        methods: {
            register() {
                window.axios.post('/register', this.credentials)
                    .then((response) => {
                        if(this.credentials.password !== this.credentials.password_confirmation){
                            swal('Verifique a senha', 'As senhas não conferem', 'error');
                            return;
                        }
                        if (response.data.status === 'success') {
                            swal('Cadastrado com sucesso!', 'Redirecionando para o painel', 'success');
                            this.$router.push({path: '/'});
                        } else {
                            let validation = '<ul>';
                            if(response.data.email && response.data.email[0] === 'The email has already been taken.') {
                                validation += '<li>Este e-mail ja existe.</li>';
                            }
                            validation += '</ul>';
                            swal({
                                title: 'Falha ao cadastrar',
                                text: validation,
                                type: 'error',
                                html: true
                            });
                        }
                    }).catch(() => {
                        swal('Falha ao cadastrar', 'Erro no servidor.', 'error');
                    });
            }
        }
    }
</script>