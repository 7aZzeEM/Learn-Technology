<template>
    <div class="box w-fit p-absolute">
        <h1 class="text-center">Administrator Login</h1>
        <form @submit.prevent="login">
            <input type="email" v-model="email" placeholder=" Type your email" class="w-full rad-6 c-fff">
            <input type="password" v-model="pass" placeholder=" Type your password" class="w-full rad-6 c-fff">
            <input type="submit" value="Login" class="c-fff d-block w-fit font-bold rad-6 pointer">
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'LoginPage',
    data () {
        return {
            email: '',
            pass: '',
            token: window.token,
        }
    },
    methods: {
        login() {
            let email = this.email;
            let password = this.pass;
            let token = this.token;
            axios.defaults.headers.common['X-Requested-With'] = token;
            axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            axios.post('/Admin/Authentication', { email: email, pass: password })
            .then (response => {
                location.href = "/Admin/" + response.data.nameAdmin;
                window.history.replaceState(null, '', '/Admin/' + response.data.nameAdmin);
            })
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                } else {
                    alert(err);
                }
            });
        },
    },
}
</script>

<style lang="scss">
body {
    background-color: #00000080;
}
    .box {
        padding: 20px 40px;
        top: 40%;
        left: 50%;
        transform: translate(-50%,-50%);
        border-radius: 30px;
        border: 3px solid;
        form {
            input {
                border: none;
                outline: none;
                margin: 10px auto;
                height: 40px;
                background-color: #000000b8;
                &:focus {
                    transform: scale(1.1);
                }
            }
            input[type="submit"] {
                padding: 10px 20px;
                &:hover {
                    background-color: rgb(0 0 0 / 57%);
                }
            }
        }
    }
</style>