<template>
    <div>
        <el-form label-width="100px" :model="formData" ref="formRef" :rules="formRules">
            <el-form-item label="试题章节" prop="chapter_uid">
                <el-cascader
                    v-model="formData.chapter_uid"
                    :options="chapterList"
                    :props="props"
                    style="width: 100%"
                    @change="handleChapterChange"
                />
            </el-form-item>
            <el-form-item label="试题题干" prop="title">
                <exam-editor v-model="formData.title" :height="150" width="100%" />
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
           <el-form-item label="试题难度" prop="level">
                <el-radio-group v-model="formData.level" placeholder="请选择试题难度">
                    <el-radio
                        v-for="(item, index) in dictData.level"
                        :key="index"
                        :value="parseInt(item.value)"
                        :label="parseInt(item.value)"
                    >
                        {{ item.name }}
                    </el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="试题解析" prop="analysis">
                <editor v-model="formData.analysis" :height="150" width="100%" />
            </el-form-item>
            <el-form-item label="试题答案">
                <el-radio-group @change="optionCheck" v-model="formData.selectAnswer">
                    <div class="padding-right20 display-flex-start-center">
                        <el-radio
                            v-for="(item, index) in formData.option"
                            :key="item.check + index"
                            :value="item.check"
                            :label="item.title"
                            size="large"
                            name="option_check"
                        />
                    </div>
                </el-radio-group>
            </el-form-item>
            <div class="display-flex-start-center">
                <el-button type="primary" @click="saveForm">保存试题</el-button>
                <el-button type="warning">重置数据</el-button>
            </div>
        </el-form>
    </div>
</template>

<script setup lang="ts">
import type { FormInstance } from 'element-plus'

import { apiTenantExamChapterTree } from '@/api/exam/tenant_exam_chapter'
import { useDictData } from '@/hooks/useDictOptions'
import { ExamOptionCheck } from '@/utils/enums'
import {apiTenantExamQuestionAdd, apiTenantExamQuestionDetail, apiTenantExamQuestionEdit} from "@/api/exam/tenant_exam_question";
interface Props {
    id?: number
    libraryUid: string
}
const emit = defineEmits(['success'])
const props = defineProps<Props>()
const formData = reactive({
    id: props.id || 0,
    chapterUid: '',
    libraryUid: '',
    tenant_exam_library_uid: props.libraryUid,
    title: '',
    score: 1,
    analysis: '',
    is_show: 1,
    sort: 0,
    level: 1,
    selectAnswer: '',
    exam_type: 3,
    answer: [],
    option: [
        {
            check: ExamOptionCheck.A,
            title: '正确',
            is_check: false
        },
        {
            check: ExamOptionCheck.B,
            title: '错误',
            is_check: false
        }
    ]
})
const { dictData } = useDictData('show_status,level')
const chapterList = reactive([])
const formRef = shallowRef<FormInstance>()
const formRules = reactive<any>({
    title: [
        {
            required: true,
            message: '请输入试题题干',
            trigger: ['blur']
        }
    ],
    is_show: [
        {
            required: true,
            message: '请选择试题显示状态',
            trigger: ['blur']
        }
    ],
    sort: [
        {
            required: true,
            message: '请输入试题显示权重',
            trigger: ['blur']
        }
    ],
    score: [
        {
            required: true,
            message: '请输入试题积分',
            trigger: ['blur']
        },
        {
            type: 'number',
            message: '请输入大于0的整数',
            min: 0
        }
    ],
    answer: [
        {
            required: true,
            message: '请选勾选题答案',
            trigger: ['blur']
        },
        {
            validator: (rule: any, value: string[], callback: any) => {
                if (value.length < 1) {
                    callback(new Error('请选勾选题答案'))
                } else {
                    callback()
                }
            },
            trigger: ['blur', 'change']
        }
    ],
    level: [
        {
            required: true,
            message: '请勾选试题难度',
            trigger: ['blur']
        }
    ]
})

watch(
    () => props.id,
    (newValue, oldValue) => {
        console.log('新值:', newValue)
        console.log('旧值:', oldValue)
        if (newValue !== oldValue) {
            fetchQuestionDetail()
        }
    }
)

const handleChapterChange = (value) => {
    formData.chapter_uid = value[1]
}

const saveForm = async () => {
    console.log('saveForm', formData)
    // await formRef.value?.validate()
    const data = { ...formData }
    await formRef.value?.validate((valid: boolean) => {
        if (valid) {
            formData.uid ? apiTenantExamQuestionEdit(data) : apiTenantExamQuestionAdd(data)
            emit('success', data)
        } else {
            console.log('error submit!!', data)
        }
    })
}

const optionCheck = (check: string) => {
    formData.answer = [check]
}

const fetchQuestionDetail = async () => {
    const res = await apiTenantExamQuestionDetail({ id: props.id })
    Object.assign(formData, res)
    formData.selectAnswer = res.answer.join('')
}

const fetchChapterList = async () => {
    apiTenantExamChapterTree({ tenant_exam_library_uid: formData.tenant_exam_library_uid }).then(
        (res) => {
            Object.assign(chapterList, res)
        }
    )
}
fetchChapterList()
</script>

<style scoped></style>
