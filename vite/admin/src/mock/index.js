// 引入Mock文件，由于 Vite 不支持require()方法所以改用import
import Mock from "mockjs";

// 随机选取 id 和 date，并生成 20 条数据
const data = [];
const ids = ["9527", "9526", "9528"];
const dates = [
  "2023-05-07",
  "2023-05-08",
  "2023-05-09",
  "2023-05-10",
  "2023-05-11",
  "2023-05-12",
  "2023-05-13",
];
for (let i = 0; i < ids.length; i++) {
  const id = ids[i];
  for (let j = 0; j < dates.length; j++) {
    const date = dates[j];
    const count = Mock.Random.integer(120, 200);
    data.push({
      id,
      date,
      count,
    });
  }
}

export { data };
