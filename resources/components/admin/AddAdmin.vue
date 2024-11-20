<template>
    <div class="box p-absolute p-10">
        <p class="font-bold p-absolute w-full text-center" v-if="message">Completed Create Admin!</p>
        <h1 class="text-center"> Add New Admin </h1>
        <form @submit.prevent="CreateAdmin">
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
                type="email"
                placeholder="Email"
                class="w-full b-none out-none mb-10 rad-6"
                v-model="email"
                required
            >
            <input
                type="password"
                placeholder="Password"
                class="w-full b-none out-none mb-10 rad-6"
                v-model="password"
                autocomplete="current-password"
                required
            >
            <input
                type="text"
                placeholder="Phone"
                class="w-full b-none out-none mb-10 rad-6"
                v-model="phone"
                @input="handlePhone"
                required
            >
            <input
                type="submit"
                value="Create"
                class="b-none rad-6 d-block w-fit m-auto font-bold pointer mt-10 c-fff"
            >
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'AddAdmin',
    data() {
        return {
            fname: '',
            lname: '',
            email: '',
            password: '',
            phone: '',
            powers: null,
            message: false,
            powersAdmin: window.admin.email,
        }
    },
    methods: {
        handlefname () {
            this.fname = this.fname.replace(/[^a-zA-Z0-9]/, '');
        },
        handlelname () {
            this.lname = this.lname.replace(/[^a-zA-Z0-9]/, '');
        },
        handlePhone () {
            this.phone = this.phone.replace(/[^0-9]/, '');
        },
        CreateAdmin () {
            let data = new FormData();
            data.append('first_name', this.fname);
            data.append('last_name', this.lname);
            data.append('email', this.email);
            data.append('password', this.password);
            data.append('phone', this.phone);
            data.append('powers', this.powers ? 1 : 0);
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.defaults.headers.common['X-CSRF-TOKEN'] = window.token.csrftoken;
            axios.post('/Admin/Create/Admin', data)
            .then (response => {
                this.message = true;
                this.fname = '';
                this.lname = '';
                this.email = '';
                this.password = '';
                this.phone = '';
                setTimeout(() => this.message = false, 3000);
            })
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                } else {
                    alert(err);
                }
            })
        }
    },
    mounted () {
        this.powers = this.powersAdmin === 'learntechnology@learntechnology.org' ? true : false;
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