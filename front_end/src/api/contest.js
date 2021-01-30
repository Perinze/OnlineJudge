import fetch from "../config/fetch";

// TODO 获取比赛列表
export const getContestList = () => fetch("/contests");

// TODO 获取比赛详情
export const getContest = (id) => fetch(`/contests/${id}`);

// TODO 获取用户参加比赛的数据
export const getUserContest = (id) => fetch(`/contests/user/${id}`);

// TODO 加入比赛
export const joinContest = (cid, uid) => fetch(`/contests/${cid}/user/${uid}`, "post");