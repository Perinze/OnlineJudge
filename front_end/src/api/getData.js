import fetch from '../config/fetch';

// 用户逻辑

/**
 * 登陆
 */

export const login = data => fetch('/Login/do_login', 'post', data);

/**
 * 登出
 */

export const logout = () => fetch('/Login/do_logout', 'post', {});

/**
 * 注册
 */

export const register = data => fetch('/Register/register', 'post', data);

/**
 * 找回密码-发送验证码
 */

export const getCaptcha = data => fetch('/Login/forgetPassword', 'post', data);

/**
 * 找回密码-验证验证码
 */

export const forgetPassword = data => fetch('/Login/forgetPassword', 'post', data);

/**
 * 检查登录状态
 */

export const checkLogin = data => fetch('/Login/checkLogin', 'post', data);

/**
 * 获取用户信息
 */

export const getUserInfo = data => fetch('/User/searchUser', 'post', data);

/**
 * 更改用户信息性
 */

export const changeUserInfo = data => fetch('/User/editUser', 'post', data);



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

/**
 * 获取PV数据（百度统计API）
 */

export const getPvData = (data, header) => fetch('https://api.baidu.com/json/tongji/v1/ReportService/getData', 'post', data, header);




// 题目逻辑

/**
 * 获取题目列表
 */

export const getProblemList = () => fetch('/Problem/displayAllProblem');

/**
 * 获取题目信息
 */

export const getProblem = data => fetch('/Problem/displayProblem', 'post', data);

/**
 * Submit Code
 */

export const submitCode = data => fetch('/Submit/submit', 'post', data);




// 比赛逻辑

/**
 * 获取比赛列表
 */

export const getContestList = () => fetch('/Contest/getAllContest');

/**
 * 获取比赛详情
 */

export const getContest = data => fetch('/Contest/getTheContest', 'post', data);

/**
 * 获取用户参加比赛的数据
 */

export const getUserContest = () => fetch('/Contest/getUserContest');

/**
 * 检查用户是否参加了某场比赛
 */

export const checkUserContest = data => fetch('/Contest/checkContest', 'post', data);

/**
 * 加入比赛
 */

export const joinContest = data => fetch('/Contest/joinContest', 'post', data);




// 排名

/**
 * 比赛排名list
 */

export const getContestRank = data => fetch('/Rank/contest_rank', 'post', data);




// 讨论板

/**
 * 获取某场比赛的讨论列表
 */

export const getDiscussList = data => fetch('/discuss/getAlldiscuss', 'post', data);

/**
 * 获取某场比赛的某个讨论内容
 */

export const getDiscussDetail = data => fetch('/discuss/getThediscuss', 'post', data);

/**
 * 获取某场比赛用户相关讨论列表
 */

export const getUserDiscuss = data => fetch('/discuss/getUserDiscuss', 'post', data);

/**
 * 提问问题/发表讨论板
 */

export const addDiscuss = data => fetch('/discuss/add_discuss', 'post', data);

/**
 * 回复问题
 */

export const addReply = data => fetch('/discuss/add_reply', 'post', data);




// 状态

/**
 * 获取提交返回
 */

export const getSubmitInfo = data => fetch('/submit/get_submit_info', 'post', data);

/**
 * 获取评测信息
 */

export const getStatus = data => fetch('/Submit/getSubmitStatus', 'post', data);




// 反馈系统

/**
 * 提交反馈
 */

export const submitFeedback = data => fetch('/feedback/add_feedback', 'post', data);


/**
 * 创建小组
 */

export const addGroup = (data) => fetch('/Group/add_group', 'post', data);

/**
 * 获取用户所属小组
 */

export const getUserGroups = () => fetch('/Group/user_get_all_group');

/**
 * 获取某个小组
 */

export const getTheGroup = (data) => fetch('/Group/get_the_group', 'post', data);

/**
 * 获取所有讨论
 */

export const getAllTopic = (data) => fetch('/discuss/getAllTopic', 'post', data);

/**
 * 上传图片
 */

export const uploadImage = (data) => fetch('/upload/upload_image', 'post', data);

/**
 * 查找用户
 */

 export const searchUser = (data) => fetch('/User/searchUser', 'post', data);

// Test

/**
 * Twitter API
 * close VPN to test timeout
 */

export const testRequest = () => fetch('https://analytics.twitter.com/tpm/p?_=1571277967228');

/**
 * Test Error 404
 */

export const testError = () => fetch('/Base/index');


/**
 * 获取所有讨论
 */

export const getAllDiscussion = (data) => fetch('/discuss/getAllDiscuss', 'post', data);

// knowledgeTree

/**
 * 获取知识树星级排名，待下一版添加
 */

// export const getUserRank = () => fetch('/achievement/getUserRank');

/**
 * 获取知识树上知识点
 */

export const getAllKnowledge = () => fetch('/knowledge/getAllKnowledge');

/**
 * 获取知识点对应标签
 */

export const getAllTag = data => fetch('/knowledge/getAllTag', 'post', data);

