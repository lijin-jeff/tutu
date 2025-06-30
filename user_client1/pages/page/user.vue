<template>
	<view class="page-e tn-safe-area-inset-bottom">
		<!-- 顶部自定义导航 -->
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<!-- <view slot="back" class='tn-custom-nav-bar__back' @click="goBack">
				<text class='icon tn-icon-left'></text>
				<text class='icon tn-icon-home-capsule-fill'></text>
			</view> -->
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">个人中心</text>
			</view>
		</tn-nav-bar>

		<view class="top-backgroup">
			<image src='/static/image/tutudatimyuser123123123123123.png' mode='widthFix' class='backgroud-image'></image>
		</view>

		<view class="tn-margin-left tn-margin-right" :style="{paddingTop: vuex_custom_bar_height + 10 + 'px'}">
			<!-- 图标logo/头像 -->
			<view class="tn-flex tn-flex-row-between tn-flex-col-center tn-margin-bottom" style="margin-top: -450rpx;">
				<view class="justify-content-item">
					<view class="tn-flex tn-flex-col-center tn-flex-row-left">
						<view class="logo-pic tn-shadow" @click="tn('/subpages/user/set')">
							<view class="logo-image">
								<view class="tn-shadow-blur"
									:style="'background-image:url('+ user.avatar +');width: 110rpx;height: 110rpx;background-size: cover;overflow: hidden;'">
								</view>
							</view>
						</view>
						<view class="tn-padding-right">
							<view class="tn-padding-right tn-padding-left-sm">
								<text class="tn-color-wallpaper tn-text-xl tn-text-bold">{{user.nickname}}</text>
								<!-- <view class="" style="margin: 10rpx 0;">
										<text class=" tn-round tn-text-xs tn-bg-red tn-color-white"
											style="padding: 10rpx 20rpx;">普通用户</text>
									</view> -->
							</view>
							<view class="tn-padding-right tn-padding-top-xs tn-padding-left-sm tn-text-ellipsis" @click="copyUid(user.sn)">
								<text class="tn-color-gray">编号: {{user.sn}}</text>
								<text class="main-color tn-padding-left-xs tn-text-sm tn-icon-copy"></text>
							</view>
						</view>
					</view>
				</view>
				<view class="justify-content-item" @click="tn('/subpages/user/set')">
					<view class="tn-icon-install tn-color-gray" style="font-size: 50rpx;opacity: 0.5;">
					</view>
				</view>
			</view>

			<view class="">
				<view class="button-number tn-flex tn-flex-row-between tn-flex-col-center tn-shadow-blur"
					style="background: linear-gradient(-120deg, #42B476, #42B476, #42B476, #42B476)">
					<view class="tn-margin-left">
						<view class="tn-flex tn-flex-col-center" style="color: #F1C68E;">
							<text class="tn-text-bold tn-text-xl">会员开通</text>
							<!-- <text class="tn-icon-vip-text tn-text-center" style="font-size: 60rpx;"></text> -->
						</view>
						<view class='tn-color-white tn-text-sm'>升级会员，体验更多功能</view>
					</view>
					<view class="tn-margin-right" @click="tn('/subpages/user/member')">
						<tn-button shape="round" backgroundColor="#F1C68E" fontColor="#634738" padding="10rpx 0"
							width="160rpx">
							<text class="tn-text-bold">开 通</text>
						</tn-button>
					</view>

					<view class="tnwave waveAnimation">
						<view class="waveWrapperInner bgTop">
							<view class="wave waveTop" style="background-image: url('/static/image/wave-2.png')">
							</view>
						</view>
						<view class="waveWrapperInner bgMiddle">
							<view class="wave waveMiddle"
								style="background-image: url('/static/image/wave-2.png')"></view>
						</view>
						<view class="waveWrapperInner bgBottom">
							<view class="wave waveBottom"
								style="background-image: url('/static/image/wave-1.png')"></view>
						</view>
					</view>

				</view>
			</view>

			<!-- 更多信息-->
			<!-- 方式12 start-->
			<view class="tn-margin-top-lg tn-bg-white">
				<view class="tn-flex tn-flex-row-center tn-radius tn-padding-top">
					<view class="tn-padding-sm tn-margin-xs tn-radius" @click="tn('/subpages/order/orderList')">
						<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
							<view class="icon12__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-bg-blue--light">
								<view class="tn-icon-cart tn-color-wallpaper"></view>
							</view>
							<view class="tn-text-center">
								<text class="tn-text-ellipsis">订单记录</text>
							</view>
						</view>
					</view>
					<view class="tn-padding-sm tn-margin-xs tn-radius" @click="tn('/subpages/order/balanceRecharge')">
						<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
							<view class="icon12__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-bg-blue--light">
								<view class="tn-icon-lucky-money tn-color-wallpaper"></view>
							</view>
							<view class="tn-text-center">
								<text class="tn-text-ellipsis">账户余额</text>
							</view>
						</view>
					</view>
					<view class="tn-padding-sm tn-margin-xs tn-radius" @click="tn('/subpages/user/scoreHistory')">
						<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
							<view class="icon12__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-bg-blue--light">
								<view class="tn-icon-order tn-color-wallpaper"></view>
							</view>
							<view class="tn-text-center">
								<text class="tn-text-ellipsis">积分明细</text>
							</view>
						</view>
					</view>
					<view class="tn-padding-sm tn-margin-xs tn-radius" @click="tn('/subpages/exam/examinationHistory')">
						<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
							<view class="icon12__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-bg-blue--light">
								<view class="tn-icon-edit tn-color-wallpaper"></view>
							</view>
							<view class="tn-text-center">
								<text class="tn-text-ellipsis">考试记录</text>
							</view>
						</view>
					</view>
				</view>
			</view>
			
			<!-- 更多信息-->
			<view class="tn-margin-top">
				<tn-list-cell :hover="true" :unlined="true" :radius="true" :fontSize="30"
					@click="tn('/subpages/common/serviceQrCode')">
					<view class="tn-flex tn-flex-col-center">
						<view class="icon1__item--icon tn-flex tn-flex-row-center tn-flex-col-center" :style="{color: mainColor}">
							<view class="tn-icon-plane-fill"></view>
						</view>
						<view class="tn-margin-left-sm tn-flex-1">商务合作</view>
						<view class="tn-color-gray tn-icon-right"></view>
					</view>
				</tn-list-cell>
				<tn-list-cell :hover="true" :unlined="true" :radius="true" :fontSize="30"
					@click="tn('/subpages/common/helpList')">
					<view class="tn-flex tn-flex-col-center">
						<view class="icon1__item--icon tn-flex tn-flex-row-center tn-flex-col-center" :style="{color: mainColor}">
							<view class="tn-icon-ticket-fill"></view>
						</view>
						<view class="tn-margin-left-sm tn-flex-1">在线帮助</view>
						<view class="tn-color-gray tn-icon-right"></view>
					</view>
				</tn-list-cell>
				<tn-list-cell :hover="true" :unlined="true" :radius="true" :fontSize="30"
					@click="tn('/subpages/common/update')">
					<view class="tn-flex tn-flex-col-center">
						<view class="icon1__item--icon tn-flex tn-flex-row-center tn-flex-col-center" :style="{color: mainColor}">
							<view class="tn-icon-message-fill"></view>
						</view>
						<view class="tn-flex tn-flex-row-between" style="width: 100%;">
							<view class="tn-margin-left-sm">软件更新</view>
							<view class="tn-color-gray tn-icon-right"></view>
						</view>
					</view>
				</tn-list-cell>
			</view>

			<view class="tn-margin-top">
				<tn-list-cell :hover="true" :unlined="true" :radius="true" :fontSize="30">
					<button class="tn-flex tn-flex-col-center tn-button--clear-style" open-type="contact">
						<view class="icon1__item--icon tn-flex tn-flex-row-center tn-flex-col-center" :style="{color: mainColor}">
							<view class="tn-icon-service-fill"></view>
						</view>
						<view class="tn-flex tn-flex-row-between" style="width: 100%;">
							<view class="tn-margin-left-sm">在线客服</view>
							<view class="tn-color-gray tn-icon-right"></view>
						</view>
					</button>
				</tn-list-cell>
				<tn-list-cell :hover="true" :unlined="true" :radius="true" :fontSize="30">
					<button class="tn-flex tn-flex-col-center tn-button--clear-style" open-type="feedback">
						<view class="icon1__item--icon tn-flex tn-flex-row-center tn-flex-col-center" :style="{color: mainColor}">
							<view class="tn-icon-tip-fill"></view>
						</view>
						<view class="tn-flex tn-flex-row-between" style="width: 100%;">
							<view class="tn-margin-left-sm">问题反馈</view>
							<view class="tn-color-gray tn-icon-right"></view>
						</view>
					</button>
				</tn-list-cell>
				<tn-list-cell :hover="true" :unlined="true" :radius="true" :fontSize="30" @click="copyWechat()">
					<view class="tn-flex tn-flex-col-center">
						<view class="icon1__item--icon tn-flex tn-flex-row-center tn-flex-col-center" :style="{color: mainColor}">
							<view class="tn-icon-tel-circle-fill"></view>
						</view>
						<view class="tn-margin-left-sm tn-flex-1">技术热线</view>
						<view
							class="tn-margin-left-sm tn-color-wallpaper tn-text-sm tn-padding-left-xs tn-padding-right-xs tn-bg-gray--light tn-round">
							wx_06282</view>
					</view>
				</tn-list-cell>
				<tn-list-cell :hover="true" :unlined="true" :radius="true" :fontSize="30" @click="loginOut">
					<view class="tn-flex tn-flex-col-center">
						<view class="icon1__item--icon tn-flex tn-flex-row-center tn-flex-col-center" :style="{color: mainColor}">
							<view class="tn-icon-my-simple-fill"></view>
						</view>
						<view class="tn-margin-left-sm tn-flex-1">退出登录</view>
						<view
							class="tn-margin-left-sm tn-color-wallpaper tn-text-sm tn-padding-left-xs tn-padding-right-xs tn-bg-gray--light tn-round">
						</view>
					</view>
				</tn-list-cell>
			</view>

		</view>

		<view class="tn-text-center tn-margin-top-xl tn-padding-bottom-xl">
			<view>
				<text class="tn-icon-copyright"></text>
				<text class="tn-padding-xs main-color">兔兔答题</text>
				<text class="">提供技术支持</text>
			</view>
		</view>
		<view class='tn-tabbar-height'></view>
		
		<view class="tn-padding-xl"></view>
		
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'pageE',
		mixins: [template_page_mixin],
		props: {
			user: {
				required: true,
				type: Object
			},
		},
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				loginStatus: 2, // 1登录2未登录
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
		methods: {
			// 跳转
			tn(url) {
				if (url == '') {
					this.$func.showToast('暂未开放')
					return
				}
				this.$func.navigatorTo(url)
			},
			// 复制微信号
			copyWechat() {
				this.$func.setClipboardData('wx_06282')
			},
			copyUid(sn) {
				this.$func.setClipboardData(sn)
			},
			// 退出登录
			loginOut() {
				uni.clearStorageSync("login")
				this.$func.showToast("退出成功")
				this.loginStatus = 2
			},
		},
		onShareAppMessage() {
			return {
				title: "兔兔知识竞赛活动，邀请您来答题啦，快来和我一起答题吧！！！",
				desc: '兔兔知识竞赛活动',
				path: "/pages/index?shareSn=" + this.userInfo.sn,
				imageUrl: 'https://imgcdn.tutudati.com/tutusharecompress.png'
			}
		}
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";

	.page-e {
		max-height: 100vh;
	}

	.tn-color-wallpaper {
		color: #1D2541;
	}

	/* 顶部背景图 start */
	.top-backgroup {
		height: 450rpx;
		z-index: -1;

		.backgroud-image {
			width: 100%;
			height: 450rpx;
			// z-index: -1;
		}
	}

	/* 顶部背景图 end */


	.image-pic {
		border: 1rpx solid #F8F7F8;
		background-size: cover;
		background-repeat: no-repeat;
		// background-attachment:fixed;
		background-position: top;
		border-radius: 10rpx;
	}

	/* 图标容器5 start */
	.icon5 {
		&__item {
			// width: 30%;
			background-color: #FFFFFF;
			border-radius: 10rpx;
			padding: 0rpx;
			margin: 0rpx;
			transform: scale(1);
			transition: transform 0.3s linear;
			transform-origin: center center;

			&--icon {
				width: 96rpx;
				height: 96rpx;
				border-radius: 50%;
				margin-bottom: 18rpx;
				position: relative;
				z-index: 1;
			}
		}
	}

	/* 用户头像 start */
	.logo-image {
		width: 110rpx;
		height: 110rpx;
		position: relative;
		overflow: hidden;
		border-radius: 50%;
	}

	.logo-pic {
		background-size: cover;
		background-repeat: no-repeat;
		// background-attachment:fixed;
		background-position: top;
		border: 8rpx solid rgba(255, 255, 255, 0.05);
		box-shadow: 0rpx 0rpx 80rpx 0rpx rgba(0, 0, 0, 0.15);
		border-radius: 50%;
		overflow: hidden;
		// background-color: #FFFFFF;
	}

	/* 页面阴影 start*/
	.wallpaper-shadow {
		border-radius: 15rpx;
		box-shadow: 0rpx 0rpx 50rpx 0rpx rgba(0, 0, 0, 0.07);
	}

	/* 页面阴影 end*/

	/* 图标容器15 start */
	.icon15 {
		&__item {
			width: 30%;
			background-color: #FFFFFF;
			border-radius: 10rpx;
			padding: 30rpx;
			margin: 20rpx 10rpx;
			transform: scale(1);
			transition: transform 0.3s linear;
			transform-origin: center center;

			&--icon {
				width: 100rpx;
				height: 100rpx;
				font-size: 60rpx;
				border-radius: 50%;
				margin-bottom: 18rpx;
				position: relative;
				z-index: 1;

				&::after {
					content: " ";
					position: absolute;
					z-index: -1;
					width: 100%;
					height: 100%;
					left: 0;
					bottom: 0;
					border-radius: inherit;
					opacity: 1;
					transform: scale(1, 1);
					background-size: 100% 100%;


				}
			}
		}
	}


	/* 图标容器12 start */
	.icon12 {
		&__item {
			width: 30%;
			background-color: #FFFFFF;
			border-radius: 10rpx;
			padding: 30rpx;
			margin: 20rpx 10rpx;
			transform: scale(1);
			transition: transform 0.3s linear;
			transform-origin: center center;

			&--icon {
				width: 15rpx;
				height: 15rpx;
				font-size: 50rpx;
				border-radius: 50%;
				margin-bottom: 38rpx;
				position: relative;
				z-index: 1;

				&::after {
					content: " ";
					position: absolute;
					z-index: -1;
					width: 100%;
					height: 100%;
					left: 0;
					bottom: 0;
					border-radius: inherit;
					opacity: 1;
					transform: scale(1, 1);
					background-size: 100% 100%;

				}
			}
		}
	}

	/* 图标容器1 start */
	.icon1 {
		&__item {
			// width: 30%;
			background-color: #FFFFFF;
			border-radius: 10rpx;
			padding: 30rpx;
			margin: 20rpx 10rpx;
			transform: scale(1);
			transition: transform 0.3s linear;
			transform-origin: center center;

			&--icon {
				width: 40rpx;
				height: 40rpx;
				font-size: 40rpx;
				border-radius: 50%;
				position: relative;
				z-index: 1;

				&::after {
					content: " ";
					position: absolute;
					z-index: -1;
					width: 100%;
					height: 100%;
					left: 0;
					bottom: 0;
					border-radius: inherit;
					opacity: 1;
					transform: scale(1, 1);
					background-size: 100% 100%;
					background-image: url('/static/image/icon_bg.png');
				}
			}
		}
	}

	/* 图标容器1 end */


	.button-shake {
		animation: shake 4s infinite;
	}

	@keyframes shake {

		5%,
		50% {
			transform: scale(1);
		}

		10% {
			transform: scale(0.9);
		}

		15% {
			transform: scale(1.15);
		}

		20% {
			transform: scale(1.15) rotate(-5deg);
		}

		25% {
			transform: scale(1.15) rotate(5deg);
		}

		30% {
			transform: scale(1.15) rotate(-3deg);
		}

		35% {
			transform: scale(1.15) rotate(2deg);
		}

		40% {
			transform: scale(1.15) rotate(0);
		}
	}



	/* 背景波浪高度 */
	.button-number {
		width: 100%;
		height: 120rpx;
		border-radius: 15rpx;
		position: relative;
		z-index: 1;
	}

	/* 动态背景波浪*/
	@keyframes move_wave {
		0% {
			transform: translateX(0) translateZ(0) scaleY(1)
		}

		50% {
			transform: translateX(-25%) translateZ(0) scaleY(1)
		}

		100% {
			transform: translateX(-50%) translateZ(0) scaleY(1)
		}
	}

	.tnwave {
		overflow: hidden;
		position: absolute;
		left: 0;
		right: 0;
		bottom: 0;
		top: 0;
		margin: auto;
		z-index: -1;
		border-radius: 15rpx;
	}

	.waveWrapperInner {
		position: absolute;
		width: 100%;
		overflow: hidden;
		height: 100%;
	}

	.wave {
		position: absolute;
		left: 0;
		width: 200%;
		height: 100%;
		background-repeat: repeat no-repeat;
		background-position: 0 bottom;
		transform-origin: center bottom;
	}

	.bgTop {
		opacity: 0.1;
	}

	.waveTop {
		background-size: 50% 45px;
	}

	.waveAnimation .waveTop {
		animation: move_wave 4s linear infinite;
	}

	.bgMiddle {
		opacity: 0.2;
	}

	.waveMiddle {
		background-size: 50% 40px;
	}

	.waveAnimation .waveMiddle {
		animation: move_wave 3.5s linear infinite;
	}

	.bgBottom {
		opacity: 0.3;
	}

	.waveBottom {
		background-size: 50% 35px;
	}

	.waveAnimation .waveBottom {
		animation: move_wave 2s linear infinite;
	}
</style>