<template>
    <div class="welcome">
        <div class="welcome-main">
            <div class="welcome-view">
                <div class="welcome-view-content">
                    <span class="welcome-title">欢迎</span>
                    <span class="welcome-subtitle">感谢您选择WUTOJ，我们将为您提供最优质在线题库、赛事资讯、小组管理等服务。</span>
                    <span class="welcome-intro">WUTOJ是由武汉理工大学学生独立开发运营的在线评测系统。我们致力于为您提供最优质OJ服务，同时也欢迎您提供宝贵建议</span>
                    <span class="welcome-logo">ACM@WUT</span>
                </div>
            </div>
            <div class="welcome-interact">
                <span class="login-guide-1">我们将引导您完成注册步骤</span>
                <span class="login-guide-2">如果您已有账户可以选择：</span>
                <button class="login-button">Login</button>
                <span class="register-guide">点击下方"Sign up"按钮即可开始注册</span>
                <button class="register-button">Sign up</button>
                <span class="tourist-guide">如果您还未准备好注册账户，可以选择</span>
                <a>继续以游客模式访问</a>
                <span class="tourist-intro">您仍可以浏览页面，但个别功能无法使用</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "welcome"
    }
</script>

<style scoped>
    .welcome {
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.2);
        z-index: 1002;
    }

    .welcome-main {
        width: 280px;
        height: 200px;
        border-radius: 10px;
        z-index: 1003;
    }

    .welcome-view {

    }

    .welcome-interact {

    }
</style>