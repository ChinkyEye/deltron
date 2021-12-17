import Vue from 'vue';
// for date
import moment from 'moment'
var converter = require('number-to-words');

Vue.filter('timeformat',(arg)=>{
    return moment(arg).format("MMM,dd Do YYYY")
})

Vue.filter('datetimeformat',(arg)=>{
    return moment(arg).format("MMM Do YYYY | HH:mm:ss")
})

Vue.filter('sortlen', function(text,length,suffex){
	return text.substring(0,length)+suffex;
})

Vue.filter('formatDate',(arg)=>{
    return moment(arg).fromNow();
})

Vue.filter('wordConvert',(receive)=>{
	// console.log(typeof receive);
	if(typeof receive == 'undefined' || isNaN(receive)){
		return "";
	}
	var afterdecimal = receive*100 - parseInt(receive)*100;
    return converter.toWords(receive) + ((afterdecimal>0)?(" and " + converter.toWords(afterdecimal) + " paisa"):"");
})