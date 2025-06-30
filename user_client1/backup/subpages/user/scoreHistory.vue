<template>
	<view class="template-myblog tn-safe-area-inset-bottom">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">积分明细</text>
			</view>
		</tn-nav-bar>

		<view class="top-backgroup">
			<!-- <image src='https://xxxxxx.xxxxx.com/202310010125586b9b51671.png'
				mode='widthFix' class='backgroud-image'></image> -->
		</view>

		<view class="about__wrap">
			<view class="tn-flex tn-flex-row-right" @click="scoreHelp">
				<text class="tn-icon-help" :style="{color: '#fff', fontSize: '24rpx'}">积分说明</text>
			</view>
			
			<!-- 积分汇总信息开始 -->
			<view class="tn-flex tn-flex-row-center tn-flex-col-center tn-margin-bottom">
				<view class="justify-content-item tn-text-center">
					<view class="tn-flex tn-flex-col-center tn-flex-row-left">
						<view class="tn-color-white">
							<view class="tn-padding-left-sm tn-text-xxl">
								{{score}}
							</view>
							<view class="tn-padding-top-xs tn-padding-left-sm tn-text-ellipsis">总积分</view>
						</view>
					</view>
				</view>
			</view>
			<!-- 积分汇总信息结束 -->

			<!-- 积分选项卡开始-->
			<view class="about-shadow tn-margin-top-sm tn-padding-top-sm tn-padding-bottom-sm tn-color-black tn-bg-white">
				<tn-tabs :list="tabList" bold="true" :activeColor="mainColor" :badgeOffset="badgeOffset" :isScroll="false"
					:current="currentTab" name="title" @change="tabChange"></tn-tabs>
			</view>
			<!-- 积分选项卡结束 -->

			<!-- 积分列表开始-->
			<view class="about-shadow tn-padding-top-sm">
				<block v-for="(item, index) in scoreList" :key="index">
					<tn-list-cell :unlined="true" padding="26rpx 0rpx" :key="index">
						<view class="message">
							<view class="message__middle">
								<view class="message__name">{{item.title}}</view>
								<view class="message__content tn-text-ellipsis">{{item.win_time}}</view>
							</view>
							<view class="message__right">
								<view class="message__time" :style="{color: mainColor}" v-if="item.type === 1">{{ `+` + item.score}}</view>
								<view class="message__time" :style="{color: mainErrorColor}" v-else-if="item.type === 2">{{ `-` + item.score}}</view>
								<view class="message__tips">
									<tn-tag :backgroundColor="parseInt(item.is_platform) === 1 ? mainErrorColor : mainColor" fontColor="tn-color-white" shape="circle" width="auto"
										size="sm">{{ parseInt(item.is_platform) === 1 ? '平台' : '用户' }}</tn-tag>
								</view>
							</view>
						</view>
					</tn-list-cell>
				</block>
			</view>
			<!-- 积分列表结束 -->
		</view>
		
		<!-- 技术支持开始部分 -->
		<view class="tn-text-center tn-margin-top-xl tn-padding-bottom-xl" v-if="scoreList.length > 10">
			<view>
				<text class="tn-icon-copyright"></text>
				<text class="tn-padding-xs main-color">兔兔答题</text>
				<text class="">提供技术支持</text>
			</view>
		</view>
		<!-- 技术支持结束部分 -->
		
		<tn-popup v-model="showScoreHelp" mode="bottom" :safeAreaInsetBottom="true"
			borderRadius="30">
			<view class="exam-count-info tn-flex">
				<view class="tn-padding tn-text-bold"><text class="tn-icon-title main-color"></text>积分说明</view>
			</view>
			<view class="options tn-padding-left tn-padding-right tn-padding-bottom">
				<mp-html :selectable="true" :content="scoreContent"></mp-html>
			</view>
			<view class="tn-padding-left tn-padding-right tn-padding-bottom">
				<tn-button @click="closeScoreHelpPopup" width="100%" height="80rpx" fontSize="30" :backgroundColor="mainColor" fontColor="tn-color-white">我 已 了 解</tn-button>
			</view>
		</tn-popup>
		
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'TemplateMyblog',
		mixins: [template_page_mixin],
		data() {
			return {
				showScoreHelp: false,
				mainColor: getApp().globalData.mainColor,
				mainErrorColor: getApp().globalData.mainErrorColor,
				userInfo: {
					'avatar': 'https://imgcdn.tutudati.com/xiaomai1.jpg',
					'nickname': '兔兔用户',
					'remark': '亲爱的兔兔用户你好吖',
				},
				tabList: [{
					title: '全部'
				}, {
					title: '增加'
				}, {
					title: '减少',
				}],
				currentTab: 0,
				score: 101.01,
				scoreList: [],
				searchWhere: {
					page: 1,
					size: 20,
					type: 3,
				},
				scoreContent: '<p style="line-height: 2em;">系统积分可以通过新用户注册、在线答题刷题、邀请新用户和接收系统消息推送等系统涉及积分的功能获取。获取到的积分可以用来下载资源、充值兑换(开发中)和积分商城兑换等积分相关的功能。具体获取或消耗根据系统功能而定，积分的最终解释权归平台所有。</p>',
			}
		},
		onLoad() {
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: false,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
		},
		onShow() {
			// this.getUserScore()
			this.demoData()
		},
		methods: {
			demoData() {
				for (let index = 0; index < 100; index++) {
					this.scoreList.push({
						title: '答题奖励',
						win_time:"2025-04-04 12:12:11",
						type: index % 2 == 1 ? 1 : 2,
						is_platform: index % 10 == 0 ? 1 : 2 ,
						score: Math.round(Math.random() * 100) + '.' + Math.round(Math.random() * 100)
					})
				}
			},
			scoreHelp() {
				this.showScoreHelp = true
			},
			closeScoreHelpPopup() {
				this.showScoreHelp = false
			},
			getUserScore() {
				this.$api.apiUserScore().then(res => {
					if (res.code === 100) {
						this.score = res.data.score
						this.getUserScoreList()
						return
					}
					this.$func.showToast(res.msg)
				})
			},
			getUserScoreList() {
				uni.showLoading({
					title: '努力加载中',
					mask: true,
				})
				this.searchWhere.type = this.currentTab === 0 ? 3 : (this.currentTab === 1 ? 1 : 2)
				this.$api.apiUserScoreHistoryList(this.searchWhere).then(res => {
					uni.hideLoading()
					if (res.code === 100) {
						this.scoreList.push(...res.data.items)
						this.searchWhere.page += 1
						return
					}
					this.$func.showToast(res.msg)
				})
			},
			tabChange(e) {
				this.currentTab = e
				this.searchWhere.page = 1
				// this.scoreList = []
				// this.getUserScoreList()
			},
		},
		onReachBottom() {
			// this.getUserScoreList()
		}
	}
</script>

<style lang="scss" scoped>
	@import '@/scss/custom_nav_bar.scss';

	.bt-text {
		letter-spacing: 10rpx;
	}

	.template-myblog {}

	/* 自定义导航栏内容 start */
	.custom-nav {
		height: 100%;

		&__back {
			margin: auto 5rpx;
			font-size: 40rpx;
			margin-right: 10rpx;
			flex-basis: 5%;
			width: 100rpx;
			position: absolute;
		}
	}

	/* 自定义导航栏内容 end */

	/* 顶部背景图 start */
	.top-backgroup {
		height: 450rpx;
		z-index: -1;
		background-color: $view-theme;

		.backgroud-image {
			width: 100%;
			height: 667rpx;
			// z-index: -1;
		}
	}

	/* 顶部背景图 end */


	/* 页面 start*/
	.about-shadow {
		border-radius: 15rpx;
		box-shadow: 0rpx 0rpx 50rpx 0rpx rgba(0, 0, 0, 0.07);
	}

	.about {

		&__wrap {
			position: relative;
			z-index: 1;
			margin: 20rpx 30rpx;
			margin-top: -260rpx;
		}
	}

	/* 页面 end*/

	// 积分列表开始
	.message {
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: space-around;

		&__middle {
			width: 80%;
			padding-left: 20rpx;
			padding-right: 40rpx;
		}

		&__right {
			width: 10%;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			padding-right: 40rpx;
		}

		&__name {
			font-size: 32rpx;
			margin-bottom: 8rpx;
		}

		&__content {
			font-size: 26rpx;
			color: #838383;
		}

		&__tips {
			margin-top: 10rpx;
			&__icon {
				font-size: 36rpx;
				color: #AAAAAA;
			}
		}
	}
	// 积分列表结束
</style>