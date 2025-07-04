<template>
    <div>
        <el-card class="!border-none mb-4" shadow="never">
            <el-form
                class="mb-[-16px]"
                :model="queryParams"
                inline
            >
                <el-form-item label="用户编号" prop="user_sn">
                    <el-input class="w-[140px]" v-model="queryParams.user_sn" clearable placeholder="请输入用户编号" />
                </el-form-item>
                <el-form-item label="题库编号" prop="exam_uid">
                    <el-input class="w-[140px]" v-model="queryParams.exam_uid" clearable placeholder="请输入题库编号" />
                </el-form-item>
                <el-form-item label="开始时间" prop="start_time">
                    <daterange-picker
                        v-model:startTime="queryParams.start_time"
                        v-model:endTime="queryParams.end_time"
                    />
                </el-form-item>
                <el-form-item label="激活状态" prop="active_status">
                    <el-select class="w-[280px]" style="width: 120px;" v-model="queryParams.active_status" clearable placeholder="请选择激活状态">
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.activite_status"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="resetPage">查询</el-button>
                    <el-button @click="resetParams">重置</el-button>
                </el-form-item>
            </el-form>
        </el-card>
        <el-card class="!border-none" v-loading="pager.loading" shadow="never">
            <el-button v-perms="['exam.tenant_exam_active/add']" type="primary" @click="handleAdd">
                <template #icon>
                    <icon name="el-icon-Plus" />
                </template>
                新增
            </el-button>
            <el-button
                v-perms="['exam.tenant_exam_active/delete']"
                :disabled="!selectData.length"
                @click="handleDelete(selectData)"
            >
                删除
            </el-button>
            <div class="mt-4">
                <el-table :data="pager.lists" @selection-change="handleSelectionChange">
                    <el-table-column type="selection" width="55" />
                    <el-table-column label="id" prop="id" show-overflow-tooltip />
                    <el-table-column label="用户编号" prop="user_sn" show-overflow-tooltip />
                    <el-table-column label="用户昵称" prop="user.nickname" show-overflow-tooltip />
                    <el-table-column label="题库编号" prop="exam_uid" show-overflow-tooltip />
                    <el-table-column label="题库名称" prop="exam.title" show-overflow-tooltip />
                    <el-table-column label="开始时间" prop="start_time">
                        <template #default="{ row }">
                          <span>{{ row.start_time ? timeFormat(row.start_time, 'yyyy-mm-dd hh:MM:ss') : '' }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="结束时间" prop="end_time">
                        <template #default="{ row }">
                          <span>{{ row.end_time ? timeFormat(row.end_time, 'yyyy-mm-dd hh:MM:ss') : '' }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="激活状态" prop="active_status">
                        <template #default="{ row }">
                            <dict-value :options="dictData.activite_status" :value="row.active_status" />
                        </template>
                    </el-table-column>
                    <el-table-column label="题库激活码" prop="active_code" show-overflow-tooltip />
                    <el-table-column label="激活时间" prop="active_time" show-overflow-tooltip />
                    <el-table-column label="创建时间" prop="create_time" show-overflow-tooltip />
                    <el-table-column label="更新时间" prop="update_time" show-overflow-tooltip />
                    <el-table-column label="操作" width="120" fixed="right">
                        <template #default="{ row }">
                             <el-button
                                v-perms="['exam.tenant_exam_active/edit']"
                                type="primary"
                                link
                                @click="handleEdit(row)"
                            >
                                编辑
                            </el-button>
                            <el-button
                                v-perms="['exam.tenant_exam_active/delete']"
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
        <edit-popup v-if="showEdit" ref="editRef" :dict-data="dictData" @success="getLists" @close="showEdit = false" />
    </div>
</template>

<script lang="ts" setup name="tenantExamActiveLists">
import { usePaging } from '@/hooks/usePaging'
import { useDictData } from '@/hooks/useDictOptions'
import { apiTenantExamActiveLists, apiTenantExamActiveDelete } from '@/api/exam/tenant_exam_active'
import { timeFormat } from '@/utils/util'
import feedback from '@/utils/feedback'
import EditPopup from './edit.vue'

const editRef = shallowRef<InstanceType<typeof EditPopup>>()
// 是否显示编辑框
const showEdit = ref(false)


// 查询条件
const queryParams = reactive({
    user_sn: '',
    exam_uid: '',
    start_time: '',
    end_time: '',
    active_status: ''
})

// 选中数据
const selectData = ref<any[]>([])

// 表格选择后回调事件
const handleSelectionChange = (val: any[]) => {
    selectData.value = val.map(({ id }) => id)
}

// 获取字典数据
const { dictData } = useDictData('activite_status')

// 分页相关
const { pager, getLists, resetParams, resetPage } = usePaging({
    fetchFun: apiTenantExamActiveLists,
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
    await apiTenantExamActiveDelete({ id })
    getLists()
}

getLists()
</script>

