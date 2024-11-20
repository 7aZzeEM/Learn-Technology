<template>
    <header class="space-between">
        <div class="logo d-flex">
            <h1 class="m-0 w-fit">Learn Technology</h1>
            <input class="b-none" type="search" placeholder="Search" v-model="valueSearch" @keyup.enter="search">
        </div>
        <div class="pages d-flex p-relative">
            <ul class="align-center">
                <li><a href="/Courses">Courses</a></li>
                <li><a href="/RoadMaps">RoadMaps</a></li>
                <li><a href="/Chats">Chats</a></li>
                <li><a href="/logout" @click="removeHistory">Logout</a></li>
                <li><a href="/Profile"><img :src="`/Profile/Photo/${user.image}`" alt="Profile"></a></li>
            </ul>
        </div>
    </header>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Bar',
    data () {
        return {
            user: window.user,
            valueSearch: '',
        }
    },
    methods: {
        removeHistory() {
            window.history.replaceState(null, '', '/');
        },
        search () {
            let value = encodeURIComponent(this.valueSearch);
            location.href = '/search?q=' + value;
        }
    }
}
</script>

<style lang="scss">
    body {
        background-color: #efefef;
        header {
            background-color: #e6e6e6;
            padding: 10px 20px;
            box-shadow: 0 5px 8px 0 #b2b2b2;
            .logo {
                h1 {
                    font-size: 23px;
                    color: var(--main-color);
                    padding-right: 20px;
                }
                input {
                    padding: 5px 15px;
                    outline: none;
                    width: 300px;
                    border-radius: 50px;
                }
                @media (max-width: 684px) {
                    flex-direction: column;
                    margin: auto;
                    h1 {
                        margin: 0 auto 10px;
                    }
                }
            }
            .pages {
                ul {
                    height: 0;
                    li {
                        padding-right: 15px;
                        img {
                            width: 30px;
                            border-radius: 50px;
                            cursor: pointer;
                        }
                        a {
                            color: var(--main-color);
                            font-weight: bold;
                            img {
                                width: 30px;
                                max-width: 30px;
                                min-width: 30px;
                                height: 30px;
                                max-height: 30px;
                                min-height: 30px;
                            }
                        }
                    }
                    @media (max-width: 500px) {
                        flex-wrap: wrap;
                        padding: 0;
                        padding-bottom: 20px;
                        li {
                            padding-right: 10px;
                            padding-top: 8px;
                        }
                    }
                }
            }
            @media (max-width: 1040px) {
                flex-direction: column;
                div {
                    justify-content: center;
                }
                .pages {
                    ul {
                        width: 100%;
                        justify-content: space-between;
                        margin-top: 25px;
                    }
                }
            }
        }
    }
</style>