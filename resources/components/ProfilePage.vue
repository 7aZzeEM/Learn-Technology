<template>
    <div class="pageProfile d-grid">
        <div class="detailsOfMe grid-center p-relative">
            <div class="image m-auto">
                <img :src="`/Profile/Photo/${user.image}`" alt="Profile" class="w-full pointer h-full" @click="openEditPhoto">
            </div>
            <div class="editPhoto m-auto" v-if="editPhoto">
                <li class="pointer text-center" @click="EditPhotoProfile">Choose Photo</li>
                <li class="pointer text-center" @click="RempoveProfilePhoto">Remove Photo</li>
                <input type="file" ref="uploadPhoto" class="hide" @change="Upload">
            </div>
            <h1 class="text-center m-0">{{ user.first_name }} {{ user.last_name }}</h1>
            <div class="category p-relative m-auto">
                <input type="text" :value="user.category" class="text-center" ref="category" v-bind:readonly="openCategory">
                <span class="font-bold pointer" @click="changeCategory">E</span>
            </div>
            <div class="someDetails">
                <p class="d-flex" v-for="(link,index) in links" :key="index">
                    {{ link.name }}: <a :href="link.url" class="font-bold d-block">here</a>
                    <span class="pointer font-bold" @click="DeleteLink(index)">D</span>
                </p>
                <p class="openAddLink pointer font-bold" @click="addLink = !addLink">@Add a new URI</p>
                <form action="" class="addLink rad-6 w-full" v-if="addLink" @submit.prevent="addNewLink">
                    <input type="text" placeholder="Web Name" class="w-full rad-6" v-model="nameAddlinks">
                    <input type="url" placeholder="URI" class="w-full rad-6" v-model="urlAddlinks">
                    <input type="submit" value="Save" class="rad-6 font-bold d-block m-auto pointer">
                </form>
            </div>
        </div>
        <div class="detailsOfProjects">
            <div class="settings p-relative">
                <span class="titleSet d-block">Settings</span>
                <ul>
                    <li><a href="/Edit/username" class="font-bold">Edit Username</a></li>
                    <li><a href="/Edit/email" class="font-bold">Edit Email</a></li>
                    <li><a href="/Edit/password" class="font-bold">Edit Password</a></li>
                    <li><a href="/Edit/phone" class="font-bold">Edit Phone</a></li>
                </ul>
            </div>
            <div class="projects">
                <span class="titProjects font-bold d-block">Projects</span>
                <div class="getProjects">
                    <p class="space-between" v-for="(project,index) in projects" :key="index">
                        {{ project.name }}: <a :href="project.url" class="d-block">Go</a>
                        <span class="pointer font-bold" @click="DeleteProject(index)">D</span>
                    </p>
                </div>
                <span class="addNewProject pointer font-bold d-block" @click="addProject = !addProject">@Add a new project</span>
                <form action="" class="rad-6 p-10" v-if="addProject" @submit.prevent="addNewProject">
                    <input type="text" placeholder="Name Project" v-model="nameAddProject" class="w-full rad-6">
                    <input type="url" placeholder="URL" v-model="urlAddProject" class="w-full rad-6">
                    <input type="submit" value="Save" class="d-block m-auto font-bold pointer rad-6">
                </form>
            </div>
        </div>
        <div class="detailsOfCourses">
            <div class="containerCourses">
                <span class="TitOfRates">Rate Of Courses</span>
                <div class="course" v-if="courses.length >= 1" v-for="course in courses">
                    <span class="font-bold">{{ course.name }}</span>
                    <progress :value="100 * (course.videosEnd / course.videos)" max="100" class="h-full align-center w-full"></progress>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ProfilePage',
    data() {
        return {
            editPhoto: false,
            addProject: false,
            user: window.user,
            openCategory: true,
            addLink: false,
            links: window.user.links,
            nameAddlinks: '',
            urlAddlinks: '',
            projects: window.user.projects,
            nameAddProject: '',
            urlAddProject: '',
            courses: window.user.courses_sub,
        }
    },
    methods: {
        openEditPhoto() {
            this.editPhoto = !this.editPhoto;
        },
        EditPhotoProfile () {
            this.$refs.uploadPhoto.click();
        },
        Upload (event) {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append('photo', file);
            axios.post('/upload/photo', formData, {
                headers: {
                    'Content-Type' : 'multipart/form-data',
                }
            })
            .then (response => this.user.image = response.data.image)
            .catch (err => {
                if (err.response) {
                    alert(err.response.body.message);
                } else {
                    alert(err);
                }
            });
        },
        RempoveProfilePhoto () {
            axios.post('/remove/profile/photo')
            .then (response => this.user.image = response.data.image)
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message)
                } else {
                    alert(err);
                }
            });
        },
        changeCategory () {
            this.openCategory = false;
            let targetElement = this.$refs.category;
            targetElement.style.backgroundColor = '#ccc';
            targetElement.focus();
            targetElement.addEventListener('keydown', this.handleCategory);
        },
        handleCategory (event) {
            if (event.key === 'Enter') {
                let targetElement = this.$refs.category;
                let newCategory = targetElement.value;
                axios.post('/update/category', {category: newCategory})
                .then (response => {
                    this.user.category = response.data.category;
                    targetElement.style.backgroundColor = 'transparent';
                    this.openCategory = true;
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
        addNewLink() {
            let data = {
                name: this.nameAddlinks,
                url: this.urlAddlinks,
            }
            axios.post('/add/link', data).
            then (response => {
                this.links = response.data.links;
                this.addLink = !this.addLink;
                this.nameAddlinks = '';
                this.urlAddlinks = '';
            })
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                } else {
                    alert(err);
                }
            });
        },
        DeleteLink (index) {
            axios.post('/delete/link/' + index)
            .then (response => this.links = response.data.links)
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                } else {
                    alert(err);
                }
            });
        },
        addNewProject () {
            let data = {
                name: this.nameAddProject,
                url: this.urlAddProject,
            }
            axios.post('/add/project', data).
            then (response => {
                this.projects = response.data.projects;
                this.addProject = !this.addProject;
                this.nameAddProject = '';
                this.urlAddProject = '';
            })
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                } else {
                    alert(err);
                }
            });
        },
        DeleteProject(index) {
            axios.post('/delete/project/' + index)
            .then (response => this.projects = response.data.projects)
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
aside {
    display: none;
}
    .pageProfile {
        gap: 20px;
        margin-top: 10px;
        margin-right: 45px;
        margin-left: 45px;
        margin-bottom: 20px;
        grid-template-columns: repeat(auto-fill,minmax(350px,1fr));
        .detailsOfMe,.detailsOfProjects,.detailsOfCourses {
            background-color: #e6e6e6;
            padding: 10px 20px;
            box-shadow: 0 5px 8px 0 #b2b2b2;
        }
        .detailsOfMe {
            .image {
                width: 200px;
                border-radius: 120px;
                overflow: hidden;
                border: 3px solid #333;
                img {
                    width: 195.66px;
                    height: 198.85px;
                    max-width: 195.66px;
                    min-width: 195.66px;
                    max-height: 198.85px;
                    min-height: 198.85px;
                }
            }
            h1 {
                margin-top: 20px;
            }
            .category {
                input {
                    border: none;
                    background-color: transparent;
                    color: var(--main-color);
                    outline: none;
                }
                span {
                    font-size: 20px;
                    color: #333;
                }
            }
            .someDetails {
                margin-top: 50px;
                background-color: #CCC;
                border: 1px solid greenyellow;
                padding: 20px;
                a {
                    color: var(--main-color);
                    margin: auto
                }
                span {
                    &:hover {
                        color: #ff0000a3;
                    }
                }
                .addLink {
                    background-color: rgba(60, 55, 55, 0.431372549);
                    padding: 10px;
                    input {
                        margin-bottom: 5px;
                        padding: 5px;
                        border: none;
                        outline: none;
                    }
                    input[type="submit"] {
                        margin-top: 10px;
                        padding: 10px 20px;
                        background-color: var(--main-color);
                    }
                }
                .openAddLink {
                    &:hover {
                        color: rgba(0, 0, 0, 0.4784313725);
                    }
                }
            }
            .editPhoto {
                li {
                    color: brown;
                    font-weight: 600;
                    margin-bottom: 5px;
                    margin-top: 5px;
                }
            }
        }
        .detailsOfProjects {
            .settings {
                background-color: #CCC;
                padding: 20px;
                border-radius: 15px;
                margin: 20px 0;
                .titleSet {
                    font-weight: bolder;
                    font-size: 30px;
                }
                ul {
                    li {
                        margin-bottom: 10px;
                        a {
                            color: #000;
                        }
                    }
                }
            }
            .projects {
                background-color: #ccc;
                border-radius: 15px;
                padding: 20px;
                .titProjects {
                    margin-bottom: 10px;
                    font-size: 30px;
                }
                .getProjects {
                    p {
                        font-weight: 900;
                        a {
                            color: #333;
                        }
                        span {
                            &:hover {
                                color: #ff0000a3;
                            }
                        }
                    }
                }
                .addNewProject {
                    margin-bottom: 15px;
                    &:hover {
                        color: #0000007a;
                    }
                }
                form {
                    background-color: #3c37376e;
                    input{
                        margin-bottom: 5px;
                        padding: 5px;
                        border: none;
                        outline: none;
                    }
                    input[type="submit"] {
                        margin-top: 10px;
                        padding: 10px 20px;
                        background-color: var(--main-color);
                        &:hover {
                            background-color: #39c56ec7;
                        }
                    }
                }
            }
        }
        .detailsOfCourses {
            .containerCourses {
                background-color: #CCC;
                padding: 20px;
                margin-top: 20px;
                border-radius: 15px;
                .TitOfRates {
                    font-size: 30px;
                    font-weight: bolder;
                }
                .course {
                    margin: 10px 10px 40px;
                    height: 40px;
                }
            }
        }
        @media (max-width: 1194px) {
            grid-template-columns: repeat(auto-fill,minmax(300px,1fr));
        }
        @media (max-width: 1030px) {
            grid-template-columns: repeat(auto-fill,minmax(250px,1fr));
        }
        @media (max-width: 880px) {
            grid-template-areas: 
                "detailsOfMe detailsOfProjects"
                "detailsOfCourses detailsOfCourses";
            
            .detailsOfCourses {
                grid-area: detailsOfCourses;
            }
        }
        @media (max-width: 600px) {
            grid-template-areas: none;
            .detailsOfCourses {
                grid-area: auto;
            }
        }
        @media (max-width: 490px) {
            margin-left: 20px;
            margin-right: 20px;
        }
    }
</style>