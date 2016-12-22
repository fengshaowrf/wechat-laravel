<template>
	<div v-show="show" class="loading-container">
		<div class="ball-pulse">
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
</template>

<style lang="sass" scoped>
	@keyframes scale {
		0% {
			-webkit-transform: scale(1);
			transform: scale(1);
			opacity: 1;
		}
		45% {
			-webkit-transform: scale(0.1);
			transform: scale(0.1);
			opacity: 0.7;
		}
		80% {
			-webkit-transform: scale(1);
			transform: scale(1);
			opacity: 1;
		}
	}
	
	.loading-container {
		background: rgba(0, 0, 0, 0.5);
		box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
		text-align: center;
		border-radius: 5px;
		position: fixed;
		width: 100px;
		height: 50px;
		margin: auto;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 999;
	}
	
	.ball-pulse {
		width: 80px;
		text-align: center;
		display: inline-block;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	
	.ball-pulse>div:nth-child(0) {
		animation: scale 0.75s -0.36s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
	}
	
	.ball-pulse>div:nth-child(1) {
		-webkit-animation: scale 0.75s -0.24s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
		animation: scale 0.75s -0.24s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
	}
	
	.ball-pulse>div:nth-child(2) {
		-webkit-animation: scale 0.75s -0.12s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
		animation: scale 0.75s -0.12s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
	}
	
	.ball-pulse>div:nth-child(3) {
		-webkit-animation: scale 0.75s 0s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
		animation: scale 0.75s 0s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
	}
	
	.ball-pulse>div {
		background-color: #fff;
		width: 15px;
		height: 15px;
		border-radius: 100%;
		margin: 2px;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		display: inline-block;
	}
</style>

<script>
export default {
	props: {
		show: {
			type: Boolean,
			default: false,
		},
	},
};
</script>