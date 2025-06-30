<template>
	<view class="container">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left' @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill' @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">模拟考试</text>
			</view>
		</tn-nav-bar>

		<!-- 主体内容 -->
		<scroll-view scroll-y class="main-content" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<!-- 题型设置 -->
			<view class="section question-type-section">
				<view class="header-row">
					<text class="header-cell type-header">题型 (题数)</text>
					<text class="header-cell count-header">题数</text>
					<text class="header-cell score-header">分值</text>
				</view>
				<view class="data-row" v-for="(item, index) in questionTypes" :key="index">
					<text class="data-cell type-cell">{{ item.name }} ({{ item.exam_count }})</text>
					<view class="data-cell count-cell">
						<input type="number" v-model="item.count" @input="calculateScore" class="input-field" />
					</view>
					<view class="data-cell score-cell">
						<input type="number" v-model="item.score" @input="calculateScore" class="input-field" />
					</view>
				</view>
				<view class="summary-row">
					<text>总题数 <text class="highlight">{{ totalCount }}</text> 题</text>
					<text>共 <text class="highlight">{{ totalScore.toFixed(2) }}</text> 分</text>
				</view>
			</view>

			<!-- 考试设置 -->
			<view class="section settings-section">
				<view class="setting-item arrow">
					<text class="label">考试时长</text>
					<view class="value-section" @click="showDuration">
						<text class="value">{{ examDuration }} 分钟</text>
						<text class="arrow-icon tn-icon-right"></text>
					</view>
				</view>
				<view class="setting-item">
					<text class="label">及格分</text>
					<view class="value-section">
						<input type="number" v-model="passScore" class="input-field score-input" />
						<text class="unit">分</text>
					</view>
				</view>
				<view class="setting-item">
					<text class="label">答题后显示答案</text>
					<switch :checked="showAnswerAfter" @change="onSwitchChange('showAnswerAfter', $event)"
						:color="mainColor" style="transform:scale(0.8)" />
				</view>
				<view class="setting-item arrow">
					<text class="label">多选题得分模式</text>
					<view class="value-section" @click="showMoreCount">
						<text class="value">{{ moreSwitchRange[examMoreSwitch] }}</text>
						<text class="arrow-icon tn-icon-right"></text>
					</view>
				</view>
				<view class="setting-item">
					<view class="label-group">
						<text class="label">选项乱序</text>
						<!-- <text class="vip-tag">VIP</text> -->
						<!-- <text class="description">选项随机排列，避免背答案</text> -->
					</view>
					<switch :checked="shuffleOptions" @change="onSwitchChange('shuffleOptions', $event)" :color="mainColor"
						style="transform:scale(0.8)" />
				</view>
				<!-- <view class="setting-item">
					<view class="label-group">
						<text class="label">错题优先</text>
						<text class="vip-tag">VIP</text>
					</view>
					<switch :checked="priorityWrong" @change="onSwitchChange('priorityWrong', $event)" :color="mainColor"
						style="transform:scale(0.8)" />
				</view>
				<view class="setting-item">
					<view class="label-group">
						<text class="label">未做题优先</text>
						<text class="vip-tag">VIP</text>
					</view>
					<switch :checked="priorityUnattempted" @change="onSwitchChange('priorityUnattempted', $event)"
						:color="mainColor" style="transform:scale(0.8)" />
				</view> -->
			</view>

			<!-- 规则说明 -->
			<view class="rule-description">
				<view>出题规则说明：</view>
				<view>1. 试题题数说明：相同类型的试题，题数不能超过该类型下的总题数。</view>
				<view>2. 开启选项乱序：开启选项乱序，返回的试题，顺序将被随机打乱。</view>
			</view>

			<view class="tn-padding-xl"></view>
		</scroll-view>

		<!-- 底部操作栏 -->
		<view class="bottom-bar">
			<view class="history-link" @click="switchHistory">
				<text class="history-icon tn-icon-time"></text>
				<text>历史记录</text>
			</view>
			<button class="start-button" type="primary" @click="submitConfig">开始考试</button>
		</view>
		
		<!-- 考试时长设置 -->
		<tn-picker mode="selector" v-model="showDurationPicker" :defaultSelector="[0]" :range="numberRange"
			:confirmColor="mainColor" confirmText="确认时长" @confirm="randCountConfirm"></tn-picker>
		<!-- 考试时长结束 -->
		
		
		<!-- 多选题积分模式设置 -->
		<tn-picker mode="selector" v-model="showMoreSwitchPicker" :defaultSelector="[0]" :range="moreSwitchRange"
			:confirmColor="mainColor" confirmText="确认时长" @confirm="moreCountConfirm"></tn-picker>
		<!-- 多选题积分模式设置 -->
		
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'questionMnSetting',
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				questionTypes: [],
				totalCount: 0, // 总题数
				totalScore: 0, // 总分数
				numberRange: [10, 20, 30, 40, 50, 60],// 考试时长选择
				examDuration: 40,// 考试时长
				showDurationPicker: false,// 考试时长选择开关
				moreSwitchRange: ['全部答对，才算得分', '答对一个，也算得分'],// 多选题积分模式选择
				examMoreSwitch: 0,// 多选题积分模式
				showMoreSwitchPicker: false,// 多选题积分模式开关
				passScore: 45.0,
				showAnswerAfter: true,
				shuffleOptions: true,
				priorityWrong: false,
				priorityUnattempted: false,
				questionLibUid: '',
			}
		},
		onLoad(option) {
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: false,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
			this.questionLibUid = option.uid || ''
			this.fetchQuestionType()
		},
		methods: {
			showDuration() {// 考试时长选择
				this.showDurationPicker = true
			},
			randCountConfirm(e) {// 考试时长确认
				this.examDuration = this.numberRange[e[0]]
				this.showDurationPicker = false
			},
			showMoreCount() {// 多选题模式选择
				this.showMoreSwitchPicker = true
			},
			moreCountConfirm(e) {// 多选题模式确认
				this.examMoreSwitch = e[0]
				this.showMoreSwitchPicker = false
			},
			calculateScore() {// 根据题型动态计算总分
				let scoreSum = 0
				let questionCount = 0
				this.questionTypes.forEach((value, index) => {
					questionCount += parseInt(value.count)
					scoreSum += parseInt(value.score) * parseInt(value.count)
				})
				this.totalScore = scoreSum
				this.totalCount = questionCount
			},
			submitConfig() {// 开始考试
				this.$api.apiMockExaminationConfig({
					score: this.passScore,
					option_type_config: JSON.stringify(this.questionTypes),
					exam_time: this.examDuration,
					checkbox_type: this.examMoreSwitch === 1 ? 2 : 1,
					option_type: this.shuffleOptions ? 1 : 2,
					question_uid: this.questionLibUid
				}).then(res => {
					if (res.code === 1) {
						this.$func.navigatorTo('/subpages/exam/questionMock?uid=' + res.data.history_uid)
						return
					}
					this.$func.showToast(res.msg)
				})
			},
			switchHistory() {
				this.$func.navigatorTo('/subpages/exam/questionMockHistory?uid=' + this.questionLibUid)
			},
			onSwitchChange(key, event) {
				this[key] = event.detail.value;
			},
			fetchQuestionType() {
				this.$api.apiQuestionTypeList({
					uid: this.questionLibUid
				}).then(res => {
					this.questionTypes = res.data.exam_type_list
					this.questionTypes.forEach((value, index) => {
						value.score = 1
						value.count = 1
					})
					this.calculateScore()
				})
			},
		}
	}
</script>

<style scoped lang="scss">
	@import "@/scss/custom_nav_bar.scss";

	.container {
		display: flex;
		flex-direction: column;
		height: 100vh;
		background-color: #f8f8f8;
		font-size: 28rpx;
	}

	.main-content {
		flex-grow: 1;
		/* 占据剩余空间 */
		padding-bottom: 140rpx;
		/* 为底部按钮留出空间 */
		box-sizing: border-box;
	}

	.section {
		background-color: #fff;
		margin: 20rpx;
		border-radius: 16rpx;
		padding: 0 30rpx;
	}

	/* 题型设置 */
	.question-type-section {
		padding-top: 20rpx;
		padding-bottom: 10rpx;
	}

	.header-row,
	.data-row {
		display: flex;
		align-items: center;
		padding: 15rpx 0;
		color: #666;
	}

	.header-row {
		color: #999;
		font-size: 26rpx;
		padding-bottom: 10rpx;
	}

	.data-row {
		border-bottom: 1rpx solid #f0f0f0;

		&:last-child {
			border-bottom: none;
		}
	}

	.header-cell,
	.data-cell {
		text-align: center;
	}

	.type-header,
	.type-cell {
		width: 40%;
		text-align: left;
	}

	.count-header,
	.count-cell {
		width: 30%;
	}

	.score-header,
	.score-cell {
		width: 30%;
	}

	.type-cell {
		color: #333;
		font-size: 30rpx;
	}

	.input-field {
		background-color: #f7f7f7;
		border-radius: 8rpx;
		// padding: 8rpx 15rpx;
		font-size: 28rpx;
		text-align: center;
		width: 100rpx;
		/* 根据需要调整宽度 */
		box-sizing: border-box;
		display: inline-block;
		/* 使其可以居中 */
	}

	.score-input {
		width: 120rpx;
	}

	.summary-row {
		display: flex;
		justify-content: space-between;
		padding: 25rpx 0;
		margin-top: 10rpx;
		font-size: 28rpx;
		color: #333;
		border-top: 1rpx solid #f0f0f0;
	}

	.highlight {
		color: $view-theme;
		font-weight: bold;
		margin: 0 5rpx;
	}

	/* 考试设置 */
	.settings-section {
		padding: 0;
		/* section自带左右padding */
	}

	.setting-item {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 30rpx;
		border-bottom: 1rpx solid #f0f0f0;

		&:last-child {
			border-bottom: none;
		}
	}

	.label {
		color: #333;
		font-size: 30rpx;
	}

	.label-group {
		display: flex;
		flex-direction: row;
		align-items: flex-start;

		/* 左对齐 */
		.label {
			margin-bottom: 5rpx;
		}

		.description {
			font-size: 24rpx;
			color: #999;
		}
	}

	.vip-tag {
		background-color: #FFF0E6;
		/* 橙色背景 */
		color: #FF9900;
		/* 橙色文字 */
		font-size: 20rpx;
		padding: 2rpx 8rpx;
		border-radius: 4rpx;
		margin-left: 10rpx;
		display: inline-block;
		/* 使其可以和文字同行 */
		vertical-align: middle;
		/* 垂直居中 */
		margin-bottom: 5rpx;
		/* 与下方描述文字的间距 */
	}

	.label-group .label+.vip-tag {
		margin-left: 10rpx;
		/* VIP 标签与主标签的间距 */
	}


	.value-section {
		display: flex;
		align-items: center;
		color: #666;
	}

	.value {
		margin-right: 10rpx;
	}

	.arrow-icon {
		font-size: 30rpx;
		color: #ccc;
	}

	.unit {
		margin-left: 10rpx;
		color: #666;
	}

	/* 规则说明 */
	.rule-description {
		padding: 20rpx 30rpx;
		font-size: 24rpx;
		color: #999;
		line-height: 1.6;
		background-color: #f8f8f8;
		/* 与页面背景色一致 */
	}

	/* 底部操作栏 */
	.bottom-bar {
		position: fixed;
		bottom: 0;
		left: 0;
		right: 0;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 20rpx 30rpx;
		padding-bottom: calc(20rpx + constant(safe-area-inset-bottom));
		/* 适配 iPhone X 等底部安全区 */
		padding-bottom: calc(20rpx + env(safe-area-inset-bottom));
		background-color: #fff;
		border-top: 1rpx solid #eee;
		z-index: 10;
	}

	.history-link {
		display: flex;
		flex-direction: column;
		align-items: center;
		font-size: 22rpx;
		color: #666;
	}

	.history-icon {
		font-size: 40rpx;
		margin-bottom: 5rpx;
	}

	.start-button {
		flex-grow: 1;
		margin-left: 30rpx;
		height: 80rpx;
		line-height: 80rpx;
		font-size: 32rpx;
		background-color: $view-theme;
		border-radius: 40rpx;
	}
</style>