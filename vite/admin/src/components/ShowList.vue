<script setup>
import { data } from '../mock/index.js'
import { computed, ref } from 'vue';

const props = { data };
//const props = defineProps({
//    data: Array,
//});

// 表头
const columns = ['Id', '计划', '次数', '类型', '时间'];
// 表体
const rows = computed(() =>
    props.data.map(item => ({
        Id: item.id,
        计划: '暂无',
        次数: item.count,
        类型: '点击',
        时间: item.date.slice(5),
    })),
);

// 定义一个 ref 变量，用于存储当前选择的筛选方式，0 表示“现有 ID”，1 表示“输入 ID”
const filterType = ref(0);

// 定义一个 ref 变量，用于存储当前选择的现有 ID 值
const selectedId = ref('');

// 定义一个 ref 变量，用于存储当前输入的 ID 值
const inputId = ref('');

// 根据 ID 筛选数据
const filteredRows = computed(() => {
    if (filterType.value === 0) {
        // 如果选择了“现有 ID”，则根据 selectedId 进行筛选
        if (selectedId.value === '') {
            return rows.value;
        } else {
            return rows.value.filter(row => row.Id.toString() === selectedId.value);
        }
    } else {
        // 如果选择了“输入 ID”，则根据 inputId 进行筛选
        if (inputId.value === '') {
            return rows.value;
        } else {
            return rows.value.filter(row => row.Id.toString() === inputId.value);
        }
    }
});

</script>

<template>
    <div class="content">
        <!-- 添加选项卡，用于选择筛选方式 -->
        <div class="filter-type">
            <button :class="{ active: filterType === 0 }" @click="filterType = 0; selectedId.value = ''">
                现有 ID
            </button>
            <button :class=" { active: filterType === 1 } " @click=" filterType = 1; inputId.value = '' ">
                输入 ID
            </button>
        </div>

        <!-- 如果选择了“现有 ID”，则显示一个下拉列表，供用户选择已有的 ID -->
        <div v-if=" filterType === 0 " class="filter-dropdown">
            <label for="selected-id">请选择现有 ID：</label>
            <select id="selected-id" v-model=" selectedId ">
                <option :value=" '' ">全部</option>
                <option v-for="   row    in    rows   " :value=" row.Id ">{{ row.Id }}</option>
            </select>
        </div>

        <!-- 如果选择了“输入 ID”，则显示一个输入框，供用户输入要查询的 ID -->
        <div v-else class="filter-input">
            <label for="input-id">请输入要查询的 ID：</label>
            <input type="text" id="input-id" v-model=" inputId " />
        </div>

        <!-- 表格部分和上文的代码相同 -->
        <table class="widefat" width="300px">
            <thead>
                <tr>
                    <th v-for="   column    in    columns   " :key=" column ">{{ column }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(   row, index   ) in    filteredRows   " :key=" index ">
                    <td v-for="(   value, key   ) in    row   " :key=" key ">{{ value }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
.active {
    background-color: #2b6cb0;
    color: #fff;
}

.filter-type {
    margin-bottom: 20px;
}

.filter-dropdown,
.filter-input {
    margin-bottom: 20px;
}

label {
    display: inline-block;
    width: 120px;
}

input[type='text'],
select {
    width: 200px;
    padding: 5px;
    border-radius: 5px;
    outline: none;
    border: 1px solid #ccc;
}
</style>
