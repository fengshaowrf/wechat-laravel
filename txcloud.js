var qcloud = require('qcloud_cos');
var glob = require('glob');
var fs = require('fs');

// appid  secretId  secretKey
qcloud.conf.setAppInfo(' ', ' ', ' ');

//要上传的空间 改为你所要的
var bucket = ' ';
//需要上传的目录和文件

var uploadDir = './public/**/*.{js,css,eot,svg,ttf,woff,png,jpg,jpeg}';

var globalFiles = [];
var globalIndex = 0;

//读取所需文件并上传
glob(uploadDir, function (err,file) {
	
	if(err) return err;
	file.forEach(function (f, idx) {
		var filePath = f;
		globalFiles.push({
			filePath : filePath,
			bucket : filePath.split('./public/')[1]
		});
		upload(filePath,filePath.split('./public/')[1])
	});
	// console.log(globalFiles);
});


//上传文件
function upload(filepath,bucketpath) {
	qcloud.cos.upload(filepath, bucket, bucketpath,'cdn',0, function(ret){
		if (ret.code != 0) {
			
			console.log(ret);
			var f = globalFiles[globalIndex];
			upload(f.filePath,f.bucket);
			
		} else {
			// 查询文件
			var msg = {
				message : ret.message, // 是否成功
				access_url : ret.data.access_url // CDN链接
			};
			console.log(msg);
			globalIndex++;
		}
	});
}
