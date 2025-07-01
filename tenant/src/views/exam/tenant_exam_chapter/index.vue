<template>
    <div>
        <el-card class="!border-none" shadow="never">
            <el-page-header content="章节管理" @back="$router.back()" />
        </el-card>
        <el-card class="!border-none" v-loading="pager.loading" shadow="never">
            <el-form class="mb-[-16px] margin-bottom20" :model="queryParams" inline>
                <el-form-item label="章节名称" prop="title">
                    <el-input
                        class="w-[280px]"
                        v-model="queryParams.title"
                        clearable
                        placeholder="请输入章节名称"
                    />
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="resetPage">查询</el-button>
                    <el-button @click="resetParams">重置</el-button>
                </el-form-item>
            </el-form>
            <div>
                <el-button
                    v-perms="['exam.tenant_exam_chapter/add']"
                    type="primary"
                    @click="handleAdd"
                >
                    <template #icon>
                        <icon name="el-icon-Plus" />
                    </template>
                    新增
                </el-button>
                <el-button
                    v-perms="['exam.tenant_exam_chapter/delete']"
                    :disabled="!selectData.length"
                    @click="handleDelete(selectData)"
                >
                    删除
                </el-button>
            </div>
            <div class="mt-4">
                <el-table :data="pager.lists"
                    style="width: 100%; margin-bottom: 20px"
                    row-key="id"
                    @selection-change="handleSelectionChange"
                    :default-expand-all="false"
                    :tree-props="{ children: 'children', hasChildren: 'hasChildren' }"
                    :cell-style="{ 'text-align': 'center' }"
                    :header-cell-style="{ 'text-align': 'center' }">
                    <el-table-column type="selection" width="55" />
                    <el-table-column label="章节名称" prop="title" show-overflow-tooltip />
                    <el-table-column label="显示状态" prop="is_show">
                        <template #default="{ row }">
                            <dict-value :options="dictData.show_status" :value="row.is_show" />
                        </template>
                    </el-table-column>
                    <el-table-column label="显示权重" prop="sort" show-overflow-tooltip />
                    <el-table-column label="操作" width="120" fixed="right">
                        <template #default="{ row }">
                            <el-button
                                v-perms="['exam.tenant_exam_chapter/edit']"
                                type="primary"
                                link
                                @click="handleEdit(row)"
                            >
                                编辑
                            </el-button>
                            <el-button
                                v-perms="['exam.tenant_exam_chapter/delete']"
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
        <edit-popup
            v-if="showEdit"
            ref="editRef"
            :dict-data="dictData"
            @success="getLists"
            @close="showEdit = false"
        />
    </div>
</template>

<script lang="ts" setup name="tenantExamChapterLists">
import {
    apiTenantExamChapterDelete,
    apiTenantExamChapterLists
} from '@/api/exam/tenant_exam_chapter'
import { useDictData } from '@/hooks/useDictOptions'
import { usePaging } from '@/hooks/usePaging'
import feedback from '@/utils/feedback'

import EditPopup from './edit.vue'

const editRef = shallowRef<InstanceType<typeof EditPopup>>()
// 是否显示编辑框
const showEdit = ref(false)
const route = useRoute()

// 查询条件
const queryParams = reactive({
    title: '',
    is_show: '',
    tenant_exam_library_uid: route.query.library_uid
})

// 选中数据
const selectData = ref<any[]>([])

// 表格选择后回调事件
const handleSelectionChange = (val: any[]) => {
    selectData.value = val.map(({ id }) => id)
}

// 获取字典数据
const { dictData } = useDictData('show_status')

// 分页相关
const { pager, getLists, resetParams, resetPage } = usePaging({
    fetchFun: apiTenantExamChapterLists,
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
    await apiTenantExamChapterDelete({ id })
    getLists()
}

getLists()
</script>
