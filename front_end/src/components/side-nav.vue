<template>
    <div id="side-bar">
        <div class="logo">

        </div>
        <div class="menu-userbar" align="center">
            <div class="user-alias-border">
                <div class="user-alias">
                    <!--<img src="../assets/logo.png" height="120" width="120"/>-->
                    <div style="background: #1CC09F;height: 100%;width:100%"></div>
                </div>
            </div>
            <div class="user-info">

            </div>
        </div>
        <div style="background: #4cae4c">
            <div class="menu-item">

            </div>
            <div class="menu-item">

            </div>
            <div class="menu-item">

            </div>
            <div class="menu-item">

            </div>
            <div class="menu-item">

            </div>
        </div>
        <div id="menu-footer" align="center">
            <span class="menu-footer-content">ACM@WUT</span>
            <br>
            <span class="menu-footer-content">©2019 WUT ACM Developer</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "side-nav"
    }
</script>

<style scoped>
    #side-bar {
        height: 100%;
        width: 200px;
        background: white;
        position: fixed;
    }

    .logo {
        height: 40px;
        background: #a94442;
    }

    .menu-userbar {
        text-align: center;
        height: 220px;
        background: #66512c;
    }

    .user-alias-border {
        position: absolute;
        margin-left: 63px;
        margin-top: 10px;
        border-radius: 37px;
        border: 1px solid #00c7ff;
        height: 74px;
        width: 74px;
    }

    .user-alias {
        position: absolute;
        margin-top: 3px;
        margin-left: 3px;
        height: 66px;
        width: 66px;
        border-radius: 33px;
        overflow: hidden;
    }

    #menu-footer {
        width: 100%;
        background: #8A8A8A;
        display: block;
        position: absolute;
        bottom: 7px;
    }

    .menu-footer-content {
        align-self: center;
        font-size: 0.08em;
    }

    .menu-item {
        height: 50px;
        border: 1px solid black;
    }
</style>