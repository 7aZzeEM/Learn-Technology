<template>
    <div class="box p-absolute p-10">
        <p class="font-bold p-absolute w-full text-center" v-if="message">Completed Change Phone!</p>
        <h1 class="text-center"> Change Phone Number </h1>
        <form @submit.prevent="ChangePhone">
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
                value="Change"
                class="b-none rad-6 d-block w-fit m-auto font-bold pointer mt-10 c-fff"
            >
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'PhonePage',
    data() {
        return {
            phone: window.admin.phone,
            message: false,
            token: window.token,
        }
    },
    methods: {
        handlePhone () {
            this.phone = this.phone.replace(/[^0-9]/, '');
        },
        ChangePhone () {
            let data = new FormData();
            data.append('phone', this.phone);
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.token;
            axios.post('/Admin/Change/Phone', data)
            .then (response => {
                this.phone = response.data.phone;
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
        },
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