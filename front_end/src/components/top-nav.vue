<template>
    <div class="top-nav" align="center">
        <div class="search-bar">
            <img src="../assets/search.svg" width="16px" height="16px">
            <input type="text" class="search-input" placeholder="Search transactions, invoices or help">
        </div>
    </div>
</template>

<script>
    export default {
        name: "top-nav"
    }
</script>

<style scoped>
    .top-nav {
        position: fixed;
        padding-left: 200px;
        width: 100%;
        height: 60px;
        z-index: 999;
    }

    .search-bar {
        display: flex;
        align-items: center;
        position: relative;
        top: 13px;
        width: 1230px;
        height: 35px;
        opacity: 0.5;
        border-radius: 17.5px;
        /*background: rgba(255,255,255,0.3);*/
        background: rgba(0,0,0,0.3);
    }

    .search-bar >img {
        position: absolute;
        left: 16px;
    }

    .search-bar >input {
        display: unset;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0);
        border-radius: inherit;
        padding-left: 42px;
        border: none;
    }
</style>