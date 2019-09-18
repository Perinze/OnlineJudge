import Vue from 'vue';
import VueRouter from 'vue-router';

import mainpage from '../page/mainpage';
import problemlist from '../page/problemlist';
import contestlist from '../page/contestlist';
import problemdetail from '../page/tempProblemDetail';
import contestrank from '../page/contest-rank';
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
        path: '/problem/:id',
        component: problemdetail
    },
    {
        path: '/contest',
        component: contestlist
    },
    {
        path: '/contest/:id',
        component: contestpage
    },
    {
        path: '/rank/:id',
        component: contestrank
    }
];

var router = new VueRouter({
    mode: 'history',
    routes: routes
});

export default router;