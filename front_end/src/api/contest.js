import fetch from "../config/fetch";

// 获取比赛列表
export const getContestList = () => fetch("/contests");

// 获取比赛详情
export const getContest = (id) => fetch(`/contests/${id}`);

// 获取用户参加比赛的数据
export const getUserContest = (id) => fetch(`/contests/user/${id}`);

// 加入比赛
export const joinContest = (cid, uid) => fetch(`/contests/${cid}/user/${uid}`, "post");