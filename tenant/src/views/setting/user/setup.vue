<!-- 网站信息 -->
<template>
    <div class="user-setup">
        <el-card shadow="never" class="!border-none">
            <div class="font-medium mb-7">基本设置</div>
            <el-form ref="formRef" :model="formData" label-width="120px" :rules="formRules">
                <el-form-item label="用户默认头像" prop="default_avatar">
                    <div>
                        <material-picker v-model="formData.default_avatar" :limit="1" />
                        <div class="form-tips">
                            用户注册时给的默认头像，建议尺寸：400*400像素，支持jpg，jpeg，png格式。
                        </div>
                    </div>
                </el-form-item>
                <el-form-item label="用户默认昵称" prop="default_nickname">
                    <div>
                        <el-input
                            v-model="formData.default_nickname"
                            placeholder="请输入用户默认名称"
                        />
                        <div class="form-tips">用户注册时给的默认昵称。</div>
                    </div>
                </el-form-item>
            </el-form>
        </el-card>

        <footer-btns v-perms="['setting.user.user/setConfig']">
            <el-button type="primary" @click="handleSubmit">保存</el-button>
        </footer-btns>
    </div>
</template>

<script lang="ts" setup name="userSetup">
import { getUserSetup, setUserSetup } from '@/api/setting/user'
import type { FormInstance } from 'element-plus'

// 表单数据
const formData = reactive({
    default_avatar: '', // 用户默认头像
    default_nickname: '' // 用户默认昵称
})
const formRef = shallowRef<FormInstance>()
// 获取用户设置数据
const getData = async () => {
    try {
        const data = await getUserSetup()
        for (const key in formData) {
            //@ts-ignore
            formData[key] = data[key]
        }
    } catch (error) {
        console.log('获取=>', error)
    }
}

const formRules = reactive<any>({
    default_avatar: [
        {
            required: true,
            message: '请选择用户默认头像',
            trigger: ['blur']
        }
    ],
    default_nickname: [
        {
            required: true,
            message: '请设置用户默认昵称',
            trigger: ['blur']
        }
    ]
})

// 保存用户设置数据
const handleSubmit = async () => {
    try {
        await formRef.value?.validate()
        await setUserSetup(formData)
        getData()
    } catch (error) {
        console.log('保存=>', error)
    }
}

getData()
</script>

<style lang="scss" scoped></style>
