// 引入Mock文件，由于 Vite 不支持require()方法所以改用import
import Mock from "mockjs";

const baseAdId = 95226; // ad_id 的基准值
const data = []; // 存储生成的广告数据

// 生成20条广告数据
for (let i = 0; i < 100000; i++) {
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

export { data };
