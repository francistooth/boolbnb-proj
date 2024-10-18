<script>

export default {
    name: 'mail',

    data(){
        return{
            email: 'pino@gmail.it',
            message: 'Ciao sono Pino',
        }
    },

    methods: {

    }

}
</script>

<template>

    <form action="#">

        <div>
            <label for="email" class="form-label">Email:</label>
            <input v-model="email" type="email" id="email" class="form-control">
        </div>

        <div>
            <label for="message" class="form-label">Messaggio:</label>
            <textarea v-model="message" rows="8" id="message" class="form-control"></textarea>
        </div>

        <div>
            <button type="submit" class="btn btn-success">Invia</button>
        </div>

    </form>

</template>

<style lang="scss" scoped>

form{
    margin: 50px auto;
    width: 50%;

    div{
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;

        label{
            width: 100%;
            text-align: center;
        }
    }
}

</style>