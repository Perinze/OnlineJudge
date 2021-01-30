import fetch from "../config/fetch";

// 获取比赛排名list
export const getContestRank = (id) => fetch(`/rank/contest/${id}`);