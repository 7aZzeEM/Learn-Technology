<template>
    <header class="p-relative">
        <h2>LearnTechnology</h2>
        <ul class="bar center-flex">
            <li class="h-full font-bold center-flex pointer p-relative" @click="ControlCourses">
                <a href="/Admin/Control/Courses">Courses</a>
            </li>
            <li class="h-full font-bold center-flex pointer p-relative" @click="ControlRoadmap">
                <a href="/Admin/Control/RoadMaps">RoadMaps</a>
            </li>
            <li class="h-full font-bold center-flex pointer p-relative" @click="ControlUsers">
                <a href="/Admin/Control/Users">Users</a>
            </li>
            <li class="h-full font-bold center-flex pointer p-relative" @click=ControlAdmins>
                <a href="/Admin/Control/Admins">Admins</a>
            </li>
            <li class="h-full font-bold center-flex pointer p-relative" @click="ControlChats">
                <a href="/Admin/Control/Chats">Chats</a>
            </li>
            <li class="h-full font-bold center-flex pointer p-relative" @click="openSettings = !openSettings">
                <a>Settings</a>
            </li>
            <li class="h-full font-bold center-flex pointer p-relative" @click="logout">
                <a href="/logout/admin">Logout</a>
            </li>
        </ul>
        <ul class="settings p-absolute" v-if="openSettings">
            <li class="pointer" @click="EditUsername"><a href="/Admin/Edit/Username">Edit Username</a></li>
            <li class="pointer" @click="EditEmail"><a href="/Admin/Edit/Email">Edit Email</a></li>
            <li class="pointer" @click="EditPass"><a href="/Admin/Edit/Password">Edit Password</a></li>
            <li class="pointer" @click="EditPhone"><a href="/Admin/Edit/Phone">Edit Phone</a></li>
        </ul>
    </header>
</template>

<script>
export default {
    name: 'Head',
    data () {
        return {
            openSettings: false,
        }
    },
    methods: {
        EditUsername () {
            location.href = '/Admin/Edit/Username';
        },
        EditEmail () {
            location.href = '/Admin/Edit/Email';
        },
        EditPass () {
            location.href = '/Admin/Edit/Password';
        },
        EditPhone () {
            location.href = '/Admin/Edit/Phone';
        },
        ControlCourses () {
            location.href = '/Admin/Control/Courses';
        },
        ControlRoadmap () {
            location.href = '/Admin/Control/RoadMaps';
        },
        ControlUsers () {
            location.href = '/Admin/Control/Users';
        },
        ControlAdmins () {
            location.href = '/Admin/Control/Admins';
        },
        ControlChats () {
            location.href = '/Admin/Control/Chats';
        },
        logout () {
            location.href = '/logout/admin';
        }

    }
}
</script>

<style lang="scss">
    header {
        background-color: #e6e6e6;
        padding: 0px 20px;
        box-shadow: 0 5px 8px 0 #b2b2b2;
        display: flex;
        justify-content: space-between;
        h2 {
            color: royalblue;
            margin: 10px
        }
        .bar {
            margin: 0;
            padding: 0;
            li {
                padding: 0 20px;
                transition: .3s;
                overflow: hidden;
                a {
                    color: black;
                }
                @media (max-width: 950px) {
                    padding: 0 10px;
                }
                &::before {
                    content: "";
                    position: absolute;
                    width: 100%;
                    height: 4px;
                    background-color: royalblue;
                    top: 0;
                    left: -100%;
                    transition: .3s;
                }
                &:hover {
                    background-color: #ccc;
                    &::before {
                        left: 0;
                    }
                    a {
                        color: royalblue;
                    }
                }
            }
            @media (max-width: 500px) {
                li {
                    padding: 0 5px;
                    a {
                        font-size: 12px;
                    }
                }
            }
        }
        .settings {
            bottom: -215px;
            right: 0px;
            background-color: #e6e6e6;
            padding:0;
            padding: 20px 0;
            box-shadow: 0 5px 8px 0 #b2b2b2;
            border-radius: 10px;
            li {
                padding: 10px 0;
                a {
                    color: black;
                    padding: 10px 90px 10px 20px;
                }
                &:hover {
                    background-color: #ccc;
                }
            }
            @media (max-width: 661px) {
                display: block;
                width: 100%;
            }
        }
        @media (max-width: 820px) {
            display: block;
            text-align: center;
            padding: 0;
            h2 {
                margin-top: 0;
                margin-bottom: 10px;
            }
            .bar {
                height: 60px;
            }
            .settings {
                text-align: left;
            }
        }
    }
</style>