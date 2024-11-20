<template>
    <div class="containerBox p-absolute rad-6">
        <h1 class="text-center m-0">Edit Phone</h1>
        <form @submit.prevent="EditPhone">
            <input type="text" placeholder="Edit Phone Number" v-model="phone" class="w-full rad-6 p-10">
            <input type="submit" value="Save" class="rad-6 d-block m-auto pointer font-bold">
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'EditPhone',
    data () {
        return {
            phone: window.user.phone,
        }
    },
    methods: {
        EditPhone () {
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.defaults.headers.common['X-CSRF-TOKEN'] = window.token.csrftoken;
            axios.post('/edit/phone/user', {phone: this.phone})
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
        width: 500px;
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