<template>
	<view class="page tn-safe-area-inset-bottom">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back' @click="goBack">
				<text class='icon tn-icon-left'></text>
				<text class='icon tn-icon-home-capsule-fill'></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">模拟考试历史</text>
			</view>
		</tn-nav-bar>
		<view :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<!-- 顶部搜索结束开始 -->
			<!-- <view class="search-box" :style="{top: vuex_custom_bar_height + 'px'}">
				<text class="tn-icon-menu fs-22" style="color: #8b9aae;" @click="show = true"></text>
				<view class="acea-row row-middle relative search-item">
					<input type="text" placeholder-class="tn-icon-search plaClass" placeholder="搜索点什么呢" class="input"
						v-model="queryParams.keywords" confirm-type="search" @confirm="search" />
					<view class="search-btn absolute" @click="search">搜索</view>
				</view>
			</view> -->
			<!-- 顶部搜索结束 -->
			<!-- <view v-if="filterData.length > 0" style="padding-top: 76rpx;">
				<ren-dropdown-filter :filterData='filterData' :defaultIndex='defaultIndex' @onSelected='onSelected'
					@dateChange='dateChange'></ren-dropdown-filter>
			</view> -->
			<view class="exam-ul">
				<block v-for="(it, index) in historyList" :key="index">
					<view class="tn-flex exam-li mt-10">
						<view class="txt tn-flex tn-flex-direction-column">
							<view class="fs-16 line2">{{it.question.title}}</view>
							<view class="acea-row row-middle">
								<view class="tn-color-gray">
									<text class="tn-icon-time"></text>
									<text class="ml-5">{{it.exam_submit_time}}</text>
								</view>
								<view class="tn-margin-left-sm">
									<text class="tn-icon-success-circle" :style="{color: mainColor, paddingRight: '8rpx'}"></text>
									<text >{{it.correct_count}}</text>
									<text class="tn-icon-close-circle tn-padding-left-sm tn-color-red" :style="{paddingRight: '8rpx'}"></text>
									<text >{{it.error_count}}</text>
								</view>
							</view>
						</view>
						<image :src="it.question.image" class="pic"></image>
					</view>
					<!-- <view class="tn-flex tn-bg-white exam-list-btn">
						<view style="width: 50%;"></view>
						<view style="width: 50%;" class="tn-flex tn-flex-row-right">
							<view @click="submitDetail(index)">
								<tn-button :backgroundColor="mainColor" size="sm" shape="round" fontColor="tn-color-white">答题结果</tn-button>
							</view>
							<view style="text-align: right;" @click="showDesc(index)">
								<tn-button backgroundColor="tn-bg-blue" size="sm" shape="round" fontColor="tn-color-white">图表统计</tn-button>
							</view>
						</view>
					</view> -->
				</block>
			</view>
			<!-- 题库列表为空开始 -->
			<view :style="{paddingTop: vuex_custom_bar_height * 2 + 'px'}" v-if="historyList.length === 0">
				<tn-empty mode="list" text="暂无答题历史"></tn-empty>
			</view>
			<!-- 题库列表为空结束 -->
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
				mainColor: getApp().globalData.mainColor,
				queryParams: {
					page_no: 1,
					page_size: 20,
					keywords: '',
					uid: '',
				},
				historyList: [],
			}
		},
		onLoad(option) {
			this.queryParams.uid = option.uid || ''
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: false,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
			this.fetchData()
		},
		methods: {
			// 搜索
			search() {
				this.queryParams.page_no = 1
				this.historyList = []
				this.fetchData()
			},
			// 跳转题库答题结果
			submitDetail(index) {
				this.$func.navigatorTo('/pages/history/analysis?uid=' + this.historyList[index].uid)
			},
			// 答题分析
			showDesc(index) {
				this.$func.navigatorTo('/pages/history/chart?uid=' + this.historyList[index].uid)
			},
			fetchData() {
				uni.showLoading({
					title: '努力加载中',
					icon: 'none'
				})
				this.$api.apiMockExaminationHistoryList(this.queryParams).then(res => {
					if (res.code === 1) {
						this.historyList.push(...res.data.lists)
						this.queryParams.page_no += 1
						return
					}
					this.$func.showToast(res.msg)
				}).finally(() => {
					uni.hideLoading()
				})
			},
		},
		onReachBottom() {
			this.fetchData()
		}
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

	.exam-ul {
		// padding-top: 70rpx;
		width: 98%;
		margin-left: 1%;

		.exam-li {
			background: #fff;
			border-radius: 10rpx;
			padding: 20rpx;
			height: 190rpx;
			position: relative;

			.txt {
				width: calc(100% - 200rpx);
				justify-content: space-between;
			}

			.pic {
				position: absolute;
				right: 10rpx;
				width: 190rpx;
				height: 150rpx;
				border-radius: 10rpx;
			}
		}

	}

	.fs-16 {
		font-size: 30rpx;
	}

	.exam-list-btn {
		width: 100%;
		height: 70rpx;
		line-height: 70rpx;
		border-top: 1rpx solid #f5f5f5;
		font-size: 30rpx;
	}
</style>