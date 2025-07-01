<template>
    <div class="edit-popup">
        <popup
            ref="popupRef"
            :title="popupTitle"
            :async="true"
            width="800px"
            @confirm="handleSubmit"
            @close="handleClose"
        >
            <el-form ref="formRef" :model="formData" label-width="90px" :rules="formRules">
                <el-form-item label="考试名称" prop="title">
                    <el-input v-model="formData.title" clearable placeholder="请输入考试名称" />
                </el-form-item>
                <el-form-item label="考试封面" prop="image">
                    <material-picker v-model="formData.image" />
                </el-form-item>
                <el-form-item label="发布状态" prop="is_show">
                    <el-radio-group v-model="formData.is_show" placeholder="请选择发布状态">
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
                <el-form-item label="开始时间" prop="start_time">
                    <el-date-picker
                        v-model="formData.start_time"
                        type="datetime"
                        style="width: 100%"
                        placeholder="请选择考试开始时间"
                        format="YYYY-MM-DD hh:mm:ss"
                        value-format="YYYY-MM-DD hh:mm:ss"
                    />
                </el-form-item>
                <el-form-item label="结束时间" prop="end_time">
                    <el-date-picker
                        v-model="formData.end_time"
                        type="datetime"
                        style="width: 100%"
                        placeholder="请选择考试结束时间"
                        format="YYYY-MM-DD hh:mm:ss"
                        value-format="YYYY-MM-DD hh:mm:ss"
                    />
                </el-form-item>
                <el-form-item label="考试时间" prop="exam_time">
                    <el-time-picker
                        v-model="formData.exam_time"
                        style="width: 100%"
                        typ="time"
                        format="hh:mm:ss"
                        value-format="hh:mm:ss"
                        placeholder="请选择考试时间"
                    />
                </el-form-item>
                <el-form-item label="及格分数" prop="score">
                    <el-input-number
                        style="width: 100%"
                        :min="0"
                        :step="0.01"
                        v-model="formData.score"
                        clearable
                        placeholder="请输入及格分数"
                    />
                </el-form-item>
                <el-form-item label="显示权重" prop="sort">
                    <el-input-number
                        style="width: 100%"
                        :min="0"
                        :step="1"
                        v-model="formData.sort"
                        clearable
                        placeholder="请输入显示权重"
                    />
                </el-form-item>
                <el-form-item label="考试权限" prop="privilege">
                    <el-radio-group v-model="formData.privilege" placeholder="请选择考试权限">
                        <el-radio
                            v-for="(item, index) in dictData.exam_privilege"
                            :key="index"
                            :label="parseInt(item.value)"
                        >
                            {{ item.name }}
                        </el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="提交限制" prop="exam_submit_type">
                    <el-radio-group
                        v-model="formData.exam_submit_type"
                        placeholder="请选择提交限制次数"
                    >
                        <el-radio
                            v-for="(item, index) in dictData.exam_submit_type"
                            :key="index"
                            :value="parseInt(item.value)"
                            :label="parseInt(item.value)"
                        >
                            {{ item.name }}
                        </el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item
                    label="提交次数"
                    prop="submit_count_value"
                    v-if="formData.exam_submit_type !== 1"
                >
                    <el-input-number
                        style="width: 100%"
                        v-model="formData.submit_count_value"
                        clearable
                        placeholder="请输入显示权重"
                    />
                </el-form-item>
                <el-form-item label="登录方式" prop="login_style">
                    <el-radio-group v-model="formData.login_style" placeholder="请选择登录方式">
                        <el-radio
                            v-for="(item, index) in dictData.exam_login_style"
                            :key="index"
                            :label="parseInt(item.value)"
                        >
                            {{ item.name }}
                        </el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="考试说明" prop="content">
                    <editor class="flex-1" v-model="formData.content" :height="500" />
                </el-form-item>
            </el-form>
        </popup>
    </div>
</template>

<script lang="ts" setup name="tenantExamExaminationEdit">
import type { FormInstance } from 'element-plus'
import type { PropType } from 'vue'

import {
    apiTenantExamExaminationAdd,
    apiTenantExamExaminationDetail,
    apiTenantExamExaminationEdit
} from '@/api/exam/tenant_exam_examination'
import Popup from '@/components/popup/index.vue'

defineProps({
    dictData: {
        type: Object as PropType<Record<string, any[]>>,
        default: () => ({})
    }
})
const emit = defineEmits(['success', 'close'])
const formRef = shallowRef<FormInstance>()
const popupRef = shallowRef<InstanceType<typeof Popup>>()
const mode = ref('add')

// 弹窗标题
const popupTitle = computed(() => {
    return mode.value == 'edit' ? '编辑考试管理' : '新增考试管理'
})

// 表单数据
const formData = reactive({
    id: '',
    title: '',
    score: '',
    content: '',
    sort: '',
    is_show: 1,
    admin_id: '',
    tenant_id: '',
    start_time: '',
    end_time: '',
    privilege: '',
    exam_time: '',
    exam_submit_type: 1,
    submit_count_value: 0,
    login_style: '',
    image: ''
})

// 表单验证
const formRules = reactive<any>({
    title: [
        {
            required: true,
            message: '请输入考试名称',
            trigger: ['blur']
        }
    ],
    score: [
        {
            required: true,
            message: '请输入及格分数',
            trigger: ['blur']
        }
    ],
    content: [
        {
            required: true,
            message: '请输入考试说明',
            trigger: ['blur']
        }
    ],
    sort: [
        {
            required: true,
            message: '请输入显示权重',
            trigger: ['blur']
        }
    ],
    is_show: [
        {
            required: true,
            message: '请选择发布状态',
            trigger: ['blur']
        }
    ],
    start_time: [
        {
            required: true,
            message: '请输入开始时间',
            trigger: ['blur']
        }
    ],
    end_time: [
        {
            required: true,
            message: '请输入结束时间',
            trigger: ['blur']
        }
    ],
    privilege: [
        {
            required: true,
            message: '请选择考试权限',
            trigger: ['blur']
        }
    ],
    exam_time: [
        {
            required: true,
            message: '请输入考试时间',
            trigger: ['blur']
        }
    ],
    exam_submit_type: [
        {
            required: true,
            message: '请输入答题类型',
            trigger: ['blur']
        }
    ],
    image: [
        {
            required: true,
            message: '请选择考试突破',
            trigger: ['blur']
        }
    ],
    login_style: [
        {
            required: true,
            message: '请选择登录方式',
            trigger: ['blur']
        }
    ]
})

// 获取详情
const setFormData = async (data: Record<any, any>) => {
    for (const key in formData) {
        if (data[key] != null && data[key] != undefined) {
            //@ts-ignore
            formData[key] = data[key]
        }
    }
    //@ts-ignore
}

const getDetail = async (row: Record<string, any>) => {
    const data = await apiTenantExamExaminationDetail({
        id: row.id
    })
    setFormData(data)
}

// 提交按钮
const handleSubmit = async () => {
    await formRef.value?.validate()
    const data = { ...formData }
    mode.value == 'edit'
        ? await apiTenantExamExaminationEdit(data)
        : await apiTenantExamExaminationAdd(data)
    popupRef.value?.close()
    emit('success')
}

//打开弹窗
const open = (type = 'add') => {
    mode.value = type
    popupRef.value?.open()
}

// 关闭回调
const handleClose = () => {
    emit('close')
}

defineExpose({
    open,
    setFormData,
    getDetail
})
</script>
