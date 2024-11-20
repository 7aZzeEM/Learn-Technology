<template>
    <div class="course" v-for="course in courses">
        <a :href="`/Watch/${course.name}`" class="InMobile font-bold" :style="{color: course.color}">{{ course.name }}</a>
        <details>
            <summary :style="{color: course.color}" class="font-bold d-flex">{{ course.name }}</summary>
            <span class="d-block font-bold text-right">{{ course.videos }} video</span>
            <p class="align-center font-bold">Rate: <progress :value="100 * (course.videosEnd / course.videos)" max="100"></progress></p>
            <div class="buttons justify-center wrap">
                <a :href="`/Watch/${course.name}`" class="continue d-block w-fit font-bold c-fff rad-6">Watch</a>
                <a
                    :href="`/remove/course/${course.id}/user/${user.id}`"
                    class="remove d-block w-fit font-bold c-fff rad-6"
                    v-if="course.videos !== course.videosEnd"
                >
                    Remove
                </a>
            </div>
        </details>
    </div>
</template>

<script>
export default {
    name: 'Aside',
    data() {
        return {
            courses: window.user.courses_sub,
            user: window.user,
        }
    }
}
</script>

<style lang="scss">
    aside {
        .InMobile {
            display: none;
            font-size: 20px;
            margin: 20px 0;
        }
        flex: .5;
        background-color: #e6e6e6;
        box-shadow: 0 5px 8px 0 #b2b2b2;
        margin-top: 5px;
        padding: 10px;
        margin-right: 45px;
        @media (max-width: 700px) {
            details {
                display: none;
            }
            .InMobile {
                display: block;
            }
        }
        @media (max-width: 480px) {
            margin-right: 0;
        }
        details {
            margin: 20px 0;
            summary {
                font-size: 20px;
                cursor: pointer;
                @media (max-width: 448px) {
                    font-size: 15px;
                }
            }
            span {
                padding-right: 20px;
                font-size: 13px;
                color: #bb0c0c;
            }
            p {
                color: var(--main-color);
                progress {
                    height: 25px;
                    margin-left: 15px;
                    margin-right: 5px;
                }
            }
            .buttons {
                gap: 10px;
            }
            .continue {
                background-color: var(--color-button);
                padding: 10px 20px;
            }
            .remove {
                background-color: #c60707;
                padding: 10px 20px;
            }
        }
    }
</style>