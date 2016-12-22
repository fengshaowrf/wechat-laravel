/**
 * Created by appian on 2016/11/11.
 */
var f = {
	log : function(msg) {
		console.log(msg);
	},
	reload : function() {
		if(!DEV) {
			window.location.reload();
		}
	},
	alert : function(msg) {
		if(!DEV) {
			alert(msg);
		}
	}
};