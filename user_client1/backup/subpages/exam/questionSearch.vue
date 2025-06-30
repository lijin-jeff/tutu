<template>
	<view class="page tn-safe-area-inset-bottom">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">试题搜索</text>
			</view>
		</tn-nav-bar>
		<view :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<!-- 顶部搜索结束开始 -->
			<view class="search-box" :style="{top: vuex_custom_bar_height + 'px'}">
				<text class="tn-icon-menu fs-22" style="color: #8b9aae;" @click="show = true"></text>
				<view class="acea-row row-middle relative search-item">
					<input type="text" placeholder-class="tn-icon-search plaClass" placeholder="搜索点什么呢" class="input"
						v-model="queryParams.keywords" confirm-type="search" @confirm="search" />
					<view class="search-btn absolute" @click="search">搜索</view>
				</view>
			</view>
			<!-- 顶部搜索结束 -->

			<!-- 试题列表开始 -->
			<view class="tt-exam-container">
				<view class="">
					<block v-for="(item, index) in historyList">
						<view class="tn-margin-bottom-sm tn-padding tn-bg-white">
							<view class="tn-border-solids-bottom">
								<view class="tt-exam-title tn-text-bold tn-margin-bottom">
									{{ item.type == 1 ? "[单选题] " : (item.type == 2 ? "[判断题] " : "[判断题] ") }}{{ (index + 1) + `、` + item.title + `(` + item.score + `分)` }}
								</view>
								<block v-if="item.second_title != ''">
									<view class="tn-margin-bottom-sm"><mp-html :content="item.second_title" /></view>
								</block>
								<view class="tt-exam-option tn-margin-bottom">
									<block v-for="(v, k) in item.option">
										<view class="tt-option" :key="k">
											{{ v.check + `、` + v.title }}
										</view>
										<!-- <view class="tt-option" :key="index" v-if="item.type == 1">
													{{ v.check + `、` + v.title }}
												</view> -->
										<!-- 	<view class="tt-option" :key="index" v-else-if="item.type == 2">
													{{ v.option + `、` + v.title }}
												</view> -->
									</block>
								</view>
							</view>
							<view class="tn-padding-top-sm tn-padding-bottom">
								<view class="tt-answer">
									<view class="tt-margin-right">试题答案：<text
											class="tn-color-green">{{ item.option_answer }}</text></view>
								</view>
							</view>

							<view class="tn-padding-bottom">
								<view class="tt-answer">
									<view>试题解析：</view>
									<view class="tn-color-blue" @click="analysisPop(1, item)">查看解析</view>
								</view>
							</view>
							<view class="tn-padding-bottom">
								<view class="tt-answer">
									<view>试题反馈：</view>
									<view class="tn-color-blue" @click="showExamFeekFn(item)">反馈错误</view>
								</view>
							</view>
						</view>
					</block>
				</view>
			</view>
			<!-- 试题列表结束 -->

			<!-- Ai解析开始 -->
			<analysis :content="examAnsy" :showTitle="showAnalysisTitle" :showPop="showAi" @close="closeAiAnalysisPop">
			</analysis>
			<!-- ai解析结束 -->

			<!-- 试题反馈开始 -->
			<tn-popup v-model="showExamFeek" mode="center" width="90%" height="550" closeIconSize="60" :closeBtn="false"
				borderRadius="6" @close="closeExamAnsys">
				<view class="tn-padding">
					<tn-input type="textarea" maxLength="2000" border="true" :borderColor="mainColor" height="400"
						placeholder="感谢你为该试题提供试题反馈,反馈采纳之后会获取一定的积分奖励哦..." />
					<view class="tn-margin-top">
						<tn-button :backgroundColor="mainColor" width="100%" fontColor="tn-color-white">提 交 反
							馈</tn-button>
					</view>
				</view>
			</tn-popup>
			<!-- 试题反馈结束 -->

			<!-- 添加笔记开始 -->
			<tn-popup v-model="showExamNote" mode="center" width="90%" height="550" closeIconSize="60" :closeBtn="false"
				borderRadius="6" @close="closeExamNote">
				<view class="tn-padding">
					<tn-input type="textarea" maxLength="2000" border="true" :borderColor="mainColor" height="400"
						placeholder="添加一点笔记,方便复习使用..." />
					<view class="tn-margin-top">
						<tn-button :backgroundColor="mainColor" width="100%" fontColor="tn-color-white">添 加 笔
							记</tn-button>
					</view>
				</view>
			</tn-popup>
			<!-- 添加笔记结束 -->
			<view class="tn-tabbar-height"></view>
		</view>
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'Exam',
		mixins: [template_page_mixin],
		components: {},
		data() {
			return {
				showExamFeek: false,
				mainColor: getApp().globalData.mainColor,
				queryParams: {
					page: 1,
					size: 20,
					keywords: '',
					category_uid: '',
					level: '',
					free_state: '',
					year: '',
					collection_uid: '',
				},
				historyList: [],
			}
		},
		onLoad(option) {
			this.queryParams.collection_uid = option.collection_uid || ''
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: false,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
			this.fetchExam()
		},
		methods: {
			showExamFeekFn() {
				this.showExamFeek = true
			},
			fetchExam() {
				for (let index = 0; index < 100; index++) {
					this.historyList.push({
						type: 1,
						score: '2.0',
						title: '关于下面的说话正确的是?',
						option: [{
							check: 'A',
							title: '正确',
						}, {
							check: 'B',
							title: '错误',
						}],
						option_answer: 'A'
					})
				}
			}
		},
	}
</script>

<style scoped lang="scss">
	@import "@/scss/custom_nav_bar.scss";

	/deep/ .plaClass {
		color: #999;
		text-align: start;
	}

	.search-box {
		// top: 0;
		left: 0;
		position: fixed;
		z-index: 2;
		width: 100vw;
		background: #fff;
		padding: 10rpx;
		display: flex;
		align-items: center;

		.search-item {
			width: 100%;

			.input {
				width: 100% !important;
				padding-left: 30rpx;
				padding-right: 150rpx;
				margin-left: 10rpx;
				height: 60rpx;
				background: #f4f4f4;
				border-radius: 40rpx;
			}

			.search-btn {
				width: 100rpx;
				height: 50rpx;
				line-height: 50rpx;
				text-align: center;
				right: 10rpx;
				font-size: 12px;
				background: $view-theme;
				color: #fff;
				border-radius: 50rpx;
			}
		}

	}

	.tt-exam-container {
		padding-top: 38px;
		background-color: #F2F0F0;
	}

	.tt-exam-title {
		line-height: 40rpx;
	}

	.tt-option {
		line-height: 50rpx;
	}

	.tt-answer {
		display: flex;
	}

	.tt-color-orangey {
		color: #FFA62D;
	}

	.selected-ration {
		color: $view-theme;
	}

	.tt-margin-right {
		margin-right: 30rpx;
	}

	/* 底部安全边距 start*/
	.tn-tabbar-height {
		min-height: 30rpx;
		height: calc(40rpx + env(safe-area-inset-bottom) / 2);
		height: calc(40rpx + constant(safe-area-inset-bottom));
	}
</style>