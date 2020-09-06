// module.exports = {
//   name: "kdl12138",
//   desc: "sbzz",
// };

module.exports = function(method, data) {
  return Object.assign(data, { random: Math.random() });
};
