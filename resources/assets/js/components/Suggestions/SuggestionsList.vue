<template>
    <div>
        <h3>Sugestões</h3>
        <table class="bordered">
            <thead>
            <tr>
                <th>Sugestões</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="data in suggestions.data">
                <td>{{data.suggestion}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                suggestions: {
                    data: []
                }
            }
        },
        mounted(){
            window.axios.get('api/v1/suggestions').then(response => {
                this.suggestions = response.data;
            });
        }
    }
</script>