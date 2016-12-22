	## 页面目录介绍
	---class (xiejs)
		|--- index 7月新生入群
		|--- classrule 班级规则(原名:class/rules.html)
	
	---exam (appian)
		|--- entrance 入学考试题目 √
		|--- permission 入学考试封面(跳转到entrance) √
	
	---form (xiejs)
		|--- answer 阿斌bug后台
		|--- common 公共表单
		|--- index bug反馈页面
		
	--- graduate (xiejs)
		|--- thesis 写论文
		|--- share 论文分享页
	
	--- group (xiejs)
		|--- index 班长建群上传二维码 
		|--- update 班长更新二维码  
	
	---holiday (xiejs)
		|--- index 请假页面
	
	--- index (appian)
	    |--- achievement 成就领取页面
	    |--- booklist 书单列表
	    |--- date 考勤日历
		|--- date_wait 考勤日历开学未能阅读版 	
		|--- error 错误页面
		|--- index 书院首页 √
		|--- loading 加载过渡页 √
		|--- mail_list 邮件列表(所有+未读) √
		|--- profile 我的 
		|--- rule 学生手册 √
		|--- timer 新版倒计时 √
		
	--- login  (appian)
	    |--- city 报道流程2/3 选择地区 √
	    |--- index 报道1/3 获取手机号(参数控制是否要验证码) √
		|--- success 入学完成3/3 成功(display:none)
		|--- qrcode 报道完成,显示二维码3/3 √

	--- monitor (chacha)
		|--- handbook 班长手册
		|--- user 学员查看班长信息
		
	--- punish (chacha)
		|--- freeze 解除冻结申请
		|--- promise 道歉承诺书
		|--- punish 惩罚页面
	
	---swap (X)
		|--- index 调期卡
		
	---Read  (appian)
		|--- index_new_9_3 目前线上使用的阅读系统

		
	---time (chacha)
		|--- index  时光胶囊
		
	---vote (chacha)
		|--- choice  投票选举班长
		|--- index   申请班长
		|--- rank    选举完毕排名显示
		|--- result   选举搞事页面
		|--- success  班长加入班长群页面 
	
	
	--- 项目名(顶级目录,开发者随便取)
	   |--- src (一个前端源码的git仓库)
	   |--- Application (php后台开发源码 git仓库)
	   |--- dist (前端编译后的代码 git仓库)
	   
	   	   
	   <script>
           var $data = <?php echo json_encode($data);?>;
           console.log($data);
       </script>
       <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
       <script type="text/javascript" charset="utf-8">
           wx.config(<?php echo $js_config; ?>);
       </script>
       <script>
           wx.ready(function () {
               wx.showMenuItems({
                   menuList: ['menuItem:share:appMessage', 'menuItem:share:timeline', 'menuItem:share:qq', 'menuItem:favorite'] // 要显示的菜单项，所有menu项见附录3
               });
               wx.hideMenuItems({
                   menuList: ['menuItem:share:QZone', 'menuItem:share:facebook', 'menuItem:share:weiboApp', 'menuItem:copyUrl'] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
               });
               var title = $data.share_title;
               console.log(title);
               wx.onMenuShareTimeline({
                   title: title, // 分享标题
                   imgUrl: $data.headimgurl, // 分享图标
               });
       
               wx.onMenuShareAppMessage({
                   title: title, // 分享标题
                   desc: '熊猫书院',  // 分享描述
                   imgUrl: $data.headimgurl, // 分享图标
                   type: '', // 分享类型,music、video或link，不填默认为link
                   dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
               });
           });
       </script>