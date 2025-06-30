<template>
	<view class="template-order">

		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left' @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill' @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">订单中心</text>
			</view>
		</tn-nav-bar>

		<view class="order--wrap" :style="{top: vuex_custom_bar_height + 'px'}">
			<!-- 顶部标签 -->
			<tn-tabs-swiper class="order__tabs" ref="tabs" :list="list" :current="tabsIndex" :isScroll="false" :activeColor="mainColor"
				@change="tabsChange"></tn-tabs-swiper>

			<!-- 标签内容 -->
			<swiper class="order__swiper" :style="{top: `${swiperTop}px`, height: `${swiperHeight}px`}" :current="swiperIndex"
				@transition="swiperTransition" @animationfinish="swiperAnimationFinish">

				<!-- 全部订单 -->
				<swiper-item class="order__swiper__item">
					<scroll-view :style="{height: `${swiperHeight}px`}" scroll-y>
						<view v-for="(item,index) in 6" :key="index" class="order__item">
							<view class="order__item__head tn-flex tn-flex-direction-row tn-flex-col-center tn-flex-row-between">
								<view class="order__item__head__title">图鸟官方小店
								<!-- <text class="order__item__head__title--right-icon tn-icon-right"></text> -->
								</view>
								<view class="order__item__head__status">完成</view>
							</view>

							<view
								class="order__item__content tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-center">
								<view class="order__item__content__image">
									<image src="https://resource.tuniaokj.com/images/shop/card.jpg" mode="scaleToFill"></image>
								</view>
								<view class="order__item__content__title">
									图鸟官方设计 酷炫效果展示 让用户眼前一亮的赶脚
								</view>
								<view
									class="order__item__content__info tn-flex tn-flex-direction-column tn-flex-col-center tn-flex-row-center">
									<view class="order__item__content__info__price">
										<text class="order__item__content__info__price--unit">￥</text>
										<text class="order__item__content__info__price__value--integer">1000</text>
										<text class="order__item__content__info__price__value--decimal">.00</text>
									</view>
									<view class="order__item__content__info__count">
										<text>共1件</text>
									</view>
								</view>
							</view>

							<view
								class="order__item__operation tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-between">
								<view class="order__item__operaation__left">
									<!-- <text class="order__item__operaation__left--text">更多</text> -->
								</view>
								<view
									class="order__item__operation__right tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-right">
									<view class="order__item__operaation__right__button">
										<tn-button :plain="true" shape="round" fontColor="#080808" backgroundColor="#080808" :fontSize="24"
											height="auto" padding="10rpx 18rpx">查看发票</tn-button>
									</view>
									<view class="order__item__operation__right__button">
										<tn-button :plain="true" shape="round" fontColor="#080808" backgroundColor="#080808" :fontSize="24"
											height="auto" padding="10rpx 18rpx">退换/售后</tn-button>
									</view>
									<view class="order__item__operation__right__button">
										<tn-button :plain="true" shape="round" :fontColor="mainColor" :backgroundColor="mainColor"
											:fontSize="24" height="auto" padding="10rpx 18rpx">再次购买</tn-button>
									</view>
								</view>
							</view>
						</view>
						<view class="tn-padding-bottom"></view>
					</scroll-view>
				</swiper-item>

				<!-- 待付款订单 -->
				<swiper-item class="order__swiper__item">
					<scroll-view :style="{height: `${swiperHeight}px`}" scroll-y>
						<view v-for="(item,index) in 6" :key="index" class="order__item">
							<view class="order__item__head tn-flex tn-flex-direction-row tn-flex-col-center tn-flex-row-between">
								<view class="order__item__head__title">资料订单</view>
								<view class="order__item__head__status">待付款</view>
							</view>

							<view
								class="order__item__content tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-center">
								<view class="order__item__content__image">
									<image src="https://resource.tuniaokj.com/images/shop/card.jpg" mode="scaleToFill"></image>
								</view>
								<view class="order__item__content__title">
									图鸟官方设计 酷炫效果展示 让用户眼前一亮的赶脚
								</view>
								<view
									class="order__item__content__info tn-flex tn-flex-direction-column tn-flex-col-center tn-flex-row-center">
									<view class="order__item__content__info__price">
										<text class="order__item__content__info__price--unit">￥</text>
										<text class="order__item__content__info__price__value--integer">1000</text>
										<text class="order__item__content__info__price__value--decimal">.00</text>
									</view>
									<view class="order__item__content__info__count">
										<text>共1件</text>
									</view>
								</view>
							</view>

							<view
								class="order__item__operation tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-between">
								<view class="order__item__operaation__left">
									<!-- <text class="order__item__operaation__left--text">更多</text> -->
								</view>
								<view
									class="order__item__operation__right tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-right">
									<view class="order__item__operation__right__button">
										<tn-button :plain="true" shape="round" :fontColor="mainColor" :backgroundColor="mainColor"
											:fontSize="24" height="auto" padding="10rpx 18rpx">立即支付</tn-button>
									</view>
								</view>
							</view>
						</view>
						<view class="tn-padding-bottom"></view>
					</scroll-view>
				</swiper-item>

				<!-- 待发货订单 -->
				<swiper-item class="order__swiper__item">
					<scroll-view :style="{height: `${swiperHeight}px`}" scroll-y>
						<view v-for="(item,index) in 6" :key="index" class="order__item">
							<view class="order__item__head tn-flex tn-flex-direction-row tn-flex-col-center tn-flex-row-between">
								<view class="order__item__head__title">会员订单</view>
								<view class="order__item__head__status">待发货</view>
							</view>

							<view
								class="order__item__content tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-center">
								<view class="order__item__content__image">
									<image src="https://resource.tuniaokj.com/images/shop/card.jpg" mode="scaleToFill"></image>
								</view>
								<view class="order__item__content__title">
									图鸟官方设计 酷炫效果展示 让用户眼前一亮的赶脚
								</view>
								<view
									class="order__item__content__info tn-flex tn-flex-direction-column tn-flex-col-center tn-flex-row-center">
									<view class="order__item__content__info__price">
										<text class="order__item__content__info__price--unit">￥</text>
										<text class="order__item__content__info__price__value--integer">1000</text>
										<text class="order__item__content__info__price__value--decimal">.00</text>
									</view>
									<view class="order__item__content__info__count">
										<text>共1件</text>
									</view>
								</view>
							</view>

							<view
								class="order__item__operation tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-between">
								<view class="order__item__operaation__left">
									<!-- <text class="order__item__operaation__left--text">更多</text> -->
								</view>
								<view
									class="order__item__operation__right tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-right">
									<view class="order__item__operation__right__button">
										<tn-button :plain="true" shape="round" :fontColor="mainColor" :backgroundColor="mainColor"
											:fontSize="24" height="auto" padding="10rpx 18rpx">取消订单</tn-button>
									</view>
								</view>
							</view>
						</view>
						<view class="tn-padding-bottom"></view>
					</scroll-view>
				</swiper-item>

				<!-- 待收货订单 -->
				<swiper-item class="order__swiper__item">
					<scroll-view :style="{height: `${swiperHeight}px`}" scroll-y>
						<view v-for="(item,index) in 6" :key="index" class="order__item">
							<view class="order__item__head tn-flex tn-flex-direction-row tn-flex-col-center tn-flex-row-between">
								<view class="order__item__head__title">试卷订单</view>
								<view class="order__item__head__status">完成</view>
							</view>

							<view
								class="order__item__content tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-center">
								<view class="order__item__content__image">
									<image src="https://resource.tuniaokj.com/images/shop/card.jpg" mode="scaleToFill"></image>
								</view>
								<view class="order__item__content__title">
									图鸟官方设计 酷炫效果展示 让用户眼前一亮的赶脚
								</view>
								<view
									class="order__item__content__info tn-flex tn-flex-direction-column tn-flex-col-center tn-flex-row-center">
									<view class="order__item__content__info__price">
										<text class="order__item__content__info__price--unit">￥</text>
										<text class="order__item__content__info__price__value--integer">1000</text>
										<text class="order__item__content__info__price__value--decimal">.00</text>
									</view>
									<view class="order__item__content__info__count">
										<text>共1件</text>
									</view>
								</view>
							</view>

							<view
								class="order__item__operation tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-between">
								<view class="order__item__operaation__left">
									<!-- <text class="order__item__operaation__left--text">更多</text> -->
								</view>
								<view
									class="order__item__operation__right tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-right">
									<view class="order__item__operation__right__button">
										<tn-button :plain="true" shape="round" :fontColor="mainColor" :backgroundColor="mainColor"
											:fontSize="24" height="auto" padding="10rpx 18rpx">查看物流</tn-button>
									</view>
								</view>
							</view>
						</view>
						<view class="tn-padding-bottom"></view>
					</scroll-view>
				</swiper-item>

				<!-- 待评价订单 -->
				<swiper-item class="order__swiper__item">
					<scroll-view :style="{height: `${swiperHeight}px`}" scroll-y>
						<view v-for="(item,index) in 6" :key="index" class="order__item">
							<view class="order__item__head tn-flex tn-flex-direction-row tn-flex-col-center tn-flex-row-between">
								<view class="order__item__head__title">课程订单</view>
								<view class="order__item__head__status">完成</view>
							</view>

							<view
								class="order__item__content tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-center">
								<view class="order__item__content__image">
									<image src="https://resource.tuniaokj.com/images/shop/card.jpg" mode="scaleToFill"></image>
								</view>
								<view class="order__item__content__title">
									图鸟官方设计 酷炫效果展示 让用户眼前一亮的赶脚
								</view>
								<view
									class="order__item__content__info tn-flex tn-flex-direction-column tn-flex-col-center tn-flex-row-center">
									<view class="order__item__content__info__price">
										<text class="order__item__content__info__price--unit">￥</text>
										<text class="order__item__content__info__price__value--integer">1000</text>
										<text class="order__item__content__info__price__value--decimal">.00</text>
									</view>
									<view class="order__item__content__info__count">
										<text>共1件</text>
									</view>
								</view>
							</view>

							<view
								class="order__item__operation tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-between">
								<view class="order__item__operaation__left">
									<!-- <text class="order__item__operaation__left--text">更多</text> -->
								</view>
								<view
									class="order__item__operation__right tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-right">
									<view class="order__item__operation__right__button">
										<tn-button :plain="true" shape="round" @click="tl('/subpages/order/orderEvaluate')" :fontColor="mainColor" :backgroundColor="mainColor"
											:fontSize="24" height="auto" padding="10rpx 18rpx">订单评价</tn-button>
									</view>
								</view>
							</view>
						</view>
						<view class="tn-padding-bottom"></view>
					</scroll-view>
				</swiper-item>

			</swiper>
		</view>
	</view>
</template>

<script>
	import templatePageMixin from '@/libs/mixin/template_page_mixin.js'

	export default {
		name: 'TemplateOrder',
		mixins: [templatePageMixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				list: [{
						name: '全部'
					},
					{
						name: '待付款'
					},
					{
						name: '待发货',
						count: 10
					},
					{
						name: '待收货'
					},
					{
						name: '待评价',
						count: 5
					}
				],
				tabsIndex: 0,
				swiperIndex: 0,
				swiperTop: 0,
				swiperHeight: 0
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
		onReady() {
			this.$nextTick(() => {
				this.updateSwiperInfo()
			})
		},
		methods: {
			tl(url) {
				this.$func.navigatorTo(url)
			},
			// 计算可滑动区域的高度信息
			updateSwiperInfo() {
				// 获取可滑动菜单的信息
				this._tGetRect('.order__tabs').then(res => {
					if (!res) {
						setTimeout(() => {
							this.updateSwiperInfo()
						}, 10)
						return
					}
					const systemInfo = uni.getSystemInfoSync()
					this.swiperTop = res.bottom - this.vuex_custom_bar_height
					this.swiperHeight = systemInfo.safeArea.height - res.bottom + systemInfo.statusBarHeight
				})
			},
			// 标签栏值发生改变
			tabsChange(index) {
				this.swiperIndex = index
			},
			// swiper-item位置发生改变
			swiperTransition(event) {
				this.$refs.tabs.setDx(event.detail.dx)
			},
			// swiper动画结束
			swiperAnimationFinish(event) {
				const current = event.detail.current
				this.$refs.tabs.setFinishCurrent(current)
				this.swiperIndex = current
				this.tabsIndex = current
			}
		}
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";

	.template-order {
		background-color: #F7F7F7CC;
	}

	.order {
		&--wrap {
			position: fixed;
			left: 0;
			right: 0;
			width: 100%;
			background-color: #FFFFFF;
		}

		/* 导航栏 start */
		&__tabs {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			padding-top: 20rpx;
			background-color: #FFFFFF;
		}

		/* 导航栏 end */

		/* swiper start */
		&__swiper {
			position: absolute;
			left: 0;
			right: 0;
			width: 100%;
			background-color: inherit;
			padding: 0 16rpx;
		}

		/* swiper end */

		/* 订单内容 start */
		&__item {
			margin: 20rpx;
			padding: 36rpx 26rpx;
			background-color: #FFFFFF;
			border-radius: 18rpx;
			border-bottom: 1rpx solid #EAEAEA;

			&:first-child {
				margin-top: 40rpx;
			}

			&:last-child {
				margin-bottom: 0;
			}

			/* 头部 start */
			&__head {

				&__title {
					font-weight: bold;
					line-height: normal;

					&--right-icon {
						font-size: 24rpx;
						margin-left: 8rpx;
					}
				}

				&__status {
					font-size: 22rpx;
					color: #AAAAAA;
				}
			}

			/* 头部 end */

			/* 内容 start */
			&__content {

				margin-top: 20rpx;

				&__image {
					margin-right: 20rpx;

					image {
						width: 140rpx;
						height: 140rpx;
						border-radius: 10rpx;
					}
				}

				&__title {
					padding-right: 40rpx;
					display: -webkit-box;
					overflow: hidden;
					white-space: normal !important;
					text-overflow: ellipsis;
					word-wrap: break-word;
					-webkit-line-clamp: 2;
					-webkit-box-orient: vertical;
				}

				&__info {

					&__price {
						&--unit {
							font-size: 20rpx;
						}

						&__value--integer,
						&__value--decimal {
							font-weight: bold;
						}

						&__value--decimal {
							font-size: 20rpx;
						}
					}

					&__count {
						color: #AAAAAA;
						font-size: 24rpx;
					}
				}
			}

			/* 内容 end */

			/* 操作按钮 start */
			&__operation {
				margin-top: 30rpx;

				&__right {
					&__button {
						margin-left: 10rpx;
					}
				}
			}

			/* 操作按钮 end */
		}

		/* 订单内容 end */
	}
</style>