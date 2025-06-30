<template>
	<view class="template-product tn-safe-area-inset-bottom">
		<!-- 顶部自定义导航 -->
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">课程详情</text>
			</view>
		</tn-nav-bar>
		<!-- 课程基础信息开始 -->
		<view :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<view class="tn-flex tn-flex-row-left" style="width: 100%;height: 300rpx;">
				<view style="width: 40%; height: 100%;" class="tn-padding">
					<image :src="courseContent.cover" style="width: 100%; height: 100%; border-radius: 10rpx;"></image>
				</view>
				<view style="width: 60%; height: 100%; display: flex; flex-direction: column; justify-content: space-between"
					class="tn-padding tn-text-left">
					<view>
						<view class="">{{courseContent.title}}</view>
						<view class="tn-padding-top-sm tn-color-gray">
							<text>{{courseContent.category.title}}</text>
							<text class="tn-icon-title"></text>
							<text>{{courseContent.author}}</text>
						</view>
					</view>
					<view style="font-size: 36rpx;">
						<view class="tn-text-bold tn-color-red">{{courseContent.price}}</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 课程基础信息结束 -->

		<view class="tn-bg-white">
			<view class="tn-flex tn-flex-row-between tn-margin tn-text-center tn-padding-bottom tn-padding-top">
				<view class="justify-content-item">
					<view class="tn-color-gray">学习人数</view>
					<view class="tn-padding-top-sm">{{courseContent.study_count}}人</view>
				</view>
				<view class="justify-content-item">
					<view class="tn-color-gray">课程难度</view>
					<view class="tn-padding-top-sm">{{courseContent.level}}</view>
				</view>
				<view class="justify-content-item">
					<view class="tn-color-gray">课程进度</view>
					<view class="tn-padding-top-sm">{{courseContent.state}}</view>
				</view>
				<view class="justify-content-item">
					<view class="tn-color-gray">课程评分</view>
					<view class="tn-padding-top-sm">{{courseContent.score}}分</view>
				</view>
			</view>
		</view>

		<!-- <view class="tn-strip-bottom"></view> -->

		<!-- 课程tab开始 -->
		<view class="tn-padding-top-sm tn-padding-bottom-sm tn-text-xs tn-bg-white">
			<tn-tabs :list="tabList" bold="true" :activeColor="mainColor" :badgeOffset="badgeOffset" :isScroll="false"
				:current="currentTab" name="title" @change="tabChange"></tn-tabs>
		</view>
		<!-- 课程tab结束 -->

		<!-- 课程介绍开始 -->
		<view class="content-backgroup tab-content" v-if="currentTab === 0">
			<view class="tn-bg-white">
				<view class="nav_title--wrap">
					<view class="nav_title tn-margin-left tn-margin-right" :style="{backgroundColor: mainColor}">
						<mp-html :content="courseContent.content"></mp-html>
					</view>
				</view>
			</view>
		</view>
		<!-- 课程介绍结束 -->

		<!-- 课程章节开始 -->
		<view class="content-backgroup tab-content" v-if="currentTab === 1">
			<view class="tn-bg-white">
				<view class="nav_title--wrap">
					<view class="nav_title tn-margin-left tn-margin-right" style="width: 100%;">
						<view v-for="(item, index) in courseContent.chapterList" :key="index">
							<view class="tn-text-bold fs-14">第{{index + 1}}章 {{item.title}}</view>
							<view class="tn-padding-bottom">
								<view class="tn-padding-top" v-for="(i, k) in item.children" @click="tl(i)">
									<text v-if="i.type === 1" class="tn-icon-order tn-padding-right-sm"></text>
									<text v-if="i.type === 2" class="tn-icon-video tn-padding-right-sm"></text>
									<text v-if="i.type === 3" class="tn-icon-voice tn-padding-right-sm"></text>
									<text v-if="i.type === 4" class="tn-icon-edit-form tn-padding-right-sm"></text>
									<text v-if="i.type !== 1 && i.type !== 4" class="tn-padding-right-sm fs-14">{{index + 1}}-{{k + 1}} {{i.title}}{{`(`+ i.time + `)`}}</text>
									<text v-if="i.type === 1 || i.type === 4" class="tn-padding-right-sm fs-14">{{index + 1}}-{{k + 1}} {{i.title}}</text>
									<view class="tl-bottom-line tn-padding-top-sm"></view>
								</view>
							</view>
						</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 课程章节结束 -->

		<view id="top-info" class="tn-footerfixed tn-safe-area-inset-bottom tn-bg-white tn-padding"
			:style="{transform: `translateY(${topInfoTranslateY}px)`}">
			<tn-button :backgroundColor="mainColor" fontColor="#fff" width="100%" height="84rpx"
				fontSize="32">立即学习</tn-button>
		</view>

		<view class='tn-tabbar-height'></view>
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'TemplateProduct',
		mixins: [template_page_mixin],
		data() {
			return {
				tabList: [{
					title: '课程介绍'
				}, {
					title: '课程目录'
				}, {
					title: '课程评价',
					count: 0
				}],
				badgeOffset: [20, 46],
				currentTab: 1,
				topInfo: {
					height: 0,
				},
				topInfoTranslateY: 0,
				courseUid: "", // 课程uid
				courseContent: {
					uid: '',
					cover: 'https://cdn.image.tutudati.com/uploads/images/20241010/202410101739584c2975812.png',
					title: '2025年最全PHP课程2025年最全PHP课程2025年最全PHP课程',
					level: '较难',
					author: '兔兔答题',
					category: {
						uid: '',
						title: '计算机'
					},
					state: '完结',
					time: '21小时',
					study_count: 12,
					score: 9.01,
					price: 10.01,
					content: '<p>这是课程详情内容</p>',
					chapterList: [{
						title: '基础入门',
						children: [{
							uid: '',
							title: '环境搭建这是课程详情内容这是课程详情内容这是课程详情内容',
							type: 1,
							time: ''
						}, {
							uid: '',
							title: '环境搭建',
							type: 2,
							time: '22:00'
						}, {
							uid: '',
							title: '环境搭建',
							type: 3,
							time: '22:00'
						}, {
							uid: '',
							title: '环境搭建',
							type: 4,
							time: '22:00'
						}]
					}, {
						title: '环境搭建',
						children: [{
							uid: '',
							title: '环境搭建这是课程详情内容这是课程详情内容这是课程详情内容',
							type: 1,
							time: ''
						}, {
							uid: '',
							title: '环境搭建',
							type: 2,
							time: '22:00'
						}, {
							uid: '',
							title: '环境搭建',
							type: 3,
							time: '22:00'
						}, {
							uid: '',
							title: '环境搭建',
							type: 4,
							time: '22:00'
						}]
					}, {
						title: '环境搭建',
						children: [{
							uid: '',
							title: '环境搭建这是课程详情内容这是课程详情内容这是课程详情内容',
							type: 1,
							time: ''
						}, {
							uid: '',
							title: '环境搭建',
							type: 2,
							time: '22:00'
						}, {
							uid: '',
							title: '环境搭建',
							type: 3,
							time: '22:00'
						}, {
							uid: '',
							title: '环境搭建',
							type: 4,
							time: '22:00'
						}]
					}, {
						title: '环境搭建',
						children: [{
							uid: '',
							title: '环境搭建这是课程详情内容这是课程详情内容这是课程详情内容',
							type: 1,
							time: ''
						}, {
							uid: '',
							title: '环境搭建',
							type: 2,
							time: '22:00'
						}, {
							uid: '',
							title: '环境搭建',
							type: 3,
							time: '22:00'
						}, {
							uid: '',
							title: '环境搭建',
							type: 4,
							time: '22:00'
						}]
					}, ]
				}, // 课程内容
				currentChapter: 0, // 当前课程章节
				showAd: getApp().globalData.showAd,
				mainColor: getApp().globalData.mainColor,
			}
		},
		onReady() {
			this.getTopInfoRect()
		},
		onLoad(params) {
			this.courseUid = params.course_uid || ""
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: false
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
		},
		onShow() {
			// this.getCourseContent()
			// this.getChatperList()
		},
		methods: {
			tl(row) {
				if (row.type == 1) {
					this.$func.navigatorTo('/subpages/course/detailArticle?uid=' + row.uid)
				} else if (row.type == 2) {
					this.$func.navigatorTo('/subpages/course/detailVideo?uid=' + row.uid)
				} else if (row.type == 3) {
					this.$func.navigatorTo('/subpages/course/detailAudio?uid=' + row.uid)
				} else if (row.type == 4) {
					
				} else {
					this.$func.showToast('暂不支持章节类型')
				}
			},
			playCourse(item) {
				this.playType = item.type
				if (item.type === 1 || item.type === 2) {
					this.playTitle = item.title
					this.playAttacheUrl = item.attache_url
					uni.pageScrollTo({
						scrollTop: 0
					})
				} else if (item.type === 3) {
					// 文章阅读
					this.$func.navigatorTo('/subpages/course/article/content?uid=' + item.uid)
				} else if (item.type === 4) {
					this.$func.showToast('暂未开放哦')
				}
			},
			// 中间菜单切换
			tabChange(e) {
				this.currentTab = e
			},
			// 课程收藏
			collect() {
				if (this.courseContent.is_collect) {
					this.$func.showToast("已收藏")
					this.courseContent.is_collect = true
					return
				} else {
					this.$api.apiCourseCollection({
						uid: this.collectionUid
					}).then(res => {
						if (res.code == 100) {
							this.courseContent.is_collect = true
							this.courseContent.collect += 1
						}
						this.$func.showToast(res.msg)
					})
				}
			},
			// 点击课程章节
			collapseItem(index) {
				console.log(index)
				this.currentChapter = index
			},
			// 获取课程章节
			getChatperList() {
				this.$api.apiCourseChapterList({
					course_uid: this.courseUid
				}).then(res => {
					if (res.code === 100) {
						this.chapterList = res.data
						return
					}
					this.$func.showTotast(res.msg)
				})
			},
			// 音频播放处理事件
			audioStartPlay() {
				this.playStatus = true
			},
			audioStopPlay() {
				this.playStatus = false
			},
			audiShareAction() {
				this.$func.showToast('分享成功')
			},
			audioCollectionAction() {
				this.$func.showToast('收藏成功')
			},
			// 音频处理事件结束
			// 查询课程详情
			getCourseContent() {
				uni.showLoading({
					title: "努力加载中",
					icon: "none"
				})
				this.$api.apiCourseContent({
					uid: this.courseUid
				}).then(res => {
					uni.hideLoading()
					if (res.code == 100) {
						this.courseContent = res.data
						return
					}
					this.$func.showTotast(res.msg)
				})
			},
			onlineExam(uid) {
				this.$api.apiGetUserBasicInfo().then(res => {
					if (res.code == 100) {
						if (this.collectionContent.repeat_count <= this.collectionContent.submit_count) {
							this.$func.showToast('已超过答题次数')
							return
						}
						if (!this.collectionContent.submit_state) {
							this.$func.showToast('不在作答时间范围')
							return
						}
						if (this.collectionContent.collection_type === 'question_type' || this.collectionContent
							.collection_type === 'exam_type') {
							if (!this.collectionContent.is_form && this.collectionContent.require_form == 1) {
								this.tn("/subpages/exam/consult/form?uid=" + uid)
							} else {
								this.tn("/subpages/exam/submit/submit?uid=" + uid)
							}
						} else if (this.collectionContent.collection_type === 'attach_collection') {
							if (!this.collectionContent.is_form && this.collectionContent.require_form == 1) {
								this.tn("/subpages/exam/consult/form?uid=" + uid)
							} else {
								this.tn('/subpages/exam/collection/attache?url=' + this.collectionContent.attache +
									"&is_download=" + this.collectionContent.is_download)
							}
						} else {
							this.$func.showToast('暂不支持的课程类型')
						}
					} else {
						this.$func.showToast("请先登录")
						this.tn("/subpages/user/login")
					}
				})
			},
			tn(e) {
				this.$func.navigatorTo(e)
			},
			// 微信订阅消息
			async subscribe() {
				let subscribeResult = await this.$func.templateSubscribe("course_update_alter")
				let code = subscribeResult.code || 0
				if (code == 100) {
					this.$func.showToast("订阅成功")
					return
				}
				this.$func.showToast("订阅失败")
			},
			// 获取顶部销售信息容器相关信息
			getTopInfoRect() {
				this._tGetRect('#top-info').then((res) => {
					if (!res) {
						setTimeout(() => {
							this.getTopInfoRect()
						}, 50)
						return
					}
					this.topInfo.height = res.height
				})
			},
		},
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";

	.tab-content {
		min-height: 600rpx;
		padding: 0 0 100rpx 0;
	}

	.tn-tabbar-height {
		height: calc(40rpx + env(safe-area-inset-bottom) / 2);
	}


	/* 间隔线 start*/
	.tn-strip-bottom-min {
		width: 100%;
		border-bottom: 1rpx solid #F8F9FB;
	}

	/* 间隔线 start*/
	.tn-strip-bottom {
		width: 100%;
		border-bottom: 20rpx solid rgba(241, 241, 241, 0.8);
	}

	/* 间隔线 end*/
	/* 标题 start */
	.nav_title {
		-webkit-background-clip: text;
		// color: transparent;

		&--wrap {
			position: relative;
			display: flex;
			min-height: 100rpx;
			align-items: center;
			justify-content: left;
			background-image: url('/static/image/title44.png');
			background-size: cover;
		}
	}

	/* 标题 end */
	/* 底部*/
	.tn-footerfixed {
		position: fixed;
		background-color: rgba(255, 255, 255, 0.5);
		box-shadow: 0rpx 0rpx 30rpx 0rpx rgba(0, 0, 0, 0.07);
		bottom: 0;
		width: 100%;
		transition: all 0.25s ease-out;
		will-change: transform;
		z-index: 100;
	}

	/* 底部 start*/
	.footerfixed {
		position: fixed;
		width: 100%;
		bottom: 0;
		z-index: 999;
		box-shadow: 0rpx 0rpx 30rpx 0rpx rgba(0, 0, 0, 0.07);
	}
</style>