import fetch from "../config/fetch";

// TODO 获取题目列表 params
export const getProblemList = (data) => fetch(`/problems?page_number=${data.page}`, "get", data);

// TODO 获取题目信息 params
export const getProblem = (data) => fetch(`/problems/problem/${data.problem_id}`, "get");
