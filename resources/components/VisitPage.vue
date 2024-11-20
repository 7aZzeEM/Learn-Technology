<template>
    <div class="pageProfile d-grid">
        <div class="detailsOfMe grid-center p-relative">
            <div class="image m-auto">
                <img :src="`/Profile/Photo/${user.photo}`" class="w-full pointer h-full">
            </div>
            <h1 class="text-center m-0">{{ user.first_name }} {{ user.last_name }}</h1>
            <div class="category p-relative m-auto">
                <p class="m-0">{{ user.category }}</p>
            </div>
            <div class="someDetails">
                <p class="d-flex" v-for="link in JSON.parse(user.links)">
                    {{ link.name }}: <a :href="link.url" class="font-bold d-block">here</a>
                </p>
            </div>
        </div>
        <div class="detailsOfProjects">
            <div class="projects">
                <span class="titProjects font-bold d-block">Projects</span>
                <div class="getProjects">
                    <p class="space-between" v-for="project in JSON.parse(user.projects)">
                        {{ project.name }}: <a :href="project.url" class="d-block">Go</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="detailsOfCourses">
            <div class="containerCourses">
                <span class="TitOfRates">Rate Of Courses</span>
                <div class="course" v-for="course in JSON.parse(user.courses_sub)">
                    <span class="font-bold">{{ course.name }}</span>
                    <progress :value="100 * (course.videosEnd / course.videos)" max="100" class="h-full align-center w-full"></progress>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'VisitPage',
    data() {
        return {
            user: window.otherUser,
        }
    },
    methods: {},
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
                p {
                    color: var(--main-color);
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
            }
        }
        .detailsOfProjects {
            .projects {
                background-color: #ccc;
                border-radius: 15px;
                padding: 20px;
                margin-top: 20px;
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