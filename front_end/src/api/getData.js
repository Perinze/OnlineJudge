import fetch from '../config/fetch';

// 用户逻辑

/**
 * 登陆
 */

export const login = data => fetch('/Login/login', 'post', data);




// 业务逻辑

/**
 * 获取公告列表
 */

export const getNotice = () => fetch('/Index/notice');

/**
 * 获取滚动图列表
 */

export const getCarousel = () => fetch('/Index/rotation');

/**
 * 获取日常数据(十三天内的提交量/通过量)
 */

export const getDailydata = () => fetch('/Index/data');




// 题目逻辑

/**
 * 获取题目列表
 */

export const getProblemList = () => fetch('/Problem/displayAllProblem');

/**
 * 获取题目信息
 */

export const getProblem = data => fetch('/Problem/displayProblem', 'post', data);




// 比赛逻辑

/**
 * 获取比赛列表
 */

export const getContestList = () => fetch('/Contest/getAllContest');

/**
 * 获取比赛详情
 */

export const getContest = data => fetch('/Contest/getTheContest', 'post', data);

