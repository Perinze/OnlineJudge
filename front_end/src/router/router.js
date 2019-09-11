import Vue from 'vue';
import VueRouter from 'vue-router';

import mainpage from '../page/mainpage';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: mainpage
    },
    {

    }
];

var router = new VueRouter({
    mode: 'history',
    routes: routes
});

export default router;