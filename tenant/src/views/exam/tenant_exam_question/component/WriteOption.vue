<template>
    <div>
        <el-form label-width="70px">
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
            <el-form-item label="试题解析" prop="analysis">
                <editor v-model="formData.analysis" :height="150" width="100%" />
            </el-form-item>
            <el-form-item label="答案选项">
                <div v-for="(item, index) in formData.option" :key="item.check" class="with100">
                    <div>
                        <el-radio-group @change="optionCheck" v-model="formData.selectAnswer">
                            <div class="" style="width: 100%">
                                <div class="padding-right20 display-flex-start-center">
                                    <div class="display-flex-start-center">
                                        <el-button
                                            type="success"
                                            icon="Plus"
                                            link
                                            @click="addOption"
                                            >添加选项
                                        </el-button>
                                        <el-button
                                            type="danger"
                                            icon="Delete"
                                            link
                                            @click="deleteOption(index)"
                                            >删除选项
                                        </el-button>
                                    </div>
                                </div>
                            </div>
                        </el-radio-group>
                    </div>
                    <!--                    编辑器不能嵌套到radio-group内，否则编辑器内的内容不会被显示-->
                    <div class="margin-top10">
                        <exam-editor
                            v-model="formData.option[index].title"
                            :height="150"
                            width="100%"
                        />
                    </div>
                </div>
            </el-form-item>
            <div class="display-flex-start-center">
                <el-button type="primary">保存试题</el-button>
                <el-button type="warning">重置数据</el-button>
            </div>
        </el-form>
    </div>
</template>

<script setup lang="ts">
import { useDictData } from '@/hooks/useDictOptions'

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
            title: '请输入选项值'
        }
    ]
})
const { dictData } = useDictData('show_status')

const addOption = () => {
    formData.option.push({
        check: '',
        title: '请输入选项值'
    })
}
const deleteOption = (index: number) => {
    formData.option.splice(index, 1)
    rebuildOption()
}

const optionCheck = (check: string) => {
    formData.answer = [check]
}

const rebuildOption = () => {
    const option = []
    for (let i = 0; i < formData.option.length; i++) {
        option.push({
            title: formData.option[i].title,
            check: ''
        })
    }
    formData.option = option
}
</script>

<style scoped></style>
