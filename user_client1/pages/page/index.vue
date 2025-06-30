<template>
	<view class="template-health tn-safe-area-inset-bottom">
		<tn-nav-bar fixed :isBack="false" :bottomShadow="false" :backgroundColor="navBarBackgroundColor" v-if="showSearch">
			<view id="navbar" class="custom-nav tn-flex tn-flex-col-center tn-flex-row-left">
				<view class="custom-nav__back">
					<view class="logo-pic tn-shadow-blur" :style="'background-image:url('+ user.avatar +')'">
						<view class="logo-image">
						</view>
					</view>
				</view>
				<view @click="tl('/pages/search')" class="custom-nav__search tn-flex tn-flex-col-center tn-flex-row-center" :style="[navBarStyle]">
					<view class="custom-nav__search__box tn-flex tn-flex-col-center tn-flex-row-left"
						style="background-color: rgba(230,230,230,0.3);">
						<view class="custom-nav__search__icon tn-icon-search"></view>
						<view class="custom-nav__search__text tn-padding-left-xs">大家都在搜索...</view>
					</view>
				</view>
			</view>
		</tn-nav-bar>

		<!-- 轮播图开始 -->
		<swiper class="card-swiper" :circular="true" :autoplay="true" duration="500" interval="5000" @change="cardSwiper">
			<swiper-item v-for="(item,index) in swiperList" :key="index" :class="cardCur==index?'cur':''">
				<view class="swiper-item image-banner">
					<image :src="item.image" mode="aspectFill"></image>
				</view>
			</swiper-item>
		</swiper>
		<view class="indication">
			<block v-for="(item,index) in swiperList" :key="index">
				<view class="spot" :class="cardCur==index?'active':''"></view>
			</block>
		</view>
		<!-- 轮播图结束 -->

		<!-- 顶部主菜单开始-->
		<view class="tn-flex tn-margin-xs tn-padding-top-sm tn-color-white icon-function" id="page_tips">
			<view class="tn-flex-1 tn-padding-sm tn-margin-xs tn-radius" @click="tl('')">
				<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
					<view class="icon15__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-shadow-blur">
						<view class="tn-icon-scan"></view>
					</view>
					<view class="tn-text-center">
						<text class="tn-text-ellipsis">拍照试题</text>
					</view>
				</view>
			</view>
			<view class="tn-flex-1 tn-padding-sm tn-margin-xs tn-radius" @click="tl('/subpages/user/member')">
				<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
					<view class="icon15__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-shadow-blur ">
						<view class="tn-icon-vip"></view>
					</view>
					<view class="tn-text-center">
						<text class="tn-text-ellipsis">会员特权</text>
					</view>
				</view>
			</view>
			<view class="tn-flex-1 tn-padding-sm tn-margin-xs tn-radius" @click="tl('')">
				<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
					<view class="icon15__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-shadow-blur">
						<view class="tn-icon-folder-reduce"></view>
					</view>
					<view class="tn-text-center">
						<text class="tn-text-ellipsis">知识库</text>
					</view>
				</view>
			</view>
			<view class="tn-flex-1 tn-padding-sm tn-margin-xs tn-radius" @click="tl('')">
				<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
					<view class="icon15__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-shadow-blur">
						<view class="tn-icon-ai"></view>
					</view>
					<view class="tn-text-center">
						<text class="tn-text-ellipsis">体验AI</text>
					</view>
				</view>
			</view>
		</view>
		<!-- 顶部主菜单结束-->

		<!-- 菜单按钮开始-->
		<view class="health-shadow tn-margin tn-color-black tn-bg-white"
			style="position: relative;z-index: 1;padding: 20rpx 6rpx;">
			<view class="tn-flex tn-flex-wrap">
				<block v-for="(item, index) in menuList" :key="index">
					<view class="tn-margin-bottom-xl tn-radius tl-menu-item" v-if="index <= 4" @click="tl(item.url)">
						<!-- icon类型的菜单风格开始 -->
						<!-- <view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
							<view
								class="icon9__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-shadow-blur tn-bg-orange tn-color-white">
								<view class="tn-icon-chemistry"></view>
							</view>
							<view class="tn-color-black tn-text-sm tn-text-center">
								<text class="tn-text-ellipsis">{{item.title}}</text>
							</view>
						</view> -->
						<!-- icon类型的菜单风格结束 -->
						<!-- 图片模式的菜单开始 -->
						<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
							<view
								class="icon9__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-shadow-blur tn-color-white">
								<view style="width: 100%; height: 100%;">
									<image :src="item.image" style="width: 100%; height: 100%;"></image>
								</view>
							</view>
							<view class="tn-color-black tn-text-sm tn-text-center">
								<text class="tn-text-ellipsis">{{item.title}}</text>
							</view>
						</view>
						<!-- 图片模式的菜单结束 -->
					</view>
					<view class="tn-radius tl-menu-item" v-if="index > 4" @click="tl(item.url)">
						<!-- icon类型的菜单风格开始 -->
						<!-- <view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
							<view
								class="icon9__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-shadow-blur tn-bg-orange tn-color-white">
								<view class="tn-icon-chemistry"></view>
							</view>
							<view class="tn-color-black tn-text-sm tn-text-center">
								<text class="tn-text-ellipsis">{{item.title}}</text>
							</view>
						</view> -->
						<!-- icon类型的菜单风格结束 -->
						<!-- 图片模式的菜单开始 -->
						<view class="tn-flex tn-flex-direction-column tn-flex-row-center tn-flex-col-center">
							<view
								class="icon9__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-shadow-blur tn-color-white">
								<view style="width: 100%; height: 100%;">
									<image :src="item.image" style="width: 100%; height: 100%;"></image>
								</view>
							</view>
							<view class="tn-color-black tn-text-sm tn-text-center">
								<text class="tn-text-ellipsis">{{item.title}}</text>
							</view>
						</view>
						<!-- 图片模式的菜单结束 -->
					</view>
				</block>
			</view>
		</view>
		<!-- 菜单按钮结束-->

		<!-- 胶囊开始-->
		<!-- 		<view class="tn-flex tn-flex-wrap tn-padding-xs" style="margin-top: -30rpx;">
			<view class="" style="width: 100%;">
				<view class="image-piccapsule tn-shadow-blur"
					style="background-image:url('https://resource.tuniaokj.com/images/capsule-banner/banner-tnui.png');">
					<view class="image-capsule">
					</view>
				</view>
			</view>
		</view> -->
		<!-- 胶囊结束-->
		
		<!-- 热门题库开始 -->
		<view class="tn-flex tn-flex-row-between" v-if="questionLibHotList.length > 0">
			<view class="justify-content-item tn-margin tn-text-bold tn-text-lg">
				<text class="tn-icon-fire-fill tn-color-red"></text>
				<text>大家都在练</text>
			</view>
			<view class="justify-content-item tn-margin tn-text-sm" @click="tl('/subpages/exam/questionlib')">
				<text class="tn-padding-xs">更多</text>
				<text class="tn-icon-right-double"></text>
			</view>
		</view>
		
		<swiper class="card-collection-swiper2 tn-margin-top-sm tn-margin-left tn-margin-right" :circular="true"
			previous-margin="190rpx" next-margin="190rpx" :autoplay="false" :duration="2000" @change="resume">
			<swiper-item v-for="(item,index) in questionLibHotList" :key="index" :class="cardCur2==index?'cur':''">
				<view class="swiper-item"
				@click="tl('/subpages/exam/questionContent?uid=' + item.uid)"
					:style="'background-image:url('+ item.image + ');width:300rpx;height: 60%;background-size: cover;border-radius: 10rpx;'">
				</view>
				<view class="tn-text-ellipsis" style="height: 40%;width:300rpx">{{item.title}}</view>
			</swiper-item>
		</swiper>
		<!-- 热门题库结束 -->

		<!-- 推荐题库开始 -->
		<view class="" v-if="questionLibRecommendList.length > 0">
			<view class="tn-flex tn-flex-row-between">
				<view class="justify-content-item tn-margin tn-text-bold tn-text-lg">
					<text class="tn-icon-ticket tn-color-red"></text>
					<text>推荐题库</text>
				</view>
				<view class="justify-content-item tn-margin tn-text-sm" @click="tl('/subpages/exam/questionlib')">
					<text class="tn-padding-xs">更多</text>
					<text class="tn-icon-right-double"></text>
				</view>
			</view>

			<view class="tn-flex tn-margin-left tn-margin-right">
				<view class="list-container">
					<view class="list-item" v-for="(item, index) in questionLibRecommendList" :key="index"
						@click="tl('/subpages/exam/questionContent?uid=' + item.uid)">
						<view class="item-left">
							<image :src="item.image" mode="aspectFill"></image>
						</view>
						<view class="item-right">
							<text class="item-title tn-text-ellipsis-2">{{ item.title }}</text>
							<view class="item-info">
								<view class="tn-margin-right-lg">
									<text class="tn-icon-menu-circle tn-color-blue tn-padding-right-2"></text>
									<text>{{ item.cate_name }}</text>
								</view>
								<view class="tn-margin-right-lg">
									<text class="tn-icon-write tn-padding-right-2" :style="{color: mainColor}"></text>
									<text>{{ item.submit_count }}</text>
								</view>
							</view>
						</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 推荐题库结束 -->

		<!-- 推荐课程开始 -->
		<!-- <view class="tn-margin-top">
			<view class="tn-flex tn-flex-row-between">
				<view class="justify-content-item tn-margin tn-text-bold tn-text-lg">
					<text class="tn-icon-title tn-color-red"></text>
					<text>推荐课程</text>
				</view>
				<view class="justify-content-item tn-margin tn-text-sm">
					<text class="tn-padding-xs">更多</text>
					<text class="tn-icon-right-double"></text>
				</view>
			</view>

			<view class="tn-flex tn-margin-top tn-margin-left tn-margin-right">
				<view class="tn-flex tn-flex-wrap" style="margin: 0 0;">
					<block v-for="(item, index) in listData" :key="index">
						<view class="" style="width: 50%;"
							@click="bannerNav('/subpages/course/content/content?course_uid=' + item.uid)">
							<view class="product-content">
								<view class="image-pic" :style="'background-image:url(' + item.imageUrl + ')'">
									<view class="image-product">
										<view class="tn-flex tn-flex-col-center tn-text-center"
											style="height: 38rpx;position: absolute;top: 10rpx;left:10rpx;background-color: #00000080;border-radius: 10rpx;">
											<view class="tn-margin-xs tn-color-white">UI设计</view>
										</view>
										<view class="tn-text-df"
											style="width: 100%;height: 40rpx;background: linear-gradient(0deg, rgba(0,0,0,0.6), rgba(0,0,0,0));position: absolute;bottom: 0;">
											<view class="tn-padding-left-xs tn-padding-right-xs tn-color-white clamp-text-1">
												<text class="tn-icon-play-fill"></text>
												<text class="tn-padding-left-xs">12</text>
											</view>
										</view>
									</view>
								</view>

								<view class="tn-text-justify tn-padding-top-sm">
									<text class="clamp-text-2 item-title">{{ item.title }}</text>
								</view>
								<view class="tn-text-justify tn-padding-top-xs tn-flex tn-flex-row-left item-title">
									<text class="tn-text-sm tn-color-gray tn-padding-right-sm">共1课时</text>
									<text class="tn-text-sm tn-color-orangered tn-icon-eye">1</text>
								</view>
							</view>
						</view>
					</block>
				</view>
			</view>
		</view> -->
		<!-- 推荐课程结束 -->

		<view class="tn-padding-xl"></view>

		<nav-footer :currentIndex="0"></nav-footer>

		<view class="tn-padding-xl"></view>

	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'TemplateHealth',
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
				showSearch: true,
				menuList: [],
				cardCur: 0,
				swiperList: [],
				cardCur2: 0,
				resumeList: [{
					id: 0,
					type: 'image',
					title: '蔡东东',
					name: '产品总监',
					hot: '1.29W',
					share: '216',
					love: '962',
					avatar: 'https://resource.tuniaokj.com/images/blogger/avatar_4.jpeg',
					url: 'https://cdn.image.tutudati.com/uploads/images/20241123/2024112300404392f437510.jpg',
				}, {
					id: 1,
					type: 'image',
					title: '图鸟北北',
					name: 'UI设计师',
					hot: '964',
					share: '94',
					love: '186',
					avatar: 'https://resource.tuniaokj.com/images/blogger/avatar_1.jpeg',
					url: 'https://cdn.image.tutudati.com/uploads/images/20241123/2024112300404392f437510.jpg',
				}, {
					id: 2,
					type: 'image',
					title: '图鸟西西',
					name: '高级前端',
					hot: '3.26K',
					share: '146',
					love: '379',
					avatar: 'https://resource.tuniaokj.com/images/blogger/avatar_2.jpeg',
					url: 'https://cdn.image.tutudati.com/uploads/images/20241123/2024112300404392f437510.jpg',
				}, {
					id: 3,
					type: 'image',
					title: '图鸟南南',
					name: '项目经理',
					hot: '6.32K',
					share: '133',
					love: '432',
					avatar: 'https://resource.tuniaokj.com/images/blogger/avatar_3.jpeg',
					url: 'https://cdn.image.tutudati.com/uploads/images/20241123/2024112300404392f437510.jpg',
				}, {
					id: 4,
					type: 'image',
					title: '图鸟猪猪',
					name: '纯打杂',
					hot: '8.65K',
					share: '321',
					love: '886',
					avatar: 'https://resource.tuniaokj.com/images/blogger/blogger_beibei.jpg',
					url: 'https://cdn.image.tutudati.com/uploads/images/20241123/2024112300404392f437510.jpg',
				}],
				navBarRectInfo: {},
				navBarChangebaseLineHeight: 0,
				navBarStyle: {
					color: '#FFFFFF',
					opacity: 1,
					display: 'flex'
				},
				navBarBackgroundColor: 'rgba(255, 255, 255, 0)',
				activeBgAnimation: {},
				questionLibRecommendList: [],// 推荐题库
				questionLibHotList: [],// 热门题库
			}
		},
		onReady() {
			this.$nextTick(() => {
				this.initNavBarRectInfo()
			})
		},
		created() {
			this.fetchBanner()
			this.fetchMenu()
			this.fetchRecommendQuestionList()
			this.fetchHotQuestionList()
		},
		methods: {
			fetchRecommendQuestionList() {
				this.$api.apiRecommendQuestionLib({
					page_no: 1,
					page_size: 20,
					recommend_state: 1
				}).then(res => {
					this.questionLibRecommendList = res.data.lists
				})
			},
			fetchHotQuestionList() {
				this.$api.apiHotQuestionLib({
					page_no: 1,
					page_size: 20,
					hot_state: 1
				}).then(res => {
					this.questionLibHotList = res.data.lists
				})
			},
			fetchBanner() {
				this.$api.apiImageConfig({
					type: 'image_banner',
					position: 'home_top',
					client: this.$func.currentPlatform()
				}).then(res => {
					this.swiperList = res.data
				})
			},
			fetchMenu() {
				this.$api.apiImageConfig({
					type: 'image_menu',
					position: 'home_menu',
					client: this.$func.currentPlatform()
				}).then(res => {
					this.menuList = res.data
				})
			},
			updateSearchState(top) {
				this.showSearch = (top < 40 ? true : false)
			},
			tl(url) {
				console.log(url, '跳转地址')
				if(url === '') {
					this.$func.showToast('暂未开放')
					return
				}
				this.$func.navigatorTo(url)
			},
			// cardSwiper
			cardSwiper(e) {
				this.cardCur = e.detail.current
			},
			// resume
			resume(e) {
				this.cardCur2 = e.detail.current
			},
			// 初始化导航栏信息
			async initNavBarRectInfo() {
				const navBarRectInfo = await this._tGetRect('#navbar')
				const pageTipsRectInfo = await this._tGetRect('#page_tips')
				if (!navBarRectInfo.hasOwnProperty('top') || !pageTipsRectInfo.hasOwnProperty('top')) {
					setTimeout(() => {
						this.initNavBarRectInfo()
					}, 10)
					return
				}
				this.navBarRectInfo = {
					top: navBarRectInfo.top
				}
				this.navBarChangebaseLineHeight = pageTipsRectInfo.top - navBarRectInfo.top
			},
			// 更新导航栏信息
			updateNavBarRectInfo() {
				this._tGetRect('#page_tips').then((res) => {
					const top = res?.top || 0
					if (!top) {
						return
					}
					const differHeight = top - this.navBarRectInfo.top
					const opacity = differHeight / this.navBarChangebaseLineHeight
					if (opacity < 0) {
						this.navBarStyle.color = 'rgba(0, 0, 0, ${opacity})'
						this.navBarBackgroundColor = `rgba(255, 255, 255, 1)`
					} else {
						this.navBarStyle.color = 'rgba(255, 255, 255, 1)'
						this.navBarBackgroundColor = `rgba(255, 255, 255, ${1 - opacity})`
					}
				})
			},
			// 跳转到
			navTuniaoUI(e) {
				uni.navigateTo({
					url: '/pages/index/index'
				})
			},
		},
	}
</script>

<style lang="scss" scoped>
	@import '@/scss/custom_nav_bar.scss';

	// 推荐课程开始
	.product-content {
		// box-shadow: 0rpx 0rpx 50rpx 0rpx rgba(0, 0, 0, 0.07);
		border-radius: 15rpx;
		// background-color: rgba(255, 255, 255, 1);
		margin: 10rpx 10rpx 30rpx 10rpx;
	}

	.image-product {
		height: 180rpx;
		font-size: 16rpx;
		font-weight: 300;
		position: relative;
		border-radius: 15rpx;
		overflow: hidden;
	}

	.image-pic {
		background-size: cover;
		background-repeat: no-repeat;
		// background-attachment:fixed;
		background-position: center;
		border-radius: 15rpx;
	}

	/* 内容 end*/

	/* 文字截取*/
	.clamp-text-1 {
		-webkit-line-clamp: 1;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		text-overflow: ellipsis;
		overflow: hidden;
	}

	.clamp-text-2 {
		-webkit-line-clamp: 2;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		text-overflow: ellipsis;
		overflow: hidden;
	}

	.clamp-text-3 {
		-webkit-line-clamp: 3;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		text-overflow: ellipsis;
		overflow: hidden;
	}

	// 推荐课程结束

	.template-health {
		background-color: #FFF;
	}

	.tl-menu-item {
		width: 20%;
	}

	// 推荐试卷开始
	.list-container {
		// padding: 0 30rpx;
		width: 100%;
	}

	.list-item {
		display: flex;
		padding: 30rpx 0;
		border-bottom: 1rpx solid #eee;
	}

	.item-left {
		width: 200rpx;
		height: 140rpx;
		margin-right: 20rpx;
	}

	.item-left image {
		width: 100%;
		height: 100%;
		border-radius: 8rpx;
	}

	.item-right {
		flex: 1;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}

	.item-title {
		font-size: 28rpx;
		font-weight: 500;
		letter-spacing: 2rpx;
		line-height: 1.4;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
	}

	.item-info {
		display: flex;
		align-items: center;
		font-size: 28rpx;
		color: #666;
	}

	// 推荐试卷结束
	.icon-function {
		position: relative;
		z-index: 1;
		margin: 20rpx 5rpx;
		margin-top: -420rpx;
	}

	/* 轮播视觉差 start */
	.card-swiper {
		height: 600rpx !important;
	}

	.card-swiper swiper-item {
		width: 750rpx !important;
		left: 0rpx;
		box-sizing: border-box;
		// padding: 0rpx 30rpx 90rpx 30rpx;
		overflow: initial;
	}

	.card-swiper swiper-item .swiper-item {
		width: 100%;
		display: block;
		height: 100%;
		transform: scale(1);
		transition: all 0.2s ease-in 0s;
		overflow: hidden;
	}

	.card-swiper swiper-item.cur .swiper-item {
		transform: none;
		transition: all 0.2s ease-in 0s;
	}

	.image-banner {
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.image-banner image {
		width: 100%;
		height: 100%;
	}

	/* 轮播指示点 start*/
	.indication {
		z-index: 9999;
		width: 100%;
		height: 36rpx;
		position: absolute;
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: center;
		opacity: 0;
	}

	.spot {
		background-color: #FFFFFF;
		opacity: 0.6;
		width: 10rpx;
		height: 10rpx;
		border-radius: 20rpx;
		top: -60rpx;
		margin: 0 8rpx !important;
		position: relative;
	}

	.spot.active {
		opacity: 1;
		width: 30rpx;
		background-color: #FFFFFF;
	}

	/* 简历推荐 start */
	.card-swiper2 {
		height: 420rpx !important;
		overflow: hidden;
	}

	.card-collection-swiper2 {
		height: 200rpx !important;
		// overflow: hidden;
	}

	.card-swiper2 swiper-item {
		width: 680rpx !important;
		left: 30rpx;
		box-sizing: border-box;
		overflow: initial;
		padding: 0 0rpx 40rpx 0;
	}

	.card-swiper2 swiper-item .swiper-item {
		width: 100%;
		display: block;
		height: 100%;
		// transform: scale(1);
		// transition: transform 0.2s ease-out 0s;
	}

	.card-swiper2 swiper-item.cur .swiper-item {
		// transform: scale(1);
	}

	.card-swiper2 swiper-item .swiper-item2 {
		width: 100%;
		display: block;
		height: 50%;
		border-radius: 50%;
		transform: translate(480rpx, -300rpx) scale(0.9);
		transition: transform 0.3s ease-out 0s;
	}

	.card-swiper2 swiper-item.cur .swiper-item2 {
		transform: translate(510rpx, -320rpx) scale(0.9);
	}

	.card-swiper2 swiper-item .swiper-item-text {
		width: 100%;
		display: block;
		height: 100%;
		border-radius: 10rpx;
		transform: translate(20rpx, -420rpx) scale(0.8);
		transition: transform 0.6s ease-out 0s;
		overflow: hidden;
	}

	.card-swiper2 swiper-item.cur .swiper-item-text {
		transform: translate(20rpx, -450rpx) scale(0.9);
	}





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
				// border-radius: 50%;
				margin-bottom: 0rpx;
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


	/* 图标容器9 start */
	.icon9 {
		&__item {
			width: 30%;
			background-color: #FFFFFF;
			border-radius: 10rpx;
			transform: scale(1);
			transition: transform 0.3s linear;
			transform-origin: center center;

			&--icon {
				width: 80rpx;
				height: 80rpx;
				font-size: 50rpx;
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
					background-image: url(https://resource.tuniaokj.com/images/cool_bg_image/icon_bg6.png);
				}
			}
		}
	}


	/* 阴影 start*/
	.health-shadow {
		border-radius: 15rpx;
		box-shadow: 0rpx 0rpx 50rpx 0rpx rgba(0, 0, 0, 0.07);
	}

	/* 自定义导航栏内容 start */
	.custom-nav {
		height: 100%;

		&__back {
			margin: auto 5rpx;
			font-size: 40rpx;
			margin-right: 10rpx;
			margin-left: 30rpx;
			flex-basis: 5%;
		}

		&__search {
			flex-basis: 60%;
			width: 100%;
			height: 100%;

			&__box {
				width: 100%;
				height: 70%;
				padding: 10rpx 0;
				margin: 0 30rpx;
				border-radius: 60rpx 60rpx 0 60rpx;
				font-size: 24rpx;
			}

			&__icon {
				padding-right: 10rpx;
				margin-left: 20rpx;
				font-size: 30rpx;
			}

			&__text {
				// color: #AAAAAA;
			}
		}
	}

	.logo-image {
		width: 65rpx;
		height: 65rpx;
		position: relative;
	}

	.logo-pic {
		background-size: cover;
		background-repeat: no-repeat;
		// background-attachment:fixed;
		background-position: top;
		border-radius: 50%;
	}

	/* 自定义导航栏内容 end */


	/* 热门图片 start*/
	.image-tuniao1 {
		padding: 164rpx 0rpx;
		font-size: 40rpx;
		font-weight: 300;
		position: relative;
	}

	.image-tuniao2 {
		padding: 75rpx 0rpx;
		font-size: 40rpx;
		font-weight: 300;
		position: relative;
	}

	.image-tuniao3 {
		padding: 90rpx 0rpx;
		font-size: 40rpx;
		font-weight: 300;
		position: relative;
	}

	.image-pic {
		background-size: cover;
		background-repeat: no-repeat;
		// background-attachment:fixed;
		background-position: top;
		border-radius: 10rpx;
	}

	/* 胶囊banner*/
	.image-capsule {
		padding: 100rpx 0rpx;
		font-size: 40rpx;
		font-weight: 300;
		position: relative;
	}

	.image-piccapsule {
		background-size: cover;
		background-repeat: no-repeat;
		// background-attachment:fixed;
		background-position: top;
		border-radius: 20rpx 20rpx 0 0;
	}

	/* 标题 start */
	.nav_title {
		-webkit-background-clip: text;
		color: transparent;

		&--wrap {
			position: relative;
			display: flex;
			height: 120rpx;
			font-size: 46rpx;
			align-items: center;
			justify-content: center;
			font-weight: bold;
			background-image: url(https://resource.tuniaokj.com/images/title_bg/title00.png);
			background-size: cover;
		}
	}

	/* 标题 end */
</style>