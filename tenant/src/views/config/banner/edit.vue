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
                <el-form-item label="图片类型" prop="image_type">
                    <div style="width: 100%">
                        <el-select
                            class="flex-1"
                            v-model="formData.image_type"
                            clearable
                            placeholder="请选择图片类型"
                        >
                            <el-option
                                v-for="(item, index) in dictData.image_type"
                                :key="index"
                                :label="item.name"
                                :value="item.value"
                            />
                        </el-select>
                        <div class="form-tips">
                            菜单配置表示用户端的功能菜单，轮播图配置表示用户端轮播图。
                        </div>
                    </div>
                </el-form-item>
                <el-form-item label="显示位置" prop="position">
                    <div style="width: 100%">
                        <el-select
                            class="flex-1"
                            v-model="formData.position"
                            clearable
                            placeholder="请选择显示位置"
                        >
                            <el-option
                                v-for="(item, index) in dictData.image_position"
                                :key="index"
                                :label="item.name"
                                :value="item.value"
                            />
                        </el-select>
                        <div class="form-tips">
                            图片类型是菜单则选择带有菜单字样的位置，图片类型是轮播图则选择轮播图位置。
                        </div>
                    </div>
                </el-form-item>
                <el-form-item label="图片标题" prop="title">
                    <el-input v-model="formData.title" clearable placeholder="请输入图片标题" />
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
                        :max="100000"
                        style="width: 100%"
                        v-model="formData.sort"
                        clearable
                        placeholder="请输入显示权重"
                    />
                </el-form-item>
                <el-form-item label="显示平台" prop="client">
                    <el-select
                        class="flex-1"
                        v-model="formData.client"
                        clearable
                        placeholder="请选择显示平台"
                    >
                        <el-option
                            v-for="(item, index) in dictData.client"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="封面图片" prop="image">
                    <material-picker v-model="formData.image" />
                </el-form-item>
                <el-form-item label="菜单图标" prop="icon">
                    <div style="width: 100%">
                        <el-input v-model="formData.icon" clearable placeholder="请输入菜单图标" />
                        <div class="form-tips">适用于用户端菜单，使用的是字体库类型的菜单。</div>
                    </div>
                </el-form-item>
                <el-form-item label="跳转地址" prop="url">
                    <el-input v-model="formData.url" clearable placeholder="请输入跳转地址" />
                </el-form-item>
            </el-form>
        </popup>
    </div>
</template>

<script lang="ts" setup name="tenantBannerEdit">
import type { FormInstance } from 'element-plus'
import type { PropType } from 'vue'

import {
    apiTenantBannerAdd,
    apiTenantBannerDetail,
    apiTenantBannerEdit
} from '@/api/config/tenant_banner'
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
    return mode.value == 'edit' ? '编辑轮播图管理' : '新增轮播图管理'
})

// 表单数据
const formData = reactive({
    id: '',
    title: '',
    is_show: '',
    sort: '',
    position: '',
    client: '',
    image: '',
    image_type: '',
    url: '',
    icon: ''
})

// 表单验证
const formRules = reactive<any>({
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
    ],
    position: [
        {
            required: true,
            message: '请选择显示位置',
            trigger: ['blur']
        }
    ],
    client: [
        {
            required: true,
            message: '请选择显示平台',
            trigger: ['blur']
        }
    ],
    image_type: [
        {
            required: true,
            message: '请选择图片类型',
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
    const data = await apiTenantBannerDetail({
        id: row.id
    })
    setFormData(data)
}

// 提交按钮
const handleSubmit = async () => {
    await formRef.value?.validate()
    const data = { ...formData }
    mode.value == 'edit' ? await apiTenantBannerEdit(data) : await apiTenantBannerAdd(data)
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
