<template>
    <div class="page">
        <div class="table-container">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="p-10">Profile</th>
                        <th class="p-10">ID</th>
                        <th class="p-10">Name</th>
                        <th class="p-10">Specialization</th>
                        <th class="p-10">Email</th>
                        <th class="p-10">Phone</th>
                        <th class="p-10">Courses_Sub</th>
                        <th class="p-10">Courses_End</th>
                        <th class="p-10">Projects</th>
                        <th class="p-10">Profile User</th>
                        <th class="p-10">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" v-for="(user,index) in users" :key="index">
                        <td class="p-10">
                            <img :src="`/Profile/Photo/${user.photo}`" alt="Profile" class="rad-6">
                        </td>
                        <td class="p-10">{{ user.id }}</td>
                        <td class="p-10">{{ user.first_name }} {{ user.last_name }}</td>
                        <td class="p-10">{{ user.category }}</td>
                        <td class="p-10">{{ user.email }}</td>
                        <td class="p-10">{{ user.phone }}</td>
                        <td class="p-10">
                            {{
                                JSON.parse(user.courses_sub || '[]').length - JSON.parse(user.courses_end || '[]').length
                            }}
                        </td>
                        <td class="p-10">{{ JSON.parse(user.courses_end || '[]').length }}</td>
                        <td class="p-10">{{ JSON.parse(user.projects || '[]').length }}</td>
                        <td class="p-10">
                            <button
                                class="view p-10 rad-6 b-none pointer c-fff font-bold"
                                @click="showProfile(user.id)"
                            >
                                View
                            </button>
                        </td>
                        <td class="p-10">
                            <button
                                class="delete p-10 rad-6 b-none pointer c-fff font-bold"
                                @click="deleteUser(user.id, $event.target.closest('tr'),index)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'UsersPage',
    data () {
        return  {
            users: JSON.parse(window.users),
        }
    },
    methods: {
        showProfile(id) {
            location.href=`/Admin/Visit/User?id=${id}`
        },
        deleteUser(id,element,index) {
            element.style.opacity = .5;
            let courses = JSON.parse(this.users[index].courses_sub);
            courses = courses.map((c) => c.id);

            axios.post(`/Admin/Remove/User?id=${id}&courses=${JSON.stringify(courses)}`)
            .then (response => {
                this.users = response.data.allUsers;
                element.style.opacity = 1;
            })
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                    element.style.opacity = 1;
                } else {
                    alert(err);
                    element.style.opacity = 1;
                }
            });
            
        }
    }
}
</script>

<style lang="scss">
    .page {
        background-color: #CCC;
        padding: 20px;
        border: 3px solid black;
        table {
            thead {
                height: 50px;
            }
            img {
                width: 100px;
                height: 100px;
            }
            .view {
                background-color: blue;
                &:hover {
                    background-color: #0808a4;
                }
            }
            .delete {
                background-color: red;
                &:hover {
                    background-color: #ff0000b5;
                }
            }
            th {
                background-color: #b19c9c;
            }
            td {
                background-color: #a3abac;
            }
        }
        .table-container {
            overflow-x: auto;
            --webkit-overflow-scrolling: touch;
            max-width: 100%;
        }
        table {
            white-space: nowrap;
        }
    }
</style>