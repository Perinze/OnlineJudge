import Vue from 'vue';
import VueRouter from 'vue-router';

import mainpage from '../page/mainpage';
import problemlist from '../page/problemlist';
import contestlist from '../page/contestlist';
import problemdetail from '../page/tempProblemDetail';
import contestrank from '../page/contest-rank';
import contestpage from '../page/contestpage';
import discusslist from '../page/discusslist';
import discussdetail from '../page/discussdetail';
import submitpage from '../page/submitpage';
import page404 from '../page/page404';

Vue.use(VueRouter);

const routes = [
    {
        // 重定向到主页
        path: '',
        redirect: '/main'
    },
    {
        // 主页
        path: '/main',
        component: mainpage,
        meta: {
            isLogin: false
        }
    },
    {
        // 题目列表
        path: '/problem',
        component: problemlist,
        meta: {
            isLogin: false
        }
    },
    {
        // 题目详情
        path: '/problem/:id',
        component: problemdetail,
        meta: {
            isLogin: false
        }
    },
    {
        // 比赛列表
        path: '/contest',
        component: contestlist,
        meta: {
            isLogin: false
        }
    },
    {
        // 比赛主页
        path: '/contest/:id',
        component: contestpage,
        meta: {
            isLogin: true
        }
    },
    {
        // 比赛排行榜
        path: '/rank/:id',
        component: contestrank,
        meta: {
            isLogin: true
        }
    },
    {
        // (某场比赛)讨论板列表
        path: '/discuss/:id',
        component: discusslist,
        meta: {
            isLogin: true
        }
    },
    {
        // (某场比赛)讨论板单条详情
        path: '/discuss/:id/:did',
        component: discussdetail,
        meta: {
            isLogin: true
        }
    },
    {
        //  提交页面 redirect
        path: '/submit',
        redirect: '/submit/1000',
        meta: {
            isLogin: true
        }
    },
    {
        // 提交页面
        path: '/submit/:pid',
        component: submitpage,
        meta: {
            isLogin: true
        }
    },
    {
        // default
        path: '*',
        component: page404,
        meta: {
            isLogin: false
        }
    }
];

var router = new VueRouter({
    mode: 'history',
    routes: routes
});

export default router;