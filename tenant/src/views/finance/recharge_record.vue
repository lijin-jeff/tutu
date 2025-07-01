<template>
    <div>
        <el-card class="!border-none" shadow="never">
            <el-form ref="formRef" class="mb-[-16px] mt-[16px]" :model="queryParams" :inline="true">
                <el-form-item label="订单单号">
                    <el-input
                        class="w-[280px]"
                        v-model="queryParams.sn"
                        placeholder="请输入订单单号"
                        clearable
                        @keyup.enter="resetPage"
                    />
                </el-form-item>
                <el-form-item label="用户信息">
                    <el-input
                        class="w-[280px]"
                        v-model="queryParams.user_info"
                        placeholder="请输入用户账号/昵称/手机号"
                        clearable
                        @keyup.enter="resetPage"
                    />
                </el-form-item>
                <el-form-item label="订单类型" class="w-[280px]">
                    <el-select v-model="queryParams.pay_way">
                        <el-option label="全部" value />
                        <el-option label="余额充值" :value="1" />
                        <el-option label="购买试题" :value="2" />
                        <el-option label="购买课程" :value="3" />
                        <el-option label="商城购物" :value="4" />
                        <el-option label="会员充值" :value="5" />
                        <el-option label="资料购买" :value="6" />
                    </el-select>
                </el-form-item>
                <el-form-item label="订单终端" class="w-[280px]">
                  <el-select v-model="queryParams.order_terminal">
                    <el-option label="全部" value />
                    <el-option label="微信小程序" :value="1" />
                    <el-option label="微信公众号" :value="2" />
                    <el-option label="手机H5" :value="3" />
                    <el-option label="电脑PC" :value="4" />
                    <el-option label="苹果APP" :value="5" />
                    <el-option label="安卓APP" :value="6" />
                    <el-option label="其他" :value="0" />
                  </el-select>
                </el-form-item>
                <el-form-item label="支付状态" class="w-[280px]">
                    <el-select v-model="queryParams.pay_status">
                        <el-option label="全部" value />
                        <el-option label="未支付" :value="0" />
                        <el-option label="已支付" :value="1" />
                    </el-select>
                </el-form-item>
                <el-form-item label="退款状态" class="w-[280px]">
                  <el-select v-model="queryParams.refund_status">
                    <el-option label="全部" value />
                    <el-option label="未退款" :value="0" />
                    <el-option label="已退款" :value="1" />
                  </el-select>
                </el-form-item>
                <el-form-item label="下单时间">
                    <daterange-picker
                        v-model:startTime="queryParams.start_time"
                        v-model:endTime="queryParams.end_time"
                    />
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="resetPage">查询</el-button>
                    <el-button @click="resetParams">重置</el-button>
                    <export-data
                        class="ml-2.5"
                        :fetch-fun="rechargeLists"
                        :params="queryParams"
                        :page-size="pager.size"
                    />
                </el-form-item>
            </el-form>
        </el-card>
        <el-card class="!border-none mt-4" shadow="never">
            <el-table size="large" v-loading="pager.loading" :data="pager.lists">
                <el-table-column label="用户信息" min-width="160">
                    <template #default="{ row }">
                        <div class="items-center">
                            <image-contain
                                class="flex-none mr-2"
                                :src="row.avatar"
                                :width="40"
                                :height="40"
                                preview-teleported
                                fit="contain"
                            />
                            {{ row.nickname }}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="订单单号" prop="sn" min-width="190" />
                <el-table-column label="订单类型" prop="order_type_text" min-width="190" />
                <el-table-column label="商品名称" prop="order_title" min-width="190" />
                <el-table-column label="订单金额" prop="order_amount" min-width="100" />
                <el-table-column label="购买数量" prop="order_count" />
                <el-table-column label="支付方式" prop="pay_way_text" min-width="100" />
                <el-table-column label="支付终端" prop="order_terminal_text" min-width="100" />
                <el-table-column label="支付状态" prop="pay_status" min-width="100">
                    <template #default="{ row }">
                        <span
                            :class="{
                                'text-error': row.pay_status === 0
                            }"
                        >
                            {{ row.pay_status_text }}
                        </span>
                    </template>
                </el-table-column>
                <el-table-column label="退款状态" prop="refund_status" min-width="100">
                  <template #default="{ row }">
                          <span
                              :class="{
                                  'text-error': row.refund_status === 0
                              }"
                          >
                              {{ row.refund_status_text }}
                          </span>
                  </template>
                </el-table-column>
                <el-table-column label="提交时间" prop="create_time" min-width="180" />
                <el-table-column label="支付时间" prop="pay_time" min-width="180" />
                <el-table-column label="操作" width="120" fixed="right">
                    <template #default="{ row }">
                        <el-button
                            v-if="row.pay_status == 1"
                            v-perms="['recharge.recharge/refund']"
                            type="primary"
                            link
                            :disabled="row.refund_status == 1"
                            @click="handleRefund(row.id)"
                        >
                            退款
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
            <div class="flex justify-end mt-4">
                <pagination v-model="pager" @change="getLists" />
            </div>
        </el-card>
    </div>
</template>
<script lang="ts" setup name="rechargeRecord">
import { rechargeLists, refund } from '@/api/finance'
import { usePaging } from '@/hooks/usePaging'
import feedback from '@/utils/feedback'

const queryParams = reactive({
    sn: '',
    user_info: '',
    pay_way: '',
    pay_status: '',
    refund_status: '',
    start_time: '',
    end_time: '',
    order_type: '',
    order_terminal: ''
})

const { pager, getLists, resetPage, resetParams } = usePaging({
    fetchFun: rechargeLists,
    params: queryParams
})
const handleRefund = async (id: number) => {
    await feedback.confirm('确认退款？')
    await refund({
        recharge_id: id
    })
    getLists()
}

getLists()
</script>
