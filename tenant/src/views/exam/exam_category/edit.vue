<template>
    <div class="edit-popup">
        <popup
            ref="popupRef"
            :title="popupTitle"
            :async="true"
            width="550px"
            @confirm="handleSubmit"
            @close="handleClose"
        >
            <el-form ref="formRef" :model="formData" label-width="90px" :rules="formRules">
                <el-form-item label="上级分类" prop="parent_uid">
                    <el-select v-model="formData.parent_uid" clearable placeholder="请选择上级分类">
                        <el-option
                            v-for="item in parentList"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="分类名称" prop="title">
                    <el-input v-model="formData.title" clearable placeholder="请输入分类名称" />
                </el-form-item>
                <el-form-item label="启用状态" prop="is_show">
                    <el-radio-group v-model="formData.is_show" placeholder="请选择启用状态">
                        <el-radio
                            v-for="(item, index) in dictData.show_status"
                            :key="index"
                            :label="parseInt(item.value)"
                        >
                            {{ item.name }}
                        </el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="显示权重" prop="sort">
                    <el-input v-model="formData.sort" clearable placeholder="请输入显示权重" />
                </el-form-item>
                <el-form-item label="分类封面" prop="cover">
                    <material-picker v-model="formData.cover" />
                </el-form-item>
                <el-form-item label="是否推荐" prop="is_recommend">
                    <el-radio-group v-model="formData.is_recommend" placeholder="请选择推荐状态">
                        <el-radio
                            v-for="(item, index) in dictData.is_recommend"
                            :key="index"
                            :label="parseInt(item.value)"
                        >
                            {{ item.name }}
                        </el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="分类icon" prop="icon">
                    <div>
                      <el-input v-model="formData.icon" clearable placeholder="" />
                      <div class="form-tips">适用于用户端自定义图标的情况下，填写icon的名称，前端直接根据icon名称渲染图标</div>
                    </div>
                </el-form-item>
            </el-form>
        </popup>
    </div>
</template>

<script lang="ts" setup name="examCategoryEdit">
import type { FormInstance } from 'element-plus'
import type { PropType } from 'vue'

import {
    apiExamCategoryAdd,
    apiExamCategoryDetail,
    apiExamCategoryEdit,
    apiExamCategoryParent
} from '@/api/exam/exam_category'
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
const parentList = reactive([])

// 弹窗标题
const popupTitle = computed(() => {
    return mode.value == 'edit' ? '编辑试题分类' : '新增试题分类'
})

// 表单数据
const formData = reactive({
    id: '',
    title: '',
    is_show: '',
    sort: '',
    cover: '',
    is_recommend: '',
    icon: '',
    parent_uid: ''
})

// 表单验证
const formRules = reactive<any>({
    title: [
        {
            required: true,
            message: '请输入分类名称',
            trigger: ['blur']
        }
    ],
    is_show: [
        {
            required: true,
            message: '请选择启用状态',
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
    is_recommend: [
        {
            required: true,
            message: '请选择是否推荐',
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
}

const getDetail = async (row: Record<string, any>) => {
    const data = await apiExamCategoryDetail({
        id: row.id
    })
    setFormData(data)
}

// 提交按钮
const handleSubmit = async () => {
    await formRef.value?.validate()
    const data = { ...formData }
    mode.value == 'edit' ? await apiExamCategoryEdit(data) : await apiExamCategoryAdd(data)
    popupRef.value?.close()
    emit('success')
}

const fetchParentList = async () => {
    await apiExamCategoryParent().then((res) => {
        Object.assign(parentList, res)
    })
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
fetchParentList()

defineExpose({
    open,
    setFormData,
    getDetail
})
</script>
