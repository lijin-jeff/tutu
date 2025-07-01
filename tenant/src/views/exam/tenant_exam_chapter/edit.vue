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
                    <el-select :model="formData" clearable placeholder="请选择上级分类">
                        <el-cascader
						v-model="formData.parent_uid"
						:options="parentList"
						:props="props"
						style="width: 100%"
						@change="handleChange"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="章节名称" prop="title">
                    <el-input v-model="formData.title" clearable placeholder="请输入章节名称" />
                </el-form-item>
                <el-form-item label="显示状态" prop="is_show">
                    <el-radio-group v-model="formData.is_show" placeholder="请选择显示状态">
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
                    <el-input-number
                        :min="0"
                        :step="1"
                        v-model="formData.sort"
                        clearable
                        placeholder="请输入显示权重"
                        style="width: 100%"
                    />
                </el-form-item>
            </el-form>
        </popup>
    </div>
</template>

<script lang="ts" setup name="tenantExamChapterEdit">
import type { FormInstance } from 'element-plus'
import type { PropType } from 'vue'

import {
    apiTenantExamChapterAdd,
    apiTenantExamChapterDetail,
    apiTenantExamChapterEdit,
    apiTenantExamChapterParent
} from '@/api/exam/tenant_exam_chapter'
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
const route = useRoute()

// 弹窗标题
const popupTitle = computed(() => {
    return mode.value == 'edit' ? '编辑题库章节' : '新增题库章节'
})

// 表单数据
const formData = reactive({
    id: '',
    title: '',
    is_show: '',
    sort: '',
    parent_uid: '',
   tenant_exam_library_uid: route.query.library_uid
})

// 表单验证
const formRules = reactive<any>({
    title: [
        {
            required: true,
            message: '请输入章节名称',
            trigger: ['blur']
        }
    ],
    is_show: [
        {
            required: true,
            message: '请选择显示状态',
            trigger: ['blur']
        }
    ],
    sort: [
        {
            required: true,
            message: '请输入显示权重',
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
    const data = await apiTenantExamChapterDetail({
        id: row.id
    })
    setFormData(data)
}

// 提交按钮
const handleSubmit = async () => {
    await formRef.value?.validate()
    const data = { ...formData }
    mode.value == 'edit'
        ? await apiTenantExamChapterEdit(data)
        : await apiTenantExamChapterAdd(data)
    popupRef.value?.close()
    emit('success')
}

//打开弹窗
const open = (type = 'add') => {
    mode.value = type
    popupRef.value?.open()
}

const fetchParentList = async () => {
    await apiTenantExamChapterParent({tenant_exam_library_uid: route.query.library_uid}).then((res) => {
        Object.assign(parentList, res)
    })
}

const handleChange = (value) => {
    formData.parent_uid = value[1]
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
