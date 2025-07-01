<template>
    <div class="">
        <el-form-item label="试题类型">
            <el-radio-group
                placeholder="请选择"
                v-model="examOptionType"
                @change="examOptionTypeChange"
            >
                <el-radio
                    v-for="(item, index) in dictData.exam_level"
                    :key="index"
                    :value="parseInt(item.value)"
                    :label="parseInt(item.value)"
                >
                    {{ item.name }}
                </el-radio>
            </el-radio-group>
        </el-form-item>
        <div style="margin-top: 20px">
            <RadioOption v-if="examOptionType === 1" :library-uid="library_uid" />
            <CheckBoxOption v-else-if="examOptionType === 2" :library-uid="library_uid" />
            <JudeOption v-else-if="examOptionType === 3" :library-uid="library_uid" />
            <WriteOption v-else-if="examOptionType === 4" />
            <QuestionOption v-else-if="examOptionType === 5" />
            <CompoundOption v-else-if="examOptionType === 6" />
            <ClozeOption v-else-if="examOptionType === 7" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { useDictData } from '@/hooks/useDictOptions'

import CheckBoxOption from './CheckBoxOption.vue'
import ClozeOption from './ClozeOption.vue'
import CompoundOption from './CompoundOption.vue'
import JudeOption from './JudeOption.vue'
import QuestionOption from './QuestionOption.vue'
import RadioOption from './RadioOption.vue'
import WriteOption from './WriteOption.vue'

const route = useRoute()

interface Props {
    libraryUid: string
}

const props = defineProps<Props>()
const examOptionType = ref(1)
const library_uid = ref(route.query.library_uid)

const { dictData } = useDictData('exam_level')
const examOptionTypeChange = (val: number) => {
    examOptionType.value = val
}
</script>

<style scoped>
.child-component {
    border: 1px solid #eee;
    padding: 20px;
    margin: 10px;
}

.tip-head-title {
    font-size: 30px;
}
</style>
