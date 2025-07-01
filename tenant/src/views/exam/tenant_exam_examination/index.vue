<template>
  <div>
    <el-card class="!border-none mb-4" shadow="never">
      <el-form class="mb-[-16px]" :model="queryParams" inline>
        <el-form-item label="考试名称" prop="title">
          <el-input
              style="width: 150px"
              v-model="queryParams.title"
              clearable
              placeholder="请输入考试名称"
          />
        </el-form-item>
        <el-form-item label="考试时间">
          <daterange-picker
              v-model:startTime="queryParams.start_time"
              v-model:endTime="queryParams.end_time"
          />
        </el-form-item>
        <el-form-item label="考试权限" prop="privilege">
          <el-select
              style="width: 100px"
              v-model="queryParams.privilege"
              clearable
              placeholder="请选择考试权限"
          >
            <el-option label="全部" value=""></el-option>
            <el-option
                v-for="(item, index) in dictData.exam_privilege"
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
      <el-button
          v-perms="['exam.tenant_exam_examination/add']"
          type="primary"
          @click="handleAdd"
      >
        <template #icon>
          <icon name="el-icon-Plus"/>
        </template>
        新增
      </el-button>
      <el-button
          v-perms="['exam.tenant_exam_examination/delete']"
          :disabled="!selectData.length"
          @click="handleDelete(selectData)"
      >
        删除
      </el-button>
      <div class="mt-4">
        <el-table :data="pager.lists" @selection-change="handleSelectionChange">
          <el-table-column type="selection" width="55"/>
          <el-table-column label="考试名称" prop="title" show-overflow-tooltip/>
          <el-table-column label="考试封面" prop="image">
            <template #default="{ row }">
              <el-image style="width:50px;height:50px;" :src="row.image" />
            </template>
          </el-table-column>
          <el-table-column label="开始时间" prop="start_time" show-overflow-tooltip/>
          <el-table-column label="结束时间" prop="end_time" show-overflow-tooltip/>
          <el-table-column label="考试权限" prop="privilege">
            <template #default="{ row }">
              <dict-value :options="dictData.exam_privilege" :value="row.privilege"/>
            </template>
          </el-table-column>
          <el-table-column
              label="答题类型"
              prop="submit_count_type"
              show-overflow-tooltip
          >
            <template #default="{ row }">
              <dict-value
                  :options="dictData.exam_submit_type"
                  :value="row.exam_submit_type"
              />
            </template>
          </el-table-column>
          <el-table-column label="登录方式" prop="login_style">
            <template #default="{ row }">
              <dict-value
                  :options="dictData.exam_login_style"
                  :value="row.login_style"
              />
            </template>
          </el-table-column>
          <el-table-column label="绑定试卷" prop="paper.title" show-overflow-tooltip/>
          <el-table-column label="创建时间" prop="create_time" show-overflow-tooltip/>
          <el-table-column label="操作" width="200" fixed="right">
            <template #default="{ row }">
              <el-button
                  v-perms="['exam.tenant_exam_examination/edit']"
                  type="primary"
                  link
                  @click="handleEdit(row)"
              >
                编辑
              </el-button>
              <el-button
                  v-perms="['exam.tenant_exam_examination/edit']"
                  type="primary"
                  link
                  @click="paperSelect(row)"
              >
                试卷
              </el-button>
              <el-button
                  v-perms="['exam.tenant_exam_examination/delete']"
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
        <pagination v-model="pager" @change="getLists"/>
      </div>
    </el-card>
    <edit-popup
        v-if="showEdit"
        ref="editRef"
        :dict-data="dictData"
        @success="getLists"
        @close="showEdit = false"
    />
    <!--      试卷开始-->
    <el-dialog
        title="试卷选择"
        v-model="dialogLibraryVisible"
        width="80%">
      <div class="mt-4">
        <el-card class="!border-none" shadow="never" :body-style="{ padding: 10 + 'px' }">
          <el-form
              class="mb-[-16px]"
              :model="paperQueryParams"
              inline
          >
            <el-form-item label="试卷名称" prop="title">
              <el-input class="w-[280px]" v-model="paperQueryParams.title" clearable placeholder="请输入试卷名称"/>
            </el-form-item>
            <el-form-item label="启用状态" prop="is_show">
              <el-select class="w-[280px]" style="width: 100px" v-model="paperQueryParams.is_show" clearable
                         placeholder="请选择启用状态">
                <el-option label="全部" value=""></el-option>
                <el-option
                    v-for="(item, index) in dictData.show_status"
                    :key="index"
                    :label="item.name"
                    :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="随机状态" prop="is_rand">
              <el-select class="w-[280px]" style="width: 100px" v-model="paperQueryParams.is_rand" clearable
                         placeholder="请选择随机状态">
                <el-option label="全部" value=""></el-option>
                <el-option
                    v-for="(item, index) in dictData.paper_rand"
                    :key="index"
                    :label="item.name"
                    :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="paperListFun.resetPage">查询</el-button>
              <el-button @click="paperListFun.resetParams">重置</el-button>
              <el-button type="warning" @click="paperConfirm">确认</el-button>
            </el-form-item>
          </el-form>
        </el-card>
        <el-card class="!border-none" v-loading="paperListFun.pager.loading" shadow="never">
          <div class="mt-4">
<!--            <div class="mb-4">当前试卷：{{ selectPaperInfo.value.paper !== undefined ? selectPaperInfo.value.paper.title : '' }}</div>-->
            <el-table :data="paperListFun.pager.lists" @selection-change="handlePaperSelectionChange">
              <el-table-column type="selection" width="55"/>
              <el-table-column label="试卷ID" prop="id" show-overflow-tooltip/>
              <el-table-column label="试卷编号" prop="uid" show-overflow-tooltip/>
              <el-table-column label="试卷封面" prop="image">
                <template #default="{ row }">
                  <el-image style="width:50px;height:50px;" :src="row.image"/>
                </template>
              </el-table-column>
              <el-table-column label="试卷名称" prop="title" show-overflow-tooltip/>
              <el-table-column label="随机状态" prop="is_rand">
                <template #default="{ row }">
                  <dict-value :options="dictData.paper_rand" :value="row.is_rand"/>
                </template>
              </el-table-column>
              <el-table-column label="试题总数" prop="option_count" show-overflow-tooltip/>
              <el-table-column label="试题总分" prop="option_score" show-overflow-tooltip/>
              <el-table-column label="启用状态" prop="is_show">
                <template #default="{ row }">
                  <dict-value :options="dictData.show_status" :value="row.is_show"/>
                </template>
              </el-table-column>
              <el-table-column label="显示权重" prop="sort" show-overflow-tooltip/>
              <el-table-column label="创建时间" prop="create_time" show-overflow-tooltip/>
              <el-table-column label="更新时间" prop="update_time" show-overflow-tooltip/>
            </el-table>
          </div>
          <div class="flex mt-4 justify-end">
            <pagination v-model="paperListFun.pager" @change="paperListFun.getLists"/>
          </div>
        </el-card>
      </div>
    </el-dialog>
    <!--      试卷结束-->
  </div>
</template>

<script lang="ts" setup name="tenantExamExaminationLists">
import {
  apiTenantExamExaminationDelete,
  apiTenantExamExaminationLists,
  apiTenantExamExaminationSavePaper
} from '@/api/exam/tenant_exam_examination'
import {apiTenantExamPaperLists} from '@/api/exam/tenant_exam_paper'
import {useDictData} from '@/hooks/useDictOptions'
import {usePaging} from '@/hooks/usePaging'
import feedback from '@/utils/feedback'

import EditPopup from './edit.vue'

const editRef = shallowRef<InstanceType<typeof EditPopup>>()
// 是否显示编辑框
const showEdit = ref(false)

// 查询条件
const queryParams = reactive({
  title: '',
  is_show: '',
  admin_id: '',
  tenant_id: '',
  start_time: '',
  end_time: '',
  privilege: '',
  exam_time: '',
  exam_submit_type: '',
  login_style: ''
})

/**
 * 试卷处理逻辑开始
 */
const dialogLibraryVisible = ref(false)
const paperSelectData = ref<any[]>([])
const paperQueryParams = reactive({
  title: '',
  is_show: '',
  is_rand: '',
})
const examination_id = ref(0)
const selectPaperInfo = ref({})

const paperListFun = usePaging({
  fetchFun: apiTenantExamPaperLists,
  params: paperQueryParams
})

const paperSelect = async (data: any) => {
  await paperListFun.getLists()
  examination_id.value = data.id
  dialogLibraryVisible.value = true
  selectPaperInfo.value = data
}

const handlePaperSelectionChange = (val: any[]) => {
  paperSelectData.value = val.map(({id}) => id)
  if (paperSelectData.value.length > 1) {
    feedback.msgError('只能选择一个试卷')
    paperSelectData.value = []
  }
}

const paperConfirm = () => {
  if (paperSelectData.value.length > 1) {
    feedback.msgError('只能选择一个试卷')
    return
  }
  apiTenantExamExaminationSavePaper({id: examination_id.value, paper_id: paperSelectData.value[0]}).then(res => {
    feedback.msgSuccess('绑定成功')
    dialogLibraryVisible.value = false
  })
}
/**
 * 试卷处理结束
 */

// 选中数据
const selectData = ref<any[]>([])

// 表格选择后回调事件
const handleSelectionChange = (val: any[]) => {
  selectData.value = val.map(({id}) => id)
}

// 获取字典数据
const {dictData} = useDictData('show_status,exam_privilege,exam_login_style,exam_submit_type,paper_rand')

// 分页相关
const {pager, getLists, resetParams, resetPage} = usePaging({
  fetchFun: apiTenantExamExaminationLists,
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
  await apiTenantExamExaminationDelete({id})
  getLists()
}

getLists()
</script>
