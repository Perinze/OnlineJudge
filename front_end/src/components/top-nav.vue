<template>
    <div class="top-nav" :style="{background: 'rgba(255,255,255,'+topnavOpacity+')'}">
        <div class="search-bar">
            <img src="../assets/search.svg" width="16px" height="16px">
            <input type="text" class="search-input" placeholder="Search transactions, invoices or help">
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
        opacity: 0.5;
        border-radius: 17.5px;
        background: rgba(255,255,255,1);
        /*background: rgba(0,0,0,0.3);*/
    }

    .search-bar >img {
        position: absolute;
        left: 16px;
    }

    .search-bar >img {
        filter: invert(0.4);
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
    }

    .search-bar >input ::placeholder {
        font-size:15px;
        font-weight:400;
        color:rgba(136,136,136,1);
    }
</style>