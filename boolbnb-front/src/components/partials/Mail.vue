<script>
import axios from 'axios';
import { store } from '../../store';

export default {
    name: 'mail',
    props: {
        slug: String,
    },
    data() {
        return {
            store,
            email: 'pino@gmail.it',
            message: 'Ciao sono Pino',
            apartmentId: 40,
        }
    },

    methods: {


        sendForm() {
            console.log(this.slug)
            axios.post(store.apiUrl + 'messaggi')
                .then(response => {
                    console.log(response.data);

                })
                .catch(error => {
                    console.log(error.message);
                });
        }
    }

}
</script>

<template>

    <form action="#" @submit.prevent="sendForm">

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
form {
    margin: 50px auto;
    width: 50%;

    div {
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;

        label {
            width: 100%;
            text-align: center;
        }
    }
}
</style>