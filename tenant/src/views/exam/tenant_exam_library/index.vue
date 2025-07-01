<template>
    <div>
        <el-card class="!border-none mb-4" shadow="never" :body-style="{ padding: 10 + 'px' }">
            <el-form class="" :model="queryParams" inline>
                <el-form-item label="题库名称" prop="title">
                    <el-input
                        class="w-[120px]"
                        v-model="queryParams.title"
                        clearable
                        placeholder="请输入"
                    />
                </el-form-item>
                <!--                <el-form-item label="显示状态" prop="is_show">-->
                <!--                    <el-select-->
                <!--                        style="width: 100px"-->
                <!--                        v-model="queryParams.is_show"-->
                <!--                        clearable-->
                <!--                        placeholder="请选择"-->
                <!--                    >-->
                <!--                        <el-option label="全部" value=""></el-option>-->
                <!--                        <el-option-->
                <!--                            v-for="(item, index) in dictData.show_status"-->
                <!--                            :key="index"-->
                <!--                            :label="item.name"-->
                <!--                            :value="item.value"-->
                <!--                        />-->
                <!--                    </el-select>-->
                <!--                </el-form-item>-->
                <el-form-item label="题库分类" prop="category_uid">
                    <el-cascader
                        v-model="queryParams.category_uid"
                        :options="categoryList"
                        :props="props"
                        style="width: 100%"
                        @change="handleChange"
                    />
                </el-form-item>
                <!--                <el-form-item label="题库作者" prop="author">-->
                <!--                    <el-input-->
                <!--                        style="width: 100px"-->
                <!--                        v-model="queryParams.author"-->
                <!--                        clearable-->
                <!--                        placeholder="请输入"-->
                <!--                    />-->
                <!--                </el-form-item>-->
                <el-form-item label="收费状态" prop="free_state">
                    <el-select
                        style="width: 100px"
                        v-model="queryParams.free_state"
                        clearable
                        placeholder="请选择"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.price_typ"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="是否热门" prop="hot_state">
                    <el-select
                        style="width: 100px"
                        v-model="queryParams.hot_state"
                        clearable
                        placeholder="请选择"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.hot_state"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="是否推荐" prop="recommend_state">
                    <el-select
                        style="width: 100px"
                        v-model="queryParams.recommend_state"
                        clearable
                        placeholder="请选择"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.recommend_state"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="收费状态" prop="free_state">
                    <el-select
                        style="width: 100px"
                        v-model="queryParams.free_state"
                        clearable
                        placeholder="请选择"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.price_typ"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <!--                <el-form-item label="题库年份" prop="year">-->
                <!--                    <el-select-->
                <!--                        style="width: 100px"-->
                <!--                        v-model="queryParams.year"-->
                <!--                        clearable-->
                <!--                        placeholder="请选择"-->
                <!--                    >-->
                <!--                        <el-option label="全部" value=""></el-option>-->
                <!--                        <el-option-->
                <!--                            v-for="(item, index) in dictData.data_year"-->
                <!--                            :key="index"-->
                <!--                            :label="item.name"-->
                <!--                            :value="item.value"-->
                <!--                        />-->
                <!--                    </el-select>-->
                <!--                </el-form-item>-->
                <el-form-item>
                    <el-button type="primary" @click="resetPage">查询</el-button>
                    <el-button @click="resetParams">重置</el-button>
                </el-form-item>
            </el-form>
        </el-card>
        <el-card class="!border-none" v-loading="pager.loading" shadow="never">
            <el-button v-perms="['exam.tenant_exam_library/add']" type="primary" @click="handleAdd">
                <template #icon>
                    <icon name="el-icon-Plus" />
                </template>
                新增
            </el-button>
            <el-button
                v-perms="['exam.tenant_exam_library/delete']"
                :disabled="!selectData.length"
                @click="handleDelete(selectData)"
            >
                删除
            </el-button>
            <div class="mt-4">
                <el-table :data="pager.lists" @selection-change="handleSelectionChange">
                    <el-table-column type="selection" width="55" />
                    <el-table-column label="题库编号" prop="uid" show-overflow-tooltip />
                    <el-table-column label="题库分类" prop="category.title" />
                    <el-table-column label="题库名称" prop="title" show-overflow-tooltip />
                    <el-table-column label="题库封面" prop="cover">
                        <template #default="{ row }">
                            <el-image
                                v-if="row.image !== ''"
                                style="width: 50px; height: 50px"
                                :src="row.image"
                                :preview-src-list="[row.image]"
                                preview-teleported
                            />
                        </template>
                    </el-table-column>
                    <!--                    <el-table-column label="题库作者" prop="author" show-overflow-tooltip />-->
                    <el-table-column label="收费状态" prop="free_state">
                        <template #default="{ row }">
                            <dict-value :options="dictData.price_typ" :value="row.free_state" />
                        </template>
                    </el-table-column>
                    <!--                    <el-table-column label="题库价格" prop="money" show-overflow-tooltip />-->
                    <!--                    <el-table-column label="题库折扣" prop="discount" show-overflow-tooltip />-->
                    <!--                    <el-table-column label="题库年份" prop="year">-->
                    <!--                        <template #default="{ row }">-->
                    <!--                            <dict-value :options="dictData.data_year" :value="row.year" />-->
                    <!--                        </template>-->
                    <!--                    </el-table-column>-->
                    <el-table-column label="显示状态" prop="is_show">
                        <template #default="{ row }">
                            <dict-value :options="dictData.show_status" :value="row.is_show" />
                        </template>
                    </el-table-column>
                    <!--                    <el-table-column label="显示权重" prop="sort" show-overflow-tooltip />-->
                    <el-table-column label="创建时间" prop="create_time" show-overflow-tooltip />
                    <el-table-column label="操作" width="180" fixed="right">
                        <template #default="{ row }">
                            <div class="display-flex-start-center">
                                <el-button
                                    v-perms="['exam.tenant_exam_library/edit']"
                                    type="primary"
                                    link
                                    @click="handleEdit(row)"
                                >
                                    编辑
                                </el-button>
                                <el-button
                                    v-perms="['exam.tenant_exam_library/delete']"
                                    type="danger"
                                    class="padding-right10"
                                    link
                                    @click="handleDelete(row.id)"
                                >
                                    删除
                                </el-button>
                                <el-dropdown>
                                    <el-button type="warning" link
                                        >操作<el-icon class="el-icon--right"
                                            ><arrow-down
                                        /></el-icon>
                                    </el-button>
                                    <template #dropdown>
                                        <el-dropdown-menu>
                                            <el-dropdown-item
                                                ><el-button
                                                    v-perms="['exam.tenant_exam_question/lists']"
                                                    type="primary"
                                                    link
                                                    @click="handleQuestion(row)"
                                                >
                                                    题库
                                                </el-button></el-dropdown-item
                                            >
                                            <el-dropdown-item
                                                ><el-button
                                                    v-perms="['exam.tenant_exam_chapter/lists']"
                                                    type="primary"
                                                    link
                                                    @click="handleChapter(row)"
                                                >
                                                    章节
                                                </el-button></el-dropdown-item
                                            >
                                        </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div class="flex mt-4 justify-end">
                <pagination v-model="pager" @change="getLists" />
            </div>
        </el-card>
        <edit-popup
            v-if="showEdit"
            ref="editRef"
            :dict-data="dictData"
            @success="getLists"
            @close="showEdit = false"
        />
    </div>
</template>

<script lang="ts" setup name="tenantExamLibraryLists">
import { useRouter } from 'vue-router'

import { apiExamCategoryTree } from '@/api/exam/exam_category'
import {
    apiTenantExamLibraryDelete,
    apiTenantExamLibraryLists
} from '@/api/exam/tenant_exam_library'
import { useDictData } from '@/hooks/useDictOptions'
import { usePaging } from '@/hooks/usePaging'
import feedback from '@/utils/feedback'

import EditPopup from './edit.vue'

const router = useRouter()

const editRef = shallowRef<InstanceType<typeof EditPopup>>()
// 是否显示编辑框
const showEdit = ref(false)

// 查询条件
const queryParams = reactive({
    title: '',
    is_show: '',
    category_uid: '',
    author: '',
    free_state: '',
    year: '',
    hot_state: '',
    recommend_state: ''
})
const categoryList = reactive([])

// 选中数据
const selectData = ref<any[]>([])

// 表格选择后回调事件
const handleSelectionChange = (val: any[]) => {
    selectData.value = val.map(({ id }) => id)
}
const handleChange = (value: string[]) => {
    queryParams.category_uid = value[1]
}

// 跳转题库页面
const handleQuestion = (data: any) => {
    router.push({
        path: 'question',
        query: {
            library_uid: data.uid
        }
    })
}

const handleChapter = (data: any) => {
    router.push({
        path: 'tenant_exam_chapter',
        query: {
            library_uid: data.uid
        }
    })
}
// 获取字典数据
const { dictData } = useDictData('show_status,price_typ,data_year,hot_state,recommend_state')

// 分页相关
const { pager, getLists, resetParams, resetPage } = usePaging({
    fetchFun: apiTenantExamLibraryLists,
    params: queryParams
})

// 添加
const handleAdd = async () => {
    showEdit.value = true
    await nextTick()
    editRef.value?.open('add')
}

// 编辑
const handleEdit = async (data: any) => {
    showEdit.value = true
    await nextTick()
    editRef.value?.open('edit')
    editRef.value?.setFormData(data)
}

// 删除
const handleDelete = async (id: number | any[]) => {
    await feedback.confirm('确定要删除？')
    await apiTenantExamLibraryDelete({ id })
    getLists()
}
const fetchExamCategoryList = async () => {
    await apiExamCategoryTree().then((res) => {
        Object.assign(categoryList, res)
    })
}
fetchExamCategoryList()
getLists()
</script>
<style scoped></style>
