## 内部使用脚手架

> 基于vue-multipages 2.0版本

> 优化了之前的目录结构，前端调试情况直接访问public下的代码，与线上环境同步


```js

--- src
	|--- apis ( 为ajax封装的一层promise )
	|--- components 
	|--- css
	|--- fonts
	|--- images
	|--- js
	|--- mock （ 前端mock服务 ）
	|--- sass
	|--- views
```



npm run dev 前端开发用

npm run api 启动mock服务

npm run build:dev 不压缩代码 其余完全和线上环境一样

npm run build 发布用

gulp php:dev 后台人员开发时使用

gulp build:php 后台人员修改了前端文件时使用