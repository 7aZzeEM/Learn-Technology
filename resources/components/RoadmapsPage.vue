<template>
    <div class="messages justify-center">
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
    </div>
    <div class="roadmaps justify-center wrap">
        <div class="roadmap p-relative" v-for="roadmap in Roadmaps">
            <img :src="`/Image/Roadmap/${roadmap.image}`" alt="LogoRoadMap" class="w-full">
            <h3 class="text-center">{{ roadmap.name_track }}</h3>
            <span class="d-block text-right font-bold">{{ roadmap.count_courses }} Courses</span>
            <a class="p-absolute c-fff font-bold rad-6" :href="`/Get/Courses/${roadmap.courses}`">Get Courses</a>
        </div>
    </div>
</template>

<script>
export default {
    name: 'RoadmapsPage',
    data () {
        return {
            Roadmaps: JSON.parse(window.roadmaps),
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
    .roadmaps {
        margin-right: 30px;
        margin-top: 50px;
        gap: 20px;
        .roadmap {
            width: 300px;
            background-color: #e6e6e6;
            padding: 10px 20px;
            box-shadow: 0 5px 8px 0 #b2b2b2;
            margin-bottom: 30px;
            transition: .3s;
            img {
                min-height: 200px;
            }
            span {
                margin-bottom: 70px;
                color: #bb0c0c;
            }
            a {
                bottom: 10px;
                left: 50%;
                transform: translateX(-50%);
                background-color: var(--color-button);
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                &:hover {
                    background-color: var(--color-button-hover);
                }
            }
            &:hover {
                transform: translateY(-20px);
            }
        }
        @media (max-width: 480px) {
            margin-right: 0;
            .roadmap {
                width: 250px;
            }
        }
    }
</style>