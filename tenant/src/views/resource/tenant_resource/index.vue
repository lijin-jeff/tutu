<template>
    <div>
        <el-card class="!border-none mb-4" shadow="never">
            <el-form
                class="mb-[-16px]"
                :model="queryParams"
                inline
            >
                <el-form-item label="资源名称" prop="title">
                  <el-input class="w-[280px]" v-model="queryParams.title" clearable placeholder="请输入资源名称" />
                </el-form-item>
                <el-form-item label="资源作者" prop="author">
                  <el-input class="w-[280px]" v-model="queryParams.author" clearable placeholder="请输入资源作者" />
                </el-form-item>
                <el-form-item label="资源分类" prop="category_uid">
                  <el-cascader
                      v-model="queryParams.category_uid"
                      :options="categoryList"
                      :props="props"
                      style="width: 100%"
                      @change="handleChange"
                  />
                </el-form-item>
                <el-form-item label="上架状态" prop="is_show">
                  <el-select class="w-[280px]" style="width: 200px;" v-model="queryParams.is_show" clearable placeholder="请选择上架装">
                    <el-option label="全部" value=""></el-option>
                    <el-option
                        v-for="(item, index) in dictData.show_status"
                        :key="index"
                        :label="item.name"
                        :value="item.value"
                    />
                  </el-select>
                </el-form-item>
                <el-form-item label="付费状态" prop="free_state">
                  <el-select class="w-[280px]" style="width: 200px;" v-model="queryParams.free_state" clearable placeholder="请选择付费状态">
                    <el-option label="全部" value=""></el-option>
                    <el-option
                        v-for="(item, index) in dictData.price_typ"
                        :key="index"
                        :label="item.name"
                        :value="item.value"
                    />
                  </el-select>
                </el-form-item>
                <el-form-item label="资源年份" prop="year">
                  <el-select class="w-[280px]" style="width: 200px;" v-model="queryParams.year" clearable placeholder="请选择资源年份">
                    <el-option label="全部" value=""></el-option>
                    <el-option
                        v-for="(item, index) in dictData.data_year"
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
            <el-button v-perms="['resource.tenant_resource/add']" type="primary" @click="handleAdd">
                <template #icon>
                    <icon name="el-icon-Plus" />
                </template>
                新增
            </el-button>
            <el-button
                v-perms="['resource.tenant_resource/delete']"
                :disabled="!selectData.length"
                @click="handleDelete(selectData)"
            >
                删除
            </el-button>
            <div class="mt-4">
                <el-table :data="pager.lists" @selection-change="handleSelectionChange">
                    <el-table-column type="selection" width="55" />
                    <el-table-column label="资源编号" prop="uid" show-overflow-tooltip />
                    <el-table-column label="资源分类" prop="category.title" show-overflow-tooltip />
                    <el-table-column label="资源名称" prop="title" show-overflow-tooltip />
                    <el-table-column label="上架状态" prop="is_show">
                        <template #default="{ row }">
                            <dict-value :options="dictData.show_status" :value="row.is_show" />
                        </template>
                    </el-table-column>
                    <el-table-column label="分类封面" prop="image">
                      <template #default="{ row }">
                        <el-image style="width:50px;height:50px;" :src="row.image"/>
                      </template>
                    </el-table-column>
                    <el-table-column label="资源作者" prop="author" show-overflow-tooltip />
                    <el-table-column label="付费状态" prop="free_state">
                        <template #default="{ row }">
                            <dict-value :options="dictData.price_typ" :value="row.free_state" />
                        </template>
                    </el-table-column>
                    <el-table-column label="资源价格" prop="money" show-overflow-tooltip />
                    <el-table-column label="资源年份" prop="year">
                        <template #default="{ row }">
                            <dict-value :options="dictData.data_year" :value="row.year" />
                        </template>
                    </el-table-column>
                    <el-table-column label="显示权重" prop="sort" show-overflow-tooltip />
                    <el-table-column label="创建时间" prop="create_time" show-overflow-tooltip />
                    <el-table-column label="更新时间" prop="update_time" show-overflow-tooltip />
                    <el-table-column label="操作" width="120" fixed="right">
                        <template #default="{ row }">
                             <el-button
                                v-perms="['resource.tenant_resource/edit']"
                                type="primary"
                                link
                                @click="handleEdit(row)"
                            >
                                编辑
                            </el-button>
                            <el-button
                                v-perms="['resource.tenant_resource/delete']"
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

<script lang="ts" setup name="tenantResourceLists">
import { usePaging } from '@/hooks/usePaging'
import { useDictData } from '@/hooks/useDictOptions'
import { apiTenantResourceLists, apiTenantResourceDelete } from '@/api/resource/tenant_resource'
import feedback from '@/utils/feedback'
import EditPopup from './edit.vue'
import {apiTenantResourceCategoryTree} from "@/api/resource/tenant_resource_category";

const editRef = shallowRef<InstanceType<typeof EditPopup>>()
// 是否显示编辑框
const showEdit = ref(false)
const categoryList = reactive([])

// 查询条件
const queryParams = reactive({
    title: '',
    is_show: '',
    category_uid: '',
    author: '',
    free_state: '',
    year: ''
})

// 选中数据
const selectData = ref<any[]>([])

const handleChange = (value) => {
  queryParams.category_uid = value[1]
}

// 表格选择后回调事件
const handleSelectionChange = (val: any[]) => {
    selectData.value = val.map(({ id }) => id)
}

// 获取字典数据
const { dictData } = useDictData('show_status,price_typ,data_year')

// 分页相关
const { pager, getLists, resetParams, resetPage } = usePaging({
    fetchFun: apiTenantResourceLists,
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

const fetchExamCategoryList = async () => {
  await apiTenantResourceCategoryTree().then((res) => {
    Object.assign(categoryList, res)
  })
}
fetchExamCategoryList()

// 删除
const handleDelete = async (id: number | any[]) => {
    await feedback.confirm('确定要删除？')
    await apiTenantResourceDelete({ id })
    getLists()
}

getLists()
</script>

