import fetch from "../config/fetch";

// 获取比赛列表
export const getContestList = () => fetch("/contests");

// 获取比赛详情
export const getContest = (id) => fetch(`/contests/contest/${id}`);

// 获取用户参加比赛的数据
export const getUserContest = () => fetch(`/contests/user`);

// 加入比赛
export const joinContest = (data) => fetch(`/contests/user/${data.contest_id}?user_id=${data.user_id}&status=${data.status}`, "post", data);