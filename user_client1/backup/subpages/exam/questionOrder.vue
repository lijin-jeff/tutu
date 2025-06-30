<template>
	<view class="container">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">顺序练习</text>
			</view>
		</tn-nav-bar>

		<!-- 题目区域 -->
		<view :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<swiper style="min-height: 100vh;" :current="currentExamIndex" @change="swiperChange" :duration="0">
				<swiper-item v-for="(item, index) in 100" :key="index">
					<scroll-view scroll-y class="question-area">
						<!-- 题目头部信息 -->
						<view class="question-header tn-padding">
							<view class="progress-info" @click="showOptionCard = true">
								<text class="current-q">{{currentExamIndex + 1}}</text>
								<text class="total-q">/100</text>
								<text class="answer-card-link fs-14">答题卡 ></text>
							</view>
							<view class="header-actions">
								<radio-group @change="showOnlyWrongChange">
									<label class="show-wrong-label">
										<radio value="showWrong" :checked="showOnlyWrong" style="transform:scale(0.7)"  :color="mainColor"/>
										<text>背题模式</text>
									</label>
								</radio-group>
								<uni-icons type="star" size="24" color="#666" style="margin-left: 10px;"></uni-icons>
							</view>
						</view>

						<!-- 题目内容 -->
						<view class="question-content tn-padding-left tn-padding-right tn-padding-bottom">
							<!-- <view class="question-type-tag">{{ index + 1 }}、单选题</view> -->
							<text class="question-text">高墩施工前应编制测量控制方案，施工过程中应对墩身的（）进行监控</text>
						</view>

						<!-- 选项 -->
						<view class="options-list tn-padding">
							<view v-for="(option, index) in options" :key="index"
								:class="['option-item', option.status]" @click="selectOption(index)">
								<view class="option-icon" v-if="option.status === 'correct'">
									<view class="tn-icon-success fs-18 tn-color-white"></view>
								</view>
								<view class="option-icon" v-if="option.status === 'wrong'">
									<view class="tn-icon-close fs-18 tn-color-white"></view>
								</view>
								<text class="option-label"
									v-if="option.status !== 'correct' && option.status !== 'wrong'">{{ option.label }}</text>
								<text class="option-text">{{ option.text }}</text>
							</view>
						</view>

						<!-- 答案与解析区域 -->
						<view class="answer-section">
							<text class="tn-icon-title section-title">答案</text>
							<view class="answer-details">
								<text>正确答案: <text class="correct-answer-label">A</text></text>
								<text>我的答案: <text class="my-answer-label">B</text></text>
							</view>
							<view class="stats-grid">
								<view class="stat-item">
									<text class="stat-label">作答人数</text>
									<text class="stat-value">211</text>
								</view>
								<view class="stat-item">
									<text class="stat-label">全站正确率</text>
									<text class="stat-value">85%</text>
								</view>
								<view class="stat-item">
									<text class="stat-label">易错项</text>
									<text class="stat-value">D</text>
								</view>
							</view>
						</view>
						<!-- 试题解析区域 -->
						<view class="answer-section">
							<text class="tn-icon-title section-title">解析</text>
							<view class="">
								<mp-html content="这里存放试题解析"></mp-html>
							</view>
						</view>
					</scroll-view>
				</swiper-item>
			</swiper>
		</view>

		<!-- 答题卡开始 -->
		<tn-popup zIndex="99999" v-model="showOptionCard" mode="bottom" height="50%" :safeAreaInsetBottom="true"
			:borderRadius="30">
			<view class="card-options">
				<block v-for="(item, index) in 100" :key="index">
					<view :key="index" :class="index === currentExamIndex ? 'card-option-item-select' : 'card-option-item'"
						@click="examChange(index)">
						{{index + 1}}
					</view>
				</block>
			</view>
		</tn-popup>
		<!-- 答题卡结束 -->
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'questionOrder',
		mixins: [template_page_mixin],
		data() {
			return {
				showOptionCard: false,
				mainColor: getApp().globalData.mainColor,
				showOnlyWrong: false,
				currentExamIndex: 0,
				options: [{
						label: 'A',
						text: '标高',
						status: 'correct'
					},
					{
						label: 'B',
						text: '平面位置',
						status: 'wrong'
					},
					{
						label: 'C',
						text: '垂直度',
						status: 'default'
					},
					{
						label: 'D',
						text: '强度',
						status: 'default'
					},
				],
				selectedOptionIndex: 1, // 假设用户选了B
				correctOptionIndex: 0, // 正确答案是A
			};
		},
		methods: {
			examChange(index) {
				this.currentExamIndex = index
				this.showOptionCard = false
			},
			swiperChange(event) {
				this.currentExamIndex = event.detail.current
			},
			goBack() {
				uni.navigateBack();
			},
			showOnlyWrongChange(e) {
				this.showOnlyWrong = e.detail.value.includes('showWrong');
				console.log('只看错题:', this.showOnlyWrong);
			},
			selectOption(index) {
				// 实际应用中，这里会提交答案并获取结果，然后更新options的status
				console.log('选择了选项:', this.options[index].label);
				// 模拟选择后的状态更新 (这里仅作演示，实际逻辑会更复杂)
				this.options.forEach((opt, i) => {
					if (i === this.correctOptionIndex) {
						opt.status = 'correct';
					} else if (i === index && index !== this.correctOptionIndex) {
						opt.status = 'wrong';
					} else {
						opt.status = 'default'; // 或者 'disabled' 如果不允许重选
					}
				});
				this.selectedOptionIndex = index;
			}
		}
	}
</script>

<style lang="scss">
	@import "@/scss/custom_nav_bar.scss";

	/* 选项卡开始 */
	.card-options {
		display: flex;
		flex-wrap: wrap;
		padding: 20rpx;
		padding-bottom: 10rpx;
		justify-content: flex-start;
	}

	.card-option-item {
		display: grid;
		place-items: center;
		width: 80rpx;
		height: 80rpx;
		border-radius: 50%;
		background-color: #EFF5F6;
		margin: 10rpx;
		color: #080808;
	}

	.card-option-item-select {
		display: grid;
		place-items: center;
		width: 80rpx;
		height: 80rpx;
		border-radius: 50%;
		background-color: $view-theme;
		margin: 10rpx;
		color: #ffffff;
	}

	/* 选项卡结束 */

	.container {
		display: flex;
		flex-direction: column;
		height: 100%;
		background-color: #f0f2f5;
		/* 页面背景色 */
	}

	.question-area {
		flex: 1;
		overflow-y: auto;
		padding: 6rpx;
	}

	.question-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		// margin-bottom: 15px;
		font-size: 14px;
		color: #666;
		background-color: #fff;

		.progress-info {
			display: flex;
			align-items: baseline;
		}

		.current-q {
			font-size: 18px;
			font-weight: bold;
			color: #333;
		}

		.total-q {
			margin-left: 2px;
		}

		.answer-card-link {
			margin-left: 10px;
			color: #007aff; // 主题蓝色
		}

		.header-actions {
			display: flex;
			align-items: center;
		}

		.show-wrong-label {
			display: flex;
			align-items: center;
			font-size: 13px;
			color: #333;
		}
	}

	.question-content {
		background-color: #fff;

		.question-type-tag {
			display: inline-block;
			background-color: #e6f7ff;
			color: #1890ff;
			padding: 2px 6px;
			font-size: 11px;
			border-radius: 3px;
			margin-right: 8px;
			margin-bottom: 10px;
		}

		.question-text {
			font-size: 16px;
			line-height: 1.6;
			color: #333;
			display: block; // 使标签和文本分开
		}
	}

	.options-list {
		background-color: #fff;

		.option-item {
			background-color: #fff;
			padding: 12px 15px;
			border-radius: 8px;
			margin-bottom: 10px;
			display: flex;
			align-items: center;
			border: 1px solid #fff; // 默认边框
			transition: all 0.2s ease;

			&.correct {
				background-color: #f6ffed; // 淡绿色
				border-color: #b7eb8f; // 绿色边框
				color: #52c41a; // 绿色文字

				.option-icon {
					background-color: #52c41a; // 绿色图标背景
					border-radius: 50%;
					width: 20px;
					height: 20px;
					display: flex;
					justify-content: center;
					align-items: center;
					margin-right: 10px;
				}

				.option-text {
					color: #52c41a;
				}
			}

			&.wrong {
				background-color: #fff1f0; // 淡红色
				border-color: #ffa39e; // 红色边框
				color: #f5222d; // 红色文字

				.option-icon {
					background-color: #f5222d; // 红色图标背景
					border-radius: 50%;
					width: 20px;
					height: 20px;
					display: flex;
					justify-content: center;
					align-items: center;
					margin-right: 10px;
				}

				.option-text {
					color: #f5222d;
				}
			}

			&.selected {
				// 假设有选中但未判断对错的状态
				border-color: #1890ff;
			}

			.option-label {
				font-weight: bold;
				margin-right: 10px;
				color: #666;
				width: 20px; // 保持宽度一致
				text-align: center;
			}

			.option-text {
				font-size: 15px;
				flex: 1;
				line-height: 1.5;
				color: #333; // 默认文字颜色
			}
		}
	}

	.answer-section {
		background-color: #fff;
		padding: 15px;
		border-radius: 0rpx;
		margin-top: 20rpx;

		.section-title {
			font-size: 16px;
			font-weight: bold;
			margin-bottom: 10px;
			display: block;
			text-align: left;
			color: $view-theme;
		}

		.answer-details {
			display: flex;
			justify-content: space-between;
			font-size: 14px;
			color: #666;
			margin-bottom: 15px;
			padding-bottom: 15px;
			border-bottom: 1px solid #f0f0f0;

			.correct-answer-label {
				color: #52c41a; // 绿色
				font-weight: bold;
				margin-left: 5px;
			}

			.my-answer-label {
				color: #faad14; // 橙色
				font-weight: bold;
				margin-left: 5px;
			}
		}

		.stats-grid {
			display: flex;
			justify-content: space-between;
			text-align: center;
		}

		.stat-item {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		.stat-label {
			font-size: 12px;
			color: #999;
			margin-bottom: 5px;
		}

		.stat-value {
			font-size: 16px;
			color: #333;
			font-weight: bold;
		}
	}
</style>