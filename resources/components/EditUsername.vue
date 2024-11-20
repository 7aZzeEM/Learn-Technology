<template>
    <div class="containerBox p-absolute rad-6">
        <h1 class="text-center m-0">Edit Username</h1>
        <form @submit.prevent="EditUsername">
            <input type="text" placeholder="First Name" v-model="FristName" class="w-full rad-6 p-10">
            <input type="text" placeholder="Last Name" v-model="LastName" class="w-full rad-6 p-10">
            <input type="submit" value="Save" class="rad-6 d-block m-auto pointer font-bold">
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'EditUsername',
    data () {
        return {
            FristName: window.user.first_name,
            LastName: window.user.last_name,
        }
    },
    methods: {
        EditUsername () {
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.defaults.headers.common['X-CSRF-TOKEN'] = window.token.csrftoken;
            axios.post('/edit/username/user', {first_name: this.FristName, last_name: this.LastName})
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