import fetch from "../config/fetch";

// 用户逻辑

/**
 * 找回密码-发送验证码
 */

export const getCaptcha = (data) =>
  fetch("/Login/forgetPassword", "post", data);

/**
 * 找回密码-验证验证码
 */

export const forgetPassword = (data) =>
  fetch("/forgetPassword", "post", data);

/**
 * 检查登录状态
 */

export const checkLogin = (data) => fetch("/Login/checkLogin", "get");

// 业务逻辑

/**
 * 获取PV数据（百度统计API）
 */

export const getPvData = (data, header) =>
  fetch(
    "https://api.baidu.com/json/tongji/v1/ReportService/getData",
    "post",
    data,
    header
  );

// 比赛逻辑

/**
 * 检查用户是否参加了某场比赛
 */
export const checkUserContest = (contest_id) =>
  fetch(`/contests/user/${contest_id}`, "get");

// 讨论板

// 获取某场比赛用户相关讨论列表
export const getUserDiscuss = (data) => fetch("/discuss/getUserDiscuss", "post", data);

// 获取比赛通知
export const getNotificationByID = (data) => fetch("/Notification/getNotificationByID", "post", data);

// 状态

/**
 * 获取提交返回
 */

export const getSubmitInfo = (data) =>
  fetch("/submit/get_submit_info", "post", data);

/**
 * 获取评测信息
 */

export const getStatus = (data) =>
  fetch("/Submit/getSubmitStatus", "post", data);

// 反馈系统

/**
 * 提交反馈
 */

export const submitFeedback = (data) =>
  fetch("/feedback/add_feedback", "post", data);

// 小组（被砍了）

/**
 * 创建小组
 */

export const addGroup = (data) => fetch("/Group/add_group", "post", data);

/**
 * 获取用户所属小组
 */

export const getUserGroups = () => fetch("/Group/user_get_all_group");

// TODO 获取所有讨论 查查这是个啥
export const getAllTopic = (data) => fetch("/discuss/getAllTopic", "post", data);

/**
 * 上传图片
 */

export const uploadImage = (data) => fetch("/upload/upload_image", "post", data);

/**
 * 上传头像
 */

export const uploadAvatar = (data) => fetch("/upload/upload_avatar", "post", data);

/**
 * 查找用户
 */

export const searchUser = (data) => fetch("/User/searchUser", "post", data);

// Test

/**
 * Twitter API
 * close VPN to test timeout
 */

export const testRequest = () =>
  fetch("https://analytics.twitter.com/tpm/p?_=1571277967228");

/**
 * Test Error 404
 */

export const testError = () => fetch("/Base/index");

// knowledgeTree(砍了)

/**
 * 获取知识树星级排名，待下一版添加
 */

// export const getUserRank = () => fetch('/achievement/getUserRank');

/**
 * 获取知识树上知识点
 */

export const getAllKnowledge = () => fetch("/knowledge/getAllKnowledge");

/**
 * 获取知识点对应标签 
 */

export const getAllTag = (data) => fetch("/knowledge/getAllTag", "post", data);
