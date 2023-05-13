<script setup>
import * as echarts from 'echarts';
import { ref, shallowRef, onMounted } from 'vue';

import { data as dataObj } from '../mock/index.js'
console.error(dataObj)
//接收数据
const props = defineProps({
    data: Array,
});

//将数据处理成所需格式
const handleData = (data) => {
    //获取指定值构成的数组
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

    //获取数据集
    /*
     * data:待处理数据
     * id: id数组
     * date:时间数组
     */
    const arrData = (data, id, date) => {
        //存储结果
        const list = [];
        //拿到id
        id.forEach((item) => {
            const a = data.filter((index) => index.id === item); // 筛选出所有id为指定值的数据 包含对象的数组
            const result = date.map((date) => {
                // 使用 find 方法查找数据，如果找到了则返回对应的 count 值，否则为 0
                const foundItem = a.find((index) => index.date === date);
                return foundItem ? Number(foundItem.count) : 0;
            });

            //组成数组
            const arr = {
                name: item,
                data: result,
                type: "line",
                smooth: true,
            };
            list.push(arr);
        });
        return list;
    };

    //获取ID数组
    const id = getArr(data, "id");
    //获取时间数组
    const date = getArr(data, "date").reverse();

    const list = arrData(data, id, date);

    //处理下时间
    const handleDate = date.map((item) => item.substr(5).replace("-", "_"));

    const obj = {
        id: id,
        date: handleDate,
        data: list,
    };
    return obj;
};


//测试
//获取div节点
const main = ref(null);
//定义全局变量
const chart = shallowRef(); //这里使用shallowRef，避免进行标签筛选时报错
//拿到数据并展示
const showEcharts = (item) => {
    if (
        chart.value != null &&
        chart.value != "" &&
        chart.value != undefined
    ) {
        chart.value.dispose();
    }
    // 基于准备好的dom，初始化echarts实例
    chart.value = echarts.init(main.value);
    // 准备数据
    const option = ({
        title: {
            text: "广告效果统计",
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
    });
    // 使用刚指定的配置项和数据显示图表。
    chart.value.setOption(option);
}



onMounted(() => {
    //处理筛选后的数据
    //const data = handleData(props.data);
    const data = handleData(dataObj);

    //渲染图表
    showEcharts(data);
})


</script>
<template>
    <div ref="main" style="width: 600px; height: 400px"></div>
</template>

<style scoped></style>