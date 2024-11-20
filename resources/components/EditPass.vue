<template>
    <div class="containerBox p-absolute rad-6">
        <h1 class="text-center m-0">Edit Password</h1>
        <form @submit.prevent="EditPasswod">
            <input type="password" placeholder="Old Password" v-model="oldPass" class="w-full rad-6 p-10">
            <input type="password" placeholder="New Password" v-model="pass" class="w-full rad-6 p-10">
            <input type="password" placeholder="Current Password" v-model="CurrentPass" class="w-full rad-6 p-10">
            <input type="submit" value="Save" class="rad-6 d-block m-auto pointer font-bold">
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'EditPasswod',
    data () {
        return {
            oldPass: '',
            pass: '',
            CurrentPass: '',
        }
    },
    methods: {
        EditPasswod () {
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.defaults.headers.common['X-CSRF-TOKEN'] = window.token.csrftoken;
            axios.post('/edit/password/user', {oldPass: this.oldPass, pass: this.pass, CurrentPass: this.CurrentPass})
            .then (response => location.href = "/Profile")
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                } else {
                    alert(err);
                }
            });
        }
    }
}
</script>

<style lang="scss">
aside {
    display: none;
}
    .containerBox {
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        background-color: #CCC;
        padding: 20px;
        h1 {
            margin-bottom: 20px;
        }
        input {
            margin-bottom: 10px;
            border: none;
            outline: none;
        }
        input[type="submit"] {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: var(--main-color);
            &:hover {
                background-color: #39c56ebd;
            }
        }
        @media (max-width: 600px) {
            width: 350px;
        }
    }
</style>