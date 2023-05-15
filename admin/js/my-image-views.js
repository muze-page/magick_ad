console.log(imageViewsData);

//将数据写入本地
const add = (data) => {
  const obj = JSON.stringify(data);
  localStorage.setItem("magick_ad_count", obj);
};
add(imageViewsData);
