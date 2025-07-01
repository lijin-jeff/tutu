<template>
    <div class="edit-popup">
        <popup
            ref="popupRef"
            :title="popupTitle"
            :async="true"
            width="60%"
            @confirm="handleSubmit"
            @close="handleClose"
        >
            <el-form ref="formRef" :model="formData" label-width="90px" :rules="formRules">
                <el-form-item label="资源分类" prop="category_uid">
                  <el-cascader
                      v-model="formData.category_uid"
                      :options="categoryList"
                      :props="props"
                      style="width: 100%"
                      @change="handleChange"
                  />
                </el-form-item>
                <el-form-item label="资源名称" prop="title">
                    <el-input v-model="formData.title" clearable placeholder="请输入资源名称" />
                </el-form-item>
                <el-form-item label="上架状态" prop="is_show">
                    <el-radio-group v-model="formData.is_show" placeholder="请选择上架状态">
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
                    <el-input-number :min="0" :step="1" style="width:100%" v-model="formData.sort" clearable placeholder="请输入显示权重" />
                </el-form-item>
                <el-form-item label="资源封面" prop="image">
                  <material-picker v-model="formData.image" />
                </el-form-item>
                <el-form-item label="资源附件" prop="file_url">
                  <material-picker v-model="formData.file_url" type="file"/>
                </el-form-item>
                <el-form-item label="资源作者" prop="author">
                  <el-input v-model="formData.author" clearable placeholder="请输入资源作者" />
                </el-form-item>
                <el-form-item label="付费状态" prop="free_state">
                  <el-select class="flex-1" v-model="formData.free_state" clearable placeholder="请选择付费状态">
                    <el-option
                        v-for="(item, index) in dictData.price_typ"
                        :key="index"
                        :label="item.name"
                        :value="item.value"
                    />
                  </el-select>
                </el-form-item>
                <el-form-item label="资源价格" prop="money">
                  <el-input-number v-model="formData.money"  :min="0" :step="0.01" style="width:100%" clearable placeholder="请输入资源价格" />
                </el-form-item>
                <el-form-item label="资源年份" prop="year">
                  <el-select class="flex-1" v-model="formData.year" clearable placeholder="请选择资源年份">
                    <el-option
                        v-for="(item, index) in dictData.data_year"
                        :key="index"
                        :label="item.name"
                        :value="parseInt(item.value)"
                    />
                  </el-select>
                </el-form-item>
                <el-form-item label="资源描述" prop="remark">
                    <editor class="flex-1" v-model="formData.remark" :height="500" />
                </el-form-item>
            </el-form>
        </popup>
    </div>
</template>

<script lang="ts" setup name="tenantResourceEdit">
import type { FormInstance } from 'element-plus'
import Popup from '@/components/popup/index.vue'
import { apiTenantResourceAdd, apiTenantResourceEdit, apiTenantResourceDetail } from '@/api/resource/tenant_resource'
import type { PropType } from 'vue'
import {apiTenantResourceCategoryTree} from "@/api/resource/tenant_resource_category";

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
const categoryList = reactive([])

// 弹窗标题
const popupTitle = computed(() => {
    return mode.value == 'edit' ? '编辑资源管理' : '新增资源管理'
})

// 表单数据
const formData = reactive({
    id: '',
    title: '',
    is_show: '',
    sort: '',
    image: '',
    remark: '',
    category_uid: '',
    author: '兔兔答题',
    free_state: '',
    money: '0.00',
    year: '',
    file_url: ''
})


// 表单验证
const formRules = reactive<any>({
    title: [{
        required: true,
        message: '请输入资源名称',
        trigger: ['blur']
    }],
    is_show: [{
        required: true,
        message: '请选择上架装',
        trigger: ['blur']
    }],
    sort: [{
        required: true,
        message: '请输入显示权重',
        trigger: ['blur']
    }],
    image: [{
        required: true,
        message: '请输入资源封面',
        trigger: ['blur']
    }],
    remark: [{
        required: true,
        message: '请输入资源描述',
        trigger: ['blur']
    }],
    category_uid: [{
        required: true,
        message: '请输入资源分类',
        trigger: ['blur']
    }],
    author: [{
        required: true,
        message: '请输入资源作者',
        trigger: ['blur']
    }],
    free_state: [{
        required: true,
        message: '请选择付费状态',
        trigger: ['blur']
    }],
    file_url: [{
      required: true,
      message: '请上传资源',
      trigger: ['blur']
    }],
    year: [{
        required: true,
        message: '请选择资源年份',
        trigger: ['blur']
    }]
})

const handleChange = (value) => {
  formData.category_uid = value[1]
}

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
    const data = await apiTenantResourceDetail({
        id: row.id
    })
    setFormData(data)
}


// 提交按钮
const handleSubmit = async () => {
    await formRef.value?.validate()
    const data = { ...formData,  }
    mode.value == 'edit' 
        ? await apiTenantResourceEdit(data) 
        : await apiTenantResourceAdd(data)
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

const fetchExamCategoryList = async () => {
  await apiTenantResourceCategoryTree().then((res) => {
    Object.assign(categoryList, res)
  })
}
fetchExamCategoryList()


defineExpose({
    open,
    setFormData,
    getDetail
})
</script>
