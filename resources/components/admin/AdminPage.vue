<template>
    <div class="page">
        <div class="table-container">
            <span
                class="font-bold d-block mb-10 hov pointer"
                v-if="permissionAdd"
                @click="addAdmin"
            >
                @Add_new_Admin
            </span>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="p-10">ID</th>
                        <th class="p-10">Name</th>
                        <th class="p-10">Email</th>
                        <th class="p-10">Phone</th>
                        <th class="p-10">Power</th>
                        <th class="p-10">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" v-for="(admin,index) in admins" :key="index">
                        <td class="p-10">{{ admin.id }}</td>
                        <td class="p-10">{{ admin.first_name }} {{ admin.last_name }}</td>
                        <td class="p-10">{{ admin.email }}</td>
                        <td class="p-10">{{ admin.phone }}</td>
                        <td class="p-10">{{ admin.powers ? 'Super Admin' : 'Admin' }}</td>
                        <td class="p-10">
                            <button
                                class="p-10 rad-6 b-none c-fff font-bold"
                                @click="deleteAdmin(admin.id, $event.target.closest('tr'), index)"
                                :class="{
                                    delete: (del === 'All' || (del === 'Super' && !admin.powers)),
                                    pointer: (del === 'All' || (del === 'Super' && !admin.powers)),
                                    deleteHide: (del !== 'All' && del !== 'Super') || (del === 'Super' && admin.powers),
                                    notAllow: (del !== 'All' && del !== 'Super') || (del === 'Super' && admin.powers)
                                }"
                                
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
    name: 'AdminPage',
    data() {
        return {
            admins: window.admins,
            me: window.admin,
            permissionAdd: window.per,
            owner: false,
            del: '',
        };
    },
    methods: {
        handleAdmins() {
            let index = this.admins.findIndex(item => item.id === this.me.id);
            if (index !== -1) {
                this.admins.splice(index, 1);
            }
            let index2 = this.admins.findIndex(item => item.email === 'learntechnology@learntechnology.org');
            if (index2 !== -1) {
                this.admins.splice(index2, 1);
            }
            if (this.me.email === 'learntechnology@learntechnology.org') this.owner = true;
        },
        permissionDelete () {
            if (this.owner) {
                this.del = 'All';
            } else if (!this.owner && this.me.powers) {
                this.del = 'Super';
            } else if (!this.owner && !this.me.powers) {
                this.del = 'Admin';
            } 
        },
        addAdmin () {
            location.href='/Admin/Add/Admin';
        },
        deleteAdmin (id , element , index) {
            if (this.owner) {
                element.style.opacity = .5;
                this.SendAPIremoveAdmin(id , element , index);
            } else if (!this.owner && this.me.powers) {
                if (!this.admins[index].powers) {
                    element.style.opacity = .5;
                    this.SendAPIremoveAdmin(id , element , index);
                }
            }
        },
        SendAPIremoveAdmin(id , element , index) {
            axios.post(`/Admin/Remove/Admin?id=${id}`)
            .then (response => {
                element.style.opacity = 1;
                this.admins.splice(index, 1);
            })
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                    element.style.opacity = 1;
                } else {
                    alert(err);
                    element.style.opacity = 1;
                }
            })
        }
    },
    mounted() {
        this.handleAdmins();
        this.permissionDelete();
    },
}
</script>

<style lang="scss">
    .page {
        background-color: #CCC;
        padding: 20px;
        border: 3px solid black;
        .hov {
            &:hover {
                color: #00000094;
            }
        }
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
            .deleteHide {
                background-color: #80000042;
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