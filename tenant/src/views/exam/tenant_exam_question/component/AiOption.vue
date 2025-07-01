<template>
    <div>
        <div>
            <el-button type="success" icon="ChatDotRound" @click="dialogVisible = true"
                >调用AI生成试题
            </el-button>
        </div>
        <div class="" style="display: flex">
            <div style="width: 50%">
                <div class="tip-head-title">
                    <el-button type="primary" icon="InfoFilled" link disabled>编辑区</el-button>
                </div>
                <el-input
                    type="textarea"
                    v-model="formData.content"
                    :autosize="{ minRows: 40, maxRows: 40 }"
                    :placeholder="placeholder"
                    resize="none"
                    :show-word-limit="true"
                    maxlength="65535"
                />
            </div>
            <div style="width: 50%; padding-left: 20px">
                <div class="tip-head-title">
                    <el-button type="primary" icon="View" link disabled>预览区</el-button>
                </div>
                <el-input
                    type="textarea"
                    v-model="formData.content"
                    :autosize="{ minRows: 40, maxRows: 40 }"
                    :placeholder="placeholder"
                    resize="none"
                    :show-word-limit="true"
                    maxlength="65535"
                    :disabled="true"
                />
            </div>
        </div>
        <el-dialog
            v-model="dialogVisible"
            title="AI生成提示词"
            width="30%"
            :body-style="{ margin: '20px', borderRadius: '8px' }"
            class="custom-dialog"
        >
            <div class="dialog-content">
                <el-input
                    v-model="formData.content"
                    type="textarea"
                    :autosize="{ minRows: 4 }"
                    placeholder="请输入内容AI提示词内容"
                />
            </div>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="dialogVisible = false">取 消</el-button>
                    <el-button type="primary" @click="aiRequest">确 定</el-button>
                </span>
            </template>
        </el-dialog>
    </div>
</template>

<script setup lang="ts">
interface Props {
    libraryUid: string
}
const props = defineProps<Props>()
const dialogVisible = ref(false)
const placeholder = `AI生成将根据文本输入的格式生成试题`

const formData = reactive({
    chapter_uid: '',
    tenant_exam_library_uid: props.libraryUid,
    content: ''
})

const aiRequest = () => {
    dialogVisible.value = false
    setInterval(function () {
        formData.content += '正在生成中...'
    }, 100)
}
</script>

<style scoped>
/* 内容容器边距 */
.dialog-content {
    margin: 0;
}

/* 深度覆盖 Element 默认样式 */
.custom-dialog :deep(.el-dialog__body) {
    padding: 0 !important;
    background: #f8f9fa;
}

.custom-dialog :deep(.el-dialog__footer) {
    border-top: 1px solid #eee;
    padding: 0;
}

.tip-head-title {
    font-size: 30px;
}
</style>
