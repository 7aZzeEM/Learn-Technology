<template>
    <div class="contentChatPage d-flex">
        <div class="messanger rad-6">
            <div class="mess p-10 space-between p-relative">
                <h3 class="p-absolute c-fff">{{ nameChat }}</h3>
                <span class="closeChat p-absolute font-bold" @click="closeChat">×</span>
                <div class="messages" ref="containerMessage">
                    <p v-for="(chat, index) in chats"
                      :class="{myMessage: chat.id_user === usr_id, someMessage: chat.id_user !== usr_id}" class="p-relative">
                        <q
                            class="p-absolute pointer"
                            :class="{meQ: chat.id_user === usr_id,notMeQ: chat.id_user !== usr_id}"
                            @click="visitUser(chat.id_user)"
                            v-if="chat.id_user !== usr_id"
                        >
                            {{ chat.username }}
                        </q>
                        <span>{{ chat.message }}</span>
                    </p>
                </div>
                <div class="sender p-relative">
                    <form action="" @submit.prevent='SendMessage'>
                        <input type="text" placeholder="Message" class="w-full" v-model="messageSending">
                        <button class="p-absolute c-fff font-bold">Send</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="chats">
            <button
                class="w-full p-10 c-fff font-bold"
                v-for="(course, index) in myCourses"
                :key="index"
                @click="openChat(course.id, index, course.name)"
                :class="{current: index === id_chat_open}"
            >
                {{ course.name }}
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ChatsPage',
    data() {
        return {
            myCourses: window.user.courses_sub,
            messageSending: '',
            chatMood: false,
            Course_id: null,
            id_chat_open: null,
            chats: null,
            usr_id: window.user.id,
            pollingInterval: null,
            nameChat: null,
            username: window.user.first_name + ' ' + window.user.last_name,
        }
    },
    methods: {
        SendMessage () {
            if (this.chatMood) {
                let message = this.messageSending;
                this.messageSending = '';
                let data = {
                    user_id: window.user.id,
                    message: message,
                    course_id: this.Course_id,
                    username: this.username,
                };
                let addMessageNow = {
                    id_user : this.usr_id,
                    message : message,
                };
                this.chats.push(addMessageNow);
                this.scrollToBottom();
                axios.post('/chat/send/message', data)
                .then(response => {
                    this.fetchChat();
                })
                .catch(err => {
                    if (err.response) {
                        console.log(err.response.data.message);
                    } else {
                        console.log(err);
                    }
                })
            }
        },
        openChat(id,index,name) {
            this.Course_id = id;
            this.chatMood = true;
            this.id_chat_open = index;
            this.nameChat = name;
            this.$el.querySelector('.closeChat').style.display = 'inline';

            this.fetchChat().then(() => {
                this.scrollToBottom();
            });
            this.startPolling();
        },
        fetchChat() {
            let data = {
                id_course: this.Course_id
            }
            return axios.post('/chat/get/chats', data)
            .then(response => {
                if (JSON.stringify(this.chats) !== response.data.message) {
                    this.chats = JSON.parse(response.data.message);
                    this.scrollToBottom();
                }
            })
            .catch(err => {
                if (err.response) {
                    console.log(err.response.data.message)
                } else {
                    console.log(err);
                }
            });
        },
        startPolling () {
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
            }
            this.pollingInterval = setInterval(this.fetchChat, 1000);
        },
        scrollToBottom() {
            const containerMessage = this.$refs.containerMessage;
            if (containerMessage) {
                requestAnimationFrame(() => {
                    containerMessage.scrollTop = containerMessage.scrollHeight;
                });
            }
        },
        destroyInterval() {
            clearInterval(this.pollingInterval);
        },
        closeChat() {
            this.destroyInterval();
            this.Course_id = null;
            this.chatMood = false;
            this.id_chat_open = null;
            this.nameChat = null;
            this.$el.querySelector('.closeChat').style.display = 'none';
            setTimeout(() => this.chats = null,500);
        },
        visitUser (id) {
            location.href = `/user/profile?id=${id}`;
        }
    }
}
</script>

<style lang="scss">
    .contentChatPage {
        margin: 50px 130px;
        gap: 20px;
        background-color: #e6e6e6;
        padding: 10px 20px;
        box-shadow: 0 5px 8px 0 #b2b2b2;
        .chats {
            flex: 1;
            background-color: #CCC;
            button {
                border: none;
                outline: none;
                margin: 0 0 15px;
                cursor: pointer;
                background-color: #393636;
                &:hover {
                    background-color: #00000085;
                }
            }
            .current {
                background-color: black;
            }
        }
        .messanger {
            flex: 2;
            height: 500px;
            background-image: url(../img/chat.jpg);
            border-top: 40px solid #333;
            .mess {
                height: 100%;
                flex-direction: column;
                h3 {
                    top: -49px;
                    left: 50%;
                    transform: translateX(-50%);
                }
                .closeChat {
                    display: none;
                    color: red;
                    font-size: 30px;
                    top: -35px;
                    right: 10px;
                    cursor: pointer;
                }
                .messages {
                    overflow: auto;
                    scroll-behavior: smooth;
                    height: 400px;
                    max-height: 400px;
                    p {
                        margin: 10px;
                        margin-bottom: 20px;
                        padding: 5px 20px 5px 10px;
                        width: fit-content;
                        margin-top: 40px;
                        span {
                            overflow-wrap: anywhere;
                        }
                        q {
                            top: -17px;
                            color: #ccc;
                            font-size: 11px;
                        }
                        .meQ {
                            left: 0;
                        }
                        .notMeQ {
                            right: 0;
                        }
                    }
                    .myMessage {
                        background-color: #065c06;
                        border-radius: 0px 15px 0px 10px;
                    }
                    .someMessage {
                        background-color: #cacacac7;
                        border-radius: 15px 0 10px 0px;
                        margin-left: auto;
                    }
                }
                .sender {
                    input {
                        height: 30px;
                        padding: 20px;
                        border: none;
                        outline: none;
                        border-radius: 25px;
                        padding-right: 66px;
                    }
                    button {
                        right: 10px;
                        border-radius: 25px;
                        border: none;
                        outline: none;
                        background-color: black;
                        padding: 5px;
                        top: 50%;
                        transform: translateY(-50%);
                        cursor: pointer;
                    }
                }
            }
        }
        @media (max-width: 1000px) {
            margin: 50px 100px;
        }
        @media (max-width: 900px) {
            margin: 50px;
        }
        @media (max-width: 800px) {
            margin: 50px 0;
            flex-direction: column;
        }
    }
    @media (max-width: 500px) {
        aside {
            display: none;
        }
    }
</style>