<template>
    <div class="box p-absolute p-10">
        <p class="font-bold p-absolute w-full text-center" v-if="message">Completed Change Email!</p>
        <h1 class="text-center"> Change Email </h1>
        <form @submit.prevent="EditEmail">
            <input
                type="email"
                placeholder="Email"
                class="w-full b-none out-none mb-10 rad-6"
                v-model="email"
                required
            >
            <input
                type="submit"
                value="Change"
                class="b-none rad-6 d-block w-fit m-auto font-bold pointer mt-10 c-fff"
            >
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'EmailPage',
    data() {
        return {
            email: window.admin.email,
            message: false,
            token: window.token,
        }
    },
    methods: {
        EditEmail () {
            let data = new FormData();
            data.append('email', this.email);
            axios.defaults.headers.common['X-Requested_With'] = 'XMLHttpRequest';
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.token;
            axios.post('/Admin/Change/Email', data)
            .then (response => {
                this.email = response.data.email;
                this.message = true;
                setTimeout(() => {
                    this.message = false;
                },3000);
            })
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                } else {
                    alert(err);
                }
            });
        }
    },
}
</script>

<style lang="scss">
    .box {
        width: 500px;
        border: 3px solid royalblue;
        border-radius: 20px;
        left: 50%;
        transform: translateX(-50%);
        top: 25%;
        p {
            top: -90px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 30px;
            color: rosybrown;
        }
        h1 {
            color: royalblue;
        }
        form {
            input:not(:last-child) {
                background-color: #CCC;
                padding: 8px;
            }
            input[type="submit"] {
                padding: 10px 20px;
                background-color: royalblue;
                &:hover {
                    background-color: #4169e1c9;
                }
            }
        }
        @media (max-width: 600px) {
            width: 400px;
        }
        @media (max-width: 450px) {
            width: 350px;
        }
    }
</style>