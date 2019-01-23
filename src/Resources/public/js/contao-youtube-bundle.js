"use strict";function _classCallCheck(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function _defineProperties(a,b){for(var c,d=0;d<b.length;d++)c=b[d],c.enumerable=c.enumerable||!1,c.configurable=!0,"value"in c&&(c.writable=!0),Object.defineProperty(a,c.key,c)}function _createClass(a,b,c){return b&&_defineProperties(a.prototype,b),c&&_defineProperties(a,c),a}var YouTubeBundle=/*#__PURE__*/function(){function a(){_classCallCheck(this,a)}return _createClass(a,null,[{key:"getConfig",value:function a(){return{cookies:{privacy:{name:"youtube-privacy",value:"auto",expire:365}},privacyAutoFieldName:"youtubePrivacyAuto"}}},{key:"onReady",value:function b(){document.querySelectorAll("[data-media=\"youtube\"]").forEach(function(b){b.getAttribute("data-autoplay")&&a.initVideo(b)}),utilsBundle.event.addDynamicEventListener("click","[data-media=\"youtube\"]",function(b){a.initVideo(b)})}},{key:"initVideo",value:function f(b){function c(){b.classList.add("initialize"),d.classList.add("initialize"),e.setAttribute("src",e.getAttribute("src")+"&autoplay=1"),b.classList.remove("initialize","video-hidden"),d.classList.remove("initialize","video-hidden")}var d=b.parentNode.querySelector(".video-container"),e=d.querySelector("iframe");// stop playing video on closing any modal window
if(utilsBundle.event.addDynamicEventListener("click","[data-dismiss=\"modal\"]",function(){e.setAttribute("src",e.getAttribute("data-src"))}),document.addEventListener("hidden.bs.modal",function(){e.setAttribute("src",e.getAttribute("data-src"))}),b.getAttribute("data-privacy")){// auto load privacy videos if set within cookie
if(a.getPrivacyAuto()==a.getConfig().cookies.privacy.value)return e.setAttribute("src",e.getAttribute("data-src")),c(),!1;var g=alertify.confirm("&nbsp;",b.getAttribute("data-privacy-html").replace(/\\"/g,"\""),function(){g.elements.content.querySelector("[name="+a.getConfig().privacyAutoFieldName+"]").checked&&a.setPrivacyAuto(),e.setAttribute("src",e.getAttribute("data-src")),c()},function(){});return!1}e.setAttribute("src",e.getAttribute("data-src")),c()}},{key:"setPrivacyAuto",value:function b(){a.createCookie(a.getConfig().cookies.privacy.name,a.getConfig().cookies.privacy.value,a.getConfig().cookies.privacy.expire)}},{key:"getPrivacyAuto",value:function b(){return a.readCookie(a.getConfig().cookies.privacy.name)}},{key:"createCookie",value:function e(a,b,c){var d;if(c){var f=new Date;f.setTime(f.getTime()+1e3*(60*(60*(24*c)))),d="; expires="+f.toGMTString()}else d="";document.cookie=encodeURIComponent(a)+"="+encodeURIComponent(b)+d+"; path=/"}},{key:"readCookie",value:function g(a){for(var b,d=encodeURIComponent(a)+"=",e=document.cookie.split(";"),f=0;f<e.length;f++){for(b=e[f];" "===b.charAt(0);)b=b.substring(1,b.length);if(0===b.indexOf(d))return decodeURIComponent(b.substring(d.length,b.length))}return null}},{key:"eraseCookie",value:function c(b){a.createCookie(b,"",-1)}}]),a}();document.addEventListener("DOMContentLoaded",YouTubeBundle.onReady);