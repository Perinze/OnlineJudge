<template>
    <div id="blur-header" class="content-blurred">
        <div style="z-index: 2">
            <component
                    :is="componentBlur"
            >
            </component>
        </div>
        <svg id="svg-image-blur">
            <filter id="blur-effect">
                <feGaussianBlur stdDeviation="20" />
            </filter>
        </svg>
    </div>
</template>

<script>
    import mainpage from "./mainpage"

    export default {
        name: "blur_nav",
        components: {mainpage},
        props: {
            componentName: String
        },
        data() {
            return {
                componentBlur: this.componentName
            }
        }
    }
</script>

<style scoped>
    #blur-header{
        width: 77.5%;
        height: 100px;
        overflow:hidden;
        position: fixed;
        left: 200px;
        top: 0;
        background: #111111;
        background-blend-mode: darken;
        z-index:999;
        box-shadow:0 1px 0 rgba(0,0,0,.5),0 1px 2px rgba(0,0,0,.5);
    }

    .content-blurred {
        /*position:relative;*/
        top:0;
        left:0;
        right:0;
        -webkit-filter:blur(20px);
        filter:url(#blur-effect);
        opacity:.55;
        z-index: 998;
    }
</style>