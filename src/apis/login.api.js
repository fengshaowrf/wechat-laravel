/**
 * Created by appian on 2016/11/16.
 */
import { ajaxGet, ajaxPost } from '../js/ajaxtools';
import { apiV } from '../js/dev.version';

/**
 * 获取验证码
 */

export function getCode(data) {
	return ajaxGet(apiV('college', 'login/sms'), data);
}

/**
 * 验证手机号和验证码
 */

export function checkUserCode(data) {
	return ajaxGet(apiV('college', 'login/login'), data);
}

/**
 * 提交城市信息
 */

export function submitCityArr(data) {
	return ajaxPost(apiV('college', 'login/update'), data);
}