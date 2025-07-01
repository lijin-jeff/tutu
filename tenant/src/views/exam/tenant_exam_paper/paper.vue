<template>
  <el-card class="!border-none margin-bottom20" shadow="never">
    <el-page-header content="试卷管理" @back="$router.back()"/>
  </el-card>
  <div class="exam-container">
    <el-aside width="300px" class="exam-aside">
      <el-card
          style="width: 100%"
          class="margin-bottom10"
          :body-style="{ padding: 10 + 'px' }"
          v-for="(item, index) in formData.data"
          :key="index"
      >
        <template #header>
          <div class="card-header">
            <span>{{ item.exam_type }}</span>
          </div>
        </template>
        <div class="left-main">
          <div class="left-main-left">
            <div style="display: flex; justify-content: flex-start">
              <div class="padding-right10">
                <span>共</span>
                <span class="font-setting">{{ item.total_number }}</span>
                <span>道</span>
              </div>
              <div>
                <span>共</span>
                <span class="font-setting">{{ item.total_score }}</span>
                <span>分</span>
              </div>
            </div>
            <div class="left-main-left-score">
              <div style="display: flex; align-items: center">
                <div class="padding-right10">每题分数</div>
                <div class="padding-right10">
                  <el-input
                      v-model="item.score"
                      :min="1"
                      :step="1"
                      @change="handlePerScoreChange(index, $event)"
                      style="width: 50px; height: 25px"
                  />
                </div>
                <div>分</div>
              </div>
            </div>
          </div>
          <!--          <div class="left-main-right">-->
          <!--            <el-icon :size="15">-->
          <!--              <Delete/>-->
          <!--            </el-icon>-->
          <!--            <el-icon :size="15">-->
          <!--              <Top/>-->
          <!--            </el-icon>-->
          <!--            <el-icon :size="15">-->
          <!--              <Bottom/>-->
          <!--            </el-icon>-->
          <!--          </div>-->
        </div>
      </el-card>
      <el-card style="max-width: 300px" class="margin-top10" v-if="formData.data.length > 0">
        <div style="display: flex; justify-content: flex-start" class="margin-bottom20">
          <div>总题数</div>
          <div class="margin-left10 font-setting">{{ formData.total.exam_count }}</div>
          <div class="margin-left10">道</div>
        </div>
        <div style="display: flex; justify-content: flex-start">
          <div>总分数</div>
          <div class="margin-left10 font-setting">{{ formData.total.exam_score }}</div>
          <div class="margin-left10">分</div>
        </div>
      </el-card>
    </el-aside>
    <el-main class="exam-main">
      <el-card style="width: 100%" shadow="never" :body-style="{ padding: 20 + 'px' }">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px">
          <div style="display: flex; justify-content: flex-start; align-items: center">
            <div class="margin-left10">
              <el-button type="primary" @click="savePaper">保存试卷</el-button>
            </div>
            <div class="margin-left10">
              <el-button type="primary" @click="fetchLibraryLists">选择题库试题</el-button>
            </div>
          </div>
        </div>
        <div>
          <!--          <div v-for="(item, index) in formData.exam_list" :key="index">-->
          <div v-for="(exam_item, exam_index) in formData.exam_list" :key="exam_index">
            <div class="display-flex-between-center margin-bottom20">
              <div class="display-flex-start-center exam-title">
                <div>{{ exam_index + 1 }}、[{{ exam_item.exam_type_text }}]</div>
                <div v-html="exam_item.title"></div>
              </div>
              <div class="margin-right10 display-flex-right-center">
                <div class="padding-right20">
                  分数:
                  <el-input-number
                      :step="0.01"
                      :min="1"
                      :max="10"
                      style="width: 150px"
                      v-model="formData.exam_list[exam_index].score"
                      placeholder="请输入分数"
                      clearable
                      @change="handleScoreChange(exam_index, $event)"
                  />
                </div>
                <div class="padding-right20" @click="deleteExam(exam_index)">
                  <el-icon :size="15">
                    <Delete/>
                  </el-icon>
                </div>
                <div class="padding-right20">
                  <el-icon :size="15" @click="moveUp(exam_index)">
                    <Top/>
                  </el-icon>
                </div>
                <div class="padding-right20">
                  <el-icon :size="15"  @click="moveDown(exam_index)">
                    <Bottom/>
                  </el-icon>
                </div>
              </div>
            </div>
            <!--                             试题选项开始-->
            <div class="margin-bottom20">
              <div
                  v-for="(optionItem, optionIndex) in exam_item.option"
                  :key="optionIndex"
              >
                <div class="exam-option-item margin-top20">
                  <el-col span="0.5">
                    <div :class="optionItem.is_check ? 'exam-option-selected' : 'exam-option' ">
                      {{ optionItem.check }}
                    </div>
                  </el-col>
                  <el-col :span="23">
                    <div
                        v-html="optionItem.title"
                        class="margin-left10"
                    ></div>
                  </el-col>
                </div>
              </div>
            </div>
            <!--                          试题选项结束-->
            <div class="exam-answer">
              <div>试题解析：</div>
              <div v-html="exam_item.analysis"></div>
            </div>
            <el-divider/>
          </div>
          <!--          </div>-->
        </div>
      </el-card>
    </el-main>
    <!--    题库选择开始-->
    <el-dialog
        title="题库选择"
        v-model="dialogLibraryVisible"
        width="80%">
      <div class="mt-4">
        <el-card class="!border-none mb-4" shadow="never" :body-style="{ padding: 10 + 'px' }">
          <el-form class="" :model="queryLibraryParams" inline>
            <el-form-item label="题库名称" prop="title">
              <el-input
                  class="w-[120px]"
                  v-model="queryLibraryParams.title"
                  clearable
                  placeholder="请输入"
              />
            </el-form-item>
            <el-form-item label="题库分类" prop="category_uid">
              <el-cascader
                  v-model="queryLibraryParams.category_uid"
                  :options="categoryList"
                  :props="props"
                  style="width: 100%"
                  @change="handleLibraryCategoryChange"
              />
            </el-form-item>
            <el-form-item label="收费状态" prop="free_state">
              <el-select
                  style="width: 100px"
                  v-model="queryLibraryParams.free_state"
                  clearable
                  placeholder="请选择"
              >
                <el-option label="全部" value=""></el-option>
                <el-option
                    v-for="(item, index) in dictData.price_typ"
                    :key="index"
                    :label="item.name"
                    :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="是否热门" prop="hot_state">
              <el-select
                  style="width: 100px"
                  v-model="queryLibraryParams.hot_state"
                  clearable
                  placeholder="请选择"
              >
                <el-option label="全部" value=""></el-option>
                <el-option
                    v-for="(item, index) in dictData.hot_state"
                    :key="index"
                    :label="item.name"
                    :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="是否推荐" prop="recommend_state">
              <el-select
                  style="width: 100px"
                  v-model="queryLibraryParams.recommend_state"
                  clearable
                  placeholder="请选择"
              >
                <el-option label="全部" value=""></el-option>
                <el-option
                    v-for="(item, index) in dictData.recommend_state"
                    :key="index"
                    :label="item.name"
                    :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="收费状态" prop="free_state">
              <el-select
                  style="width: 100px"
                  v-model="queryLibraryParams.free_state"
                  clearable
                  placeholder="请选择"
              >
                <el-option label="全部" value=""></el-option>
                <el-option
                    v-for="(item, index) in dictData.price_typ"
                    :key="index"
                    :label="item.name"
                    :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="resetPage">查询</el-button>
              <el-button @click="resetParams">重置</el-button>
              <el-button @click="confirmLibrary" type="warning">确认选择</el-button>
            </el-form-item>
          </el-form>
        </el-card>
        <el-table :data="pager.lists" @selection-change="handleSelectionChange">
          <el-table-column type="selection" width="55"/>
          <el-table-column label="题库编号" prop="uid" show-overflow-tooltip/>
          <el-table-column label="题库分类" prop="category.title"/>
          <el-table-column label="题库名称" prop="title" show-overflow-tooltip/>
          <el-table-column label="试题总数" prop="exam_count" show-overflow-tooltip/>
          <el-table-column label="题库封面" prop="cover">
            <template #default="{ row }">
              <el-image
                  v-if="row.image !== ''"
                  style="width: 50px; height: 50px"
                  :src="row.image"
                  :preview-src-list="[row.image]"
                  preview-teleported
              />
            </template>
          </el-table-column>
          <el-table-column label="收费状态" prop="free_state">
            <template #default="{ row }">
              <dict-value :options="dictData.price_typ" :value="row.free_state"/>
            </template>
          </el-table-column>
          <el-table-column label="显示状态" prop="is_show">
            <template #default="{ row }">
              <dict-value :options="dictData.show_status" :value="row.is_show"/>
            </template>
          </el-table-column>
          <el-table-column label="创建时间" prop="create_time" show-overflow-tooltip/>
        </el-table>
      </div>
      <div class="flex mt-4 justify-end">
        <pagination v-model="pager" @change="getLists"/>
      </div>
    </el-dialog>
    <!--    题库选择结束-->
  </div>
</template>

<script setup lang="ts">
import {ElLoading} from 'element-plus'

import {useDictData} from "@/hooks/useDictOptions";
import {usePaging} from "@/hooks/usePaging";
import {apiTenantExamLibraryLists} from "@/api/exam/tenant_exam_library";
import {apiExamCategoryTree} from "@/api/exam/exam_category";
import {apiTenantExamQuestionList} from '@/api/exam/tenant_exam_question'
import {apiTenantExamSavePaper, apiTenantPaperDetail} from '@/api/exam/tenant_exam_paper'
import {useRouter} from "vue-router";
import feedback from "@/utils/feedback";

const dialogLibraryVisible = ref(false)
const route = useRoute()
const router = useRouter()
const queryParams = reactive({
  exam_type: ''
})

const formData = reactive({
  data: [],
  exam_list: [],
  total: {}
})

const fetchPaperDetail = async () => {
  apiTenantPaperDetail({id: route.query.id}).then(res => {
    Object.assign(formData, [])
    Object.assign(formData, res)
  })
}
fetchPaperDetail()

/**
 * 组卷处理逻辑开始
 */
// 保存组卷数据
const savePaper = () => {
  apiTenantExamSavePaper(Object.assign(formData, {id: route.query.id})).then(res => {
    feedback.msgSuccess('保存成功')
    router.back()
  })
}

// 删除试题
const deleteExam = (exam_index: number) => {
  formData.exam_list.splice(exam_index, 1)
  scoreCalculate()
}

// 试题积分变化
const handleScoreChange = (index: number, value: string) => {
  console.log(value, index)
  scoreCalculate()
}

// 批量设置分数
const handlePerScoreChange = (index: number, value: string) => {
  formData.exam_list.forEach((item: any, key: number) => {
    if (parseInt(item.exam_type) === 1 && index === 0) {
      formData.exam_list[key].score = parseFloat(value)
    } else if (parseInt(item.exam_type) === 2 && index === 1) {
      formData.exam_list[key].score = parseFloat(value)
    } else if (parseInt(item.exam_type) === 3 && index === 2) {
      formData.exam_list[key].score = parseFloat(value)
    }
  })
  scoreCalculate()
}

// 计算试题总数和试题总分
const scoreCalculate = () => {
  let score3 = 0;
  let score2 = 0;
  let score1 = 0;
  let total_number1 = 0;
  let total_number2 = 0;
  let total_number3 = 0;
  let exam_score = 0;
  formData.exam_list.forEach((item: any) => {
    exam_score += item.score
    if (parseInt(item.exam_type) === 1) {
      score1 += item.score
      total_number1 += 1
    } else if (parseInt(item.exam_type) === 2) {
      score2 += item.score
      total_number2 += 1
    } else if (parseInt(item.exam_type) === 3) {
      score3 += item.score
      total_number3 += 1
    }
  })
  formData.data[0].total_score = score1
  formData.data[1].total_score = score2
  formData.data[2].total_score = score3
  formData.data[0].total_number = total_number1
  formData.data[1].total_number = total_number2
  formData.data[2].total_number = total_number3
  formData.total.exam_score = exam_score
  formData.total.exam_count = total_number1 + total_number2 + total_number3
}

// 上移功能
const moveUp = (index) => {
  if (index <= 0) return;
  const newItems = [...formData.exam_list];
  [newItems[index - 1], newItems[index]] = [newItems[index], newItems[index - 1]];
  formData.exam_list = newItems;
}

// 下移功能
const moveDown = (index) => {
  if (index >= formData.exam_list.length - 1) return;
  const newItems = [...formData.exam_list];
  [newItems[index], newItems[index + 1]] = [newItems[index + 1], newItems[index]];
  formData.exam_list = newItems;
}
/**
 * 组卷处理逻辑结束
 */

/**
 * 题库处理逻辑开始
 */
const queryLibraryParams = reactive({
  title: '',
  is_show: '',
  category_uid: '',
  author: '',
  free_state: '',
  year: '',
  hot_state: '',
  recommend_state: ''
})
const selectData = ref<any[]>([])
const categoryList = reactive([])
const handleSelectionChange = (val: any[]) => {
  selectData.value = val.map(({id}) => id)
}
const handleLibraryCategoryChange = (value: string[]) => {
  queryLibraryParams.category_uid = value[1]
}

const confirmLibrary = async () => {
  const loading = ElLoading.service({
    lock: true,
    text: '试题努力加载中',
    background: 'rgba(0, 0, 0, 0.7)',
  })
  await apiTenantExamQuestionList({id: selectData.value}).then(res => {
    Object.assign(formData, [])
    Object.assign(formData, res)
    dialogLibraryVisible.value = false
    loading.close()
  })
}
const {dictData} = useDictData('show_status,price_typ,data_year,hot_state,recommend_state')

const {pager, getLists, resetParams, resetPage} = usePaging({
  fetchFun: apiTenantExamLibraryLists,
  params: queryLibraryParams
})

const fetchExamCategoryList = async () => {
  await apiExamCategoryTree().then((res) => {
    Object.assign(categoryList, res)
  })
}

const fetchLibraryLists = async () => {
  await getLists()
  await fetchExamCategoryList()
  dialogLibraryVisible.value = true
}
/**
 * 题库处理逻辑结束
 */


</script>

<style scoped>
.exam-container {
  display: flex;
  height: 100vh;
}

.exam-main {
  padding: 0 0 0 20px;
}

.left-main {
  display: flex;
  justify-content: space-between;
  height: 90px;
}

.left-main-left {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
}

.left-main-left-score {
  display: flex;
  justify-content: space-between;
  flex-direction: column;
}

.left-main-right {
  display: flex;
  justify-content: space-between;
  flex-direction: column;
  height: 100%;
}

.exam-title {
  font-weight: bolder;
}

.exam-option-item {
  display: flex;
  justify-content: flex-start;
}

.font-setting {
  font-weight: bolder;
  color: #4a5dff;
}

.exam-option-selected {
  width: 20px;
  height: 20px;
  text-align: center;
  line-height: 20px;
  border-radius: 50%;
  background-color: #4a5dff;
  color: #ffffff;
}

.exam-option {
  width: 20px;
  height: 20px;
  text-align: center;
  line-height: 20px;
  border-radius: 50%;
  background-color: #ffffff;
  border: 1px solid #c8c8d2;
}

.exam-answer {
  color: #adadad;
  display: flex;
  justify-content: flex-start;
}
</style>
