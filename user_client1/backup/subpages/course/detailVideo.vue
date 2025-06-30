<template>
	<view class="template-news tn-safe-area-inset-bottom">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">课程详情</text>
			</view>
		</tn-nav-bar>

		<view class="tl-video" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<video style="width: 100%; height: 100%;" :src="courseContent.src" :enable-play-gesture="true"
				:show-progress="true" :object-fit="cover" :title="courseContent.title" :controls="true"></video>
		</view>

		<view class="tn-margin-top-xs">
			<view class="nav_title--wrap">
				<view class="nav_title tn-padding-sm tn-text-bold">
					<text>{{courseContent.title}}</text>
				</view>
			</view>
			
			<!-- 课程tab开始 -->
			<view class="tn-padding-top-sm tn-padding-bottom-sm tn-text-xs tn-bg-white tl-bottom-line">
				<tn-tabs :list="tabList" bold="true" :activeColor="mainColor" :badgeOffset="badgeOffset" :isScroll="false"
					:current="currentTab" name="title" @change="tabChange"></tn-tabs>
			</view>
			<!-- 课程tab结束 -->
			
			<!-- 课程章节开始 -->
			<view class="content-backgroup tab-content" v-if="currentTab === 1">
				<view class="tn-bg-white">
					<view class="nav_title--wrap">
						<view class="nav_title tn-margin-left tn-margin-right tn-margin-top" style="width: 95%;">
							<view v-for="(item, index) in chapterList" :key="index">
								<view class="tn-text-bold fs-14">第{{index + 1}}章 {{item.title}}</view>
								<view class="tn-padding-bottom">
									<view class="tn-padding-top" v-for="(i, k) in item.children" @click="tl(i)">
										<text v-if="i.type === 1" class="tn-icon-order tn-padding-right-sm"></text>
										<text v-if="i.type === 2" class="tn-icon-video tn-padding-right-sm"></text>
										<text v-if="i.type === 3" class="tn-icon-voice tn-padding-right-sm"></text>
										<text v-if="i.type === 4" class="tn-icon-edit-form tn-padding-right-sm"></text>
										<text v-if="i.price_state === 2" class="tn-icon-vip-text main-color fs-18"></text>
										<text v-if="i.type !== 1 && i.type !== 4" class="tn-padding-right-sm fs-14">{{index + 1}}-{{k + 1}} {{i.title}}{{`(`+ i.time + `)`}}</text>
										<text v-if="i.type == 1 || i.type === 4" class="tn-padding-right-sm fs-14">{{index + 1}}-{{k + 1}} {{i.title}}</text>
										<view class="tl-bottom-line tn-padding-top-sm"></view>
									</view>
								</view>
							</view>
						</view>
					</view>
				</view>
			</view>
			<!-- 课程章节结束 -->
			
			<!-- 课程资料开始 -->
			<view class="content-backgroup tab-content" v-if="currentTab === 3">
				<view class="tn-bg-white">
					<view class="nav_title--wrap">
						<view class="nav_title tn-margin-left tn-margin-right tn-margin-top" style="width: 95%;">
							<view v-for="(item, index) in resourceList" :key="index">
								<view class="tn-padding-bottom">
									<view class="fs-14" @click="copyContent(item.url)">
										<view class="">{{index + 1}}、{{item.title}}</view>
										<view class="tl-bottom-line tn-padding-top-sm"></view>
									</view>
								</view>
							</view>
						</view>
					</view>
				</view>
			</view>
			<!-- 课程资料结束 -->
		</view>
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'TemplateNews',
		mixins: [template_page_mixin],
		data() {
			return {
				tabList: [{
					title: '课程问答',
					count: 12
				}, {
					title: '相关课程'
				}, {
					title: '课程笔记',
					count: 1
				}, {
					title: '课程资料',
					count: 0
				}],
				badgeOffset: [20, 46],
				currentTab: 3,
				mainColor: getApp().globalData.mainColor,
				searchWhere: { // 文章查询条件
					uid: "",
				},
				courseContent: {
					title: 'PHP是世界上最好的编程语言是世界上最好的编程语言是世界上最好的编程语言',
					src: 'http://cdn.image.tutudati.com/tldemo.mp4',
				},
				resourceList: [{
					uid: '',
					title: '尚硅谷MySQL高级课程pdf百度网盘',
					url: 'https://www.tututdati.com'
				},{
					uid: '',
					title: '尚硅谷MySQL高级课程pdf百度网盘',
					url: 'https://www.tututdati.com'
				},{
					uid: '',
					title: '尚硅谷MySQL高级课程pdf百度网盘',
					url: 'https://www.tututdati.com'
				},],
				chapterList: [{
					title: '基础入门',
					children: [{
						uid: '',
						title: '环境搭建这是课程详情内容这是课程详情内容这是课程详情内容',
						type: 1,
						time: '',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 2,
						time: '22:00',
						price_state: 2,
					}, {
						uid: '',
						title: '环境搭建',
						type: 3,
						time: '22:00',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 4,
						time: '22:00',
						price_state: 2,
					}]
				}, {
					title: '环境搭建',
					children: [{
						uid: '',
						title: '环境搭建这是课程详情内容这是课程详情内容这是课程详情内容',
						type: 1,
						time: '',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 2,
						time: '22:00',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 3,
						time: '22:00',
						price_state: 2,
					}, {
						uid: '',
						title: '环境搭建',
						type: 4,
						time: '22:00',
						price_state: 1,
					}]
				}, {
					title: '环境搭建',
					children: [{
						uid: '',
						title: '环境搭建这是课程详情内容这是课程详情内容这是课程详情内容',
						type: 1,
						time: '',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 2,
						time: '22:00',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 3,
						time: '22:00',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 4,
						time: '22:00',
						price_state: 1,
					}]
				}, {
					title: '环境搭建',
					children: [{
						uid: '',
						title: '环境搭建这是课程详情内容这是课程详情内容这是课程详情内容',
						type: 1,
						time: '',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 2,
						time: '22:00',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 3,
						time: '22:00',
						price_state: 1,
					}, {
						uid: '',
						title: '环境搭建',
						type: 4,
						time: '22:00',
						price_state: 1,
					}]
				}, ]
			}
		},
		onLoad(params) {
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: false,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
			this.searchWhere.uid = params.uid || ""
			// this.getArticleContent()
		},
		methods: {
			copyContent(content) {
				this.$func.setClipboardData(content, '链接复制成功')
			},
			// 中间菜单切换
			tabChange(e) {
				this.currentTab = e
			},
			// 获取文章内容
			getArticleContent() {
				uni.showLoading({
					title: "努力加载中",
					icon: "none"
				})
				this.$api.apiArticleContent(this.searchWhere).then(res => {
					if (res.code == 100) {
						this.articleContent = res.data
						return
					}
					this.$func.showToast(res.msg)
				}).finally(() => {
					uni.hideLoading()
				})
			},
			feekback() {
				this.$func.showToast('暂未开放')
			},
			// 文章订阅
			subscribe() {
				this.$func.templateSubscribe('article_update')
			},
			// 文章收藏或者点赞
			submitCollection(type) {
				if (this.articleContent.is_collect === 1 && type === 2) {
					this.$func.showToast("你已点在看")
					return
				} else if (this.articleContent.is_click === 1 && type === 1) {
					this.$func.showToast("你已点赞")
					return
				}
				this.$api.apiArticleCollect({
					uid: this.searchWhere.uid,
					type: type
				}).then(res => {
					if (res.code == 100) {
						this.articleContent.collect_count = this.articleContent.collect_count + 1
						if (type === 1) {
							this.articleContent.is_click = 1
							this.articleContent.like_count += 1
						} else if (type === 2) {
							this.articleContent.is_collect = 1
							this.articleContent.collect_count += 1
						}
					}
					if (res.code === 101 && res.data.code === 1) {
						if (type === 1) {
							this.articleContent.is_click = 1
						} else if (type === 2) {
							this.articleContent.is_collect = 1
						}
					}
					this.$func.showToast(res.msg)
				})
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

	.template-news {
		background-color: #fff;
	}
	
	.tab-content {
		min-height: 600rpx;
	}

	.chapter-container {
		width: 100%;
		height: 400rpx;
	}

	.chapter-item {
		width: 300rpx;
		height: 100%;
	}

	.tl-video {
		width: 100%;
		height: 600rpx;
	}

	// 底部操作按钮开始
	.bottom-menu {
		width: 25%;

		&--icon {
			font-size: 34rpx;
		}

		&--text {
			font-size: 20rpx;
		}
	}

	// 底部操作按钮结束
	/* 标题 start */
	.nav_title {
		-webkit-background-clip: text;

		&--wrap {
			// height: 120rpx;
			font-size: 30rpx;
			align-items: center;
			// justify-content: center;
			// font-weight: bold;
			background-image: url('/static/image/title00.png');
			background-size: cover;
		}
	}

	/* 标题 end */
</style>