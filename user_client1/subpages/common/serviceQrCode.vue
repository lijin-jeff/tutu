<template>
	<view class="components-time-line">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">在线客服</text>
			</view>
		</tn-nav-bar>

		<!-- 页面内容 -->
		<view :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<view class="customer-service-container tn-margin-lg tn-padding-lg">
				<view class="title">添加客服二维码</view>
				<view class="divider"></view>

				<view class="qrcode-container" @click="imagePreview">
					<image class="qrcode-image" src="https://cdn.image.tutudati.com/service.png" mode="aspectFit"></image>
				</view>

				<view class="service-info">
					<text class="service-text">长按添加客服或拨打客服热线</text>
					<text class="service-phone" @tap="callService">{{mobile}}</text>
				</view>

				<view class="service-time">
					<text>服务时间: 早上 9:30 – 19:00</text>
				</view>
			</view>
		</view>

	</view>

</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'componentsTimeline',
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				mobile: '15683202303'
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
			imagePreview() {
				this.$func.showServiceImage()
			},
			callService() {
				uni.makePhoneCall({
					phoneNumber: this.mobile
				})
			}
		}
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";

	.customer-service-container {
		background-color: #fff;
		display: flex;
		flex-direction: column;
		align-items: center;
		border-radius: 10rpx;
	}

	.title {
		font-size: 32rpx;
		font-weight: bold;
		text-align: center;
		margin-bottom: 20rpx;
	}

	.divider {
		height: 1rpx;
		background-color: #eee;
		width: 100%;
		margin-bottom: 40rpx;
	}

	.qrcode-container {
		margin: 30rpx 0;
		padding: 20rpx;
		display: flex;
		justify-content: center;
	}

	.qrcode-image {
		width: 400rpx;
		height: 400rpx;
	}

	.service-info {
		display: flex;
		flex-direction: column;
		align-items: center;
		margin-top: 20rpx;
	}

	.service-text {
		font-size: 28rpx;
		color: #333;
		margin-bottom: 10rpx;
	}

	.service-phone {
		font-size: 30rpx;
		color: #007AFF;
		margin-top: 10rpx;
	}

	.service-time {
		margin-top: 30rpx;
		font-size: 26rpx;
		color: #666;
	}
</style>