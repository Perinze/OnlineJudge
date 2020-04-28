<template>
    <div class="top-nav" :style="styleObject" v-if="this.$store.state.ui.isShowTopnav">
        <div class="search-bar">
            <img src="../../assets/icon/search.svg" width="16px" height="16px">
            <input type="text" class="search-input" placeholder="Search problem, contest or user">
        </div>
    </div>
</template>

<script>
    export default {
        name: "top-nav",
        props: ['topnavOpacity', 'mineWidth' ],
        computed: {
            styleObject() {
                return {
                    width: this.mineWidth,
                    background: `rgba(255,255,255,${this.topnavOpacity})`
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .top-nav {
        display: flex;
        flex-direction: column;
        position: fixed;
        height: 60px;
        z-index: 999;
        background: white;
        transition: background .1s ease 0s,
        width 0.5s ease-in;
        color: #888888;
    }
    .search-bar {
        margin: 0 auto;
        display: flex;
        align-items: center;
        position: relative;
        top: 13px;
        width: 90%;
        max-width: 1230px;
        height: 35px;
        border-radius: 17.5px;
        background: rgba(255,255,255,0.3);
        >input, >input::placeholder, >img, & {
            transition: all .6s ease 0s;
        }
        &:hover {
            background: rgba(255,255,255,0.5);
            >input::placeholder  {
                color: #888888;
            }
        }
        &:focus, &:hover {
            >img {
                filter: invert(0.4);
            }
        }
        &:active {
            background: rgba(255,255,255,0.5);
        }
        >img {
            position: absolute;
            left: 16px;
            filter: invert(0.8);
        }
        >input {
            display: unset;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0);
            border-radius: inherit;
            padding-left: 42px;
            border: none;
            outline: none;
            -webkit-tap-highlight-color: rgba(0,0,0,0);
            &::placeholder {
                font-size:15px;
                font-weight:300;
                color: #BBBBBB;
            }
            &:focus::placeholder  {
                color: #888888;
            }
        }
    }
    @media (max-width: 1543px) and (min-width: 1280px) {
        .search-bar {
            max-width: 996px;
            left: 13px;
        }
    }
</style>
