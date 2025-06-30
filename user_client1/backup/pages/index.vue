<template>
	<view>
		<view>
			<page-a ref="pageA" v-if="currentIndex === 0" :top="top"></page-a>
			<page-e ref="pageE" v-if="currentIndex === 4" :user="userInfo"></page-e>
			<page-b ref="pageB" v-if="currentIndex === 1"></page-b>
			<page-d ref="pageD" v-if="currentIndex === 3"></page-d>
		</view>
		<view class="tabbar footerfixed">
			<view class="action" @click="menuClick(0)">
				<view class="bar-icon">
					<image class="" :src="currentIndex === 0 ? '/static/tabbar/home_cur.png' : '/static/tabbar/home.png'"></image>
				</view>
				<view class="tn-color-gray">首页</view>
			</view>
			<view class="action" @click="menuClick(1)">
				<view class="bar-icon">
					<image class=""
						:src="currentIndex === 1 ? '/static/tabbar/information_tncur.png': '/static/tabbar/information_tn.png'">
					</image>
				</view>
				<view class="tn-color-gray">资料</view>
			</view>
			<view class="action bar-center" @click="">
				<view class="nav-index-button">
					<view class="nav-index-button__content">
						<view class="nav-index-button__content--icon tn-flex tn-flex-row-center tn-flex-col-center">
							<view class="bar-circle">
								<image class="" src='https://resource.tuniaokj.com/images/bless/bless-tiger.png'></image>
							</view>
						</view>
					</view>
					<view class="nav-index-button__meteor">
						<view class="nav-index-button__meteor__wrapper">
							<view v-for="(item,index) in 6" :key="index" class="nav-index-button__meteor__item"
								:style="{transform: `rotateX(${-60 + (30 * index)}deg) rotateZ(${-60 + (30 * index)}deg)`}">
								<view class="nav-index-button__meteor__item--pic"></view>
							</view>
						</view>
					</view>
				</view>
			</view>

			<view class="action" @click="menuClick(3)">
				<view class="bar-icon">
					<image class="" :src="currentIndex === 3 ? '/static/tabbar/case_tncur.png' : '/static/tabbar/case_tn.png'">
					</image>
				</view>
				<view class="tn-color-gray">资讯</view>
			</view>
			<view class="action" @click="menuClick(4)">
				<view class="bar-icon">
					<image class="" :src="currentIndex === 4 ? '/static/tabbar/my_tncur.png' : '/static/tabbar/my_tn.png'">
					</image>
				</view>
				<view class="tn-color-gray">我的</view>
			</view>
		</view>
	</view>
</template>

<script>
	import pageA from './page/index.vue'
	import PageE from './page/user.vue'
	import pageB from './page/resource.vue'
	import PageD from './page/news.vue'
	export default {
		name: 'NavFooter',
		components: {
			pageA,
			PageE,
			pageB,
			PageD
		},
		data() {
			return {
				top: 0,
				currentIndex: 0,
				userInfo: {
					nickname: '匿名用户111',
					avatar: 'https://cdn.image.tutudati.com/uploads/images/20250108/20250108025716bc6cf6877.png',
					sex: 0,
					sn: 'uhx1adsf291',
				}
			}
		},
		onShow() {
		},
		methods: {
			fetchUserBasicInfo() {
				console.log('调用用户信息')
			},
			menuClick(index) {
				this.currentIndex = index
				if(this.currentIndex === 4) {
					this.fetchUserBasicInfo()
				}
			}
		},
		onPageScroll(e) {
			this.top = e.scrollTop
			if (this.currentIndex === 0) {
				this.$refs.pageA.updateSearchState(this.top)
			}
		}
	}
</script>

<style scoped>
	/* 底部tabbar start*/
	.footerfixed {
		position: fixed;
		width: 100%;
		bottom: 0;
		z-index: 999;
		background-color: #FFFFFF;
		box-shadow: 0rpx 0rpx 30rpx 0rpx rgba(0, 0, 0, 0.07);
	}

	.tabbar {
		display: flex;
		align-items: center;
		min-height: 110rpx;
		justify-content: space-between;
		padding: 0;
		height: calc(110rpx + env(safe-area-inset-bottom) / 2);
		padding-bottom: calc(env(safe-area-inset-bottom) / 2);
	}

	.tabbar .action {
		font-size: 22rpx;
		position: relative;
		flex: 1;
		text-align: center;
		padding: 0;
		display: block;
		height: auto;
		line-height: 1;
		margin: 0;
		overflow: initial;
	}

	.bar-center {
		animation: suspension 3s ease-in-out infinite;
	}

	@keyframes suspension {

		0%,
		100% {
			transform: translateY(0);
		}

		50% {
			transform: translateY(-0.8rem);
		}
	}

	.tabbar .action .bar-icon {
		width: 100rpx;
		position: relative;
		display: block;
		height: auto;
		margin: 0 auto 10rpx;
		text-align: center;
		font-size: 42rpx;
		// line-height: 50rpx;
	}

	.tabbar .action .bar-icon image {
		width: 50rpx;
		height: 50rpx;
		display: inline-block;
	}

	.tabbar .action .bar-circle {
		position: relative;
		display: block;
		margin: 0rpx auto 0rpx;
		text-align: center;
		font-size: 52rpx;
		line-height: 90rpx;
		// background-color: #01BEFF;
		width: 100rpx !important;
		height: 100rpx !important;
		overflow: hidden;
		// border-radius: 50%;
		// box-shadow: 0px 10px 30px rgba(70,23,129, 0.12),
		//   0px -8px 40px rgba(255, 255, 255, 1),
		//   inset 0px -10px 10px rgba(70,23,129, 0.05),
		//   inset 0px 10px 20px rgba(255, 255, 255, 1);
		// box-shadow: 0rpx 0rpx 20rpx 0rpx rgba(1, 190, 255, 0.5);
	}

	.tabbar .action .bar-circle image {
		width: 100rpx;
		height: 100rpx;
		display: inline-block;
		margin: 0rpx auto 0rpx;
	}

	/* 底部tabbar假阴影 start*/
	.bg-tabbar-shadow {
		background-image: repeating-linear-gradient(to top, rgba(0, 0, 0, 0.1) 10rpx, #FFFFFF, #FFFFFF);
		position: fixed;
		bottom: 0;
		height: 450rpx;
		width: 100vw;
		z-index: -1;
	}

	@keyframes suspension {

		0%,
		100% {
			transform: translateY(0);
		}

		50% {
			transform: translateY(-0.6rem);
		}
	}

	@keyframes spin {
		0% {
			transform: rotateX(0deg);
		}

		100% {
			transform: rotateX(-360deg);
		}
	}

	@keyframes arc {
		to {
			transform: rotate(360deg);
		}
	}
</style>