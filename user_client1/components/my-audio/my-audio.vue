<template>
	<view class="audio_container">
		<view class="audio-title"
			style="width: 100%; text-align: left; font-size: 36rpx;font-weight: bold;padding: 20rpx 0rpx; position: relative;">
			<uni-notice-bar single :scrollable="titleScroll" :size="titleFontSize" :background-color="titleBackgroundColor"
				:color="titleColor" :speed="titleScrollSpeed" :text="title" class="uni-noticebar"
				style="padding: 0px; margin-bottom: 0px;">
			</uni-notice-bar>
			<!-- <uni-icons v-show="isCollectBtn" @click="handleCollec" type="heart" size="20"
				style="color:#848484; position: absolute;top: 0rpx;right: 0px;"></uni-icons> -->
			<tn-button v-show="isCollectBtn" @click="handleCollec" blockRepeatClick="true"
				style="color:#848484;position: absolute;top: 0rpx;right: 0px;font-size: 20px;"
				shape="icon">
				<text class="tn-icon-like" style="font-size: 20px;font-family: uniicons;"></text>
			</tn-button>
		</view>
		<view class="audio-subTitle"
			:style="'font-size: '+subTitleFontSize+';font-weight: bold;padding: 0rpx 0rpx 4rpx 0rpx;position: relative;'">
			<uni-notice-bar single :scrollable="titleScroll" :size="titleFontSize" :background-color="titleBackgroundColor"
				:color="subTitleColor" :speed="titleScrollSpeed" :text="subTitle" class="uni-noticebar">
			</uni-notice-bar>
			<tn-button v-show="isShareBtn" @click="handleShare" blockRepeatClick="true" openType="share"
				style="color:#848484;position: absolute;top: 0rpx;right: 0px;font-size: 20px;"
				shape="icon">
				<text class="tn-icon-share-circle" style="font-size: 20px;font-family: uniicons;"></text>
			</tn-button>
			<!-- 	<uni-icons v-show="isShareBtn" @click="handleShare" type="redo" size="20"
				style="color:#848484;position: absolute;top: 0rpx;right: 0px;"></uni-icons> -->
		</view>
		<view>
			<slider :backgroundColor='backgroundColor' :activeColor='activeColor' @change="handleSliderChange"
				:value="sliderIndex" :max="maxSliderIndex" block-color="#343434" block-size="16" style="margin: 10px 2px;" />
		</view>
		<view style="padding: 0rpx 15rpx 0rpx 15rpx ; display: block; ">
			<view style="float: left; font-size: 20rpx;color:#FFF;">
				{{currentTimeText}}
			</view>
			<view style="float: right;font-size: 20rpx;color:#FFF;">
				{{totalTimeText}}
			</view>
		</view>
		<view class="tn-margin-bottom-xl tn-padding-top-xl">
			<uni-grid :column="4" :showBorder="false" :square="false" class="audio-item">
				<uni-grid-item>
					<view class="uni-grid-icon">
						<image @tap="handleLoopPlay" src="https://imgcdn.tutudati.com/Loop.svg"
							style="width: 48rpx;height: 48rpx; top:6rpx;">
						</image>
					</view>
				</uni-grid-item>
				<uni-grid-item>
					<view class="uni-grid-icon">
						<image @tap="handleFastRewind" src="https://imgcdn.tutudati.com/get-back.svg"
							style="width: 48rpx;height: 48rpx;top:6rpx;">
						</image>
					</view>
				</uni-grid-item>
				<uni-grid-item>
					<view class="uni-grid-icon">
						<image @tap="handleChangeAudioState" v-show="!isPlaying" src="https://imgcdn.tutudati.com/pause.svg"
							style="width: 48rpx;height: 48rpx;top:6rpx;">
						</image>
						<image @tap="handleChangeAudioState" v-show="isPlaying" src="https://imgcdn.tutudati.com/play.svg"
							style="width: 48rpx;height: 48rpx;top:6rpx;">
						</image>
					</view>
				</uni-grid-item>
				<uni-grid-item>
					<view class="uni-grid-icon">
						<image @tap="handleFastForward" src="https://imgcdn.tutudati.com/fast-forward.svg"
							style="width: 48rpx;height: 48rpx;top:6rpx;">
						</image>
					</view>
				</uni-grid-item>
				<!-- <uni-grid-item>
					<view class="uni-grid-icon">
						<image @tap="audioDownload" src="../../static/images/menu.svg"
							style="width: 48rpx;height: 48rpx; top:6rpx; ">
						</image>
					</view>
				</uni-grid-item> -->
				<uni-grid-item>
					<view class="uni-grid-icon">
						<image @tap="audioMoreList" src="https://imgcdn.tutudati.com/menu.svg"
							style="width: 48rpx;height: 48rpx; top:6rpx; ">
						</image>
					</view>
				</uni-grid-item>
			</uni-grid>
		</view>
	</view>
</template>
<script>
	export default {
		name: 'MyAudio',
		//audioPlay开始播放
		//audioPause停止播放
		//audioEnd音频自然播放结束事件
		//audioCanplay音频进入可以播放状态，但不保证后面可以流畅播放
		//change播放状态改变 返回值false停止播放 true开始播放
		//audioError 播放器错误
		// audioDownload下载
		emits: ['audioPlay', 'audioPause', 'audioEnd', 'audioCanplay', 'change', 'audioError', 'audioDownload'],
		props: {
			//标题文字
			title: {
				type: String,
				default: '',
			},
			//标题默认字体大小
			titleFontSize: {
				type: Number,
				default: 35
			},
			//标题文字颜色
			titleColor: {
				type: String,
				default: '#fff'
			},
			//标题背景色
			titleBackgroundColor: {
				type: String,
				default: '#042330'
			},
			//标题是否滚动
			titleScroll: {
				type: Boolean,
				default: true
			},
			//标题滚动速度
			titleScrollSpeed: {
				type: Number,
				default: 100
			},

			subTitle: {
				type: String,
				default: ''
			},
			subTitleColor: {
				type: String,
				default: '#fff'
			},
			subTitleFontSize: {
				type: String,
				default: "30rpx"
			},
			//是否自动播放
			autoplay: {
				type: Boolean,
				default: false
			},
			//滑块左侧已选择部分的线条颜色
			activeColor: {
				type: String,
				default: '#fff'
			},
			//滑块右侧背景条的颜色
			backgroundColor: {
				type: String,
				default: '#E5E5E5'
			},

			//音频地址
			src: {
				type: [String, Array],
				default: ''
			},

			//是否倒计时
			isCountDown: {
				type: Boolean,
				default: false
			},

			//音乐封面
			audioCover: {
				type: String,
				default: ''
			},
			//是否显示收藏按钮
			isCollectBtn: {
				type: Boolean,
				default: false
			},
			//是否显示分享按钮
			isShareBtn: {
				type: Boolean,
				default: false
			},
		},
		data() {
			return {
				totalTimeText: '00:00', //视频总长度文字
				currentTimeText: '00:00:00', //视频已播放长度文字

				isPlaying: false, //播放状态

				sliderIndex: 0, //滑块当前值
				maxSliderIndex: 100, //滑块最大值

				IsReadyPlay: false, //是否已经准备好可以播放了

				isLoop: false, //是否循环播放

				speedValue: [0.5, 0.8, 1.0, 1.25, 1.5, 2.0],
				speedValueIndex: 2,
				playSpeed: '1.0', //播放倍速 可取值：0.5/0.8/1.0/1.25/1.5/2.0

				stringObject: (data) => {
					return typeof(data)
				},
				innerAudioContext: uni.createInnerAudioContext()
			}
		},
		async mounted() {
			console.log(this.src, "音频文件", this.title, this.subTitle)
			this.innerAudioContext.src = typeof(this.src) == 'string' ? this.src : this.src[0];
			if (this.autoplay) {
				if (!this.src) return console.error('src cannot be empty，The target value is string or array')

				// #ifdef H5
				var ua = window.navigator.userAgent.toLowerCase();
				if (ua.match(/MicroMessenger/i) == 'micromessenger') {
					const jweixin = require('../../utils/jweixin');

					jweixin.config({});
					jweixin.ready(() => {
						WeixinJSBridge.invoke('getNetworkType', {}, (e) => {
							this.innerAudioContext.play();

						})
					})
				}
				// #endif

				// #ifndef H5
				this.innerAudioContext.autoplay = true;
				// #endif
			}

			//音频播放事件
			this.innerAudioContext.onPlay(() => {
				this.isPlaying = true;
				this.$emit('audioPlay')

				this.$emit('change', {
					state: true
				});

				setTimeout(() => {
					this.maxSliderIndex = parseFloat(this.innerAudioContext.duration).toFixed(2);

				}, 100)
			});

			//音频暂停事件
			this.innerAudioContext.onPause(() => {
				this.$emit('audioPause');
				this.$emit('change', {
					state: false
				});
			});

			//音频自然播放结束事件
			this.innerAudioContext.onEnded(() => {
				this.isPlaying = !this.isPlaying;
				this.$emit('audioEnd');

				if (this.isLoop) {
					this.changePlayProgress(0);
					this.innerAudioContext.play();
				}
			});

			//音频进入可以播放状态，但不保证后面可以流畅播放
			this.innerAudioContext.onCanplay((event) => {

				this.IsReadyPlay = true;

				this.$emit('audioCanplay');

				let duration = this.innerAudioContext.duration;

				//console.log('总时长', duration)

				//将当前音频长度秒转换为00：00：00格式
				this.totalTimeText = this.getFormateTime(duration);
				this.maxSliderIndex = parseFloat(duration).toFixed(2);

				//console.log(this.getFormateTime(duration))

				//console.log('总时长1', this.totalTimeText)

				//防止视频无法正确获取时长
				setTimeout(() => {
					duration = this.innerAudioContext.duration;

					//将当前音频长度秒转换为00：00：00格式
					this.totalTimeText = this.getFormateTime(duration);
					this.maxSliderIndex = parseFloat(duration).toFixed(2);

					//console.log('总时长2', this.totalTimeText)
				}, 300)

			});

			//音频播放错误事件
			this.innerAudioContext.onTimeUpdate((res) => {
				this.sliderIndex = parseFloat(this.innerAudioContext.currentTime).toFixed(2);
				this.currentTimeText = this.getFormateTime(this.innerAudioContext.currentTime);
			});

			//音频播放错误事件
			this.innerAudioContext.onError((res) => {
				console.log(res.errMsg);
				console.log(res.errCode);
				this.$emit('change', {
					state: false
				});
				this.audioPause();

				this.$emit('audioError', res);
			});

		},
		methods: {
			// 下载音频文件
			audioDownload() {
				this.$emit("audioDownload")
			},
			//销毁innerAudioContext()实例
			audioDestroy() {
				if (this.innerAudioContext) {
					this.innerAudioContext.destroy();
					this.isPlaying = false;
				}
			},
			//点击变更播放状态
			handleChangeAudioState() {
				if (this.isPlaying && !this.innerAudioContext.paused) {
					this.audioPause();
				} else {
					this.audioPlay();
				}
			},
			//开始播放
			audioPlay() {
				this.innerAudioContext.play();
				this.isPlaying = true;
			},
			//暂停播放
			audioPause() {
				this.innerAudioContext.pause();
				this.isPlaying = false;
			},
			//变更滑块位置
			handleSliderChange(e) {
				this.changePlayProgress(e.detail ? e.detail.value : e)
			},
			//更改播放倍速
			handleChageSpeed() {
				//获取播放倍速列表长度
				let speedCount = this.speedValue.length;
				//如果当前是最大倍速，从-1开始
				if (this.speedValueIndex == (speedCount - 1)) {
					this.speedValueIndex = -1;
				}
				//最新倍速序号
				this.speedValueIndex += 1;
				//获取最新倍速文字
				this.playSpeed = this.speedValue[this.speedValueIndex].toFixed(1);
				//暂停播放
				this.audioPause();
				//变更播放倍速
				this.innerAudioContext.playbackRate(this.speedValue[this.speedValueIndex]);
				//开始播放
				this.audioPlay();
			},
			//快退15秒
			handleFastRewind() {
				if (this.IsReadyPlay) {
					let value = parseInt(this.sliderIndex) - 15;
					this.changePlayProgress(value >= 0 ? value : 0);
				}
			},
			//快进15秒
			handleFastForward() {
				if (this.IsReadyPlay) {
					let value = parseInt(this.sliderIndex) + 15;
					this.changePlayProgress(value <= this.innerAudioContext.duration ? value : this.innerAudioContext
						.duration);
				}
			},
			//开启循环播放
			handleLoopPlay() {
				this.isLoop = !this.isLoop;
				if (this.isLoop) {
					uni.showToast({
						title: '已开启循环播放',
						icon: "none",
						duration: 1000
					});
				} else {
					uni.showToast({
						title: '取消循环播放',
						icon: "none",
						duration: 1000
					});
				}
			},
			//更改播放进度
			changePlayProgress(value) {
				this.innerAudioContext.seek(value);
				this.sliderIndex = value;
				this.currentTimeText = this.getFormateTime(value);
			},
			//秒转换为00:00:00
			getFormateTime(time) {
				let ms = time * 1000; // 1485000毫秒
				let date = new Date(ms);

				// 注意这里是使用的getUTCHours()方法，转换成UTC(协调世界时)时间的小时
				let hour = date.getUTCHours();
				// let hour = date.getHours(); 如果直接使用getHours()方法，则得到的时分秒格式会多出来8个小时（在国内开发基本都是使用的是东八区时间），getHours()方法会把当前的时区给加上。
				let minute = date.getMinutes();
				let second = date.getSeconds();

				let formatTime =
					`${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}:${second.toString().padStart(2, '0')}`;

				return formatTime;
			},
			handleCollec() {
				this.$emit('audioCollec');
			},
			handleShare() {
				this.$emit('audioShare');
			},
		},
		onUnload() {
			this.audioDestroy()
		},
		onHide() {
			this.audioDestroy()
		},
		beforeDestroy() {
			this.audioDestroy()
		}
	}
</script>

<style lang="scss" scoped>
	.audio_container {
		// box-shadow: 0 0 4rpx #c3c3c3;
		padding: 30rpx 20rpx 0rpx 20rpx;
		margin-bottom: 10rpx;

		.audio-title {
			font-size: 28rpx;
		}

		.uni-noticebar {
			padding: 0px;
			padding-right: 50rpx;
			margin-bottom: 0px;
			display: inline-block;
		}


		.audio-subTitle {
			width: 100%;
			text-align: left;
			font-size: 40rpx;
			color: blue;
		}

		.speed-text {
			position: absolute;
			top: 0rpx;
			left: 30rpx;
			right: 0;
			color: #475266;
			font-size: 16rpx;
			font-weight: 600;
		}

		.audio-item {
			width: 100%;
			display: flex;
			justify-content: space-around;
		}

		.uni-grid-icon {
			text-align: center;
		}

	}
</style>