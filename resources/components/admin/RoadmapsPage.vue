<template>
    <div class="page rad-6">
        <div class="form">
            <h3 class="m-0 text-center">{{ modeForm }} RoadMap</h3>
            <form class="m-auto rad-6 p-10" @submit.prevent="executeOperation">
                <span class="d-block mb-10" v-if="uploadMode">{{ modeForm+'...' }}</span>
                <progress class="w-full" v-if="uploadMode"></progress>
                <label for="name" class="font-bold c-fff">Name Track: </label>
                <input
                    type="text"
                    id="name"
                    placeholder="Name Track"
                    class="w-full b-none out-none rad-6 mt-10 c-fff"
                    v-model="nameTrack"    
                >
                <label for="image" class="font-bold c-fff mr-10">Photo: </label>
                <input type="file" id="image" class="hide" accept="image/.jpg,.png,.jpeg,.gif" @change="HandlePhoto">
                <button
                    class="b-none mt-10 p-10 rad-6 pointer"
                    @click.prevent="this.$el.querySelector('#image').click()"
                >Upload Photo
                </button> <span class="c-fff ml-10 font-bold" v-if="Photo !== null">{{ Photo.name }}</span>
                <label for="courses" class="font-bold c-fff d-block mt-20">Courses: {{ CoursesForm.length }}</label>
                <div class="containerCourses p-10 mt-10 rad-6 d-flex wrap">
                    <label
                        :for="Course.id"
                        v-for="Course in Courses"
                        class="pointer"
                    >
                        <input type="checkbox" :id="Course.id" @change="HandleCourses(Course.id)" class="checkbox pointer">
                        {{ Course.name }}
                    </label>
                </div>
                <input type="submit" :value="modeForm" class="d-block w-fit m-auto mt-20 p-10 b-none rad-6 pointer">
            </form>
        </div>
        <div class="table-container">
            <table class="mt-20 w-full">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name Track</th>
                        <th>Count Courses</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" v-for="RoadMap in roadmaps">
                        <td><img :src="`/Image/Roadmap/${RoadMap.image}`" alt="RoadMap" class="rad-6"></td>
                        <td>{{ RoadMap.id }}</td>
                        <td>{{ RoadMap.name_track }}</td>
                        <td>{{ RoadMap.count_courses }}</td>
                        <td>
                            <button
                                class="update font-bold b-none c-fff pointer p-10 rad-6 p-10"
                                @click="updateRoadmap(roadmaps.indexOf(RoadMap))"
                            >
                                Update
                            </button>
                        </td>
                        <td>
                            <button
                                class="delete font-bold b-none c-fff pointer p-10 rad-6 p-10"
                                @click="removeRoadmap(RoadMap.id, $event.target.closest('tr'))"
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
    name: 'RoadmapsPage',
    data () {
        return {
            modeForm: 'Upload',
            nameTrack: '',
            Courses: JSON.parse(window.courses),
            roadmaps: JSON.parse(window.roadmaps),
            Photo: null,
            CoursesForm: [],
            uploadMode: false,
            IDsCourses: [],
            IdRoadmapUpdateKnow: null,
            tmpNamePhoto: null,
        }
    },
    methods: {
        handleIDsCourses () {
            this.Courses.forEach(course => {
                this.IDsCourses.push(course.id);
            });
        },
        executeOperation () {
            this.uploadMode = true;
            if (this.modeForm === 'Upload') {
                let name = this.nameTrack;
                let photo = this.Photo;
                let courses = this.CoursesForm;
                let count = courses.length;
                
                let data = new FormData();
                data.append('name', name);
                data.append('image', photo);
                data.append('courses', JSON.stringify(courses));
                data.append('count', count);

                axios.post('/Admin/Add/Roadmap', data)
                .then (response => {
                    this.roadmaps = response.data.Roadmaps;
                    this.nameTrack = '';
                    this.Photo = null;
                    this.removeChecked(this.CoursesForm);
                    this.CoursesForm = [];
                    this.uploadMode = false;
                })
                .catch (err => {
                    if (err.response) {
                        alert(err.response.data.message);
                        this.uploadMode = false;
                    } else {
                        alert(err);
                        this.uploadMode = false;
                    }
                });

            } else if (this.modeForm === 'Update') {
                let targetRoadmap = this.IdRoadmapUpdateKnow;
                let name = this.nameTrack;
                let photo = this.Photo.name === this.tmpNamePhoto ? null : this.Photo;
                let courses = this.CoursesForm;
                let count = courses.length;
                let data = new FormData();

                data.append('id', targetRoadmap);
                data.append('name', name);
                if (photo !== null) {
                    data.append('image', photo);
                }
                data.append('courses', JSON.stringify(courses));
                data.append('count', count);

                axios.post('/Admin/Update/Roadmap', data)
                .then (response => {
                    this.roadmaps = response.data.newRoadmaps;
                    this.nameTrack = '';
                    this.Photo = null;
                    this.removeChecked(this.CoursesForm);
                    this.CoursesForm = [];
                    this.uploadMode = false;
                })
                .catch (err => {
                    if (err.response) {
                        alert(err.response.data.message);
                        this.uploadMode = false;
                    } else {
                        alert(err);
                        this.uploadMode = false;
                    }
                })
            }
        },
        HandlePhoto (event) {
            this.Photo = null;
            this.Photo = event.target.files[0];
        },
        HandleCourses(id) {
            if (!this.CoursesForm.includes(id)) {
                this.CoursesForm.push(id);
            } else {
                let index = this.CoursesForm.indexOf(id);
                this.CoursesForm.splice(index,1);
            }
        },
        removeChecked (arr) {
            arr.forEach(id => {
                document.getElementById(id).checked = false;
            });
        },
        async updateRoadmap (index) {
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth',
            });
            this.nameTrack = this.roadmaps[index].name_track;
            this.Photo = {name: this.roadmaps[index].image};
            let courses = JSON.parse(this.roadmaps[index].courses);
            await this.IDsCourses.forEach(id => {
                document.getElementById(id).checked = false;
            });
            this.CoursesForm = [];
            courses.forEach(id => {
                document.getElementById(id).checked = true;
                this.CoursesForm.push(id);
            });
            this.modeForm = 'Update';
            this.IdRoadmapUpdateKnow = this.roadmaps[index].id;
            this.tmpNamePhoto = this.roadmaps[index].image;
        },
        async removeRoadmap (id,e) {
            e.style.opacity = .5;
            await axios.post('/Admin/Remove/Roadmap/' + id)
            .then (response => this.roadmaps = response.data.allRoadmaps)
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message);
                } else {
                    alert(err);
                }
            });
            e.style.opacity = 1;
        }
    },
    mounted () {
        this.handleIDsCourses();
    }
}
</script>

<style lang="scss">
    .page {
        background-color: #CCC;
        padding: 20px;
        border: 3px solid black;
        margin: 30px;
        @media (max-width: 500px) {
            margin: 0;
        }
        .form {
            h3 {
                font-size: 30px;
                margin-bottom: 30px;
            }
            form {
                width: 50%;
                background-color: rgba(0, 0, 0, 0.6392156863);
                input:not(:last-of-type) {
                    height: 30px;
                    background-color: #333;
                }
                button {
                    background-color: var(--successfully-message);
                    &:hover {
                        background-color: rgba(124, 178, 124, 0.7490196078);
                    }
                }
                .containerCourses {
                    background-color: #CCC;
                    max-height: 100px;
                    overflow-y: auto;
                    label {
                        margin-right: 30px;
                        padding: 5px;
                    }
                }
                input[type="submit"] {
                    background-color: var(--color-button);
                    &:hover {
                        background-color: var(--color-button-hover);
                    }
                }
            }
            @media(max-width: 700px) {
                margin: 0;
                form {
                    width: 100%;
                }
            }
        }
        table {
            border: 3px solid;
            thead {
                height: 50px;
            }
            img {
                width: 100px;
            }
            .update {
                background-color: var(--orange-color);
                &:hover {
                    background-color: #ff8f00cf;
                }
            }
            .delete {
                background-color: red;
                &:hover {
                    background-color: #ff0000b5;
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
    }
</style>