<template>
    <div>
        <div v-if="elements.data.length > 0">
            <strong>Botões:</strong>
            <div v-for="element in elements.data" class="chip">
                {{element.title}} - postback: {{element.postback}}

                <a href="#" @click.prevent="removeButton(element.id)" class="btn-floating red">
                    <i class="material-icons">close</i>
                </a>
            </div>
        </div>
        <div v-if="elements.data.length === 0" class="card red">
            <div class="card-content white-text">Não existem botões</div>
        </div>

        <form class="grey lighten-4" id="button-add" @submit.prevent="newButton()">
            <p><strong>Novo botão</strong></p>
            <div class="input-filter inline">
                <select class="browser-default" required v-model="dataToSave.type">
                    <option value="" disabled selected>Escolha o tipo do botão</option>
                    <option value="postback">Postback</option>
                    <option value="web_url">Link</option>
                    <option value="web_url_compact">Web view compacta</option>
                    <option value="web_url_tall">Web view alta</option>
                    <option value="web_url_full">Web view completa</option>
                </select>
            </div>

            <div class="input-field inline">
                <input type="text" placeholder="Título do botão" v-model="dataToSave.title" required maxlength="20">
                <label class="active">Título</label>
            </div>
            <div class="input-field inline">
                <input type="text" placeholder="Qual postback.." v-model="dataToSave.postback" required>
                <label class="active">Destino</label>
            </div>
            <input type="submit" value="+" id="elementSaveBtn" class="btn">
        </form>
    </div>
</template>

<script>
    export default {
        props: ['messageData'],
        data() {
            return {
                message: this.messageData,
                dataToSave: {
                    type: ''
                },
                elements: {
                    data: []
                }
            }
        },
        methods: {
            newButton() {
                let data = {
                    type: this.dataToSave.type,
                    title: this.dataToSave.title,
                    postback: this.dataToSave.postback,
                    message_id: this.message.id
                };

                if (data.type === 'web_url_compact') {
                    data.type = 'web_url';
                    data.webview_height_ratio = 'compact';
                }

                if (data.type === 'web_url_tall') {
                    data.type = 'web_url';
                    data.webview_height_ratio = 'tall';
                }

                if (data.type === 'web_url_full') {
                    data.type = 'web_url';
                    data.webview_height_ratio = 'full';
                }

                this.$store.dispatch('newElement', data).then(() => {
                    this.dataToSave = {type: ''};
                    this.$store.dispatch('getElements', this.message.id).then((response) => {
                        this.elements = response.data;
                    });
                });
            },
            removeButton(id) {
                this.$store.dispatch('removeElement', id).then(() => {
                    this.$store.dispatch('getElements', this.message.id).then((response) => {
                        this.elements = response.data;
                    });
                });
            }
        },
        mounted() {
            this.$store.dispatch('getElements', this.message.id).then((response) => {
                this.elements = response.data;
            });
        }
    }
</script>

<style>
    #button-add {
        margin-top: 10px;
        padding: 10px;
        border-radius: 2px;
    }

    .btn-floating {
        width: 20px;
        height: 20px;
        line-height: 20px;
    }

    .btn-floating i {
        font-size: 15px;
        line-height: 20px;
    }
</style>