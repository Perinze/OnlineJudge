module.exports = {
  status: 0,
  message: "查询成功",
  data: {
    discuss: {
      id: 1,
      problem_id: 1001,
      contest_id: 1001,
      user_id: 1,
      nick: "123",
      title: "wyhsb",
      content: "wyhsb",
      time: "2019-10-13 15:49:45",
      status: 1,
    },
    reply: {
      data: [
        {
          id: 1,
          user_id: 1,
          nick: "123",
          discuss_id: 1,
          content: "wyhqssb",
          time: "2019-10-13 15:52:12",
        },
        {
          id: 2,
          user_id: 1,
          nick: "123",
          discuss_id: 1,
          content: "wyhsb",
          time: "2019-10-13 16:02:05",
        },
        {
          id: 3,
          user_id: 1,
          nick: "123",
          discuss_id: 1,
          content: "wyhsb",
          time: "2019-10-13 16:02:43",
        },
      ],
      count: 3,
    },
  },
};
