/**
 * Created by appian on 2016/10/31.
 */

import { getCode, checkUserCode } from "../../apis/login.api";

var mobile = Vue.component("mobile", {
	template: "#mobileTpl",
	data: function () {
		return {
			mobile: '',
			code: '',
			qrcodeText: '获取验证码',
			qrcodeBtnStatus: true,
			timer: null,
			special: $data.special
		}
	},
	watch: {
		qrcodeText: function (val) {
			var _this = this;
			clearInterval(_this.timer);
			if (val > 0) {
				this.timer = setInterval(function () {
					_this.qrcodeText--;
				}, 1000);
			} else {
				clearInterval(_this.timer);
				_this.qrcodeText = "重新获取";
				_this.qrcodeBtnStatus = true;
			}
		}
	},
	methods: {
		getCode: function () {
			var _this = this;
			if (this.mobile.length != 11 || !checkPhone(this.mobile)) {
				alert('手机号不正确');
				return;
			}
			if (!this.qrcodeBtnStatus) return;
			this.qrcodeBtnStatus = false;
			// todo 获取验证码ajax
			getCode({
				mobile: this.mobile
			}).then(function(data){
				if (data.errcode === 0) {
					_this.qrcodeText = 60;
					_this.$dispatch('watchNext', 1);
				} else if (data.errcode === 2005) {
					window.location.reload();
				} else {
					alert(data.errmsg);
					_this.qrcodeBtnStatus = true;
				}
			});
		}
	}
});
 
var V = new Vue({
	el: "html",
	data: {
		nextType: 0, //下一步按钮状态 0不可点,1可以点
		nextText: '下一步',
		title: $data.title,
		desc: $data.desc,
		special: $data.special,
		codeError: false, //错误提示
	},
	ready: function() {
		this.nextType = this.special == 1 ? 1 : 0;
	},
	methods: {
		next: function () {
			var _this = this;
			if (this.nextType === 0) return;
			// todo ajax 验证码是否正确
			checkCode(_this);
		}
	},
	events : {
		watchNext: function (val) {
			this.$set('nextType', val);
		}
	}
});

function checkCode(V) {
	var mobile = $("#custom_phone").val();
	var code = $("#custom_name").val();
	// 什么时候需要code,相关参数special: 1, 0是有验证码版本  1不需要验证码
	if($data.special == 1) code = '0bd6506986ec42e732ffb866d33bb14e';
	if (validate(mobile, '请填写手机号') || validate(code, '请填写验证码')) {
		return;
	}
	V.nextText = '验证中...';
	V.nextType = 0;
	
	checkUserCode({
		mobile: mobile,
		code: code
	}).then(function(data){
		if (data.errcode === 0) {
			window.location = 'city.html';
		} else {
			V.codeError = true;
		}
		V.nextText = '下一步';
		V.nextType = 1;
	});
}

/*
 *  type string 表单类型的!值!
 *       $("#custom_phone").val()
 *  msg  string 要提示的信息
 *       '请填写手机号'
 */
function validate(type, msg) {
	if (!type) {
		alert(msg);
		return true;
	}
	return false;
}
//验证手机号
function checkPhone(val) {  //传入val
	return /^1[3|4|5|8|7][0-9]\d{8}$/.test(val);
}