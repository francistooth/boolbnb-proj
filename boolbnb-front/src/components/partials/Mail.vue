<script>
import axios from 'axios';
import { store } from '../../store';
import Loader from './Loader.vue';

export default {
    name: 'mail',
    components: {
        Loader
    },
    props: {
        slug: String,
    },
    data() {
        return {
            store,
            name: 'Pino',
            email: 'pino@gmail.it',
            message: 'Ciao sono Pino',
            sending: false,

            errors:{
                email: [],
                message: [],
                name: [],
            },
        }
    },

    methods: {

        sendForm() {

            this.sending = true;
            const data = {
                name: this.name,
                email: this.email,
                message: this.message,
                slug: this.slug
            }

            axios.post(store.apiUrl + 'messaggi', data)
                .then(response => {

                    console.log(response.data);

                    if(!response.data.success){
                        this.errors = response.data.errors;
                    } else {
                        this.errors = {
                            name: [],
                            email: [],
                            message: [],
                        }
                    }

                    this.sending = false;
                })
                .catch(error => {
                    console.log(error.message);
                });
        }
    },
}
</script>

<template>

    <section>
        <form v-if="!sending" action="#" @submit.prevent="sendForm">

            <div>
                <label for="name" class="form-label">Nome:</label>
                <p class="text-danger">{{ errors.name?.toString() }}</p>
                <input v-model="name" type="text" id="name" class="form-control">
            </div>

            <div>
                <label for="email" class="form-label">Email:</label>
                <p class="text-danger">{{ errors.email?.toString() }}</p>
                <input v-model="email" type="email" id="email" class="form-control">
            </div>

            <div>
                <label for="message" class="form-label">Messaggio:</label>
                <p class="text-danger">{{ errors.message?.toString() }}</p>
                <textarea v-model="message" rows="8" id="message" class="form-control"></textarea>
            </div>

            <div>
                <button type="submit" class="btn btn-success">Invia</button>
            </div>

        </form>

        <Loader v-else/>

    </section>


</template>

<style lang="scss" scoped>

section{
    height: 450px;
}

form {
    margin: 50px auto;
    width: 50%;

    div {
        margin-bottom: 10px;
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