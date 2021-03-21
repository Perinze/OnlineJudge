import fetch from "../config/fetch";

// TODO 获取题目列表 params
export const getProblemList = (data) => fetch("/problems", "get", data);

// TODO 获取题目信息 params
export const getProblem = (data) => {
    return fetch(`/problems/${data.problem_id}`);
}
