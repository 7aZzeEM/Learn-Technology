<template>
    <div class="boxs justify-center">
        <h3 class="center-flex pointer" @click="Courses">Courses</h3>
        <h3 class="center-flex pointer" @click="RoadMaps">RoadMaps</h3>
        <h3 class="center-flex pointer" @click="Users">Users</h3>
        <h3 class="center-flex pointer" @click="Admins">Admins</h3>
        <h3 class="center-flex pointer" @click="Chats">Chats</h3>
    </div>
</template>

<script>
export default {
    name: 'ControlPage',
    methods: {
        Courses () {
            location.href = "/Admin/Control/Courses";
        },
        RoadMaps () {
            location.href = "/Admin/Control/RoadMaps";
        },
        Users () {
            location.href = "/Admin/Control/Users";
        },
        Admins () {
            location.href = "/Admin/Control/Admins";
        },
        Chats () {
            location.href = "/Admin/Control/Chats";
        }
    }
}
</script>

<style lang="scss">
    .boxs {
        flex-wrap: wrap;
        gap: 10px;
        h3 {
            width: 318.52px;
            height: 234.49px;
            background-color: #ccccccb5;
            border-radius: 40px;
            font-size: 30px;
            border: 3px solid #9d9d9d;
            &:hover {
                background-color: rgb(204 204 204 / 54%);
            }
        }
    }
</style>