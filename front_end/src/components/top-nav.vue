<template>
    <div class="top-nav" :style="{background: 'rgba(255,255,255,'+topnavOpacity+')'}">
        <div class="search-bar">
            <img src="../assets/icon/search.svg" width="16px" height="16px">
            <input type="text" class="search-input" placeholder="Search problem, contest or user">
        </div>
    </div>
</template>

<script>
    export default {
        name: "top-nav",
        props: ['topnavOpacity']
    }
</script>

<style scoped>
    .top-nav {
        display: flex;
        flex-direction: column;
        position: fixed;
        padding-left: 200px;
        width: 100%;
        height: 60px;
        z-index: 999;
        background: white;
        transition: background .1s ease 0s;
        color: #888888;/*rgba(,1);*/
        /*-webkit-backdrop-filter: blur(10px);*/
    }

    .search-bar {
        margin: 0 auto;
        display: flex;
        align-items: center;
        position: relative;
        top: 13px;
        width: 1230px;
        height: 35px;
        /*opacity: 0.5;*/
        border-radius: 17.5px;
        background: rgba(255,255,255,0.3);
        transition: all .6s ease 0s;
        /*background: rgba(0,0,0,0.3);*/
    }

    .search-bar:hover {
        background: rgba(255,255,255,0.5);
        transition: all .6s ease 0s;
    }

    .search-bar >img {
        position: absolute;
        left: 16px;
        filter: invert(0.8);
        transition: all .6s ease 0s;
    }

    .search-bar >input {
        display: unset;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0);
        border-radius: inherit;
        padding-left: 42px;
        border: none;
        outline: none;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
        transition: all .6s ease 0s;
    }

    .search-bar >input::placeholder {
        font-size:15px;
        font-weight:300;
        color: #BBBBBB;
        transition: all .6s ease 0s;
    }

    .search-bar >input:focus::placeholder  {
        color: #888888;
        transition: all .6s ease 0s;
    }

    .search-bar:hover >input::placeholder  {
        color: #888888;
        transition: all .6s ease 0s;
    }

    .search-bar:hover >img {
        filter: invert(0.4);
        transition: all .6s ease 0s;
    }

    .search-bar:focus >img {
        filter: invert(0.4);
        transition: all .6s ease 0s;
    }

    @media (max-width: 1543px) and (min-width: 1280px) {
        .search-bar {
            width: 996px;
            left: 13px;
        }
    }
</style>