<template>
    <el-card class="!border-none margin-bottom20" shadow="never">
        <el-page-header content="试题列表" @back="$router.back()" />
    </el-card>
    <el-card class="!border-none mb-4" shadow="never">
        <el-form class="mb-[-16px]" :model="queryParams" inline>
            <el-row>
                <el-form-item label="试题题干" prop="title">
                    <el-input
                        class="w-[140px]"
                        v-model="queryParams.title"
                        clearable
                        placeholder="请输入试题题干"
                    />
                </el-form-item>
                <el-form-item label="试题题型" prop="exam_type">
                    <el-select
                        style="width: 100px"
                        v-model="queryParams.exam_type"
                        clearable
                        placeholder="请选择试题题型"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.exam_level"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="试题章节" prop="chapter_uid">
                    <el-cascader
                        v-model="queryParams.chapter_uid"
                        :options="chapterList"
                        :props="props"
                        style="width: 100px"
                        @change="handleChange"
                    />
                </el-form-item>
                <el-form-item label="显示状态" prop="is_show">
                    <el-select
                        style="width: 100px"
                        v-model="queryParams.is_show"
                        clearable
                        placeholder="请选择显示状态"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.show_status"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="试题难度" prop="level">
                    <el-select
                        style="width: 100px"
                        v-model="queryParams.level"
                        clearable
                        placeholder="请选择试题难度"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.level"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
            </el-row>
            <el-row>
                <el-form-item>
                    <el-button type="primary" @click="resetPage">查询</el-button>
                    <el-button @click="resetParams">重置</el-button>
                </el-form-item>
            </el-row>
        </el-form>
    </el-card>
    <el-card class="!border-none" v-loading="pager.loading" shadow="never">
        <el-button v-perms="['exam.tenant_exam_question/add']" type="primary" @click="handleAdd">
            <template #icon>
                <icon name="el-icon-Plus" />
            </template>
            新增
        </el-button>
        <el-button
            v-perms="['exam.tenant_exam_question/delete']"
            :disabled="!selectData.length"
            @click="handleDelete(selectData)"
        >
            删除
        </el-button>
        <div class="mt-4">
            <el-table :data="pager.lists" @selection-change="handleSelectionChange">
                <el-table-column type="selection" width="55" />
                <el-table-column label="试题题型" prop="exam_type">
                    <template #default="{ row }">
                        <dict-value :options="dictData.exam_level" :value="row.exam_type" />
                    </template>
                </el-table-column>
                <el-table-column label="试题题干" prop="title" show-overflow-tooltip />
                <el-table-column label="试题难度" prop="level">
                    <template #default="{ row }">
                        <dict-value :options="dictData.level" :value="row.level" />
                    </template>
                </el-table-column>
                <el-table-column label="试题积分" prop="score" show-overflow-tooltip />
                <el-table-column label="试题答案" prop="answer" show-overflow-tooltip />
                <el-table-column label="显示权重" prop="sort" show-overflow-tooltip />
                <el-table-column label="显示状态" prop="is_show">
                    <template #default="{ row }">
                        <dict-value :options="dictData.show_status" :value="row.is_show" />
                    </template>
                </el-table-column>
                <el-table-column label="创建时间" prop="create_time" show-overflow-tooltip />
                <el-table-column label="操作" width="120" fixed="right">
                    <template #default="{ row }">
                        <el-button
                            v-perms="['exam.tenant_exam_question/edit']"
                            type="primary"
                            link
                            @click="handleEdit(row)"
                        >
                            编辑
                        </el-button>
                        <el-button
                            v-perms="['exam.tenant_exam_question/delete']"
                            type="danger"
                            link
                            @click="handleDelete(row.id)"
                        >
                            删除
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <div class="flex mt-4 justify-end">
            <pagination v-model="pager" @change="getLists" />
        </div>
    </el-card>
    <el-dialog v-model="showQuestionEdit" width="80%" title="试题编辑">
        <RadioOption
            v-if="questionType === 1"
            :library-uid="libraryUid"
            :id="questionId"
            @success="editSuccess"
        />
        <CheckBoxOption
            v-else-if="questionType === 2"
            :library-uid="libraryUid"
            :id="questionId"
            @success="editSuccess"
        />
        <JudeOption
            v-else-if="questionType === 3"
            :library-uid="libraryUid"
            :id="questionId"
            @success="editSuccess"
        />
        <WriteOption v-else-if="questionType === 4" />
        <QuestionOption v-else-if="questionType === 5" />
        <CompoundOption v-else-if="questionType === 6" />
        <ClozeOption v-else-if="questionType === 7" />
    </el-dialog>
</template>

<script lang="ts" setup name="tenantExamQuestionLists">
import { useRouter } from 'vue-router'

import { apiTenantExamChapterTree } from '@/api/exam/tenant_exam_chapter'
import {
    apiTenantExamQuestionDelete,
    apiTenantExamQuestionLists
} from '@/api/exam/tenant_exam_question'
import { useDictData } from '@/hooks/useDictOptions'
import { usePaging } from '@/hooks/usePaging'
import feedback from '@/utils/feedback'

import CheckBoxOption from './component/CheckBoxOption.vue'
import ClozeOption from './component/ClozeOption.vue'
import CompoundOption from './component/CompoundOption.vue'
import JudeOption from './component/JudeOption.vue'
import QuestionOption from './component/QuestionOption.vue'
import RadioOption from './component/RadioOption.vue'
import WriteOption from './component/WriteOption.vue'

const router = useRouter()
const route = useRoute()

// 试题编辑
const showQuestionEdit = ref(false)
const questionType = ref(0)
const libraryUid = ref(route.query.library_uid)
const questionId = ref(0)

// 查询条件
const queryParams = reactive({
    title: '',
    exam_type: '',
    is_show: '',
    level: '',
    chapter_uid: '',
    tenant_exam_library_uid: route.query.library_uid
})
const chapterList = reactive([])
// 选中数据
const selectData = ref<any[]>([])

// 表格选择后回调事件
const handleSelectionChange = (val: any[]) => {
    selectData.value = val.map(({ id }) => id)
}

// 获取字典数据
const { dictData } = useDictData('exam_level,show_status,level')

// 分页相关
const { pager, getLists, resetParams, resetPage } = usePaging({
    fetchFun: apiTenantExamQuestionLists,
    params: queryParams
})

// 添加
const handleAdd = () => {
    router.push({
        path: 'question/edit',
        query: {
            library_uid: route.query.library_uid
        }
    })
}

// 编辑
const handleEdit = (data: any) => {
    showQuestionEdit.value = true
    questionType.value = data.exam_type
    questionId.value = data.id
}

const editSuccess = () => {
    showQuestionEdit.value = false
    getLists()
}

// 删除
const handleDelete = async (id: number | any[]) => {
    await feedback.confirm('确定要删除？')
    await apiTenantExamQuestionDelete({ id })
    getLists()
}
const fetchChapterList = async () => {
    apiTenantExamChapterTree({ tenant_exam_library_uid: queryParams.tenant_exam_library_uid }).then(
        (res) => {
            Object.assign(chapterList, res)
        }
    )
}
fetchChapterList()
getLists()
</script>
