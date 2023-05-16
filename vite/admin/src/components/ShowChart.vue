<script setup>
import { defineProps, ref, shallowRef, onMounted, watch } from "vue";
import * as echarts from "echarts/core";
import {
  TitleComponent,
  TooltipComponent,
  GridComponent,
  LegendComponent,
  ToolboxComponent,
} from "echarts/components";
import { LineChart } from "echarts/charts";
import { CanvasRenderer } from "echarts/renderers";
import "echarts/lib/chart/line";
import "echarts/lib/component/tooltip";
import "echarts/lib/component/title";
import "echarts/lib/component/grid";
import "echarts/lib/component/legend";
import "echarts/lib/component/toolbox"; // 引入toolbox组件

// 注册组件
echarts.use([
  TitleComponent,
  TooltipComponent,
  GridComponent,
  LegendComponent,
  LineChart,
  CanvasRenderer,
  ToolboxComponent, // 引入ToolboxComponent组件
]);

//接收数据
const props = defineProps({
  data: Array,
  name: String,
});

// 将数据处理成所需格式
const handleData = (data) => {
  // 获取指定值构成的数组
  /**
   *
   * @param {*} data 待处理的值
   * @param {*} id  待提取的值
   */
  const getArr = (data, id) => {
    // 使用 reduce 函数进行去重
    const idList = data.reduce((prev, current) => {
      if (!prev[current[id]]) {
        prev[current[id]] = true;
      }
      return prev;
    }, {});
    // 将对象属性转换成数组返回
    return Object.keys(idList);
  };

  // 获取展示的数据
  /*
   * data:待处理数据
   * id: id数组
   * date:时间数组
   */
  const arrData = (data, id, date) => {
    // 存储结果
    const list = [];
    // 拿到id
    //forEach() 方法用于调用数组的每个元素，并将元素传递给回调函数。

    //注意: forEach() 对于空数组是不会执行回调函数的。
    id.forEach((item) => {
      const a = data.filter((index) => index.id === item); // 筛选出所有id为指定值的数据 组成包含对象的数组

      // 拿到展示的值
      //map() 方法返回一个新数组，数组中的元素为原始数组元素调用函数处理后的值。

      //map() 方法按照原始数组元素顺序依次处理元素。
      const result = date.map((value) => {
        // 使用 find 方法查找数据，如果找到了则返回对应的 count 值，否则为 0
        let foundItem = a.find((index) => index.date === value);
        if (!foundItem) {
          foundItem = { count: 0 };
        }
        return Number(foundItem.count);
      });

      // 组成数组
      const arr = {
        name: item, //Id 信息
        data: result.reverse(), //时间反转了，这里也要反转下
        type: "line", // 配置信息
        smooth: true, // 配置信息
      };
      list.push(arr);
    });
    return list;
  };

  // 获取ID数组
  const id = getArr(data, "id");
  // 获取时间数组
  const date = getArr(data, "date");
  //保留月和日
  const newArr = date.map((timeString) => {
    const shortTimeString = timeString.replace("-", "");
    const formattedTimeString =
      shortTimeString.slice(4, 6) + "-" + shortTimeString.slice(7, 9);
    return formattedTimeString;
  });
  // 获取展示数据
  const list = arrData(data, id, date);

  const obj = {
    id: id,
    date: [...newArr].reverse(), // 创建一个新的反转后的数组
    data: list,
  };
  return obj;
};

// 测试
// 获取div节点
const main = ref(null);
// 定义全局变量
const chart = shallowRef(); // 这里使用shallowRef，避免进行标签筛选时报错
// 拿到数据并展示
const showEcharts = (item) => {
  // 清理原有数据
  if (chart.value != null && chart.value != "" && chart.value != undefined) {
    chart.value.dispose();
  }
  // 基于准备好的dom，初始化echarts实例
  chart.value = echarts.init(main.value);
  // 准备数据
  const option = {
    title: {
      text: props.name,
    },
    tooltip: {
      trigger: "axis",
    },
    legend: {
      data: item.id,
    },
    grid: {
      left: "3%",
      right: "4%",
      bottom: "3%",
      containLabel: true,
    },
    toolbox: {
      feature: {
        saveAsImage: {},
      },
    },
    xAxis: {
      type: "category",
      boundaryGap: false,
      data: item.date,
    },
    yAxis: {
      type: "value",
    },
    series: item.data,
  };
  // 使用刚指定的配置项和数据显示图表。
  chart.value.setOption(option);
};

onMounted(() => {
  // 处理筛选后的数据
  const data = handleData(props.data);
  // 渲染图表
  showEcharts(data);
});

// 监听数据变化
watch(
  () => props.data,
  (newValue) => {
    // 处理筛选后的数据
    const data = handleData(newValue);
    // 渲染图表
    showEcharts(data);
  }
);
</script>
<template>
  <div ref="main" style="width: 600px; height: 400px"></div>
</template>

<style scoped></style>
