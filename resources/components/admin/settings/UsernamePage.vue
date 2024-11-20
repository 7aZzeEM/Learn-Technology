<template>
    <div class="box p-absolute p-10">
        <p class="font-bold p-absolute w-full text-center" v-if="message">Completed Change Username!</p>
        <h1 class="text-center"> Change Username </h1>
        <form @submit.prevent="EditUsername">
            <input
                type="text"
                placeholder="First Name"
                class="w-full b-none out-none mb-10 rad-6"
                v-model="fname"
                @input="handlefname"
                required
            >
            <input type="text"
                placeholder="Last Name"
                class="w-full b-none out-none mb-10 rad-6"
                v-model="lname"
                @input="handlelname"
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
    name: 'UsernamePage',
    data() {
        return {
            fname: window.admin.first_name,
            lname: window.admin.last_name,
            message: false,
            token: window.token,
        }
    },
    methods: {
        handlefname () {
            this.fname = this.fname.replace(/[^a-zA-Z0-9]/, '');
        },
        handlelname () {
            this.lname = this.lname.replace(/[^a-zA-Z0-9]/, '');
        },
        EditUsername () {
            let data = new FormData();
            data.append('first_name', this.fname);
            data.append('last_name', this.lname);
            axios.defaults.headers.common['X-Requested_With'] = 'XMLHttpRequest';
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.token;
            axios.post('/Admin/Change/Username', data)
            .then (response => {
                this.fname = response.data.data.fname;
                this.lname = response.data.data.lname;
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