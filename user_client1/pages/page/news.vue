<template>
	<view class="page tn-safe-area-inset-bottom">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">图文资讯</text>
			</view>
		</tn-nav-bar>
		<view :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<!-- 顶部搜索 -->
			<view class="search-box" :style="{top: vuex_custom_bar_height + 'px'}">
				<text class="tn-icon-menu fs-22" style="color: #8b9aae;" @click="showCategoryMenu = true"></text>
				<view class="acea-row row-middle relative search-item">
					<input type="text" placeholder-class="tn-icon-search plaClass" placeholder="搜索点什么呢" class="input"
						v-model="queryParams.keyword" confirm-type="search" @confirm="search" />
					<view class="search-btn absolute" @click="search">搜索</view>
				</view>
			</view>
			<view class="exam-ul">
				<scroll-view>
					<block v-for="(it, index) in newsList" :key="index">
						<view class="tn-flex exam-li mt-10" @click="tl('/subpages/news/content?uid=' + it.id)">
							<view class="txt tn-flex tn-flex-direction-column">
								<view class="fs-16 tn-text-ellipsis-2 news-title">{{it.title}}</view>
								<view class="acea-row row-middle tn-color-gray">
									<view>
										<text class="tn-icon-bookmark"></text>
										<text class="ml-5">{{it.cate_name}}</text>
									</view>
									<view class="tn-margin-left-sm">
										<text class="tn-icon-time"></text>
										<text class="ml-5">{{it.create_time}}</text>
									</view>
								</view>
							</view>
							<view class="" style="height: 100%;">
								<view style="height: 100%;">
									<image :src="it.image" class="pic"></image>
								</view>
							</view>
						</view>
					</block>
				</scroll-view>
			</view>
			<!-- 资源列表为空开始 -->
			<view :style="{paddingTop: vuex_custom_bar_height * 2 + 'px'}" v-if="newsList.length === 0">
				<tn-empty mode="list" text="暂无图文数据"></tn-empty>
			</view>
			<!-- 资源列表为空结束 -->
			<view class="tn-tabbar-height"></view>
		</view>
		<!-- 选择器 -->
		<view class="">
			<tn-select v-model="showCategoryMenu" :confirmColor="mainColor" valueName="id" labelName="name"
				mode="multi-auto" :list="categoryList" @confirm="categoryConfirm"></tn-select>
		</view>
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'pageB',
		mixins: [template_page_mixin],
		components: {},
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				queryParams: {
					page_no: 1,
					page_size: 20,
					keyword: '',
					cid: '',
				},
				showCategoryMenu: false,
				newsList: [],
				categoryList: [],
			}
		},
		onLoad(option) {
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: true,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
			this.queryParams.category_uid = option.category_uid || ''
		},
		created() {
			this.fetchNewsList()
			this.fetchCategoryList()
		},
		methods: {
			categoryConfirm(e) {
				this.queryParams.cid = e[0].value
				this.queryParams.page_no = 1
				this.newsList = []
				this.fetchNewsList()
			},
			search() {
				this.queryParams.page_no = 1
				this.newsList = []
				this.fetchNewsList()
			},
			fetchNewsList() {
				uni.showLoading({
					title: '努力加载中'
				})
				this.$api.apiArtcileList(this.queryParams).then(res => {
					this.newsList.push(...res.data.lists)
					this.queryParams.page_no += 1
					uni.hideLoading()
				})
			},
			fetchCategoryList() {
				this.$api.apiArticleCateList().then(res => {
					this.categoryList = res.data
				})
			},
			tl(url) {
				this.$func.navigatorTo(url)
			}
		}
	}
</script>

<style scoped lang="scss">
	@import "@/scss/custom_nav_bar.scss";

	/deep/ .plaClass {
		color: #999;
		text-align: start;
	}

	.news-title {
		letter-spacing: 1rpx;
		font-size: 30rpx;
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
		padding-top: 70rpx;
		width: 98%;
		margin-left: 1%;

		.exam-li {
			background: #fff;
			border-radius: 10rpx;
			padding: 20rpx;
			// height: 240rpx;
			position: relative;

			.txt {
				width: calc(100% - 200rpx);
				justify-content: space-between;
			}

			.pic {
				width: 200rpx;
				height: 150rpx;
				border-radius: 10rpx;
			}
		}

	}

	.fs-16 {
		font-size: 30rpx;
	}
</style>