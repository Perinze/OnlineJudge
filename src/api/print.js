import fetch from "../config/fetch";

export const printRequest = (data) => fetch("/print","post",data);