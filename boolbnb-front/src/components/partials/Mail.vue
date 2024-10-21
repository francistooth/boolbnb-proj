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
            name: '',
            email: '',
            message: '',
            sending: false,
            sent: false,
            apiError:false,
            errorMessage: '',

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
                        this.sent = true;
                        this.errors = {
                            name: [],
                            email: [],
                            message: [],
                        }
                    }

                    this.name = '',
                    this.email = '',
                    this.message = '',

                    this.sending = false;

                    setTimeout(() => {
                        this.sent = false;
                    }, 2500);
                })
                .catch(error => {
                    this.sending = false;
                    console.log(error.message);
                    this.errorMessage = error.message;
                    this.apiError = true;
                });
        },

        resetError(){
            this.errorMessage = '';
            this.apiError = false;
        }

    },
}
</script>

<template>

    <section>
        <form v-if="!sending && !apiError" action="#" @submit.prevent="sendForm">

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

            <div v-if="!sent">
                <button type="submit" class="btn btn-success my-2">Invia</button>
            </div>
            <div v-else>
                <h3 class="text-success my-2">Messaggio inviato correttamente</h3>
            </div>

        </form>

        <Loader v-else-if="!apiError"/>

        <div v-if="apiError" class="text-center">
            <h2 class="text-danger">{{ errorMessage }}</h2>
            <button class="btn btn-warning" @click="resetError">Riprova</button>
        </div>
    </section>


</template>

<style lang="scss" scoped>

section{
    height: 580px;

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
}
</style>