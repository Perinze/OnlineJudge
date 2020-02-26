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
import submitdetail from '../page/submitdetail';
import page404 from '../page/page404';
import group from '../page/group';
import addGroup from '../page/addGroup';
import editAdmin from '../page/editAdmin';
import addProblem from '../page/addProblem';
import groupManager from '../page/groupManager';
import discussion from '../page/discussion';
import discussionInfo from '../page/discussionInfo';
import addDiscussion from '../page/addDiscussion';
import achievement from "../page/achievement";
import achievementInfo from "../page/achievementInfo";
import rank from '../page/rank';
import store from "../store/index";

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
        path: '/plist',
        component: problemlist,
        meta: {
            isLogin: false
        }
    },
    {
        // 题目详情
        path: '/problem',
        component: problemdetail,
        props: (route) => ({
            pid: route.query.p, // 题目标号
            cid: route.query.c  // 比赛标号
        }),
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
        // 提交页面
        path: '/submit',
        component: submitpage,
        props: (route) => ({
            pid: route.query.p, // 题目标号
            cid: route.query.c  // 比赛标号
        }),
        meta: {
            isLogin: true
        }
    },
    {
        // 提交详情
        path: '/status',
        component: submitdetail,
        props: (route) => ({
            pid: route.query.p,   // 题目标号
            sid: route.query.s,   // 提交标号
            cid: route.query.c    // 比赛标号
        }),
        meta: {
            isLogin: true
        }
    },
    {
        // 小组首页
        path: '/group',
        component: group,
        meta: {
            isLogin: false
        }
    },
    {
        // 新增小组
        path: '/addGroup',
        component: addGroup,
        meta: {
            isLogin: false
        }
    },
    {
        // 设置管理员
        path: '/editAdmin',
        component: editAdmin,
        meta: {
            isLogin: false
        }
    },
    {
        // 创建题库
        path: '/addProblem',
        component: addProblem,
        meta: {
            isLogin: false
        }
    },
    {
        // 小组管理
        path: '/groupManager',
        component: groupManager,
        meta: {
            isLogin: false
        }
    },
    {
        // 讨论区
        path: '/discussion',
        component: discussion,
        meta: {
            isLogin: false
        }
    },
    {
        // 讨论区某条帖子
        path: '/discussionInfo',
        component: discussionInfo,
        meta: {
            isLogin: false
        }
    },
    {
        // 新增帖子
        path: '/addDiscussion',
        component: addDiscussion,
        meta: {
            isLogin: false
        }
    },
    {
        // 排行榜
        path: '/rank',
        component: rank,
        meta: {
            isLogin: false
        }
    },
    {
        // default
        path: '*',
        component: page404,
        meta: {
            isLogin: false
        }
    },
    {
        //知识树
        path: '/achievement',
        component: achievement,
        meta: {
            isLogin: false
        }
    },
    {
        //知识树详情
        path: '/achievementInfo',
        component: achievementInfo,
        meta: {
            isLogin: false
        }
    },
];

var router = new VueRouter({
    mode: 'history',
    routes: routes
});

const pathArr_noTopnav = ["/addGroup", "/editAdmin", "/addProblem", "/groupManager", "/discussionInfo", "/addDiscussion","/achievementInfo"];

router.beforeEach((to, from, next) => {
    if (pathArr_noTopnav.indexOf(to.path) >= 0) {
        store.dispatch("ui/changeIsShowTopnav", false);
    } else {
        store.dispatch("ui/changeIsShowTopnav", true);
    }
    next();
})

export default router;
