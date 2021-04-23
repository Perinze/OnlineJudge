import fetch from "../config/fetch";

// TODO 获取公告列表
export const getNotice = () => fetch("/notice");

// 获取滚动图
export const getCarousel = () => fetch("/rotation");

// 获取日常数据(十三天内的提交量/通过量)
export const getDailydata = () => fetch("/data");