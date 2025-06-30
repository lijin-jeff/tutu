<template>
	<view>
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">开通会员</text>
			</view>
		</tn-nav-bar>

		<view class="page" :style="{paddingTop: vuex_custom_bar_height + 10 + 'px'}">
			<view class="user">
				<image :src="userInfo.avatar" />
				<view>
					<text>{{userInfo.nickname}}</text>
					<text v-if="userInfo.vip_state === 1">你还未开通会员</text>
					<text v-else-if="userInfo.vip_state === 2">会员已过期 请重新开通</text>
					<text v-else-if="userInfo.vip_state === 3">{{`会员到期时间` + userInfo.vip_endTime}}</text>
				</view>
			</view>

			<view class="option">
				<view class="option-title">会员套餐</view>
				<view class="option-list">
					<view :class="'option-item ' + (k === current ? 'option-selected' : '')" v-for="(v, k) in options"
						:key="k" @click="change(k)">
						<text>{{v.time}}</text>
						<text>￥{{v.price}}</text>
						<text :style="{color: mainColor}">原价：￥{{v.oldPrice}}</text>
						<view class="option-item-line"></view>
					</view>
				</view>
				<view class="option-botton" @click="pay()">立即开通</view>
			</view>

			<view class="table">
				<view class="td th">
					<view>功能权限</view>
					<view>普通用户</view>
					<view>VIP用户</view>
				</view>
				<view class="td" v-for="(v, k) in advantages" :key="k">
					<view>{{v.name}}</view>
					<view>
						<image src="/static/image/no.png" v-if="v.normal === 0"></image>
						<image src="/static/image/ok.png" v-else-if="v.normal === 1"></image>
						<text v-else>{{v.normal}}</text>
					</view>
					<view>
						<image src="/static/image/ok.png" v-if="v.vip === 1"></image>
						<text v-else>{{v.vip}}</text>
					</view>
				</view>
			</view>
		</view>


	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				options: [{
						time: '月度',
						oldPrice: "40.00",
						price: "10.00"
					},
					{
						time: '季度',
						oldPrice: "99.00",
						price: "32.00"
					},
					{
						time: '年度',
						oldPrice: "198.00",
						price: "99.00"
					},
				],
				advantages: [{
						name: '常规题库',
						normal: 1,
						vip: 1
					},
					{
						name: '精品题库',
						normal: 0,
						vip: 1
					},
					{
						name: '题库折扣',
						normal: 0,
						vip: 1
					},
					{
						name: '常规资源',
						normal: 1,
						vip: 1
					},
					{
						name: '精品资源',
						normal: 0,
						vip: 1
					},
					{
						name: '广告限制',
						normal: 0,
						vip: 1
					},
					{
						name: '存储空间',
						normal: '不限',
						vip: '不限'
					},
					{
						name: '答题历史',
						normal: '最近一个月',
						vip: '永久'
					},
				],
				current: 0, // 当前选中套餐
				userInfo: {
					nickname: '匿名用户111',
					avatar: 'https://cdn.image.tutudati.com/uploads/images/20250108/20250108025716bc6cf6877.png',
					sex: 0,
					sn: 'uhx1adsf291',
					vip_state: 1
				},
				orderSn: '',
				timeId: 0
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
			this.fetchUser()
		},
		methods: {
			fetchUser() {
				this.$api.apiUserInfo().then(res => {
					if (res.code === 1) {
						this.userInfo = res.data
						return
					}
					this.$func.showToast(res.msg)
				})
			},
			change(k) {
				this.current = k;
			},
			pay() {
				this.$func.showToast('会员充值已关闭')
				return
				uni.showLoading({
					title: '订单生成中',
					mask: true
				})
				this.$api.apiVipPay({
					vip_type: this.current,
					client_type: 1,
					order_type: 3
				}).then(res => {
					console.log(res)
					uni.hideLoading()
					if (res.code === 100) {
						this.orderSn = res.data.order_sn
						uni.requestPayment({
							provider:'wxpay',
							timeStamp: String(Date.now()),
							nonceStr: res.data.config.nonceStr,
							package: res.data.config.package,
							signType: res.data.config.signType,
							paySign: res.data.config.paySign
						})
						let _that = this
						_that.timeId = setInterval(function() {
							_that.fetchPayState()
						}, 1000)
						return
					}
					this.$func.showToast(res.msg)
				})
			},
			fetchPayState() {
				this.$api.apiOrderPayState({order_sn: this.orderSn}).then(res => {
					console.log(res)
				})
			},
		}
	}
</script>

<style lang="scss" scoped>
	@import '@/scss/custom_nav_bar.scss';

	.page {
		display: flex;
		flex-direction: column;
		align-items: center;
		min-height: 100vh;
		background: linear-gradient(180deg, #42B476, #f4f4f4);

		.user {
			background: #fff;
			padding: 30rpx;
			border-radius: 12rpx;
			width: 700rpx;
			margin-bottom: 20rpx;
			display: flex;
			box-sizing: border-box;

			image {
				width: 90rpx;
				height: 90rpx;
				border-radius: 50%;
				margin-right: 30rpx;
			}

			view {
				display: flex;
				flex-direction: column;
				justify-content: space-between;

				text {
					&:nth-child(2) {
						font-size: 14px;
						color: #555;
					}
				}
			}
		}

		.option {
			display: flex;
			align-items: center;
			flex-direction: column;
			background: #fff;
			width: 700rpx;
			border-radius: 12rpx;
			margin-bottom: 20rpx;

			.option-title {
				font-weight: bold;
				padding: 30rpx 0;
			}

			.option-list {
				display: flex;
				justify-content: center;

				.option-item {
					width: 200rpx;
					height: 200rpx;
					padding: 20rpx 0;
					margin: 0 8rpx;
					border: 1px solid #42B476;
					border-radius: 12rpx;
					display: flex;
					flex-direction: column;
					align-items: center;
					justify-content: space-between;
					position: relative;
					box-sizing: border-box;

					&:active {
						background: #1b4f30;
					}

					text {
						color: #42B476;

						&:nth-child(2) {
							font-size: 22px;
							font-weight: bold;
						}

						&:nth-child(3) {
							font-size: 14px;
							color: #ccc;
						}
					}

					.option-item-line {
						width: 180rpx;
						height: 1px;
						background: #ccc;
						position: absolute;
						bottom: calc(20rpx + 8px);
						left: 10rpx;
						opacity: .8;
					}
				}

				.option-selected {
					background: #1b4f30;
				}
			}

			.option-botton {
				margin: 30rpx 0;
				width: 200rpx;
				height: 90rpx;
				line-height: 90rpx;
				border-radius: 12rpx;
				text-align: center;
				background: #42B476;
				color: #fff;

				&:active {
					background: #2a754c;
				}
			}
		}

		.table {
			width: 700rpx;
			background: #fff;
			border-radius: 12rpx;

			.td {
				display: flex;
				justify-content: space-between;
				height: 80rpx;
				line-height: 80rpx;

				view {
					font-size: 14px;
					color: #444;
					width: 233rpx;
					text-align: center;
				}

				image {
					width: 40rpx;
					height: 40rpx;
				}
			}

			.th {
				view {
					font-size: 16px;
					color: #000;
					font-weight: bold;
				}
			}
		}
	}
</style>