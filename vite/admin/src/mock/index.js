// 引入Mock文件，由于 Vite 不支持require()方法所以改用import
import Mock from "mockjs";

const baseAdId = 95226; // ad_id 的基准值
const data = []; // 存储生成的广告数据

// 生成20条广告数据
for (let i = 0; i < 10; i++) {
  const startDate = new Date("2023-03-14").getTime();
  const endDate = new Date("2023-05-17").getTime() - 1; // 区间右侧不包含，所以这里需要减一毫秒
  const randomDate = new Date(Mock.Random.integer(startDate, endDate));

  data.push({
    id: i + 1,
    ad_id: (baseAdId - Mock.Random.integer(1, 2)).toString(),
    ad_type: Mock.Random.pick(["view", "click"]),
    ad_time: randomDate.toISOString().replace("T", " ").substr(0, 19),
  });
}

//生成统计数据
// { id: "2666", date: "2023-05-15", count: "3", type: "click" },
const count = [];
// 时间范围
const startDate = new Date("2023-05-14");
const endDate = new Date("2023-05-30");

// 假设有5个id和2个type
const ids = ["1", "2", "3"];
const types = ["view", "click","null"];

// 遍历所有id和type的组合
for (let id of ids) {
  for (let type of types) {
    // 为每个id的每个type在每个日期生成随机数据
    for (
      let date = new Date(startDate);
      date <= endDate;
      date.setDate(date.getDate() + 1)
    ) {
      const dateString = date.toISOString().slice(0, 10);
      count.push({
        id,
        type,
        date: dateString,
        count: Mock.Random.natural(60, 100),
      });
    }
  }
}
export { data, count };
