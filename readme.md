# 微信公众号项目Demo(laravel版)

## 简介

    基于laravel的微信公众号项目实践
    
## 项目说明

1. 多公众号用unionid统一登录(`Middleware\UnionWechatOauth::class`)
2. Event/Listener 监听微信消息事件
3. 前后端项目半分离(前端独立使用vue.js开发[模板项目](https://github.com/pluxwill/view-src-demo),`artisan for:view` command 即可安装)
4. 集成`overtrue/laravel-wechat` package ,并实现自定义Cache，兼容历史项目redis中access_token的key

## 使用说明

//TODO