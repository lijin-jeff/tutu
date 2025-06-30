<template>
	<view class="container">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left' @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill' @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">试题收藏</text>
			</view>
		</tn-nav-bar>

		<!-- 题目区域 -->
		<view :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<swiper style="min-height: 100vh;" :current="swiperCurrentIndex" @change="swiperChange" :duration="0"
				:circular="true">
				<swiper-item v-for="(item, index) in swiperList" :key="index">
					<scroll-view scroll-y class="question-area">
						<!-- 题目头部信息 -->
						<view class="question-header tn-padding">
							<view class="progress-info" @click="showOptionCard = true">
								<text class="current-q">{{ questionListIndex + 1}}</text>
								<text class="total-q">/{{ questionList.length }}</text>
								<text class="answer-card-link fs-14">答题卡 ></text>
							</view>
							<view class="header-actions">
								<checkbox-group @change="showOnlyWrongChange">
									<label class="show-wrong-label">
										<checkbox value="show" :checked="showOnlyWrong" style="transform:scale(0.7)"
											:color="mainColor" />
										<text>{{ showOnlyWrong ? '背题模式' : '答题模式' }}</text>
									</label>
								</checkbox-group>
								<uni-icons type="star" size="24" color="#666" style="margin-left: 10px;"></uni-icons>
							</view>
						</view>

						<!-- 题目内容 -->
						<view class="question-content tn-padding-left tn-padding-right tn-padding-bottom">
							<!-- <view class="question-type-tag">{{ index + 1 }}、单选题</view> -->
							<mp-html :content="item.title" />
						</view>

						<!-- 选项 -->
						<view class="options-list tn-padding-left tn-padding-right tn-padding-bottom">
							<view v-for="(optionItem, optionIndex) in item.option" :key="optionIndex"
								:class="['option-item', optionItem.status]"
								@click="selectOption(index, optionIndex, item.exam_type_name)">
								<view class="tn-flex tn-flex-direction-row tn-flex-col-center tn-padding-sm">
									<view class="option-label">{{ optionItem.check + '、'}}</view>
									<view class="option-text">
										<mp-html :content="optionItem.title" />
									</view>
								</view>
							</view>
						</view>

						<!-- 答案与解析区域 -->
						<!-- <view class="answer-section">
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
						</view> -->
						<!-- 试题解析区域 -->
						<view class="answer-section">
							<text class="tn-icon-title section-title">解析</text>
							<view class="" v-if="showOnlyWrong === true || item.is_selected === true">
								<mp-html :content="item.analysis"></mp-html>
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
				<block v-for="(item, index) in questionList" :key="index">
					<view :key="index"
						:class="index === questionListIndex ? 'card-option-item-select' : 'card-option-item'"
						@click="examChange(index)">
						{{index + 1}}
					</view>
				</block>
			</view>
		</tn-popup>
		<!-- 答题卡结束 -->
		
		<!-- 移除收藏开始 -->
		<view class="remove-button" @click="removeCollection">
			移除收藏
		</view>
		<!-- 移除收藏结束 -->
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'questionOrder',
		mixins: [template_page_mixin],
		data() {
			return {
				showOptionCard: false, // 显示选项卡
				mainColor: getApp().globalData.mainColor,
				questionUid: '', // 查询题库uid
				showOnlyWrong: false,
				swiperList: [], // 渲染数组
				swiperCurrentIndex: 0, // 渲染数组序号
				questionList: [], // 全量数组
				questionListIndex: 0, // 全量数组序号
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
			this.questionUid = option.uid || ''
			this.fetchQuestionList()
		},
		methods: {
			// 移除试题收藏
			removeCollection() {
				this.$api.apiQuestionCollection({
					library_uid: this.questionUid,
					question_uid: this.swiperList[this.swiperCurrentIndex].uid,
					action: 2
				}).then(res => {
					this.$func.showToast(res.msg)
					if (res.code === 1) {
						// TODO 这里需要优化一下，动态移除对应的数据，而不是重新拉取
						this.fetchQuestionList()
					}
				})
			},
			// 处理数据渲染事件
			examChange(index) {
				this.showOptionCard = false
				this.questionListIndex = index
				this.upDateSwiperList()
			},
			//swiper改变时
			swiperChange(e) {
				let current = e.detail.current;
				if (
					this.swiperCurrentIndex - current == 2 ||
					this.swiperCurrentIndex - current == -1
				) {
					this.questionListIndex =
						this.questionListIndex + 1 == this.questionList.length ?
						0 :
						this.questionListIndex + 1;
					this.swiperCurrentIndex =
						this.swiperCurrentIndex + 1 == 3 ? 0 : this.swiperCurrentIndex + 1;
					this.upDateSwiperList();
				}
				else if (
					this.swiperCurrentIndex - current == -2 ||
					this.swiperCurrentIndex - current == 1
				) {
					this.questionListIndex =
						this.questionListIndex - 1 == -1 ?
						this.questionList.length - 1 :
						this.questionListIndex - 1;
					this.swiperCurrentIndex =
						this.swiperCurrentIndex - 1 == -1 ? 2 : this.swiperCurrentIndex - 1;
					this.upDateSwiperList();
				}
			},
			upDateSwiperList() {
				let displayList = []
				displayList[this.swiperCurrentIndex] = this.questionList[this.questionListIndex];
				displayList[this.swiperCurrentIndex - 1 == -1 ? 2 : this.swiperCurrentIndex - 1] =
					this.questionList[
						this.questionListIndex - 1 == -1 ?
						this.questionList.length - 1 :
						this.questionListIndex - 1
					];
				displayList[
						this.swiperCurrentIndex + 1 == 3 ? 0 : this.swiperCurrentIndex + 1
					] =
					this.questionList[
						this.questionListIndex + 1 == this.questionList.length ?
						0 :
						this.questionListIndex + 1
					];

				this.swiperList = displayList;
			},
			// 处理选项事件
			showOnlyWrongChange(e) {
				this.showOnlyWrong = (e.detail.value[0] === 'show' ? true : false)
				this.showOnlyWrong ? this.showOnlyWrongQeustion() : this.hideOnlyWrongQuestion()
			},
			showOnlyWrongQeustion() { // 背题模式处理
				this.questionList.forEach((item, index) => {
					item.is_selected = true
					item.status = 'correct'
					item.option.forEach((optionItem, optionIndex) => {
						if (item.answer.indexOf(optionItem.check) >= 0) {
							optionItem.is_selected = true
							optionItem.status = 'correct'
						} else {
							optionItem.is_selected = true
							optionItem.status = 'wrong'
						}
					})
				})
			},
			hideOnlyWrongQuestion() { // 答题模式处理
				this.questionList.forEach((item, index) => {
					item.is_selected = false
					item.status = 'default'
					item.option.forEach((optionItem, optionIndex) => {
						optionItem.is_selected = false
						optionItem.status = 'default'
					})
				})
			},
			selectOption(index, optionIndex, examType) {
				index = this.questionListIndex
				let selectCheck = this.questionList[index].option[optionIndex].check
				this.questionList[index].is_selected = true
				this.questionList[index].option[optionIndex].is_selected = true
				this.questionList.forEach((opt, i) => {
					// 这里一定要判断i === index的情况，否则循环处理时，有些试题的选项数量不一致
					if (i === index && opt.answer.indexOf(selectCheck) >= 0) {
						opt.status = 'correct'
						opt.option[optionIndex].status = 'correct'
					} else if (i === index && opt.answer.indexOf(selectCheck) < 0) {
						opt.status = 'wrong'
						opt.option[optionIndex].status = 'wrong'
					}
				})
			},
			fetchQuestionList() { // 拉取试题
				uni.showLoading({
					title: '试题努力加载中'
				})
				this.$api.apiQuestionCollectionList({
					uid: this.questionUid,
				}).then(res => {
					uni.hideLoading()
					if (res.code === 1) {
						this.questionList = res.data
						this.upDateSwiperList()
						return
					}
					this.$func.showToast(res.msg)
				})
			}
		}
	}
</script>

<style lang="scss">
	@import "@/scss/custom_nav_bar.scss";
	.remove-button {
		width: 100%; 
		position: fixed; 
		bottom: 0rpx; 
		height: 100rpx; 
		line-height: 100rpx;
		font-size: 32rpx;
		text-align: center;
		color: #fff;
		background-color: $view-theme;
	}
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
			// padding: 12px 15px;
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

			&.default {
				background-color: #fffefe; // 淡灰背景
				border-color: #eaeaea; // 灰色边框
				color: #C0C0C0; // 灰色文字

				.option-icon {
					//background-color: #C0C0C0; // 绿色图标背景
					border-radius: 50%;
					width: 20px;
					height: 20px;
					display: flex;
					justify-content: center;
					align-items: center;
					margin-right: 10px;
				}

				.option-text {
					// color: #C0C0C0;
				}
			}

			&.selected {
				// 假设有选中但未判断对错的状态
				border-color: #1890ff;
			}

			.option-label {
				// font-weight: bold;
				margin-right: 10rpx;
				color: #333;
				width: 20px; // 保持宽度一致
				text-align: center;
			}

			.option-text {
				font-size: 15px;
				flex: 1;
				// padding-left: 4rpx;
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