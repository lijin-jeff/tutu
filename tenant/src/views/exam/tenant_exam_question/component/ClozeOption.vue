<template>
  <div>
    <el-form label-width="70px">
      <el-form-item label="试题材料" prop="title">
        <exam-editor v-model="formData.title" :height="150" width="100%"/>
      </el-form-item>
      <el-form-item label="显示权重" prop="sort">
        <div style="width: 100%">
          <el-input-number
              :min="0"
              :step="1"
              v-model="formData.sort"
              style="width: 100%"
              clearable
              placeholder="请输入"
          />
          <div class="form-tips">默认为0， 只能为大于0的整数。值越大越排前显示。</div>
        </div>
      </el-form-item>
      <el-form-item label="试题积分" prop="score">
        <div style="width: 100%">
          <el-input-number
              :min="1"
              :step="0.01"
              style="width: 100%"
              v-model="formData.score"
              clearable
              placeholder="请输入"
          />
          <div class="form-tips">默认为0， 只能为大于0的整数。值越大越排前显示。</div>
        </div>
      </el-form-item>
      <el-form-item label="启用状态" prop="is_show">
        <el-radio-group v-model="formData.is_show" placeholder="请选择">
          <el-radio
              v-for="(item, index) in dictData.show_status"
              :key="index"
              :value="parseInt(item.value)"
              :label="parseInt(item.value)"
          >
            {{ item.name }}
          </el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="试题解析" prop="analysis">
        <editor v-model="formData.analysis" :height="150" width="100%"/>
      </el-form-item>
      <el-form-item label="子项试题">
        <div
            v-for="(item, index) in formData.option"
            :key="item.check"
            class="with100 margin-bottom20"
        >
          <div>
            <el-checkbox-group v-model="formData.answer">
              <div class="" style="width: 100%">
                <div class="padding-right20 display-flex-start-center">
                  <div class="display-flex-start-center">
                    <el-button
                        type="success"
                        icon="Plus"
                        link
                        @click="addQuestion"
                    >添加子试题
                    </el-button
                    >
                    <el-button
                        type="danger"
                        icon="Delete"
                        link
                        @click="deleteQuestion(index)"
                    >删除试题
                    </el-button
                    >
                  </div>
                </div>
              </div>
            </el-checkbox-group>
          </div>
          <!--                    编辑器不能嵌套到radio-group内，否则编辑器内的内容不会被显示-->
          <div class="margin-top10">
            <!--                        <exam-editor-->
            <!--                            v-model="formData.option[index].title"-->
            <!--                            :height="150"-->
            <!--                            width="100%"-->
            <!--                        />-->
            <div class="margin-left50">
              <div
                  v-for="(childrenItem, childrenIndex) in item.children"
                  :key="childrenItem.check"
                  class="with100"
              >
                <el-checkbox-group v-model="formData.answer">
                  <div class="" style="width: 100%">
                    <div class="padding-right20 display-flex-start-center">
                      <div class="padding-right">
                        <el-checkbox
                            :value="childrenItem.check"
                            :label="`选项` + childrenItem.check"
                            size="large"
                            name="option_check"
                        />
                      </div>
                      <div class="display-flex-start-center">
                        <el-button
                            type="success"
                            icon="Plus"
                            link
                            @click="addOption(index)"
                        >添加选项
                        </el-button
                        >
                        <el-button
                            type="danger"
                            icon="Delete"
                            link
                            @click="deleteOption(index, childrenIndex)"
                        >删除选项
                        </el-button
                        >
                      </div>
                    </div>
                  </div>
                </el-checkbox-group>
                <div class="margin-top10">
                  <input
                      v-model="
                                            formData.option[index].children[childrenIndex].title
                                        "
                      clearable
                      class="custom-input"
                  />
                  <!--                                    <exam-editor-->
                  <!--                                        v-model="formData.option[index].children[childrenIndex].title"-->
                  <!--                                        :height="150"-->
                  <!--                                        width="100%"-->
                  <!--                                    />-->
                </div>
              </div>
            </div>
          </div>
        </div>
      </el-form-item>
      <div class="display-flex">
        <el-button type="primary">保存试题</el-button>
        <el-button type="warning">重置数据</el-button>
      </div>
    </el-form>
  </div>
</template>

<script setup lang="ts">
import {useDictData} from '@/hooks/useDictOptions'
import {ExamOptionCheck} from '@/utils/enums'

const formData = reactive({
  uid: '',
  chapterUid: '',
  libraryUid: '',
  title: '',
  score: 1,
  analysis: '',
  is_show: 1,
  sort: 0,
  selectAnswer: '',
  answer: [],
  option: [
    {
      check: '',
      title: '请输入子试题题干',
      children: [
        {
          check: ExamOptionCheck.A,
          title: ''
        }
      ]
    }
  ]
})
const {dictData} = useDictData('show_status')

const addQuestion = () => {
  formData.option.push({
    check: '',
    title: '请输入子试题题干',
    children: [
      {
        check: ExamOptionCheck.A,
        title: '请输入试题选项'
      }
    ]
  })
}
const deleteQuestion = (index: number) => {
  formData.option.splice(index, 1)
}

const addOption = (index: number) => {
  const enumKeys = Object.keys(ExamOptionCheck).filter((k) => isNaN(Number(k)))
  const lastIndex = formData.option[index].children.length
  if (formData.option[index].children.length < 4) {
    if (enumKeys[lastIndex] !== undefined) {
      console.log(enumKeys[lastIndex])
      formData.option[index].children.push({
        check: enumKeys[lastIndex],
        title: '请输入选项值'
      })
    }
  }
}
const deleteOption = (index: number, childrenIndex: number) => {
  formData.option[index].children.splice(childrenIndex, 1)
  rebuildOption()
}

const rebuildOption = () => {
  const enumKeys = Object.keys(ExamOptionCheck).filter((k) => isNaN(Number(k)))
  for (let i = 0; i < formData.option.length; i++) {
    const option = []
    for (let j = 0; j < formData.option[i].children.length; j++) {
      option.push({
        title: formData.option[i].children[j].title,
        check: enumKeys[j]
      })
    }
    formData.option[i].children = option
  }
}
</script>

<style scoped>
.custom-input :deep(.el-input__inner) {
  border-color: #67c23a !important;
  border-width: 2px;
}

.custom-input :deep(.el-input__inner:focus) {
  border-color: #409eff !important;
  box-shadow: 0 0 4px rgba(64, 158, 255, 0.3);
}
</style>
