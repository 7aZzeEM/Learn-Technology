<template>
    <div class="watch d-flex">
        <div class="det">
            <p class="align-center font-bold">Rate: <progress :value="100 * (endVideos / NameVideos.length)" max="100"></progress></p>
            <a
                :href="`/remove/course/${this.IDCourse}/user/${user.id}`"
                class="RemoveInMobile c-fff font-bold p-10"
                v-if="NameVideos.length !== endVideos"
            >
                Remove
            </a>
        </div>
        <div class="video">
            <video
                :src="`/video/watch/${Course}/${NameVideos[startVideo]}`"
                class="w-full"
                controls
                @error="handleError"
                @ended="EndVideo(startVideo)"
                autoplay
            ></video>
        </div>
        <div class="playlist">
            <a
                v-for="(video, index) in NameVideos"
                :key="index"
                class="d-block text-center rad-6"
                :class="{ current: index === startVideo }"
                @click="startVideo = index"
            >
                {{ video }}
            </a>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'WatchPage',
    data () {
        return {
            NameVideos: window.videos,
            Course: window.course,
            user: window.user,
            IndexCourse: null,
            startVideo: null,
            IDCourse: null,
            endVideos: null,
        }
    },
    methods: {
        auth () {
            let IDs = [];
            let courses_sub = this.user.courses_sub;
            IDs = courses_sub.map((c) => c.name);
            if (!IDs.includes(this.Course)) {
                location.href = '/Courses';
            }
            this.IndexCourse = courses_sub.findIndex((c) => c.name === this.Course);
            let CountVideos = this.user.courses_sub[this.IndexCourse].videosEnd;
            if (CountVideos === this.NameVideos.length) {
                this.startVideo = CountVideos - 1;
            } else {
                this.startVideo = CountVideos;
            }
            this.IDCourse = this.user.courses_sub[this.IndexCourse].id;
            this.endVideos = this.user.courses_sub[this.IndexCourse].videosEnd;
        },
        handleError () {
            alert("Error When Download Video");
        },
        EndVideo(index) {
            if (this.user.courses_sub[this.IndexCourse].videosEnd === this.NameVideos.length) {
                let data = {
                    userID: this.user.id,
                    IndexCourse: this.IndexCourse,
                }
                axios.post('/End/Course', data)
                .then(response => console.log(response.data.message))
                .catch(err => {
                    if (err.response) {
                        console.log(err.response.data.message);
                    } else {
                        console.log(err.message);
                    }
                })
            } else {
                if (this.startVideo + 1 !== this.user.courses_sub[this.IndexCourse].videos) {
                    this.startVideo++;
                }
                let data = {
                    id: this.user.id,
                    indexVideo: index,
                    IndexCourse: this.IndexCourse,
                }
                axios.post('/video/end',data)
                .then(response => console.log(response.data.message))
                .catch(err => {
                    if(err.response) {
                        console.log(err.response.data.message);
                    } else {
                        console.log(err.message);
                    }
                });
            }
        }
    },
    mounted() {
        this.auth();
    },
}
</script>

<style lang="scss">
    .watch {
        .det {
            display: none;
            justify-content: space-around;
            align-items: center;
            .RemoveInMobile {
                background-color: #c60707;
                border-radius: 50px;
            }
            p {
                height: 25px;
                progress {
                    height: 100%;
                }
            }
            @media (max-width: 700px) {
                display: flex;
            }
        }
        background-color: #e6e6e6;
        box-shadow: 0 5px 8px 0 #b2b2b2;
        margin: 60px;
        .video {
            flex: 3;
            video {
                min-height: 200px;
            }
        }
        .playlist {
            flex: 1;
            margin: 0 20px;
            a {
                background-color: #cccccc63;
                padding: 5px 0;
                margin: 15px 0;
                transition: background-color 0.3s;
                &:hover,&.current {
                    background-color: #CCC;
                }
            }
        }
        @media (max-width: 900px) {
            flex-direction: column;
        }
    }
@media (max-width: 700px) {
    aside {
        display: none;
    }
}
</style>