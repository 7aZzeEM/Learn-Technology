<template>
    <div class="page rad-6">
        <div class="upload">
            <h3 class="m-0 text-center">Upload Course</h3>
            <form class="rad-6 p-10 m-auto" @submit.prevent="uploadCourse">
                <p v-if="uploading">Uploading...</p>
                <progress class="w-full" v-if="uploading"></progress>
                <label for="name" class="font-bold c-fff">Name Course: </label>
                <input
                    type="text"
                    id="name"
                    placeholder="Name Course"
                    class="w-full mt-10 b-none out-none rad-6 c-fff"
                    v-model="nameCourse"
                >
                <label for="videos" class="font-bold c-fff mr-10">Videos: </label>
                <input
                    type="file"
                    id="videos"
                    class="hide"
                    @change="uploadedVideos"
                    webkitdirectory
                    multiple
                >
                <button class="mt-10 b-none p-10 rad-6 pointer" @click.prevent="uploadVideos">Upload Videos</button>
                <span class="font-bold c-fff ml-10" v-if="Videos.length > 0 && Videos.length < 501">
                    {{ Videos.length }} Videos
                </span>
                <span class="font-bold c-fff ml-10" v-if="Videos.length >= 500" style="color: red">
                    Error: Max Videos is 500
                </span>
                <label for="photo" class="font-bold c-fff mr-10 d-block mt-20">Photo: 
                    <button
                        class="mt-10 b-none p-10 rad-6 pointer ml-10"
                        @click.prevent="uploadPhoto"
                    >
                        Upload Photo
                    </button>
                    <span class="font-bold c-fff ml-10" v-if="namePhoto !== ''">{{ namePhoto }}</span>
                </label>
                <input type="file" id="photo" accept="image/.jpg,.png,.jpeg,.gif" class="hide" @change="uploadedPhoto">
                <label for="color" class="font-bold c-fff d-block mr-10 mt-20">Color: 
                    <input type="color" id="color" class="ml-10">
                </label>
                <input type="submit" value="Upload" class="p-10 rad-6 b-none d-block w-fit m-auto pointer mt-20">
            </form>
        </div>
        <div class="table-container">
            <table class="w-full mt-20">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Count videos</th>
                        <th>Count Users</th>
                        <th>Color</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" v-for="Course in Courses" :key="Course.id">
                        <td><img :src="`/photos/${Course.image}`" class="rad-6"></td>
                        <td>{{ Course.id }}</td>
                        <td>{{ Course.name }}</td>
                        <td>{{ Course.videos }}</td>
                        <td>{{ JSON.parse(Course.users).length }}</td>
                        <td>{{ Course.color }}</td>
                        <td>
                            <button
                                class="b-none font-bold p-10 pointer c-fff rad-6"
                                @click.prevent="DeleteCourse(Course.id , $event.target.closest('tr'))"
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
    name: 'CoursesPage',
    data () {
        return {
            Courses: JSON.parse(window.courses),
            Videos: [],
            namePhoto: '',
            nameCourse: '',
            photo: null,
            color: '',
            uploading: false,
        }
    },
    methods: {
        uploadVideos () {
            this.$el.querySelector('#videos').click();
        },
        uploadPhoto () {
            this.$el.querySelector('#photo').click();
        },
        uploadedVideos (event) {
            this.Videos = [];
            for (let i = 0; i < event.target.files.length; i++) {
                if (event.target.files[i].type.startsWith("video/")) {
                    this.Videos.push(event.target.files[i]);
                }
            }
            event.target.value = '';
        },
        uploadedPhoto (event) {
            this.namePhoto = event.target.files[0].name;
            this.photo = event.target.files[0];
        },
        uploadCourse () {
            let name = this.nameCourse;
            let videos = this.Videos;
            let photo = this.photo;
            let color = this.$el.querySelector('#color').value;
            this.uploading = true;

            let course = new FormData();
            course.append('name', name);
            course.append('photo', photo);
            videos.forEach((video) => {
                course.append('videos[]', video);
            });
            
            course.append('color', color);

            axios.post('/Admin/Add/Course', course,{
                headers: {
                    'Content-Type' : 'multipart/form-data'
                }
            }).then(response => {
                this.Courses = response.data.allCourses;
                this.uploading = false;
                this.nameCourse = '';
                this.namePhoto = '';
                this.photo = null;
                this.Videos = [];
                this.color = '';
            })
            .catch(err => {
                if (err.response) {
                    alert(err.response.data.message);
                    this.uploading = false;
                } else {
                    alert(err);
                    this.uploading = false;
                }
            });
        },
        DeleteCourse(id,e) {
            e.style.opacity = .5;
            axios.post('/Admin/remove/course/' + id)
            .then (response => {
                this.Courses = response.data.allCourses;
            })
            .catch (err => {
                if (err.response) {
                    e.style.opacity = 1;
                    alert(err.response.data.message);
                } else {
                    e.style.opacity = 1;
                    alert(err);
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
    margin: 30px;
    h3 {
        font-size: 30px;
        margin-bottom: 30px;
    }

    form {
        width: 50%;
        background-color: #000000a3;
        
        input[type="text"] {
            height: 30px;
            background-color: #333;
        }

        button {
            background-color: var(--successfully-message);
            &:hover {
                background-color: #7cb27cbf;
            }
        }

        input[type="color"] {
            width: 130px;
        }

        input[type="submit"] {
            background-color: var(--color-button);
            &:hover {
                background-color: var(--color-button-hover);
            }
        }
    }
    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border: 3px solid;
        thead {
            height: 50px;
        }
        tbody {
            background-color: #CCC;

            img {
                width: 100px;
            }

            button {
                background-color: #aa0b0b;
                &:hover {
                    background-color: #7a0505;
                }
            }
        }
    }
    @media (max-width: 900px) {
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        table {
            white-space: nowrap;
        }
    }
    @media(max-width: 700px) {
        margin: 0;
        form {
            width: 100%;
        }
    }
}
</style>
