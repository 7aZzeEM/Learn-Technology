<template>
    <div class="box p-absolute p-10">
        <p class="font-bold p-absolute w-full text-center" v-if="message">Completed Change Password!</p>
        <h1 class="text-center"> Change Password </h1>
        <form @submit.prevent="ChangePassword">
            <input
                type="password"
                placeholder="Old Password"
                class="w-full b-none out-none mb-10 rad-6"
                v-model="Oldpassword"
                autocomplete="current-password"
                required
            >
            <input
                type="password"
                placeholder="New Password"
                class="w-full b-none out-none mb-10 rad-6"
                v-model="newPassword"
                autocomplete="current-password"
                required
            >
            <input
                type="password"
                placeholder="Current Password"
                class="w-full b-none out-none mb-10 rad-6"
                v-model="CurrentPassword"
                autocomplete="current-password"
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
    name: 'PasswordPage',
    data() {
        return {
            Oldpassword: '',
            newPassword: '',
            CurrentPassword: '',
            message: false,
            token: window.token,
        }
    },
    methods: {
        ChangePassword () {
            let data = new FormData();
            data.append('old_pass', this.Oldpassword);
            data.append('new_pass', this.newPassword);
            data.append('current_pass', this.CurrentPassword);
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.token;
            axios.post('/Admin/Change/Password', data)
            .then (response => {
                this.message = true;
                this.Oldpassword = '';
                this.newPassword = '';
                this.CurrentPassword = '';
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
            })
        }
    }
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