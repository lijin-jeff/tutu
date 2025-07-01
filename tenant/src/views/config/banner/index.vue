<template>
    <div>
        <el-card class="!border-none mb-4" shadow="never">
            <el-form class="mb-[-16px]" :model="queryParams" inline>
                <el-form-item label="图片标题" prop="title">
                    <el-input
                        class="w-[140px]"
                        v-model="queryParams.title"
                        clearable
                        placeholder="请输入图片标题"
                    />
                </el-form-item>
                <el-form-item label="显示状态" prop="is_show">
                    <el-select
                        class="w-[280px]"
                        v-model="queryParams.is_show"
                        clearable
                        placeholder="请选择显示状态"
                        style="width: 100px"
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
                <el-form-item label="显示位置" prop="position">
                    <el-select
                        class="w-[280px]"
                        v-model="queryParams.position"
                        clearable
                        placeholder="请选择显示位置"
                        style="width: 100px"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.image_position"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="图片类型" prop="image_type">
                    <el-select
                        class="w-[280px]"
                        v-model="queryParams.image_type"
                        clearable
                        placeholder="请选择显示位置"
                        style="width: 100px"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.image_type"
                            :key="index"
                            :label="item.name"
                            :value="item.value"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="显示平台" prop="client">
                    <el-select
                        class="w-[280px]"
                        v-model="queryParams.client"
                        clearable
                        placeholder="请选择显示平台"
                        style="width: 100px"
                    >
                        <el-option label="全部" value=""></el-option>
                        <el-option
                            v-for="(item, index) in dictData.client"
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
            <el-button v-perms="['config.tenant_banner/add']" type="primary" @click="handleAdd">
                <template #icon>
                    <icon name="el-icon-Plus" />
                </template>
                新增
            </el-button>
            <el-button
                v-perms="['config.tenant_banner/delete']"
                :disabled="!selectData.length"
                @click="handleDelete(selectData)"
            >
                删除
            </el-button>
            <div class="mt-4">
                <el-table :data="pager.lists" @selection-change="handleSelectionChange">
                    <el-table-column type="selection" width="55" />
                    <el-table-column label="图片类型" prop="image_type">
                        <template #default="{ row }">
                            <dict-value :options="dictData.image_type" :value="row.image_type" />
                        </template>
                    </el-table-column>
                    <el-table-column label="显示位置" prop="position">
                        <template #default="{ row }">
                            <dict-value :options="dictData.image_position" :value="row.position" />
                        </template>
                    </el-table-column>
                    <el-table-column label="显示平台" prop="client">
                        <template #default="{ row }">
                            <dict-value :options="dictData.client" :value="row.client" />
                        </template>
                    </el-table-column>
                    <el-table-column label="图片标题" prop="title" show-overflow-tooltip />
                    <el-table-column label="封面图片" prop="image">
                        <template #default="{ row }">
                            <el-image
                                v-if="row.image !== ''"
                                style="width: 50px; height: 50px"
                                :src="row.image"
                                :preview-src-list="[row.image]"
                                :preview-teleported="true"
                            />
                        </template>
                    </el-table-column>
                    <el-table-column label="显示状态" prop="is_show">
                        <template #default="{ row }">
                            <dict-value :options="dictData.show_status" :value="row.is_show" />
                        </template>
                    </el-table-column>
                    <el-table-column label="显示权重" prop="sort" show-overflow-tooltip />
                    <el-table-column label="图片图标" prop="icon" show-overflow-tooltip />
                    <el-table-column label="操作" width="120" fixed="right">
                        <template #default="{ row }">
                            <el-button
                                v-perms="['config.tenant_banner/edit']"
                                type="primary"
                                link
                                @click="handleEdit(row)"
                            >
                                编辑
                            </el-button>
                            <el-button
                                v-perms="['config.tenant_banner/delete']"
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

<script lang="ts" setup name="tenantBannerLists">
import { apiTenantBannerDelete, apiTenantBannerLists } from '@/api/config/tenant_banner'
import { useDictData } from '@/hooks/useDictOptions'
import { usePaging } from '@/hooks/usePaging'
import feedback from '@/utils/feedback'
import { timeFormat } from '@/utils/util'

import EditPopup from './edit.vue'

const editRef = shallowRef<InstanceType<typeof EditPopup>>()
// 是否显示编辑框
const showEdit = ref(false)

// 查询条件
const queryParams = reactive({
    title: '',
    is_show: '',
    sort: '',
    position: '',
    client: '',
    image: '',
    image_type: ''
})

// 选中数据
const selectData = ref<any[]>([])

// 表格选择后回调事件
const handleSelectionChange = (val: any[]) => {
    selectData.value = val.map(({ id }) => id)
}

// 获取字典数据
const { dictData } = useDictData('show_status,image_position,client,image_type')

// 分页相关
const { pager, getLists, resetParams, resetPage } = usePaging({
    fetchFun: apiTenantBannerLists,
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
    await apiTenantBannerDelete({ id })
    getLists()
}

getLists()
</script>
