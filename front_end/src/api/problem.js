import fetch from "../config/fetch";

// TODO 获取题目列表 params
export const getProblemList = (data) => fetch("/problems", "get", data);

// TODO 获取题目信息
export const getProblem = (id) => fetch(`/problems/${id}`);
