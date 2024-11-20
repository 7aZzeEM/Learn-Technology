<template>
    <div class="contentCourses">
        <div class="errors w-fit rad-6" v-if="Errors">
            <span class="d-block text-center font-bold">Error</span>
            <div class="e" v-for="err in JSON.parse(Errors)">
                <p>{{ err }}</p>
            </div>
        </div>
        <div class="warnings w-fit rad-6" v-if="Message">
            <span class="d-block text-center font-bold">Warning</span>
            <p>{{ Message }}</p>
        </div>
        <div class="succ w-fit rad-6" v-if="Done">
            <span class="d-block text-center font-bold">Successfully</span>
            <p>{{ Done }}</p>
        </div>
        <div class="courses">
            <div class="coursesPage d-flex rad-6" v-for="course in courses">
                <img :src="`/photos/${course.image}`" :alt="course.name" class="w-full">
                <span class="text-center font-bold" :style="{color: course.color}">{{ course.name }}</span>
                <a :href="`/subscribe/course/${course.id}/user/${user.id}`" class="w-fit m-auto rad-6 font-bold c-fff">Subscripe</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CoursesPage',
    data() {
        return {
            courses: window.courses,
            user: window.user,
            Errors: window.errors,
            Message: window.message,
            Done: window.done,
        }
    }
}
</script>

<style lang="scss">
    .errors,.warnings,.succ {
        margin: 45px auto 0;
        padding: 20px;
        p {
            width: 300px;
            @media (max-width: 500px) {
                width: 250px;
            }
            @media (max-width: 436px) {
                width: 200px;
            }
        }
    }
    .errors {
        background-color: var(--error-message);
    }
    .warnings {
        background-color: var(--warning-message);
    }
    .succ {
        background-color: var(--successfully-message);
    }
    .courses {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .coursesPage {
        flex-direction: column;
        margin: 30px 10px;
        background-color: #e6e6e6;
        box-shadow: 0 5px 8px 0 #b2b2b2;
        padding: 20px;
        width: 300px;
        transition: .3s;
        cursor: pointer;
        @media (max-width: 480px) {
            width: 220px;
        }
        img {
            height: 200px;
        }
        span {
            margin: 10px 0;
            font-size: 25px;
        }
        a {
            padding: 10px 20px;
            border: none;
            background-color: var(--color-button);
            cursor: pointer;
        }
        a:hover {
            background-color: var(--color-button-hover)
        }
    }
    .coursesPage:hover {
        transform: translateY(-15px);
    }
</style>