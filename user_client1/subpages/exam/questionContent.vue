<template>
	<view class="container">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left' @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill' @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">在线题库</text>
			</view>
		</tn-nav-bar>

		<!-- Banner -->
		<view class="banner" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<tn-swiper :list="bannerList" :radius="0"></tn-swiper>
		</view>

		<!-- 题库信息 -->
		<view class="info-section">
			<view class="title-row">
				<text class="main-title">{{questionContent.title}}</text>
				<uni-icons type="bars" size="24" color="#666"></uni-icons>
			</view>
			<view class="user-info">
				<image class="avatar" src="/static/image/defalut_logo.png"></image>
				<view class="user-details" @click="tl('/subpages/common/serviceQrCode')">
					<view class="user-id">wx_06282</view>
					<view class="meta-info">
						<text>{{ questionContent.create_time }}</text>
						<text class="separator">|</text>
						<text>{{questionContent.question_count}}题</text>
						<text class="separator">|</text>
						<text>来源 {{questionContent.author}}</text>
					</view>
				</view>
			</view>
			<view class="action-buttons">
				<view class="action-item" @click="tl('/subpages/exam/questionError?uid=' + questionUid)">
					<view class="tn-icon-close-circle action-item-icon fs-24 tn-padding-bottom-sm"></view>
					<view>我的错题</view>
				</view>
				<view class="action-item" @click="tl('/subpages/exam/questionCollection?uid=' + questionUid)">
					<view class="tn-icon-star fs-24 tn-padding-bottom-sm"></view>
					<view>我的收藏</view>
				</view>
				<view class="action-item">
					<view class="tn-icon-share-square fs-24 tn-padding-bottom-sm"></view>
					<tn-button backgroundColor="#fff" fontSize="24" height="0" padding="0rpx 0rpx" openType="share" fontColor="#686868">
						分享题库
					</tn-button>
				</view>
			</view>
		</view>

		<!-- 题库练习 -->
		<view class="practice-section">
			<text class="section-title">功能总览</text>
			<view class="grid">
				<view class="grid-item tn-margin-bottom-sm" v-for="(item, index) in practiceItems" :key="index"
					@click="handleGridItemClick(item)">
					<view>
						<view class="grid-title">{{ item.title }}</view>
						<view class="grid-desc">{{ item.desc }}</view>
					</view>
					<view class="grid-icon-wrapper">
						<view :class="'tn-icon-' + item.icon" :style="{color: item.iconColor, fontSize: 56 + 'rpx'}">
						</view>
					</view>
				</view>
			</view>
		</view>

		<!-- 随机练习选择试题数量 -->
		<tn-picker mode="selector" v-model="showRandPicker" :defaultSelector="[0]" :range="numberRange"
			:confirmColor="mainColor" confirmText="立即练习" @confirm="randCountConfirm"></tn-picker>

	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'questionLib',
		mixins: [template_page_mixin],
		data() {
			return {
				showRandPicker: false,
				numberRange: [10, 20, 30, 40, 50, 60],
				mainColor: getApp().globalData.mainColor,
				bannerList: [{
					image: 'https://cdn.image.tutudati.com/uploads/images/20241123/20241123004043066872646.jpg'
				}],
				questionUid: '',
				questionCount: 0, // 随机练习题数
				questionContent: {},
				practiceItems: []
			}
		},
		onLoad(option) {
			this.questionUid = option.uid || ''
			this.fetchQuestionDetail()
			this.fetchQuestionMenu()
		},
		methods: {
			fetchQuestionDetail() {
				this.$api.apiQuestionDetail({
					uid: this.questionUid
				}).then(res => {
					this.questionContent = res.data
				})
			},
			fetchQuestionMenu() {
				this.$api.apiQuestionMenu({
					uid: this.questionUid
				}).then(res => {
					this.practiceItems = res.data
				})
			},
			tl(url) {
				this.$func.navigatorTo(url)
			},
			goBack() {
				uni.navigateBack();
			},
			randCountConfirm(e) {// 随机练习
				this.questionCount = this.numberRange[e[0]]
				this.$func.navigatorTo('/subpages/exam/questionRand?uid=' + this.questionUid + '&count=' + this.questionCount)
			},
			handleGridItemClick(row) {
				if (row.url !== '') {
					this.$func.navigatorTo(row.url)
				} else {
					if (row.type === 1) {
						this.showRandPicker = true
					} else {
						this.$func.showToast('暂未开放')
					}
				}
			}
		},
		onShareAppMessage() {
			return {
				title: this.questionContent.title,
				desc: this.questionContent.title,
				imageUrl: this.questionContent.image,
				path: '/subpages/exam/questionContent?uid=' + this.questionUid,
			}
		}
	}
</script>

<style lang="scss">
	@import "@/scss/custom_nav_bar.scss";

	.container {
		display: flex;
		flex-direction: column;
		background-color: #f4f4f4;
	}

	.banner image {
		width: 100%;
		display: block;
	}

	.info-section {
		background-color: #fff;
		padding: 15px;
		margin-bottom: 16rpx;

		.title-row {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 10rpx;
		}

		.main-title {
			font-size: 18px;
			font-weight: bold;
		}

		.user-info {
			display: flex;
			align-items: center;
			margin-bottom: 15px;
		}

		.avatar {
			width: 40px;
			height: 40px;
			border-radius: 50%;
			margin-right: 10px;
			background-color: #eee;
			/* 占位符背景 */
		}

		.user-details {
			display: flex;
			flex-direction: column;
		}

		.user-id {
			font-size: 14px;
			color: #333;
			margin-bottom: 4px;
		}

		.meta-info {
			font-size: 12px;
			color: #999;
			display: flex;
			align-items: center;

			.separator {
				margin: 0 5px;
			}
		}

		.action-buttons {
			display: flex;
			justify-content: space-around;
			align-items: center;
			padding-top: 10px;
			border-top: 1px solid #f0f0f0;
		}

		.action-item {
			display: flex;
			flex-direction: column;
			align-items: center;
			font-size: 12px;
			color: #666;

			uni-icons {
				margin-bottom: 4px;
			}
		}
	}

	.practice-section {
		background-color: #fff;
		padding: 15px;

		.section-title {
			font-size: 16px;
			font-weight: bold;
			margin-bottom: 15px;
			display: block;
		}

		.grid {
			display: flex;
			flex-wrap: wrap;
			// justify-content: space-between; // 如果每行不足2个，会导致不对齐
		}

		.grid-item {
			width: 49%; // 每行显示两个
			display: flex;
			margin-right: 1%;
			flex-direction: row;
			justify-content: space-around;
			padding: 30rpx 10rpx;
			box-sizing: border-box;
			position: relative; // 为了徽标定位
			background-color: #F4F4F4;

			.grid-icon-wrapper {
				position: relative;
				margin-bottom: 8px;
				width: 40px; // 给徽标定位提供参考
				height: 30px;
				display: flex;
				justify-content: center;
				align-items: center;
			}

			.badge {
				position: absolute;
				top: -5px;
				right: -10px;
				padding: 1px 4px;
				border-radius: 6px;
				font-size: 9px;
				color: #fff;

				&.new {
					background-color: #ff4d4f;
				}

				&.vip {
					background-color: #fadb14;
					color: #6f4f00;
				}
			}

			.grid-title {
				font-size: 32rpx;
				color: #333;
				margin-bottom: 10rpx;
			}

			.grid-desc {
				font-size: 26rpx;
				color: #999;
			}
		}
	}
</style>