<template>
	<view class="template-pay tn-safe-area-inset-bottom">
		<!-- 顶部自定义导航 -->
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">余额充值</text>
			</view>
		</tn-nav-bar>


		<view class="" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<view class="tn-margin">
				<view class="button-vip tn-flex tn-flex-row-between tn-shadow-blur"
					:style="{backgroundColor: mainColor}">
					<view class="tn-margin-left tn-margin-top-lg">
						<view class="tn-color-white">
							余额
						</view>
						<view class="tn-color-white tn-padding-top">
							<text class="" style="margin-left: -6rpx;">￥</text>
							<text class="tn-text-bold" style="font-size: 80rpx;">129.29</text>
						</view>
					</view>
					<view class="tn-margin-right tn-margin-top-xl tn-color-white">
						<view class="tn-padding-bottom-xs">
							<text class="tn-padding-right-xs" style="opacity: 0.3;">可用本金</text>
							￥129.00
						</view>
						<view class="tn-padding-bottom-xs">
							<text class="tn-padding-right-xs" style="opacity: 0.3;">充值优惠</text>
							￥0.29
						</view>
						<view class="tn-padding-bottom-xs">
							<text class="tn-padding-right-xs" style="opacity: 0.3;">冻结金额</text>
							￥0.00
						</view>
					</view>

				</view>
			</view>

		</view>

		<view class="tn-tag-content tn-text-justify tn-margin">
			<view @click="moneySelect(index)"
				:class="'tn-tag-content__item tn-margin-right tn-text-bold ' + (index === currentSelect ? 'tag-select' : 'tag-select-no')"
				v-for="(item, index) in rechargeList" :key="index">
				<text class="">{{ item.text }}</text>
			</view>
		</view>

		<radio-group>
			<!-- #ifdef MP-ALIPAY -->
			<view
				class="tn-flex tn-flex-col-center tn-flex-row-between tn-strip-bottom-min tn-padding tn-margin-top-xs">
				<view class="justify-content-item">
					<view class="tn-text-xxl">
						<text class="tn-icon-payment-alipay tn-color-blue--dark"></text>
						<text class="tn-padding-left-sm tn-text-lg">支付宝</text>
					</view>
				</view>
				<view class="justify-content-item tn-text-xl tn-color-green--dark">
					<view class="">
						<radio value="1" :color="mainColor" style="transform:scale(0.7)"></radio>
					</view>
				</view>
			</view>
			<!-- #endif -->
			<!-- #ifdef MP-WEIXIN -->
			<view
				class="tn-flex tn-flex-col-center tn-flex-row-between tn-strip-bottom-min tn-padding tn-margin-top-xs">
				<view class="justify-content-item">
					<view class="tn-text-xxl">
						<text class="tn-icon-payment-wechat tn-color-green--dark"></text>
						<text class="tn-padding-left-sm tn-text-lg">微信支付</text>
					</view>
				</view>
				<view class="justify-content-item tn-text-xl tn-color-grey--disabled">
					<radio value="2" :color="mainColor" style="transform:scale(0.7)"></radio>
				</view>
			</view>
			<!-- #endif -->
			<view
				class="tn-flex tn-flex-col-center tn-flex-row-between tn-strip-bottom-min tn-padding tn-margin-top-xs">
				<view class="justify-content-item">
					<view class="tn-text-xxl">
						<text class="tn-icon-pay-fill tn-color-aquablue--dark"></text>
						<text class="tn-padding-left-sm tn-text-lg">银行卡支付</text>
					</view>
				</view>
				<view class="justify-content-item tn-text-xl tn-color-grey--disabled">
					<radio value="3" :color="mainColor" style="transform:scale(0.7)"></radio>
				</view>
			</view>
		</radio-group>

		<!-- 悬浮按钮-->
		<view class="tn-flex tn-footerfixed">
			<view class="tn-flex-1 justify-content-item tn-margin tn-text-center">
				<view class="tn-padding-xl">
					<text class="tn-icon-tip tn-padding-right-xs tn-color-gray"></text>
					<text class="tn-color-gray">点击充值即表示你已同意</text>
					<text class="tn-color-blue--disabled">《充值协议》</text>
				</view>
				<tn-button :backgroundColor="mainColor" padding="40rpx 0" width="100%" shadow>
					<text class="tn-color-white">立 即 充 值</text>
				</tn-button>
			</view>
		</view>

	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'TemplatePay',
		mixins: [template_page_mixin],
		data() {
			return {
				currentSelect: 0,
				mainColor: getApp().globalData.mainColor,
				rechargeList: [{
					text: '50元',
					value: 50
				}, {
					text: '99元',
					value: 99
				}, {
					text: '100元',
					value: 50
				}, {
					text: '200元',
					value: 200
				}, {
					text: '500元',
					value: 500
				}, {
					text: '1000元',
					value: 1000
				}],
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
			moneySelect(index) {
				this.currentSelect = index
			},
			// 跳转
			tn(e) {
				uni.navigateTo({
					url: e,
				});
			},
		}
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";

	/* 底部悬浮按钮 start*/
	.tn-tabbar-height {
		min-height: 100rpx;
		height: calc(120rpx + env(safe-area-inset-bottom) / 2);
	}

	.tn-footerfixed {
		position: fixed;
		width: 100%;
		bottom: calc(60rpx + env(safe-area-inset-bottom));
		z-index: 1024;
		box-shadow: 0 1rpx 6rpx rgba(0, 0, 0, 0);

	}

	/* 底部悬浮按钮 end*/

	/* 卡 */
	.button-vip {
		width: 100%;
		height: 240rpx;
		border-radius: 15rpx;
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


	/* 间隔线 start*/
	.tn-strip-bottom-min {
		width: 100%;
		border-bottom: 1rpx solid #F8F9FB;
	}

	.tn-strip-bottom {
		width: 100%;
		border-bottom: 20rpx solid rgba(241, 241, 241, 0.8);
	}

	/* 间隔线 end*/

	/* 选择*/
	.tag-select {
		color: #07C160;
		border: 1rpx solid #07C160;
		background-color: #07C16010;
		border-radius: 16rpx;
	}

	.tag-select-no {
		color: #080808;
		border: 1rpx solid #E6E6E6;
		background-color: #F9F9F9;
		border-radius: 16rpx;
	}

	/* 标签内容 start*/
	.tn-tag-content {
		&__item {
			display: inline-block;
			line-height: 45rpx;
			padding: 20rpx 38rpx;
			margin: 20rpx 20rpx 5rpx 0rpx;

			&--prefix {
				padding-right: 10rpx;
			}
		}
	}

	/* 标签内容 end*/
</style>