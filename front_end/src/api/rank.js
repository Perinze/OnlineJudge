import fetch from "../config/fetch";

// TODO 获取比赛排名list
export const getContestRank = (id) => fetch(`/rank/contest/${id}`);