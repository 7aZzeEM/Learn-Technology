<template>
    <div class="containerSearchPage rad-6">
        <ul class="space-between">
            <li><a class="font-bold" :class="{current: tab_active === 'courses'}" @click="moveSearch('courses')"> Courses </a></li>
            <li><a class="font-bold" :class="{current: tab_active === 'roadmaps'}" @click="moveSearch('roadmaps')"> Roadmaps </a></li>
            <li><a class="font-bold" :class="{current: tab_active === 'specialization'}" @click="moveSearch('specialization')"> Specialization </a></li>
            <li><a class="font-bold" :class="{current: tab_active === 'developers'}" @click="moveSearch('developers')"> Developers </a></li>
        </ul>
        <div class="Courses" id="courses">
            <div class="course space-between rad-6"
                v-for="Course in Courses"
                :key="Course.id"
            >
                <img :src="`/photos/${Course.image}`" class="rad-6">
                <h3 :style="{color: Course.color}">{{ Course.name }}</h3>
                <button class="font-bold pointer rad-6 c-fff" @click="subscribeCourse(Course.id)">Subscribe</button>
            </div>
            <p v-if="non_resault_courses" class="text-center">No Resault</p>
        </div>
        <div class="Roadmaps hide" id="roadmaps">
            <div class="roadmap space-between rad-6"
                v-for="Roadmap in Roadmaps"
                :key="Roadmap.id"
            >
                <img :src="`/Image/Roadmap/${Roadmap.image}`" class="rad-6">
                <h3>{{ Roadmap.name_track }}</h3>
                <button class="font-bold pointer rad-6 c-fff" @click="subscribeRoadmap(Roadmap.courses)">Get</button>
            </div>
            <p v-if="non_resault_roadmaps" class="text-center">No Resault</p>
        </div>
        <div class="Specialization hide" id="specialization">
            <div class="usr space-between rad-6" v-for="specialization in specializations" :key="specialization.id">
                <img :src="`/Profile/Photo/${specialization.photo}`" class="rad-6">
                <div class="detailsUsr">
                    <h3 class="m-0 text-center w-full">{{ specialization.first_name }} {{ specialization.last_name }}</h3>
                    <span class="d-block text-center">{{ specialization.category }}</span>
                </div>
                <button class="font-bold pointer rad-6 c-fff" @click="goToProfile(specialization.id)">View</button>
            </div>
            <p v-if="non_resault_specialization" class="text-center">No Resault</p>
        </div>
        <div class="Developers hide" id="developers">
            <div class="usr space-between rad-6" v-for="name in Names" :key="name.id">
                <img :src="`/Profile/Photo/${name.photo}`" class="rad-6">
                <div class="detailsUsr">
                    <h3 class="m-0 text-center w-full">{{ name.first_name }} {{ name.last_name }}</h3>
                    <span class="d-block text-center">{{ name.category }}</span>
                </div>
                <button class="font-bold pointer rad-6 c-fff" @click="goToProfile(name.id)">View</button>
            </div>
            <p v-if="non_resault_Names" class="text-center">No Resault</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SearchPage',
    data() {
        return {
            myId: window.user.id,
            query: window.q,
            Courses: [],
            Roadmaps: [],
            specializations: [],
            Names: [],
            users: [],
            user: window.user,
            non_resault_courses: false,
            non_resault_roadmaps: false,
            non_resault_specialization: false,
            non_resault_Names: false,
            tab_active: 'courses',
        }
    },
    methods: {
        getCourses() {
            let query2 = this.query + 's';
            axios.post('/get/all/courses')
            .then (response => {
                let tmp = false;
                for(let i = 0; i < response.data.courses.length; i++) {
                    let courseName2 = response.data.courses[i].name + 's';
                    if (
                        this.query.toLowerCase().includes(response.data.courses[i].name.toLowerCase()) || 
                        response.data.courses[i].name.toLowerCase().includes(this.query.toLowerCase()) ||
                        query2.toLowerCase().includes(response.data.courses[i].name.toLowerCase()) ||
                        courseName2.toLowerCase().includes(this.query.toLowerCase())
                    ) {
                        this.Courses.push(response.data.courses[i]);
                        tmp = true;
                    }
                }
                if (!tmp) {
                    this.non_resault_courses = true;
                }
            })
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message)
                } else {
                    alert(err);
                }
            })
        },
        getRoadmaps() {
            let query2 = this.query + 's';
            axios.post('/get/all/roadmaps')
            .then (response => {
                let tmp = false;
                for(let i = 0; i < response.data.roadmaps.length; i++) {
                    let roadmap2 = response.data.roadmaps[i].name_track + 's';
                    if (
                        this.query.toLowerCase().includes(response.data.roadmaps[i].name_track.toLowerCase()) || 
                        response.data.roadmaps[i].name_track.toLowerCase().includes(this.query.toLowerCase()) ||
                        query2.toLowerCase().includes(response.data.roadmaps[i].name_track.toLowerCase()) ||
                        roadmap2.toLowerCase().includes(this.query.toLowerCase())
                    ) {
                        this.Roadmaps.push(response.data.roadmaps[i]);
                        tmp = true;
                    }
                }
                if (!tmp) {
                    this.non_resault_roadmaps = true;
                }
            })
            .catch (err => {
                if (err.response) {
                    alert(err.response.data.message)
                } else {
                    alert(err);
                }
            })
        },
        async getSpecializations() {
            let query2 = this.query + 's';
            let tmp = false;
            await this.getUsers();
            for (let i = 0; i < this.users.length; i++) {
                if (this.user.id !== this.users[i].id) {
                    let name2 = this.users[i].category + 's';
                    if (
                        this.query.toLowerCase().includes(this.users[i].category.toLowerCase()) ||
                        this.users[i].category.toLowerCase().includes(this.query.toLowerCase()) ||
                        query2.toLowerCase().includes(this.users[i].category.toLowerCase()) ||
                        name2.toLowerCase().includes(this.query.toLowerCase())
                    ) {
                        this.specializations.push(this.users[i]);
                        tmp = true;
                    }
                }
            }
            if (!tmp) {
                this.non_resault_specialization = true;
            }
        },
        async getNames() {
            let query2 = this.query + 's';
            let tmp = false;
            await this.getUsers();
            for (let i = 0; i < this.users.length; i++) {
                if (this.user.id !== this.users[i].id) {
                    let name2 = this.users[i].first_name + 's';
                    let name3 = this.users[i].last_name + 's';
                    if (
                        this.query.toLowerCase().includes(this.users[i].first_name.toLowerCase()) ||
                        this.users[i].first_name.toLowerCase().includes(this.query.toLowerCase()) ||
                        query2.toLowerCase().includes(this.users[i].first_name.toLowerCase()) ||
                        name2.toLowerCase().includes(this.query.toLowerCase()) ||
                        this.query.toLowerCase().includes(this.users[i].last_name.toLowerCase()) ||
                        this.users[i].last_name.toLowerCase().includes(this.query.toLowerCase()) ||
                        query2.toLowerCase().includes(this.users[i].last_name.toLowerCase()) ||
                        name3.toLowerCase().includes(this.query.toLowerCase())
                    ) {
                        this.Names.push(this.users[i]);
                        tmp = true;
                    }
                }
            }
            if (!tmp) {
                this.non_resault_Names = true;
            }
        },
        async getUsers() {
            try {
                const response = await axios.post('/get/all/users');
                this.users = response.data.users;
            } catch (err) {
                if (err.response) {
                    alert(err.response.data.message);
                } else {
                    alert(err);
                }
            }
        },
        subscribeCourse(id) {
            location.href = `/subscribe/course/${id}/user/${this.user.id}`;
        },
        subscribeRoadmap (arr) {
            location.href = `/Get/Courses/${arr}`;
        },
        moveSearch (v) {
            let moves = ['courses', 'roadmaps', 'specialization', 'developers'];
            moves.forEach((move) => {
                let e = this.$el.querySelector('#'+move);
                if (!e.classList.contains('hide')) {
                    e.classList.add('hide');
                }
            });
            let e = this.$el.querySelector('#'+v);
            e.classList.remove('hide');
            this.tab_active = v;
        },
        goToProfile (id) {
            location.href = `/user/profile?id=${id}`;
        }
    },
    mounted() {
        this.getCourses();
        this.getRoadmaps();
        this.getSpecializations();
        this.getNames();
    }
}
</script>

<style lang="scss">
@media (max-width: 991px) {
    aside {
        display: none;
    }
    .containerSearchPage {
        margin-left: 45px;
    }
}
    .containerSearchPage {
        background-color: #e6e6e6;
        padding: 10px 20px;
        box-shadow: 0 5px 8px 0 #b2b2b2;
        margin-top: 20px;
        margin-right: 45px;
        @media (max-width: 500px) {
            width: 350px;
            margin: 20px auto;
        }
        ul {
            background-color: #CCC;
            padding: 10px;
            margin-bottom: 50px;
            a {
                color: black;
                transition: .3s;
                &:hover {
                    color: var(--main-color);
                }
            }
            .current {
                color: var(--main-color);
            }
            @media (max-width: 600px) {
                flex-direction: column;
                li {
                    margin: 10px auto;
                }
            }
        }
        .course,.roadmap,.usr {
            background-color: #8e8e8ec7;
            padding: 15px;
            margin-bottom: 15px;
            @media(max-width: 700px){
                flex-direction: column;
                img {
                    margin: 10px auto;
                    width: 200px;
                }
                h3 {
                    text-align: center;
                }
                .detailsUsr {
                    margin-bottom: 20px;
                }
                button {
                    width: fit-content;
                    margin: auto;
                }
            }
        }
        img {
            width: 100px;
            height: 66px;
        }
        button {
            background-color: var(--color-button);
            padding: 10px 20px;
            border: none;
            outline: none;
            &:hover {
                background-color: var(--color-button-hover);
            }
        }
        .detailsUsr {
            margin: auto 0;
            h3 {
                font-size: 30px;
            }
            p {
                font-size: 13px;
                color: #d8d6d6;
            }
        }
    }
</style>