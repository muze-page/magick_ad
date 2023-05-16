//广告统计表格数据
//adCountData

//将数据写入本地
const add = (data) => {
  const obj = JSON.stringify(data);
  localStorage.setItem("magick_ad_count_data", obj);
};
add(adCountData);

console.table(adCountData);
