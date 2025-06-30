<template>
	<view class="template-login">
		<!-- 顶部自定义导航 -->
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left' @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill' @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">登录授权</text>
			</view>
		</tn-nav-bar>

		<view class="login">
			<!-- 顶部背景图片-->
			<view class="login__bg login__bg--top">
				<image class="bg" src="https://resource.tuniaokj.com/images/login/2/login-top2.png" mode="widthFix"></image>
			</view>

			<view class="login__wrapper">
				<view class="tn-margin-left tn-margin-right tn-text-bold" style="font-size: 60rpx;">
					欢迎使用
				</view>
				<view class="tn-margin tn-color-gray tn-text-lg">
					云沐-智慧教育系统
				</view>

				<!-- 登录/注册切换 -->
				<!-- <view
					class="login-sussuspension login__mode tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-center">
					<view class="login__mode__item tn-flex-1" :class="[{'login__mode__item--active': currentModeIndex === 0}]"
						@tap.stop="modeSwitch(0)">
						登录
					</view>
					<view class="login__mode__item tn-flex-1" :class="[{'login__mode__item--active': currentModeIndex === 1}]"
						@tap.stop="modeSwitch(1)">
						注册
					</view>
					<view class="login__mode__slider tn-cool-bg-color-15--reverse" :style="[modeSliderStyle]"></view>
				</view> -->

				<!-- 输入框内容-->
				<view class="login__info tn-flex tn-flex-direction-column tn-flex-col-center tn-flex-row-center">
					<!-- 登录 -->
					<block v-if="currentModeIndex === 0">
						<view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-phone"></view>
							</view>
							<view class="login__info__item__input__content">
								<input maxlength="20" v-model="mobile" placeholder-class="input-placeholder" placeholder="请输入手机号" />
							</view>
						</view>

						<view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-lock"></view>
							</view>
							<view class="login__info__item__input__content">
								<input :password="!showPassword" v-model="password" placeholder-class="input-placeholder"
									placeholder="请输入登录密码" />
							</view>
							<view class="login__info__item__input__right-icon" @click="showPassword = !showPassword">
								<view :class="[showPassword ? 'tn-icon-eye' : 'tn-icon-eye-hide']"></view>
							</view>
						</view>

						<!-- <view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-safe"></view>
							</view>
							<view class="login__info__item__input__content login__info__item__input__content--verify-code">
								<input placeholder-class="input-placeholder" placeholder="请输入验证码" />
							</view>
							<view class="login__info__item__input__right-verify-code" @tap.stop="getCode">
								<tn-button backgroundColor="#01BEFF" fontColor="#FFFFFF" size="sm" padding="5rpx 10rpx" width="100%"
									shape="round">{{ tips }}</tn-button>
							</view>
						</view> -->
					</block>
					<!-- 注册 -->
					<block v-if="currentModeIndex === 1">
						<view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-phone"></view>
							</view>
							<view class="login__info__item__input__content">
								<input maxlength="20" v-model="mobile" placeholder-class="input-placeholder" placeholder="请输入注册手机号码" />
							</view>
						</view>

						<view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-safe"></view>
							</view>
							<view class="login__info__item__input__content login__info__item__input__content--verify-code">
								<input placeholder-class="input-placeholder" v-model="code" placeholder="请输入验证码" />
							</view>
							<view class="login__info__item__input__right-verify-code" @tap.stop="getCode">
								<tn-button size="sm" padding="5rpx 10rpx" width="100%" shape="round">{{ tips }}</tn-button>
							</view>
						</view>

						<view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-lock"></view>
							</view>
							<view class="login__info__item__input__content">
								<input :password="!showPassword" v-model="password" placeholder-class="input-placeholder"
									placeholder="请输入登录密码" />
							</view>
							<view class="login__info__item__input__right-icon" @click="showPassword = !showPassword">
								<view :class="[showPassword ? 'tn-icon-eye' : 'tn-icon-eye-hide']"></view>
							</view>
						</view>
					</block>
					<!-- 重置密码 -->
					<block v-if="currentModeIndex === 3">
						<view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-phone"></view>
							</view>
							<view class="login__info__item__input__content">
								<input maxlength="20" v-model="mobile" placeholder-class="input-placeholder" placeholder="请输入登录手机号码" />
							</view>
						</view>
						
						<view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-safe"></view>
							</view>
							<view class="login__info__item__input__content login__info__item__input__content--verify-code">
								<input placeholder-class="input-placeholder" v-model="code" placeholder="请输入验证码" />
							</view>
							<view class="login__info__item__input__right-verify-code" @tap.stop="getCode">
								<tn-button size="sm" padding="5rpx 10rpx" width="100%" shape="round">{{ tips }}</tn-button>
							</view>
						</view>
						
						<view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-lock"></view>
							</view>
							<view class="login__info__item__input__content">
								<input :password="!showPassword" v-model="password" placeholder-class="input-placeholder"
									placeholder="请输入新密码" />
							</view>
							<view class="login__info__item__input__right-icon" @click="showPassword = !showPassword">
								<view :class="[showPassword ? 'tn-icon-eye' : 'tn-icon-eye-hide']"></view>
							</view>
						</view>
						
						<view
							class="login__info__item__input tn-flex tn-flex-direction-row tn-flex-nowrap tn-flex-col-center tn-flex-row-left">
							<view class="login__info__item__input__left-icon">
								<view class="tn-icon-lock"></view>
							</view>
							<view class="login__info__item__input__content">
								<input :password="!showPassword_confirm" v-model="password_confirm" placeholder-class="input-placeholder"
									placeholder="请确认新密码" />
							</view>
							<view class="login__info__item__input__right-icon" @click="showPassword_confirm = !showPassword_confirm">
								<view :class="[showPassword_confirm ? 'tn-icon-eye' : 'tn-icon-eye-hide']"></view>
							</view>
						</view>
					</block>

					<view class="login__info__item__button tn-bg-blue tn-color-white" hover-class="tn-hover" @click="submitForm"
						:hover-stay-time="150">{{ currentModeIndex === 0 ? '登录' : (currentModeIndex === 1 ? '注册' : '重置密码')}}</view>

					<view  class="login__info__item__tips" :style="{margin: 0}" @click="readPolicy">
						<view class="tn-flex tn-flex-row-between tn-flex-col-center">
							<view class="tn-icon-tip"></view>
							<view class="">请仔细阅读平台<text :style="{color: mainColor}">用户隐私协议</text></view>
						</view>
					</view>

					<view v-if="currentModeIndex === 1 || currentModeIndex === 3" :class="[{'login__info__item__tips': currentModeIndex === 0}]">
						<view class="tn-flex tn-flex-row-between tn-padding">
							<view class="" @tap.stop="modeSwitch(0)">前往登录</view>
						</view>
					</view>
					<view v-if="currentModeIndex === 0" :class="[{'login__info__item__tips': currentModeIndex === 1}]">
						<view class="tn-flex tn-flex-row-between tn-padding">
							<view class="tn-padding-right" @tap.stop="modeSwitch(1)">账号注册</view>
							<view class="tn-padding-left tn-color-gray" @tap.stop="modeSwitch(3)">忘记密码</view>
						</view>
					</view>

				</view>

				<!-- 其他登录方式 -->
				<!-- <view class="login__way tn-flex tn-flex-col-center tn-flex-row-center">
					<view class="tn-padding-sm tn-margin-xs" @click="codeLogin">
						<view class="login__way__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-color-teal--dark">
							<view class="tn-icon-wechat-fill"></view>
						</view>
					</view>
					<view class="tn-padding-sm tn-margin-xs" @tap.stop="modeSwitch(0)">
						<view class="login__way__item--icon tn-flex tn-flex-row-center tn-flex-col-center tn-color-red">
							<view class="tn-icon-iphone"></view>
						</view>
					</view>
				</view> -->
			</view>

			<!-- 底部背景图片-->
			<view class="login__bg login__bg--bottom">
				<image src="https://resource.tuniaokj.com/images/login/2/login-bottom2.png" mode="widthFix"></image>
			</view>

		</view>

		<!-- 验证码倒计时 -->
		<tn-verification-code ref="code" uniqueKey="login-demo-4" :seconds="60" @change="codeChange">
		</tn-verification-code>

		<!-- 微信隐私鉴权保护弹窗开始 -->
		<!-- #ifdef MP-WEIXIN -->
		<privacy-popup ref="privacyComponent"></privacy-popup>
		<!-- #endif -->
		<!-- 微信隐私鉴权弹窗保护结束 -->

		<!-- 是否开启小程序授权开始 -->
		<tn-modal width="70%" v-model="showMpAuth" :title="showMpAuthInfo.title" :content="showMpAuthInfo.content" @click="authConfirm" :button="showMpAuthInfo.button"></tn-modal>
		<!-- 是否开启小程序授权结束 -->

	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	import PrivacyPopup from '@/components/privacy-popup/privacy-popup.vue'
	export default {
		name: 'loginPage',
		mixins: [template_page_mixin],
		components: {
			PrivacyPopup
		},
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				// 当前选中的模式
				currentModeIndex: 0,
				// 模式选中滑块
				modeSliderStyle: {
					left: 0
				},
				showMpAuth: false,
				showMpAuthInfo: {
					title: '授权提示',
					content: '当前正在使用微信小程序，是否授权微信小程序?',
					button: [{
							text: '取消',
							backgroundColor: '#E83A30',
							fontColor: '#FFFFFF',
						},
						{
							text: '确定',
							backgroundColor: getApp().globalData.mainColor,
							fontColor: '#FFFFFF'
						}
					]
				},
				// 是否显示密码
				showPassword: false,
				showPassword_confirm: false,
				// 倒计时提示文字
				tips: '获取验证码',
				mobile: '15683202304',
				password: 'qwer123456',
				password_confirm: '',
				code: '',
			}
		},
		watch: {
			currentModeIndex(value) {
				const sliderWidth = uni.upx2px(476 / 2)
				this.modeSliderStyle.left = `${sliderWidth * value}px`
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
		},
		onShow() {

		},
		methods: {
			submitForm() {
				if (this.currentModeIndex === 1) { // 注册
					this.$func.showToast('注册已关闭，请使用演示账号')
					return
					this.$api.apiAccountRegister({
						account: this.mobile,
						code: this.code,
						password: this.password,
						channel: 1
					}).then(res => {
						this.$func.showToast(res.msg)
						if (res.code === 1) {
							this.currentModeIndex = 0
						}
					})
				} else if (this.currentModeIndex === 0) { // 登录
					this.$api.apiAccountLogin({
						terminal: 1,
						account: this.mobile,
						scene: 1,
						password: this.password
					}).then(res => {
						this.$func.showToast(res.msg)
						if (res.code === 1) {
							uni.setStorageSync('login', res.data.token)
							uni.setStorageSync('nickname', res.data.nickname)
							uni.setStorageSync('avatar', res.data.avatar)
							// #ifdef MP-WEIXIN
							if (res.data.need_mp) {
								this.showMpAuth = true
							} else {
								uni.navigateBack()
							}
							// #endif
							// #ifndef MP-WEIXIN
							uni.navigateBack()
							// #endif
						}
					})
				} else if (this.currentModeIndex === 3) {
					this.$api.apiResetPassword({
						code: this.code,
						mobile: this.mobile,
						password: this.password,
						password_confirm: this.password_confirm
					}).then(res => {
						this.$func.showToast(res.msg)
						if(res.code === 1) {
							this.currentModeIndex = 0
						}
					})
				} else {
					this.$func.showToast('未知操作方式')
				}
			},
			bindMpCode() {
				let _that = this
				uni.getProvider({
					service: 'oauth',
					success(res) {
						if (~res.provider.indexOf('weixin')) {
							uni.login({
								provider: 'weixin',
								success(loginRes) {
									if (loginRes.errMsg === 'login:ok') {
										_that.$api.apiMnpAuthBind({
											code: loginRes.code
										}).then(requestRes => {
											if (requestRes.code === 1) {
												_that.showMpAuth = false
												_that.$func.showToast(requestRes.msg)
												uni.navigateBack()
												return
											}
											_that.$func.showToast(requestRes.msg)
										})
										return
									}
									_that.$func.showToast(loginRes.errMsg)
								}
							})
						} else {
							_that.$func.showToast('暂不支持该授权类型')
						}
					},
					fail(res) {
						_that.$func.showToast(res.errMsg)
					}
				})
			},
			authConfirm(e) {
				if (e.index === 1) {
					this.bindMpCode()
					return
				}
				this.showMpAuth = false
				uni.navigateBack()
			},
			readPolicy() {
				this.$func.navigatorTo('/subpages/common/policyContent?type=privacy')
			},
			// 切换模式
			modeSwitch(index) {
				this.currentModeIndex = index
				this.showPassword = false
			},
			// 获取验证码
			getCode() {
				if (!this.$func.verifyPhone(this.mobile)) {
					this.$func.showToast('请输入正确的手机号')
					return
				}
				if (this.$refs.code.canGetCode) {
					this.$func.showToast('正在获取验证码')
					this.$refs.code.start()
					this.$api.apiSmsSend({
						mobile: this.mobile,
						scene: this.currentModeIndex === 0 ? 'YZMDL' : 'ZHDLMM'
					}).then(res => {
						this.$func.showToast(res.msg)
					})
					// setTimeout(() => {
					// 	this.$func.showToast('验证码已经发送')
					// 	
					// }, 2000)
				} else {
					this.$func.showToast(this.$refs.code.secNum + '秒后再重试')
				}
			},
			// 获取验证码倒计时被修改
			codeChange(event) {
				this.tips = event
			}
		}
	}
</script>

<style lang="scss" scoped>
	@import '@/scss/custom_nav_bar.scss';

	.login {
		position: relative;
		height: 100%;
		z-index: 1;

		/* 背景图片 start */
		&__bg {
			z-index: -1;
			position: fixed;

			&--top {
				top: 0;
				left: 0;
				right: 0;
				width: 100%;

				.bg {
					width: 750rpx;
					will-change: transform;
				}
			}

			&--bottom {
				bottom: -10rpx;
				left: 0;
				right: 0;
				width: 100%;
				// height: 144px;
				margin-bottom: env(safe-area-inset-bottom);

				image {
					width: 750rpx;
					will-change: transform;
				}
			}
		}

		/* 背景图片 end */

		/* 内容 start */
		&__wrapper {
			margin-top: 300rpx;
			width: 100%;
		}

		/* 切换 start */
		&__mode {
			position: relative;
			margin: 0 auto;
			width: 476rpx;
			height: 77rpx;
			margin-top: 100rpx;
			background-color: rgba(255, 255, 255, 0.6);
			box-shadow: 0rpx 10rpx 50rpx 0rpx rgba(0, 3, 72, 0.1);
			border-radius: 39rpx;

			&__item {
				height: 77rpx;
				width: 100%;
				line-height: 77rpx;
				text-align: center;
				font-size: 31rpx;
				color: #080808;
				letter-spacing: 1em;
				text-indent: 1em;
				z-index: 2;
				transition: all 0.4s;

				&--active {
					font-weight: bold;
					color: #FFFFFF;
				}
			}

			&__slider {
				position: absolute;
				height: inherit;
				width: calc(476rpx / 2);
				border-radius: inherit;
				box-shadow: 0rpx 18rpx 72rpx 18rpx rgba(0, 195, 255, 0.1);
				z-index: 1;
				transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
			}
		}

		/* 切换 end */

		/* 登录注册信息 start */
		&__info {
			margin: 80rpx 30rpx 10rpx 30rpx;
			padding-bottom: 0;
			border-radius: 20rpx;

			&__item {

				&__input {
					margin-top: 59rpx;
					width: 100%;
					height: 77rpx;
					border: 1rpx solid #E6E6E6;
					border-radius: 39rpx;

					&__left-icon {
						width: 10%;
						font-size: 44rpx;
						margin-left: 20rpx;
						color: #838383;
					}

					&__content {
						width: 80%;
						padding-left: 10rpx;

						&--verify-code {
							width: 56%;
						}

						input {
							font-size: 24rpx;
							// letter-spacing: 0.1em;
						}
					}

					&__right-icon {
						width: 10%;
						font-size: 44rpx;
						margin-right: 20rpx;
						color: #838383;
					}

					&__right-verify-code {
						width: 34%;
						margin-right: 20rpx;
					}
				}

				&__button {
					margin-top: 75rpx;
					margin-bottom: 39rpx;
					width: 100%;
					height: 77rpx;
					text-align: center;
					font-size: 31rpx;
					font-weight: bold;
					line-height: 77rpx;
					letter-spacing: 1em;
					text-indent: 1em;
					border-radius: 39rpx;
					box-shadow: 1rpx 10rpx 24rpx 0rpx rgba(60, 129, 254, 0.35);
				}

				&__tips {
					margin: 30rpx 0;
					color: #AAAAAA;
				}
			}
		}

		/* 登录注册信息 end */

		/* 登录方式切换 start */
		&__way {
			margin: 0 auto;
			margin-top: 110rpx;

			&__item {
				&--icon {
					width: 85rpx;
					height: 85rpx;
					font-size: 70rpx;
					// border-radius: 100rpx;
					margin-bottom: 18rpx;
					position: relative;
					z-index: 1;
				}
			}
		}
	}

	/deep/.input-placeholder {
		font-size: 24rpx;
		color: #838383;
	}
</style>