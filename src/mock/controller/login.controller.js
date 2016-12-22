/**
 * Created by appian on 2016/11/16.
 */
var apiV = require('../../js/dev.version').apiV;

module.exports = function(app) {
	/**
	 * @api {get} /college/login/sms 获取验证码ajax
	 * @apiDescription 页面:/login/index
	 * @apiGroup Login
	 * @apiVersion 2.0.0
	 * @apiParam {Number} mobile 发送手机号,获取验证码
	 * @apiSuccessExample Success-Response:
	 * {
	 * 	errcode: 0, // 0: 发送成功,2005:网络问题,重新加载
	 * 	errmsg: 'ok',
	 * }
	 *
	 */
	app.get(apiV('college', 'login/sms'), function(req, res) {
		res.json({
			errcode: 0,
			errmsg: 'ok',
		});
	});  
	
	/**
	 * @api {get} /college/login/login  提交手机号和验证码
	 * @apiDescription 页面:/login/index
	 * @apiGroup Login
	 * @apiVersion 2.0.0
	 * @apiParam {Number} mobile 当前提交的手机号
	 * @apiParam {Number} code 提交的验证码
	 * @apiSuccessExample Success-Response:
	 * {
	 * 	errcode: 0,
	 * 	errmsg: 'ok',
	 * }
	 *
	 */
	app.get(apiV('college', 'login/login'), function(req, res) {
		res.json({
			errcode: 0,
			errmsg: 'ok',
		});
	});
	
	/**
	 * @api {post} /college/login/update  提交城市信息(注意:之前是/college/index/update)
	 * @apiDescription 页面:/login/city
	 * @apiGroup Login
	 * @apiVersion 2.0.0
	 * @apiParam {Array} city 提交的所有城市的数组
	 * @apiSuccessExample Success-Response:
	 * {
	 * 	errcode: 0,
	 * 	errmsg: 'ok',
	 * }
	 *
	 */
	app.post(apiV('college', 'login/update'), function(req, res) {
		res.json({
			errcode: 0,
			errmsg: 'ok',
		});
	});
	
};