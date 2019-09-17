import Vue from 'vue';
import VueRouter from 'vue-router';

import mainpage from '../page/mainpage';
import problemlist from '../page/problemlist';
import contestpage from '../page/contestpage';

Vue.use(VueRouter);

const routes = [
    {
        path: '',
        redirect: '/main'
    },
    {
        path: '/main',
        component: mainpage
    },
    {
        path: '/problem',
        component: problemlist
    },
    {
        path: '/contest',
        component: contestpage
    }
];

var router = new VueRouter({
    mode: 'history',
    routes: routes
});

export default router;