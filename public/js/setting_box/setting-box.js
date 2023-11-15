!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):e.moment=t()}(this,function(){"use strict";var H;function f(){return H.apply(null,arguments)}function a(e){return e instanceof Array||"[object Array]"===Object.prototype.toString.call(e)}function F(e){return null!=e&&"[object Object]"===Object.prototype.toString.call(e)}function c(e,t){return Object.prototype.hasOwnProperty.call(e,t)}function L(e){if(Object.getOwnPropertyNames)return 0===Object.getOwnPropertyNames(e).length;for(var t in e)if(c(e,t))return;return 1}function o(e){return void 0===e}function u(e){return"number"==typeof e||"[object Number]"===Object.prototype.toString.call(e)}function V(e){return e instanceof Date||"[object Date]"===Object.prototype.toString.call(e)}function G(e,t){for(var n=[],s=e.length,i=0;i<s;++i)n.push(t(e[i],i));return n}function E(e,t){for(var n in t)c(t,n)&&(e[n]=t[n]);return c(t,"toString")&&(e.toString=t.toString),c(t,"valueOf")&&(e.valueOf=t.valueOf),e}function l(e,t,n,s){return Pt(e,t,n,s,!0).utc()}function m(e){return null==e._pf&&(e._pf={empty:!1,unusedTokens:[],unusedInput:[],overflow:-2,charsLeftOver:0,nullInput:!1,invalidEra:null,invalidMonth:null,invalidFormat:!1,userInvalidated:!1,iso:!1,parsedDateParts:[],era:null,meridiem:null,rfc2822:!1,weekdayMismatch:!1}),e._pf}function A(e){if(null==e._isValid){var t=m(e),n=j.call(t.parsedDateParts,function(e){return null!=e}),n=!isNaN(e._d.getTime())&&t.overflow<0&&!t.empty&&!t.invalidEra&&!t.invalidMonth&&!t.invalidWeekday&&!t.weekdayMismatch&&!t.nullInput&&!t.invalidFormat&&!t.userInvalidated&&(!t.meridiem||t.meridiem&&n);if(e._strict&&(n=n&&0===t.charsLeftOver&&0===t.unusedTokens.length&&void 0===t.bigHour),null!=Object.isFrozen&&Object.isFrozen(e))return n;e._isValid=n}return e._isValid}function I(e){var t=l(NaN);return null!=e?E(m(t),e):m(t).userInvalidated=!0,t}var j=Array.prototype.some||function(e){for(var t=Object(this),n=t.length>>>0,s=0;s<n;s++)if(s in t&&e.call(this,t[s],s,t))return!0;return!1},Z=f.momentProperties=[],z=!1;function $(e,t){var n,s,i,r=Z.length;if(o(t._isAMomentObject)||(e._isAMomentObject=t._isAMomentObject),o(t._i)||(e._i=t._i),o(t._f)||(e._f=t._f),o(t._l)||(e._l=t._l),o(t._strict)||(e._strict=t._strict),o(t._tzm)||(e._tzm=t._tzm),o(t._isUTC)||(e._isUTC=t._isUTC),o(t._offset)||(e._offset=t._offset),o(t._pf)||(e._pf=m(t)),o(t._locale)||(e._locale=t._locale),0<r)for(n=0;n<r;n++)o(i=t[s=Z[n]])||(e[s]=i);return e}function q(e){$(this,e),this._d=new Date(null!=e._d?e._d.getTime():NaN),this.isValid()||(this._d=new Date(NaN)),!1===z&&(z=!0,f.updateOffset(this),z=!1)}function h(e){return e instanceof q||null!=e&&null!=e._isAMomentObject}function B(e){!1===f.suppressDeprecationWarnings&&"undefined"!=typeof console&&console.warn&&console.warn("Deprecation warning: "+e)}function e(r,a){var o=!0;return E(function(){if(null!=f.deprecationHandler&&f.deprecationHandler(null,r),o){for(var e,t,n=[],s=arguments.length,i=0;i<s;i++){if(e="","object"==typeof arguments[i]){for(t in e+="\n["+i+"] ",arguments[0])c(arguments[0],t)&&(e+=t+": "+arguments[0][t]+", ");e=e.slice(0,-2)}else e=arguments[i];n.push(e)}B(r+"\nArguments: "+Array.prototype.slice.call(n).join("")+"\n"+(new Error).stack),o=!1}return a.apply(this,arguments)},a)}var J={};function Q(e,t){null!=f.deprecationHandler&&f.deprecationHandler(e,t),J[e]||(B(t),J[e]=!0)}function d(e){return"undefined"!=typeof Function&&e instanceof Function||"[object Function]"===Object.prototype.toString.call(e)}function X(e,t){var n,s=E({},e);for(n in t)c(t,n)&&(F(e[n])&&F(t[n])?(s[n]={},E(s[n],e[n]),E(s[n],t[n])):null!=t[n]?s[n]=t[n]:delete s[n]);for(n in e)c(e,n)&&!c(t,n)&&F(e[n])&&(s[n]=E({},s[n]));return s}function K(e){null!=e&&this.set(e)}f.suppressDeprecationWarnings=!1,f.deprecationHandler=null;var ee=Object.keys||function(e){var t,n=[];for(t in e)c(e,t)&&n.push(t);return n};function r(e,t,n){var s=""+Math.abs(e);return(0<=e?n?"+":"":"-")+Math.pow(10,Math.max(0,t-s.length)).toString().substr(1)+s}var te=/(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|N{1,5}|YYYYYY|YYYYY|YYYY|YY|y{2,4}|yo?|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g,ne=/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,se={},ie={};function s(e,t,n,s){var i="string"==typeof s?function(){return this[s]()}:s;e&&(ie[e]=i),t&&(ie[t[0]]=function(){return r(i.apply(this,arguments),t[1],t[2])}),n&&(ie[n]=function(){return this.localeData().ordinal(i.apply(this,arguments),e)})}function re(e,t){return e.isValid()?(t=ae(t,e.localeData()),se[t]=se[t]||function(s){for(var e,i=s.match(te),t=0,r=i.length;t<r;t++)ie[i[t]]?i[t]=ie[i[t]]:i[t]=(e=i[t]).match(/\[[\s\S]/)?e.replace(/^\[|\]$/g,""):e.replace(/\\/g,"");return function(e){for(var t="",n=0;n<r;n++)t+=d(i[n])?i[n].call(e,s):i[n];return t}}(t),se[t](e)):e.localeData().invalidDate()}function ae(e,t){var n=5;function s(e){return t.longDateFormat(e)||e}for(ne.lastIndex=0;0<=n&&ne.test(e);)e=e.replace(ne,s),ne.lastIndex=0,--n;return e}var oe={};function t(e,t){var n=e.toLowerCase();oe[n]=oe[n+"s"]=oe[t]=e}function _(e){return"string"==typeof e?oe[e]||oe[e.toLowerCase()]:void 0}function ue(e){var t,n,s={};for(n in e)c(e,n)&&(t=_(n))&&(s[t]=e[n]);return s}var le={};function n(e,t){le[e]=t}function he(e){return e%4==0&&e%100!=0||e%400==0}function y(e){return e<0?Math.ceil(e)||0:Math.floor(e)}function g(e){var e=+e,t=0;return t=0!=e&&isFinite(e)?y(e):t}function de(t,n){return function(e){return null!=e?(fe(this,t,e),f.updateOffset(this,n),this):ce(this,t)}}function ce(e,t){return e.isValid()?e._d["get"+(e._isUTC?"UTC":"")+t]():NaN}function fe(e,t,n){e.isValid()&&!isNaN(n)&&("FullYear"===t&&he(e.year())&&1===e.month()&&29===e.date()?(n=g(n),e._d["set"+(e._isUTC?"UTC":"")+t](n,e.month(),We(n,e.month()))):e._d["set"+(e._isUTC?"UTC":"")+t](n))}var i=/\d/,w=/\d\d/,me=/\d{3}/,_e=/\d{4}/,ye=/[+-]?\d{6}/,p=/\d\d?/,ge=/\d\d\d\d?/,we=/\d\d\d\d\d\d?/,pe=/\d{1,3}/,ke=/\d{1,4}/,ve=/[+-]?\d{1,6}/,Me=/\d+/,De=/[+-]?\d+/,Se=/Z|[+-]\d\d:?\d\d/gi,Ye=/Z|[+-]\d\d(?::?\d\d)?/gi,k=/[0-9]{0,256}['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFF07\uFF10-\uFFEF]{1,256}|[\u0600-\u06FF\/]{1,256}(\s*?[\u0600-\u06FF]{1,256}){1,2}/i;function v(e,n,s){be[e]=d(n)?n:function(e,t){return e&&s?s:n}}function Oe(e,t){return c(be,e)?be[e](t._strict,t._locale):new RegExp(M(e.replace("\\","").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g,function(e,t,n,s,i){return t||n||s||i})))}function M(e){return e.replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&")}var be={},xe={};function D(e,n){var t,s,i=n;for("string"==typeof e&&(e=[e]),u(n)&&(i=function(e,t){t[n]=g(e)}),s=e.length,t=0;t<s;t++)xe[e[t]]=i}function Te(e,i){D(e,function(e,t,n,s){n._w=n._w||{},i(e,n._w,n,s)})}var S,Y=0,O=1,b=2,x=3,T=4,N=5,Ne=6,Pe=7,Re=8;function We(e,t){if(isNaN(e)||isNaN(t))return NaN;var n=(t%(n=12)+n)%n;return e+=(t-n)/12,1==n?he(e)?29:28:31-n%7%2}S=Array.prototype.indexOf||function(e){for(var t=0;t<this.length;++t)if(this[t]===e)return t;return-1},s("M",["MM",2],"Mo",function(){return this.month()+1}),s("MMM",0,0,function(e){return this.localeData().monthsShort(this,e)}),s("MMMM",0,0,function(e){return this.localeData().months(this,e)}),t("month","M"),n("month",8),v("M",p),v("MM",p,w),v("MMM",function(e,t){return t.monthsShortRegex(e)}),v("MMMM",function(e,t){return t.monthsRegex(e)}),D(["M","MM"],function(e,t){t[O]=g(e)-1}),D(["MMM","MMMM"],function(e,t,n,s){s=n._locale.monthsParse(e,s,n._strict);null!=s?t[O]=s:m(n).invalidMonth=e});var Ce="January_February_March_April_May_June_July_August_September_October_November_December".split("_"),Ue="Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),He=/D[oD]?(\[[^\[\]]*\]|\s)+MMMM?/,Fe=k,Le=k;function Ve(e,t){var n;if(e.isValid()){if("string"==typeof t)if(/^\d+$/.test(t))t=g(t);else if(!u(t=e.localeData().monthsParse(t)))return;n=Math.min(e.date(),We(e.year(),t)),e._d["set"+(e._isUTC?"UTC":"")+"Month"](t,n)}}function Ge(e){return null!=e?(Ve(this,e),f.updateOffset(this,!0),this):ce(this,"Month")}function Ee(){function e(e,t){return t.length-e.length}for(var t,n=[],s=[],i=[],r=0;r<12;r++)t=l([2e3,r]),n.push(this.monthsShort(t,"")),s.push(this.months(t,"")),i.push(this.months(t,"")),i.push(this.monthsShort(t,""));for(n.sort(e),s.sort(e),i.sort(e),r=0;r<12;r++)n[r]=M(n[r]),s[r]=M(s[r]);for(r=0;r<24;r++)i[r]=M(i[r]);this._monthsRegex=new RegExp("^("+i.join("|")+")","i"),this._monthsShortRegex=this._monthsRegex,this._monthsStrictRegex=new RegExp("^("+s.join("|")+")","i"),this._monthsShortStrictRegex=new RegExp("^("+n.join("|")+")","i")}function Ae(e){return he(e)?366:365}s("Y",0,0,function(){var e=this.year();return e<=9999?r(e,4):"+"+e}),s(0,["YY",2],0,function(){return this.year()%100}),s(0,["YYYY",4],0,"year"),s(0,["YYYYY",5],0,"year"),s(0,["YYYYYY",6,!0],0,"year"),t("year","y"),n("year",1),v("Y",De),v("YY",p,w),v("YYYY",ke,_e),v("YYYYY",ve,ye),v("YYYYYY",ve,ye),D(["YYYYY","YYYYYY"],Y),D("YYYY",function(e,t){t[Y]=2===e.length?f.parseTwoDigitYear(e):g(e)}),D("YY",function(e,t){t[Y]=f.parseTwoDigitYear(e)}),D("Y",function(e,t){t[Y]=parseInt(e,10)}),f.parseTwoDigitYear=function(e){return g(e)+(68<g(e)?1900:2e3)};var Ie=de("FullYear",!0);function je(e,t,n,s,i,r,a){var o;return e<100&&0<=e?(o=new Date(e+400,t,n,s,i,r,a),isFinite(o.getFullYear())&&o.setFullYear(e)):o=new Date(e,t,n,s,i,r,a),o}function Ze(e){var t;return e<100&&0<=e?((t=Array.prototype.slice.call(arguments))[0]=e+400,t=new Date(Date.UTC.apply(null,t)),isFinite(t.getUTCFullYear())&&t.setUTCFullYear(e)):t=new Date(Date.UTC.apply(null,arguments)),t}function ze(e,t,n){n=7+t-n;return n-(7+Ze(e,0,n).getUTCDay()-t)%7-1}function $e(e,t,n,s,i){var r,t=1+7*(t-1)+(7+n-s)%7+ze(e,s,i),n=t<=0?Ae(r=e-1)+t:t>Ae(e)?(r=e+1,t-Ae(e)):(r=e,t);return{year:r,dayOfYear:n}}function qe(e,t,n){var s,i,r=ze(e.year(),t,n),r=Math.floor((e.dayOfYear()-r-1)/7)+1;return r<1?s=r+P(i=e.year()-1,t,n):r>P(e.year(),t,n)?(s=r-P(e.year(),t,n),i=e.year()+1):(i=e.year(),s=r),{week:s,year:i}}function P(e,t,n){var s=ze(e,t,n),t=ze(e+1,t,n);return(Ae(e)-s+t)/7}s("w",["ww",2],"wo","week"),s("W",["WW",2],"Wo","isoWeek"),t("week","w"),t("isoWeek","W"),n("week",5),n("isoWeek",5),v("w",p),v("ww",p,w),v("W",p),v("WW",p,w),Te(["w","ww","W","WW"],function(e,t,n,s){t[s.substr(0,1)]=g(e)});function Be(e,t){return e.slice(t,7).concat(e.slice(0,t))}s("d",0,"do","day"),s("dd",0,0,function(e){return this.localeData().weekdaysMin(this,e)}),s("ddd",0,0,function(e){return this.localeData().weekdaysShort(this,e)}),s("dddd",0,0,function(e){return this.localeData().weekdays(this,e)}),s("e",0,0,"weekday"),s("E",0,0,"isoWeekday"),t("day","d"),t("weekday","e"),t("isoWeekday","E"),n("day",11),n("weekday",11),n("isoWeekday",11),v("d",p),v("e",p),v("E",p),v("dd",function(e,t){return t.weekdaysMinRegex(e)}),v("ddd",function(e,t){return t.weekdaysShortRegex(e)}),v("dddd",function(e,t){return t.weekdaysRegex(e)}),Te(["dd","ddd","dddd"],function(e,t,n,s){s=n._locale.weekdaysParse(e,s,n._strict);null!=s?t.d=s:m(n).invalidWeekday=e}),Te(["d","e","E"],function(e,t,n,s){t[s]=g(e)});var Je="Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),Qe="Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),Xe="Su_Mo_Tu_We_Th_Fr_Sa".split("_"),Ke=k,et=k,tt=k;function nt(){function e(e,t){return t.length-e.length}for(var t,n,s,i=[],r=[],a=[],o=[],u=0;u<7;u++)s=l([2e3,1]).day(u),t=M(this.weekdaysMin(s,"")),n=M(this.weekdaysShort(s,"")),s=M(this.weekdays(s,"")),i.push(t),r.push(n),a.push(s),o.push(t),o.push(n),o.push(s);i.sort(e),r.sort(e),a.sort(e),o.sort(e),this._weekdaysRegex=new RegExp("^("+o.join("|")+")","i"),this._weekdaysShortRegex=this._weekdaysRegex,this._weekdaysMinRegex=this._weekdaysRegex,this._weekdaysStrictRegex=new RegExp("^("+a.join("|")+")","i"),this._weekdaysShortStrictRegex=new RegExp("^("+r.join("|")+")","i"),this._weekdaysMinStrictRegex=new RegExp("^("+i.join("|")+")","i")}function st(){return this.hours()%12||12}function it(e,t){s(e,0,0,function(){return this.localeData().meridiem(this.hours(),this.minutes(),t)})}function rt(e,t){return t._meridiemParse}s("H",["HH",2],0,"hour"),s("h",["hh",2],0,st),s("k",["kk",2],0,function(){return this.hours()||24}),s("hmm",0,0,function(){return""+st.apply(this)+r(this.minutes(),2)}),s("hmmss",0,0,function(){return""+st.apply(this)+r(this.minutes(),2)+r(this.seconds(),2)}),s("Hmm",0,0,function(){return""+this.hours()+r(this.minutes(),2)}),s("Hmmss",0,0,function(){return""+this.hours()+r(this.minutes(),2)+r(this.seconds(),2)}),it("a",!0),it("A",!1),t("hour","h"),n("hour",13),v("a",rt),v("A",rt),v("H",p),v("h",p),v("k",p),v("HH",p,w),v("hh",p,w),v("kk",p,w),v("hmm",ge),v("hmmss",we),v("Hmm",ge),v("Hmmss",we),D(["H","HH"],x),D(["k","kk"],function(e,t,n){e=g(e);t[x]=24===e?0:e}),D(["a","A"],function(e,t,n){n._isPm=n._locale.isPM(e),n._meridiem=e}),D(["h","hh"],function(e,t,n){t[x]=g(e),m(n).bigHour=!0}),D("hmm",function(e,t,n){var s=e.length-2;t[x]=g(e.substr(0,s)),t[T]=g(e.substr(s)),m(n).bigHour=!0}),D("hmmss",function(e,t,n){var s=e.length-4,i=e.length-2;t[x]=g(e.substr(0,s)),t[T]=g(e.substr(s,2)),t[N]=g(e.substr(i)),m(n).bigHour=!0}),D("Hmm",function(e,t,n){var s=e.length-2;t[x]=g(e.substr(0,s)),t[T]=g(e.substr(s))}),D("Hmmss",function(e,t,n){var s=e.length-4,i=e.length-2;t[x]=g(e.substr(0,s)),t[T]=g(e.substr(s,2)),t[N]=g(e.substr(i))});k=de("Hours",!0);var at,ot={calendar:{sameDay:"[Today at] LT",nextDay:"[Tomorrow at] LT",nextWeek:"dddd [at] LT",lastDay:"[Yesterday at] LT",lastWeek:"[Last] dddd [at] LT",sameElse:"L"},longDateFormat:{LTS:"h:mm:ss A",LT:"h:mm A",L:"MM/DD/YYYY",LL:"MMMM D, YYYY",LLL:"MMMM D, YYYY h:mm A",LLLL:"dddd, MMMM D, YYYY h:mm A"},invalidDate:"Invalid date",ordinal:"%d",dayOfMonthOrdinalParse:/\d{1,2}/,relativeTime:{future:"in %s",past:"%s ago",s:"a few seconds",ss:"%d seconds",m:"a minute",mm:"%d minutes",h:"an hour",hh:"%d hours",d:"a day",dd:"%d days",w:"a week",ww:"%d weeks",M:"a month",MM:"%d months",y:"a year",yy:"%d years"},months:Ce,monthsShort:Ue,week:{dow:0,doy:6},weekdays:Je,weekdaysMin:Xe,weekdaysShort:Qe,meridiemParse:/[ap]\.?m?\.?/i},R={},ut={};function lt(e){return e&&e.toLowerCase().replace("_","-")}function ht(e){for(var t,n,s,i,r=0;r<e.length;){for(t=(i=lt(e[r]).split("-")).length,n=(n=lt(e[r+1]))?n.split("-"):null;0<t;){if(s=dt(i.slice(0,t).join("-")))return s;if(n&&n.length>=t&&function(e,t){for(var n=Math.min(e.length,t.length),s=0;s<n;s+=1)if(e[s]!==t[s])return s;return n}(i,n)>=t-1)break;t--}r++}return at}function dt(t){var e;if(void 0===R[t]&&"undefined"!=typeof module&&module&&module.exports&&null!=t.match("^[^/\\\\]*$"))try{e=at._abbr,require("./locale/"+t),ct(e)}catch(e){R[t]=null}return R[t]}function ct(e,t){return e&&((t=o(t)?mt(e):ft(e,t))?at=t:"undefined"!=typeof console&&console.warn&&console.warn("Locale "+e+" not found. Did you forget to load it?")),at._abbr}function ft(e,t){if(null===t)return delete R[e],null;var n,s=ot;if(t.abbr=e,null!=R[e])Q("defineLocaleOverride","use moment.updateLocale(localeName, config) to change an existing locale. moment.defineLocale(localeName, config) should only be used for creating a new locale See http://momentjs.com/guides/#/warnings/define-locale/ for more info."),s=R[e]._config;else if(null!=t.parentLocale)if(null!=R[t.parentLocale])s=R[t.parentLocale]._config;else{if(null==(n=dt(t.parentLocale)))return ut[t.parentLocale]||(ut[t.parentLocale]=[]),ut[t.parentLocale].push({name:e,config:t}),null;s=n._config}return R[e]=new K(X(s,t)),ut[e]&&ut[e].forEach(function(e){ft(e.name,e.config)}),ct(e),R[e]}function mt(e){var t;if(!(e=e&&e._locale&&e._locale._abbr?e._locale._abbr:e))return at;if(!a(e)){if(t=dt(e))return t;e=[e]}return ht(e)}function _t(e){var t=e._a;return t&&-2===m(e).overflow&&(t=t[O]<0||11<t[O]?O:t[b]<1||t[b]>We(t[Y],t[O])?b:t[x]<0||24<t[x]||24===t[x]&&(0!==t[T]||0!==t[N]||0!==t[Ne])?x:t[T]<0||59<t[T]?T:t[N]<0||59<t[N]?N:t[Ne]<0||999<t[Ne]?Ne:-1,m(e)._overflowDayOfYear&&(t<Y||b<t)&&(t=b),m(e)._overflowWeeks&&-1===t&&(t=Pe),m(e)._overflowWeekday&&-1===t&&(t=Re),m(e).overflow=t),e}var yt=/^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([+-]\d\d(?::?\d\d)?|\s*Z)?)?$/,gt=/^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d|))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([+-]\d\d(?::?\d\d)?|\s*Z)?)?$/,wt=/Z|[+-]\d\d(?::?\d\d)?/,pt=[["YYYYYY-MM-DD",/[+-]\d{6}-\d\d-\d\d/],["YYYY-MM-DD",/\d{4}-\d\d-\d\d/],["GGGG-[W]WW-E",/\d{4}-W\d\d-\d/],["GGGG-[W]WW",/\d{4}-W\d\d/,!1],["YYYY-DDD",/\d{4}-\d{3}/],["YYYY-MM",/\d{4}-\d\d/,!1],["YYYYYYMMDD",/[+-]\d{10}/],["YYYYMMDD",/\d{8}/],["GGGG[W]WWE",/\d{4}W\d{3}/],["GGGG[W]WW",/\d{4}W\d{2}/,!1],["YYYYDDD",/\d{7}/],["YYYYMM",/\d{6}/,!1],["YYYY",/\d{4}/,!1]],kt=[["HH:mm:ss.SSSS",/\d\d:\d\d:\d\d\.\d+/],["HH:mm:ss,SSSS",/\d\d:\d\d:\d\d,\d+/],["HH:mm:ss",/\d\d:\d\d:\d\d/],["HH:mm",/\d\d:\d\d/],["HHmmss.SSSS",/\d\d\d\d\d\d\.\d+/],["HHmmss,SSSS",/\d\d\d\d\d\d,\d+/],["HHmmss",/\d\d\d\d\d\d/],["HHmm",/\d\d\d\d/],["HH",/\d\d/]],vt=/^\/?Date\((-?\d+)/i,Mt=/^(?:(Mon|Tue|Wed|Thu|Fri|Sat|Sun),?\s)?(\d{1,2})\s(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s(\d{2,4})\s(\d\d):(\d\d)(?::(\d\d))?\s(?:(UT|GMT|[ECMP][SD]T)|([Zz])|([+-]\d{4}))$/,Dt={UT:0,GMT:0,EDT:-240,EST:-300,CDT:-300,CST:-360,MDT:-360,MST:-420,PDT:-420,PST:-480};function St(e){var t,n,s,i,r,a,o=e._i,u=yt.exec(o)||gt.exec(o),o=pt.length,l=kt.length;if(u){for(m(e).iso=!0,t=0,n=o;t<n;t++)if(pt[t][1].exec(u[1])){i=pt[t][0],s=!1!==pt[t][2];break}if(null==i)e._isValid=!1;else{if(u[3]){for(t=0,n=l;t<n;t++)if(kt[t][1].exec(u[3])){r=(u[2]||" ")+kt[t][0];break}if(null==r)return void(e._isValid=!1)}if(s||null==r){if(u[4]){if(!wt.exec(u[4]))return void(e._isValid=!1);a="Z"}e._f=i+(r||"")+(a||""),Tt(e)}else e._isValid=!1}}else e._isValid=!1}function Yt(e,t,n,s,i,r){e=[function(e){e=parseInt(e,10);{if(e<=49)return 2e3+e;if(e<=999)return 1900+e}return e}(e),Ue.indexOf(t),parseInt(n,10),parseInt(s,10),parseInt(i,10)];return r&&e.push(parseInt(r,10)),e}function Ot(e){var t,n,s,i,r=Mt.exec(e._i.replace(/\([^()]*\)|[\n\t]/g," ").replace(/(\s\s+)/g," ").replace(/^\s\s*/,"").replace(/\s\s*$/,""));r?(t=Yt(r[4],r[3],r[2],r[5],r[6],r[7]),n=r[1],s=t,i=e,n&&Qe.indexOf(n)!==new Date(s[0],s[1],s[2]).getDay()?(m(i).weekdayMismatch=!0,i._isValid=!1):(e._a=t,e._tzm=(n=r[8],s=r[9],i=r[10],n?Dt[n]:s?0:60*(((n=parseInt(i,10))-(s=n%100))/100)+s),e._d=Ze.apply(null,e._a),e._d.setUTCMinutes(e._d.getUTCMinutes()-e._tzm),m(e).rfc2822=!0)):e._isValid=!1}function bt(e,t,n){return null!=e?e:null!=t?t:n}function xt(e){var t,n,s,i,r,a,o,u,l,h,d,c=[];if(!e._d){for(s=e,i=new Date(f.now()),n=s._useUTC?[i.getUTCFullYear(),i.getUTCMonth(),i.getUTCDate()]:[i.getFullYear(),i.getMonth(),i.getDate()],e._w&&null==e._a[b]&&null==e._a[O]&&(null!=(i=(s=e)._w).GG||null!=i.W||null!=i.E?(u=1,l=4,r=bt(i.GG,s._a[Y],qe(W(),1,4).year),a=bt(i.W,1),((o=bt(i.E,1))<1||7<o)&&(h=!0)):(u=s._locale._week.dow,l=s._locale._week.doy,d=qe(W(),u,l),r=bt(i.gg,s._a[Y],d.year),a=bt(i.w,d.week),null!=i.d?((o=i.d)<0||6<o)&&(h=!0):null!=i.e?(o=i.e+u,(i.e<0||6<i.e)&&(h=!0)):o=u),a<1||a>P(r,u,l)?m(s)._overflowWeeks=!0:null!=h?m(s)._overflowWeekday=!0:(d=$e(r,a,o,u,l),s._a[Y]=d.year,s._dayOfYear=d.dayOfYear)),null!=e._dayOfYear&&(i=bt(e._a[Y],n[Y]),(e._dayOfYear>Ae(i)||0===e._dayOfYear)&&(m(e)._overflowDayOfYear=!0),h=Ze(i,0,e._dayOfYear),e._a[O]=h.getUTCMonth(),e._a[b]=h.getUTCDate()),t=0;t<3&&null==e._a[t];++t)e._a[t]=c[t]=n[t];for(;t<7;t++)e._a[t]=c[t]=null==e._a[t]?2===t?1:0:e._a[t];24===e._a[x]&&0===e._a[T]&&0===e._a[N]&&0===e._a[Ne]&&(e._nextDay=!0,e._a[x]=0),e._d=(e._useUTC?Ze:je).apply(null,c),r=e._useUTC?e._d.getUTCDay():e._d.getDay(),null!=e._tzm&&e._d.setUTCMinutes(e._d.getUTCMinutes()-e._tzm),e._nextDay&&(e._a[x]=24),e._w&&void 0!==e._w.d&&e._w.d!==r&&(m(e).weekdayMismatch=!0)}}function Tt(e){if(e._f===f.ISO_8601)St(e);else if(e._f===f.RFC_2822)Ot(e);else{e._a=[],m(e).empty=!0;for(var t,n,s,i,r,a=""+e._i,o=a.length,u=0,l=ae(e._f,e._locale).match(te)||[],h=l.length,d=0;d<h;d++)n=l[d],(t=(a.match(Oe(n,e))||[])[0])&&(0<(s=a.substr(0,a.indexOf(t))).length&&m(e).unusedInput.push(s),a=a.slice(a.indexOf(t)+t.length),u+=t.length),ie[n]?(t?m(e).empty=!1:m(e).unusedTokens.push(n),s=n,r=e,null!=(i=t)&&c(xe,s)&&xe[s](i,r._a,r,s)):e._strict&&!t&&m(e).unusedTokens.push(n);m(e).charsLeftOver=o-u,0<a.length&&m(e).unusedInput.push(a),e._a[x]<=12&&!0===m(e).bigHour&&0<e._a[x]&&(m(e).bigHour=void 0),m(e).parsedDateParts=e._a.slice(0),m(e).meridiem=e._meridiem,e._a[x]=function(e,t,n){if(null==n)return t;return null!=e.meridiemHour?e.meridiemHour(t,n):null!=e.isPM?((e=e.isPM(n))&&t<12&&(t+=12),t=e||12!==t?t:0):t}(e._locale,e._a[x],e._meridiem),null!==(o=m(e).era)&&(e._a[Y]=e._locale.erasConvertYear(o,e._a[Y])),xt(e),_t(e)}}function Nt(e){var t,n,s,i=e._i,r=e._f;if(e._locale=e._locale||mt(e._l),null===i||void 0===r&&""===i)return I({nullInput:!0});if("string"==typeof i&&(e._i=i=e._locale.preparse(i)),h(i))return new q(_t(i));if(V(i))e._d=i;else if(a(r))!function(e){var t,n,s,i,r,a,o=!1,u=e._f.length;if(0===u)return m(e).invalidFormat=!0,e._d=new Date(NaN);for(i=0;i<u;i++)r=0,a=!1,t=$({},e),null!=e._useUTC&&(t._useUTC=e._useUTC),t._f=e._f[i],Tt(t),A(t)&&(a=!0),r=(r+=m(t).charsLeftOver)+10*m(t).unusedTokens.length,m(t).score=r,o?r<s&&(s=r,n=t):(null==s||r<s||a)&&(s=r,n=t,a&&(o=!0));E(e,n||t)}(e);else if(r)Tt(e);else if(o(r=(i=e)._i))i._d=new Date(f.now());else V(r)?i._d=new Date(r.valueOf()):"string"==typeof r?(n=i,null!==(t=vt.exec(n._i))?n._d=new Date(+t[1]):(St(n),!1===n._isValid&&(delete n._isValid,Ot(n),!1===n._isValid&&(delete n._isValid,n._strict?n._isValid=!1:f.createFromInputFallback(n))))):a(r)?(i._a=G(r.slice(0),function(e){return parseInt(e,10)}),xt(i)):F(r)?(t=i)._d||(s=void 0===(n=ue(t._i)).day?n.date:n.day,t._a=G([n.year,n.month,s,n.hour,n.minute,n.second,n.millisecond],function(e){return e&&parseInt(e,10)}),xt(t)):u(r)?i._d=new Date(r):f.createFromInputFallback(i);return A(e)||(e._d=null),e}function Pt(e,t,n,s,i){var r={};return!0!==t&&!1!==t||(s=t,t=void 0),!0!==n&&!1!==n||(s=n,n=void 0),(F(e)&&L(e)||a(e)&&0===e.length)&&(e=void 0),r._isAMomentObject=!0,r._useUTC=r._isUTC=i,r._l=n,r._i=e,r._f=t,r._strict=s,(i=new q(_t(Nt(i=r))))._nextDay&&(i.add(1,"d"),i._nextDay=void 0),i}function W(e,t,n,s){return Pt(e,t,n,s,!1)}f.createFromInputFallback=e("value provided is not in a recognized RFC2822 or ISO format. moment construction falls back to js Date(), which is not reliable across all browsers and versions. Non RFC2822/ISO date formats are discouraged. Please refer to http://momentjs.com/guides/#/warnings/js-date/ for more info.",function(e){e._d=new Date(e._i+(e._useUTC?" UTC":""))}),f.ISO_8601=function(){},f.RFC_2822=function(){};ge=e("moment().min is deprecated, use moment.max instead. http://momentjs.com/guides/#/warnings/min-max/",function(){var e=W.apply(null,arguments);return this.isValid()&&e.isValid()?e<this?this:e:I()}),we=e("moment().max is deprecated, use moment.min instead. http://momentjs.com/guides/#/warnings/min-max/",function(){var e=W.apply(null,arguments);return this.isValid()&&e.isValid()?this<e?this:e:I()});function Rt(e,t){var n,s;if(!(t=1===t.length&&a(t[0])?t[0]:t).length)return W();for(n=t[0],s=1;s<t.length;++s)t[s].isValid()&&!t[s][e](n)||(n=t[s]);return n}var Wt=["year","quarter","month","week","day","hour","minute","second","millisecond"];function Ct(e){var e=ue(e),t=e.year||0,n=e.quarter||0,s=e.month||0,i=e.week||e.isoWeek||0,r=e.day||0,a=e.hour||0,o=e.minute||0,u=e.second||0,l=e.millisecond||0;this._isValid=function(e){var t,n,s=!1,i=Wt.length;for(t in e)if(c(e,t)&&(-1===S.call(Wt,t)||null!=e[t]&&isNaN(e[t])))return!1;for(n=0;n<i;++n)if(e[Wt[n]]){if(s)return!1;parseFloat(e[Wt[n]])!==g(e[Wt[n]])&&(s=!0)}return!0}(e),this._milliseconds=+l+1e3*u+6e4*o+1e3*a*60*60,this._days=+r+7*i,this._months=+s+3*n+12*t,this._data={},this._locale=mt(),this._bubble()}function Ut(e){return e instanceof Ct}function Ht(e){return e<0?-1*Math.round(-1*e):Math.round(e)}function Ft(e,n){s(e,0,0,function(){var e=this.utcOffset(),t="+";return e<0&&(e=-e,t="-"),t+r(~~(e/60),2)+n+r(~~e%60,2)})}Ft("Z",":"),Ft("ZZ",""),v("Z",Ye),v("ZZ",Ye),D(["Z","ZZ"],function(e,t,n){n._useUTC=!0,n._tzm=Vt(Ye,e)});var Lt=/([\+\-]|\d\d)/gi;function Vt(e,t){var t=(t||"").match(e);return null===t?null:0===(t=60*(e=((t[t.length-1]||[])+"").match(Lt)||["-",0,0])[1]+g(e[2]))?0:"+"===e[0]?t:-t}function Gt(e,t){var n;return t._isUTC?(t=t.clone(),n=(h(e)||V(e)?e:W(e)).valueOf()-t.valueOf(),t._d.setTime(t._d.valueOf()+n),f.updateOffset(t,!1),t):W(e).local()}function Et(e){return-Math.round(e._d.getTimezoneOffset())}function At(){return!!this.isValid()&&(this._isUTC&&0===this._offset)}f.updateOffset=function(){};var It=/^(-|\+)?(?:(\d*)[. ])?(\d+):(\d+)(?::(\d+)(\.\d*)?)?$/,jt=/^(-|\+)?P(?:([-+]?[0-9,.]*)Y)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)W)?(?:([-+]?[0-9,.]*)D)?(?:T(?:([-+]?[0-9,.]*)H)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)S)?)?$/;function C(e,t){var n,s=e,i=null;return Ut(e)?s={ms:e._milliseconds,d:e._days,M:e._months}:u(e)||!isNaN(+e)?(s={},t?s[t]=+e:s.milliseconds=+e):(i=It.exec(e))?(n="-"===i[1]?-1:1,s={y:0,d:g(i[b])*n,h:g(i[x])*n,m:g(i[T])*n,s:g(i[N])*n,ms:g(Ht(1e3*i[Ne]))*n}):(i=jt.exec(e))?(n="-"===i[1]?-1:1,s={y:Zt(i[2],n),M:Zt(i[3],n),w:Zt(i[4],n),d:Zt(i[5],n),h:Zt(i[6],n),m:Zt(i[7],n),s:Zt(i[8],n)}):null==s?s={}:"object"==typeof s&&("from"in s||"to"in s)&&(t=function(e,t){var n;if(!e.isValid()||!t.isValid())return{milliseconds:0,months:0};t=Gt(t,e),e.isBefore(t)?n=zt(e,t):((n=zt(t,e)).milliseconds=-n.milliseconds,n.months=-n.months);return n}(W(s.from),W(s.to)),(s={}).ms=t.milliseconds,s.M=t.months),i=new Ct(s),Ut(e)&&c(e,"_locale")&&(i._locale=e._locale),Ut(e)&&c(e,"_isValid")&&(i._isValid=e._isValid),i}function Zt(e,t){e=e&&parseFloat(e.replace(",","."));return(isNaN(e)?0:e)*t}function zt(e,t){var n={};return n.months=t.month()-e.month()+12*(t.year()-e.year()),e.clone().add(n.months,"M").isAfter(t)&&--n.months,n.milliseconds=+t-+e.clone().add(n.months,"M"),n}function $t(s,i){return function(e,t){var n;return null===t||isNaN(+t)||(Q(i,"moment()."+i+"(period, number) is deprecated. Please use moment()."+i+"(number, period). See http://momentjs.com/guides/#/warnings/add-inverted-param/ for more info."),n=e,e=t,t=n),qt(this,C(e,t),s),this}}function qt(e,t,n,s){var i=t._milliseconds,r=Ht(t._days),t=Ht(t._months);e.isValid()&&(s=null==s||s,t&&Ve(e,ce(e,"Month")+t*n),r&&fe(e,"Date",ce(e,"Date")+r*n),i&&e._d.setTime(e._d.valueOf()+i*n),s&&f.updateOffset(e,r||t))}C.fn=Ct.prototype,C.invalid=function(){return C(NaN)};Ce=$t(1,"add"),Je=$t(-1,"subtract");function Bt(e){return"string"==typeof e||e instanceof String}function Jt(e){return h(e)||V(e)||Bt(e)||u(e)||function(t){var e=a(t),n=!1;e&&(n=0===t.filter(function(e){return!u(e)&&Bt(t)}).length);return e&&n}(e)||function(e){var t,n,s=F(e)&&!L(e),i=!1,r=["years","year","y","months","month","M","days","day","d","dates","date","D","hours","hour","h","minutes","minute","m","seconds","second","s","milliseconds","millisecond","ms"],a=r.length;for(t=0;t<a;t+=1)n=r[t],i=i||c(e,n);return s&&i}(e)||null==e}function Qt(e,t){if(e.date()<t.date())return-Qt(t,e);var n=12*(t.year()-e.year())+(t.month()-e.month()),s=e.clone().add(n,"months"),t=t-s<0?(t-s)/(s-e.clone().add(n-1,"months")):(t-s)/(e.clone().add(1+n,"months")-s);return-(n+t)||0}function Xt(e){return void 0===e?this._locale._abbr:(null!=(e=mt(e))&&(this._locale=e),this)}f.defaultFormat="YYYY-MM-DDTHH:mm:ssZ",f.defaultFormatUtc="YYYY-MM-DDTHH:mm:ss[Z]";Xe=e("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.",function(e){return void 0===e?this.localeData():this.locale(e)});function Kt(){return this._locale}var en=126227808e5;function tn(e,t){return(e%t+t)%t}function nn(e,t,n){return e<100&&0<=e?new Date(e+400,t,n)-en:new Date(e,t,n).valueOf()}function sn(e,t,n){return e<100&&0<=e?Date.UTC(e+400,t,n)-en:Date.UTC(e,t,n)}function rn(e,t){return t.erasAbbrRegex(e)}function an(){for(var e=[],t=[],n=[],s=[],i=this.eras(),r=0,a=i.length;r<a;++r)t.push(M(i[r].name)),e.push(M(i[r].abbr)),n.push(M(i[r].narrow)),s.push(M(i[r].name)),s.push(M(i[r].abbr)),s.push(M(i[r].narrow));this._erasRegex=new RegExp("^("+s.join("|")+")","i"),this._erasNameRegex=new RegExp("^("+t.join("|")+")","i"),this._erasAbbrRegex=new RegExp("^("+e.join("|")+")","i"),this._erasNarrowRegex=new RegExp("^("+n.join("|")+")","i")}function on(e,t){s(0,[e,e.length],0,t)}function un(e,t,n,s,i){var r;return null==e?qe(this,s,i).year:(r=P(e,s,i),function(e,t,n,s,i){e=$e(e,t,n,s,i),t=Ze(e.year,0,e.dayOfYear);return this.year(t.getUTCFullYear()),this.month(t.getUTCMonth()),this.date(t.getUTCDate()),this}.call(this,e,t=r<t?r:t,n,s,i))}s("N",0,0,"eraAbbr"),s("NN",0,0,"eraAbbr"),s("NNN",0,0,"eraAbbr"),s("NNNN",0,0,"eraName"),s("NNNNN",0,0,"eraNarrow"),s("y",["y",1],"yo","eraYear"),s("y",["yy",2],0,"eraYear"),s("y",["yyy",3],0,"eraYear"),s("y",["yyyy",4],0,"eraYear"),v("N",rn),v("NN",rn),v("NNN",rn),v("NNNN",function(e,t){return t.erasNameRegex(e)}),v("NNNNN",function(e,t){return t.erasNarrowRegex(e)}),D(["N","NN","NNN","NNNN","NNNNN"],function(e,t,n,s){s=n._locale.erasParse(e,s,n._strict);s?m(n).era=s:m(n).invalidEra=e}),v("y",Me),v("yy",Me),v("yyy",Me),v("yyyy",Me),v("yo",function(e,t){return t._eraYearOrdinalRegex||Me}),D(["y","yy","yyy","yyyy"],Y),D(["yo"],function(e,t,n,s){var i;n._locale._eraYearOrdinalRegex&&(i=e.match(n._locale._eraYearOrdinalRegex)),n._locale.eraYearOrdinalParse?t[Y]=n._locale.eraYearOrdinalParse(e,i):t[Y]=parseInt(e,10)}),s(0,["gg",2],0,function(){return this.weekYear()%100}),s(0,["GG",2],0,function(){return this.isoWeekYear()%100}),on("gggg","weekYear"),on("ggggg","weekYear"),on("GGGG","isoWeekYear"),on("GGGGG","isoWeekYear"),t("weekYear","gg"),t("isoWeekYear","GG"),n("weekYear",1),n("isoWeekYear",1),v("G",De),v("g",De),v("GG",p,w),v("gg",p,w),v("GGGG",ke,_e),v("gggg",ke,_e),v("GGGGG",ve,ye),v("ggggg",ve,ye),Te(["gggg","ggggg","GGGG","GGGGG"],function(e,t,n,s){t[s.substr(0,2)]=g(e)}),Te(["gg","GG"],function(e,t,n,s){t[s]=f.parseTwoDigitYear(e)}),s("Q",0,"Qo","quarter"),t("quarter","Q"),n("quarter",7),v("Q",i),D("Q",function(e,t){t[O]=3*(g(e)-1)}),s("D",["DD",2],"Do","date"),t("date","D"),n("date",9),v("D",p),v("DD",p,w),v("Do",function(e,t){return e?t._dayOfMonthOrdinalParse||t._ordinalParse:t._dayOfMonthOrdinalParseLenient}),D(["D","DD"],b),D("Do",function(e,t){t[b]=g(e.match(p)[0])});ke=de("Date",!0);s("DDD",["DDDD",3],"DDDo","dayOfYear"),t("dayOfYear","DDD"),n("dayOfYear",4),v("DDD",pe),v("DDDD",me),D(["DDD","DDDD"],function(e,t,n){n._dayOfYear=g(e)}),s("m",["mm",2],0,"minute"),t("minute","m"),n("minute",14),v("m",p),v("mm",p,w),D(["m","mm"],T);var ln,_e=de("Minutes",!1),ve=(s("s",["ss",2],0,"second"),t("second","s"),n("second",15),v("s",p),v("ss",p,w),D(["s","ss"],N),de("Seconds",!1));for(s("S",0,0,function(){return~~(this.millisecond()/100)}),s(0,["SS",2],0,function(){return~~(this.millisecond()/10)}),s(0,["SSS",3],0,"millisecond"),s(0,["SSSS",4],0,function(){return 10*this.millisecond()}),s(0,["SSSSS",5],0,function(){return 100*this.millisecond()}),s(0,["SSSSSS",6],0,function(){return 1e3*this.millisecond()}),s(0,["SSSSSSS",7],0,function(){return 1e4*this.millisecond()}),s(0,["SSSSSSSS",8],0,function(){return 1e5*this.millisecond()}),s(0,["SSSSSSSSS",9],0,function(){return 1e6*this.millisecond()}),t("millisecond","ms"),n("millisecond",16),v("S",pe,i),v("SS",pe,w),v("SSS",pe,me),ln="SSSS";ln.length<=9;ln+="S")v(ln,Me);function hn(e,t){t[Ne]=g(1e3*("0."+e))}for(ln="S";ln.length<=9;ln+="S")D(ln,hn);ye=de("Milliseconds",!1),s("z",0,0,"zoneAbbr"),s("zz",0,0,"zoneName");i=q.prototype;function dn(e){return e}i.add=Ce,i.calendar=function(e,t){1===arguments.length&&(arguments[0]?Jt(arguments[0])?(e=arguments[0],t=void 0):function(e){for(var t=F(e)&&!L(e),n=!1,s=["sameDay","nextDay","lastDay","nextWeek","lastWeek","sameElse"],i=0;i<s.length;i+=1)n=n||c(e,s[i]);return t&&n}(arguments[0])&&(t=arguments[0],e=void 0):t=e=void 0);var e=e||W(),n=Gt(e,this).startOf("day"),n=f.calendarFormat(this,n)||"sameElse",t=t&&(d(t[n])?t[n].call(this,e):t[n]);return this.format(t||this.localeData().calendar(n,this,W(e)))},i.clone=function(){return new q(this)},i.diff=function(e,t,n){var s,i,r;if(!this.isValid())return NaN;if(!(s=Gt(e,this)).isValid())return NaN;switch(i=6e4*(s.utcOffset()-this.utcOffset()),t=_(t)){case"year":r=Qt(this,s)/12;break;case"month":r=Qt(this,s);break;case"quarter":r=Qt(this,s)/3;break;case"second":r=(this-s)/1e3;break;case"minute":r=(this-s)/6e4;break;case"hour":r=(this-s)/36e5;break;case"day":r=(this-s-i)/864e5;break;case"week":r=(this-s-i)/6048e5;break;default:r=this-s}return n?r:y(r)},i.endOf=function(e){var t,n;if(void 0===(e=_(e))||"millisecond"===e||!this.isValid())return this;switch(n=this._isUTC?sn:nn,e){case"year":t=n(this.year()+1,0,1)-1;break;case"quarter":t=n(this.year(),this.month()-this.month()%3+3,1)-1;break;case"month":t=n(this.year(),this.month()+1,1)-1;break;case"week":t=n(this.year(),this.month(),this.date()-this.weekday()+7)-1;break;case"isoWeek":t=n(this.year(),this.month(),this.date()-(this.isoWeekday()-1)+7)-1;break;case"day":case"date":t=n(this.year(),this.month(),this.date()+1)-1;break;case"hour":t=this._d.valueOf(),t+=36e5-tn(t+(this._isUTC?0:6e4*this.utcOffset()),36e5)-1;break;case"minute":t=this._d.valueOf(),t+=6e4-tn(t,6e4)-1;break;case"second":t=this._d.valueOf(),t+=1e3-tn(t,1e3)-1;break}return this._d.setTime(t),f.updateOffset(this,!0),this},i.format=function(e){return e=e||(this.isUtc()?f.defaultFormatUtc:f.defaultFormat),e=re(this,e),this.localeData().postformat(e)},i.from=function(e,t){return this.isValid()&&(h(e)&&e.isValid()||W(e).isValid())?C({to:this,from:e}).locale(this.locale()).humanize(!t):this.localeData().invalidDate()},i.fromNow=function(e){return this.from(W(),e)},i.to=function(e,t){return this.isValid()&&(h(e)&&e.isValid()||W(e).isValid())?C({from:this,to:e}).locale(this.locale()).humanize(!t):this.localeData().invalidDate()},i.toNow=function(e){return this.to(W(),e)},i.get=function(e){return d(this[e=_(e)])?this[e]():this},i.invalidAt=function(){return m(this).overflow},i.isAfter=function(e,t){return e=h(e)?e:W(e),!(!this.isValid()||!e.isValid())&&("millisecond"===(t=_(t)||"millisecond")?this.valueOf()>e.valueOf():e.valueOf()<this.clone().startOf(t).valueOf())},i.isBefore=function(e,t){return e=h(e)?e:W(e),!(!this.isValid()||!e.isValid())&&("millisecond"===(t=_(t)||"millisecond")?this.valueOf()<e.valueOf():this.clone().endOf(t).valueOf()<e.valueOf())},i.isBetween=function(e,t,n,s){return e=h(e)?e:W(e),t=h(t)?t:W(t),!!(this.isValid()&&e.isValid()&&t.isValid())&&(("("===(s=s||"()")[0]?this.isAfter(e,n):!this.isBefore(e,n))&&(")"===s[1]?this.isBefore(t,n):!this.isAfter(t,n)))},i.isSame=function(e,t){var e=h(e)?e:W(e);return!(!this.isValid()||!e.isValid())&&("millisecond"===(t=_(t)||"millisecond")?this.valueOf()===e.valueOf():(e=e.valueOf(),this.clone().startOf(t).valueOf()<=e&&e<=this.clone().endOf(t).valueOf()))},i.isSameOrAfter=function(e,t){return this.isSame(e,t)||this.isAfter(e,t)},i.isSameOrBefore=function(e,t){return this.isSame(e,t)||this.isBefore(e,t)},i.isValid=function(){return A(this)},i.lang=Xe,i.locale=Xt,i.localeData=Kt,i.max=we,i.min=ge,i.parsingFlags=function(){return E({},m(this))},i.set=function(e,t){if("object"==typeof e)for(var n=function(e){var t,n=[];for(t in e)c(e,t)&&n.push({unit:t,priority:le[t]});return n.sort(function(e,t){return e.priority-t.priority}),n}(e=ue(e)),s=n.length,i=0;i<s;i++)this[n[i].unit](e[n[i].unit]);else if(d(this[e=_(e)]))return this[e](t);return this},i.startOf=function(e){var t,n;if(void 0===(e=_(e))||"millisecond"===e||!this.isValid())return this;switch(n=this._isUTC?sn:nn,e){case"year":t=n(this.year(),0,1);break;case"quarter":t=n(this.year(),this.month()-this.month()%3,1);break;case"month":t=n(this.year(),this.month(),1);break;case"week":t=n(this.year(),this.month(),this.date()-this.weekday());break;case"isoWeek":t=n(this.year(),this.month(),this.date()-(this.isoWeekday()-1));break;case"day":case"date":t=n(this.year(),this.month(),this.date());break;case"hour":t=this._d.valueOf(),t-=tn(t+(this._isUTC?0:6e4*this.utcOffset()),36e5);break;case"minute":t=this._d.valueOf(),t-=tn(t,6e4);break;case"second":t=this._d.valueOf(),t-=tn(t,1e3);break}return this._d.setTime(t),f.updateOffset(this,!0),this},i.subtract=Je,i.toArray=function(){var e=this;return[e.year(),e.month(),e.date(),e.hour(),e.minute(),e.second(),e.millisecond()]},i.toObject=function(){var e=this;return{years:e.year(),months:e.month(),date:e.date(),hours:e.hours(),minutes:e.minutes(),seconds:e.seconds(),milliseconds:e.milliseconds()}},i.toDate=function(){return new Date(this.valueOf())},i.toISOString=function(e){if(!this.isValid())return null;var t=(e=!0!==e)?this.clone().utc():this;return t.year()<0||9999<t.year()?re(t,e?"YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]":"YYYYYY-MM-DD[T]HH:mm:ss.SSSZ"):d(Date.prototype.toISOString)?e?this.toDate().toISOString():new Date(this.valueOf()+60*this.utcOffset()*1e3).toISOString().replace("Z",re(t,"Z")):re(t,e?"YYYY-MM-DD[T]HH:mm:ss.SSS[Z]":"YYYY-MM-DD[T]HH:mm:ss.SSSZ")},i.inspect=function(){if(!this.isValid())return"moment.invalid(/* "+this._i+" */)";var e,t="moment",n="";return this.isLocal()||(t=0===this.utcOffset()?"moment.utc":"moment.parseZone",n="Z"),t="["+t+'("]',e=0<=this.year()&&this.year()<=9999?"YYYY":"YYYYYY",this.format(t+e+"-MM-DD[T]HH:mm:ss.SSS"+(n+'[")]'))},"undefined"!=typeof Symbol&&null!=Symbol.for&&(i[Symbol.for("nodejs.util.inspect.custom")]=function(){return"Moment<"+this.format()+">"}),i.toJSON=function(){return this.isValid()?this.toISOString():null},i.toString=function(){return this.clone().locale("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ")},i.unix=function(){return Math.floor(this.valueOf()/1e3)},i.valueOf=function(){return this._d.valueOf()-6e4*(this._offset||0)},i.creationData=function(){return{input:this._i,format:this._f,locale:this._locale,isUTC:this._isUTC,strict:this._strict}},i.eraName=function(){for(var e,t=this.localeData().eras(),n=0,s=t.length;n<s;++n){if(e=this.clone().startOf("day").valueOf(),t[n].since<=e&&e<=t[n].until)return t[n].name;if(t[n].until<=e&&e<=t[n].since)return t[n].name}return""},i.eraNarrow=function(){for(var e,t=this.localeData().eras(),n=0,s=t.length;n<s;++n){if(e=this.clone().startOf("day").valueOf(),t[n].since<=e&&e<=t[n].until)return t[n].narrow;if(t[n].until<=e&&e<=t[n].since)return t[n].narrow}return""},i.eraAbbr=function(){for(var e,t=this.localeData().eras(),n=0,s=t.length;n<s;++n){if(e=this.clone().startOf("day").valueOf(),t[n].since<=e&&e<=t[n].until)return t[n].abbr;if(t[n].until<=e&&e<=t[n].since)return t[n].abbr}return""},i.eraYear=function(){for(var e,t,n=this.localeData().eras(),s=0,i=n.length;s<i;++s)if(e=n[s].since<=n[s].until?1:-1,t=this.clone().startOf("day").valueOf(),n[s].since<=t&&t<=n[s].until||n[s].until<=t&&t<=n[s].since)return(this.year()-f(n[s].since).year())*e+n[s].offset;return this.year()},i.year=Ie,i.isLeapYear=function(){return he(this.year())},i.weekYear=function(e){return un.call(this,e,this.week(),this.weekday(),this.localeData()._week.dow,this.localeData()._week.doy)},i.isoWeekYear=function(e){return un.call(this,e,this.isoWeek(),this.isoWeekday(),1,4)},i.quarter=i.quarters=function(e){return null==e?Math.ceil((this.month()+1)/3):this.month(3*(e-1)+this.month()%3)},i.month=Ge,i.daysInMonth=function(){return We(this.year(),this.month())},i.week=i.weeks=function(e){var t=this.localeData().week(this);return null==e?t:this.add(7*(e-t),"d")},i.isoWeek=i.isoWeeks=function(e){var t=qe(this,1,4).week;return null==e?t:this.add(7*(e-t),"d")},i.weeksInYear=function(){var e=this.localeData()._week;return P(this.year(),e.dow,e.doy)},i.weeksInWeekYear=function(){var e=this.localeData()._week;return P(this.weekYear(),e.dow,e.doy)},i.isoWeeksInYear=function(){return P(this.year(),1,4)},i.isoWeeksInISOWeekYear=function(){return P(this.isoWeekYear(),1,4)},i.date=ke,i.day=i.days=function(e){if(!this.isValid())return null!=e?this:NaN;var t,n,s=this._isUTC?this._d.getUTCDay():this._d.getDay();return null!=e?(t=e,n=this.localeData(),e="string"!=typeof t?t:isNaN(t)?"number"==typeof(t=n.weekdaysParse(t))?t:null:parseInt(t,10),this.add(e-s,"d")):s},i.weekday=function(e){if(!this.isValid())return null!=e?this:NaN;var t=(this.day()+7-this.localeData()._week.dow)%7;return null==e?t:this.add(e-t,"d")},i.isoWeekday=function(e){return this.isValid()?null!=e?(t=e,n=this.localeData(),n="string"==typeof t?n.weekdaysParse(t)%7||7:isNaN(t)?null:t,this.day(this.day()%7?n:n-7)):this.day()||7:null!=e?this:NaN;var t,n},i.dayOfYear=function(e){var t=Math.round((this.clone().startOf("day")-this.clone().startOf("year"))/864e5)+1;return null==e?t:this.add(e-t,"d")},i.hour=i.hours=k,i.minute=i.minutes=_e,i.second=i.seconds=ve,i.millisecond=i.milliseconds=ye,i.utcOffset=function(e,t,n){var s,i=this._offset||0;if(!this.isValid())return null!=e?this:NaN;if(null==e)return this._isUTC?i:Et(this);if("string"==typeof e){if(null===(e=Vt(Ye,e)))return this}else Math.abs(e)<16&&!n&&(e*=60);return!this._isUTC&&t&&(s=Et(this)),this._offset=e,this._isUTC=!0,null!=s&&this.add(s,"m"),i!==e&&(!t||this._changeInProgress?qt(this,C(e-i,"m"),1,!1):this._changeInProgress||(this._changeInProgress=!0,f.updateOffset(this,!0),this._changeInProgress=null)),this},i.utc=function(e){return this.utcOffset(0,e)},i.local=function(e){return this._isUTC&&(this.utcOffset(0,e),this._isUTC=!1,e&&this.subtract(Et(this),"m")),this},i.parseZone=function(){var e;return null!=this._tzm?this.utcOffset(this._tzm,!1,!0):"string"==typeof this._i&&(null!=(e=Vt(Se,this._i))?this.utcOffset(e):this.utcOffset(0,!0)),this},i.hasAlignedHourOffset=function(e){return!!this.isValid()&&(e=e?W(e).utcOffset():0,(this.utcOffset()-e)%60==0)},i.isDST=function(){return this.utcOffset()>this.clone().month(0).utcOffset()||this.utcOffset()>this.clone().month(5).utcOffset()},i.isLocal=function(){return!!this.isValid()&&!this._isUTC},i.isUtcOffset=function(){return!!this.isValid()&&this._isUTC},i.isUtc=At,i.isUTC=At,i.zoneAbbr=function(){return this._isUTC?"UTC":""},i.zoneName=function(){return this._isUTC?"Coordinated Universal Time":""},i.dates=e("dates accessor is deprecated. Use date instead.",ke),i.months=e("months accessor is deprecated. Use month instead",Ge),i.years=e("years accessor is deprecated. Use year instead",Ie),i.zone=e("moment().zone is deprecated, use moment().utcOffset instead. http://momentjs.com/guides/#/warnings/zone/",function(e,t){return null!=e?(this.utcOffset(e="string"!=typeof e?-e:e,t),this):-this.utcOffset()}),i.isDSTShifted=e("isDSTShifted is deprecated. See http://momentjs.com/guides/#/warnings/dst-shifted/ for more information",function(){if(!o(this._isDSTShifted))return this._isDSTShifted;var e,t={};return $(t,this),(t=Nt(t))._a?(e=(t._isUTC?l:W)(t._a),this._isDSTShifted=this.isValid()&&0<function(e,t,n){for(var s=Math.min(e.length,t.length),i=Math.abs(e.length-t.length),r=0,a=0;a<s;a++)(n&&e[a]!==t[a]||!n&&g(e[a])!==g(t[a]))&&r++;return r+i}(t._a,e.toArray())):this._isDSTShifted=!1,this._isDSTShifted});w=K.prototype;function cn(e,t,n,s){var i=mt(),s=l().set(s,t);return i[n](s,e)}function fn(e,t,n){if(u(e)&&(t=e,e=void 0),e=e||"",null!=t)return cn(e,t,n,"month");for(var s=[],i=0;i<12;i++)s[i]=cn(e,i,n,"month");return s}function mn(e,t,n,s){t=("boolean"==typeof e?u(t)&&(n=t,t=void 0):(t=e,e=!1,u(n=t)&&(n=t,t=void 0)),t||"");var i,r=mt(),a=e?r._week.dow:0,o=[];if(null!=n)return cn(t,(n+a)%7,s,"day");for(i=0;i<7;i++)o[i]=cn(t,(i+a)%7,s,"day");return o}w.calendar=function(e,t,n){return d(e=this._calendar[e]||this._calendar.sameElse)?e.call(t,n):e},w.longDateFormat=function(e){var t=this._longDateFormat[e],n=this._longDateFormat[e.toUpperCase()];return t||!n?t:(this._longDateFormat[e]=n.match(te).map(function(e){return"MMMM"===e||"MM"===e||"DD"===e||"dddd"===e?e.slice(1):e}).join(""),this._longDateFormat[e])},w.invalidDate=function(){return this._invalidDate},w.ordinal=function(e){return this._ordinal.replace("%d",e)},w.preparse=dn,w.postformat=dn,w.relativeTime=function(e,t,n,s){var i=this._relativeTime[n];return d(i)?i(e,t,n,s):i.replace(/%d/i,e)},w.pastFuture=function(e,t){return d(e=this._relativeTime[0<e?"future":"past"])?e(t):e.replace(/%s/i,t)},w.set=function(e){var t,n;for(n in e)c(e,n)&&(d(t=e[n])?this[n]=t:this["_"+n]=t);this._config=e,this._dayOfMonthOrdinalParseLenient=new RegExp((this._dayOfMonthOrdinalParse.source||this._ordinalParse.source)+"|"+/\d{1,2}/.source)},w.eras=function(e,t){for(var n,s=this._eras||mt("en")._eras,i=0,r=s.length;i<r;++i){switch(typeof s[i].since){case"string":n=f(s[i].since).startOf("day"),s[i].since=n.valueOf();break}switch(typeof s[i].until){case"undefined":s[i].until=1/0;break;case"string":n=f(s[i].until).startOf("day").valueOf(),s[i].until=n.valueOf();break}}return s},w.erasParse=function(e,t,n){var s,i,r,a,o,u=this.eras();for(e=e.toUpperCase(),s=0,i=u.length;s<i;++s)if(r=u[s].name.toUpperCase(),a=u[s].abbr.toUpperCase(),o=u[s].narrow.toUpperCase(),n)switch(t){case"N":case"NN":case"NNN":if(a===e)return u[s];break;case"NNNN":if(r===e)return u[s];break;case"NNNNN":if(o===e)return u[s];break}else if(0<=[r,a,o].indexOf(e))return u[s]},w.erasConvertYear=function(e,t){var n=e.since<=e.until?1:-1;return void 0===t?f(e.since).year():f(e.since).year()+(t-e.offset)*n},w.erasAbbrRegex=function(e){return c(this,"_erasAbbrRegex")||an.call(this),e?this._erasAbbrRegex:this._erasRegex},w.erasNameRegex=function(e){return c(this,"_erasNameRegex")||an.call(this),e?this._erasNameRegex:this._erasRegex},w.erasNarrowRegex=function(e){return c(this,"_erasNarrowRegex")||an.call(this),e?this._erasNarrowRegex:this._erasRegex},w.months=function(e,t){return e?(a(this._months)?this._months:this._months[(this._months.isFormat||He).test(t)?"format":"standalone"])[e.month()]:a(this._months)?this._months:this._months.standalone},w.monthsShort=function(e,t){return e?(a(this._monthsShort)?this._monthsShort:this._monthsShort[He.test(t)?"format":"standalone"])[e.month()]:a(this._monthsShort)?this._monthsShort:this._monthsShort.standalone},w.monthsParse=function(e,t,n){var s,i;if(this._monthsParseExact)return function(e,t,n){var s,i,r,e=e.toLocaleLowerCase();if(!this._monthsParse)for(this._monthsParse=[],this._longMonthsParse=[],this._shortMonthsParse=[],s=0;s<12;++s)r=l([2e3,s]),this._shortMonthsParse[s]=this.monthsShort(r,"").toLocaleLowerCase(),this._longMonthsParse[s]=this.months(r,"").toLocaleLowerCase();return n?"MMM"===t?-1!==(i=S.call(this._shortMonthsParse,e))?i:null:-1!==(i=S.call(this._longMonthsParse,e))?i:null:"MMM"===t?-1!==(i=S.call(this._shortMonthsParse,e))||-1!==(i=S.call(this._longMonthsParse,e))?i:null:-1!==(i=S.call(this._longMonthsParse,e))||-1!==(i=S.call(this._shortMonthsParse,e))?i:null}.call(this,e,t,n);for(this._monthsParse||(this._monthsParse=[],this._longMonthsParse=[],this._shortMonthsParse=[]),s=0;s<12;s++){if(i=l([2e3,s]),n&&!this._longMonthsParse[s]&&(this._longMonthsParse[s]=new RegExp("^"+this.months(i,"").replace(".","")+"$","i"),this._shortMonthsParse[s]=new RegExp("^"+this.monthsShort(i,"").replace(".","")+"$","i")),n||this._monthsParse[s]||(i="^"+this.months(i,"")+"|^"+this.monthsShort(i,""),this._monthsParse[s]=new RegExp(i.replace(".",""),"i")),n&&"MMMM"===t&&this._longMonthsParse[s].test(e))return s;if(n&&"MMM"===t&&this._shortMonthsParse[s].test(e))return s;if(!n&&this._monthsParse[s].test(e))return s}},w.monthsRegex=function(e){return this._monthsParseExact?(c(this,"_monthsRegex")||Ee.call(this),e?this._monthsStrictRegex:this._monthsRegex):(c(this,"_monthsRegex")||(this._monthsRegex=Le),this._monthsStrictRegex&&e?this._monthsStrictRegex:this._monthsRegex)},w.monthsShortRegex=function(e){return this._monthsParseExact?(c(this,"_monthsRegex")||Ee.call(this),e?this._monthsShortStrictRegex:this._monthsShortRegex):(c(this,"_monthsShortRegex")||(this._monthsShortRegex=Fe),this._monthsShortStrictRegex&&e?this._monthsShortStrictRegex:this._monthsShortRegex)},w.week=function(e){return qe(e,this._week.dow,this._week.doy).week},w.firstDayOfYear=function(){return this._week.doy},w.firstDayOfWeek=function(){return this._week.dow},w.weekdays=function(e,t){return t=a(this._weekdays)?this._weekdays:this._weekdays[e&&!0!==e&&this._weekdays.isFormat.test(t)?"format":"standalone"],!0===e?Be(t,this._week.dow):e?t[e.day()]:t},w.weekdaysMin=function(e){return!0===e?Be(this._weekdaysMin,this._week.dow):e?this._weekdaysMin[e.day()]:this._weekdaysMin},w.weekdaysShort=function(e){return!0===e?Be(this._weekdaysShort,this._week.dow):e?this._weekdaysShort[e.day()]:this._weekdaysShort},w.weekdaysParse=function(e,t,n){var s,i;if(this._weekdaysParseExact)return function(e,t,n){var s,i,r,e=e.toLocaleLowerCase();if(!this._weekdaysParse)for(this._weekdaysParse=[],this._shortWeekdaysParse=[],this._minWeekdaysParse=[],s=0;s<7;++s)r=l([2e3,1]).day(s),this._minWeekdaysParse[s]=this.weekdaysMin(r,"").toLocaleLowerCase(),this._shortWeekdaysParse[s]=this.weekdaysShort(r,"").toLocaleLowerCase(),this._weekdaysParse[s]=this.weekdays(r,"").toLocaleLowerCase();return n?"dddd"===t?-1!==(i=S.call(this._weekdaysParse,e))?i:null:"ddd"===t?-1!==(i=S.call(this._shortWeekdaysParse,e))?i:null:-1!==(i=S.call(this._minWeekdaysParse,e))?i:null:"dddd"===t?-1!==(i=S.call(this._weekdaysParse,e))||-1!==(i=S.call(this._shortWeekdaysParse,e))||-1!==(i=S.call(this._minWeekdaysParse,e))?i:null:"ddd"===t?-1!==(i=S.call(this._shortWeekdaysParse,e))||-1!==(i=S.call(this._weekdaysParse,e))||-1!==(i=S.call(this._minWeekdaysParse,e))?i:null:-1!==(i=S.call(this._minWeekdaysParse,e))||-1!==(i=S.call(this._weekdaysParse,e))||-1!==(i=S.call(this._shortWeekdaysParse,e))?i:null}.call(this,e,t,n);for(this._weekdaysParse||(this._weekdaysParse=[],this._minWeekdaysParse=[],this._shortWeekdaysParse=[],this._fullWeekdaysParse=[]),s=0;s<7;s++){if(i=l([2e3,1]).day(s),n&&!this._fullWeekdaysParse[s]&&(this._fullWeekdaysParse[s]=new RegExp("^"+this.weekdays(i,"").replace(".","\\.?")+"$","i"),this._shortWeekdaysParse[s]=new RegExp("^"+this.weekdaysShort(i,"").replace(".","\\.?")+"$","i"),this._minWeekdaysParse[s]=new RegExp("^"+this.weekdaysMin(i,"").replace(".","\\.?")+"$","i")),this._weekdaysParse[s]||(i="^"+this.weekdays(i,"")+"|^"+this.weekdaysShort(i,"")+"|^"+this.weekdaysMin(i,""),this._weekdaysParse[s]=new RegExp(i.replace(".",""),"i")),n&&"dddd"===t&&this._fullWeekdaysParse[s].test(e))return s;if(n&&"ddd"===t&&this._shortWeekdaysParse[s].test(e))return s;if(n&&"dd"===t&&this._minWeekdaysParse[s].test(e))return s;if(!n&&this._weekdaysParse[s].test(e))return s}},w.weekdaysRegex=function(e){return this._weekdaysParseExact?(c(this,"_weekdaysRegex")||nt.call(this),e?this._weekdaysStrictRegex:this._weekdaysRegex):(c(this,"_weekdaysRegex")||(this._weekdaysRegex=Ke),this._weekdaysStrictRegex&&e?this._weekdaysStrictRegex:this._weekdaysRegex)},w.weekdaysShortRegex=function(e){return this._weekdaysParseExact?(c(this,"_weekdaysRegex")||nt.call(this),e?this._weekdaysShortStrictRegex:this._weekdaysShortRegex):(c(this,"_weekdaysShortRegex")||(this._weekdaysShortRegex=et),this._weekdaysShortStrictRegex&&e?this._weekdaysShortStrictRegex:this._weekdaysShortRegex)},w.weekdaysMinRegex=function(e){return this._weekdaysParseExact?(c(this,"_weekdaysRegex")||nt.call(this),e?this._weekdaysMinStrictRegex:this._weekdaysMinRegex):(c(this,"_weekdaysMinRegex")||(this._weekdaysMinRegex=tt),this._weekdaysMinStrictRegex&&e?this._weekdaysMinStrictRegex:this._weekdaysMinRegex)},w.isPM=function(e){return"p"===(e+"").toLowerCase().charAt(0)},w.meridiem=function(e,t,n){return 11<e?n?"pm":"PM":n?"am":"AM"},ct("en",{eras:[{since:"0001-01-01",until:1/0,offset:1,name:"Anno Domini",narrow:"AD",abbr:"AD"},{since:"0000-12-31",until:-1/0,offset:1,name:"Before Christ",narrow:"BC",abbr:"BC"}],dayOfMonthOrdinalParse:/\d{1,2}(th|st|nd|rd)/,ordinal:function(e){var t=e%10;return e+(1===g(e%100/10)?"th":1==t?"st":2==t?"nd":3==t?"rd":"th")}}),f.lang=e("moment.lang is deprecated. Use moment.locale instead.",ct),f.langData=e("moment.langData is deprecated. Use moment.localeData instead.",mt);var _n=Math.abs;function yn(e,t,n,s){t=C(t,n);return e._milliseconds+=s*t._milliseconds,e._days+=s*t._days,e._months+=s*t._months,e._bubble()}function gn(e){return e<0?Math.floor(e):Math.ceil(e)}function wn(e){return 4800*e/146097}function pn(e){return 146097*e/4800}function kn(e){return function(){return this.as(e)}}pe=kn("ms"),me=kn("s"),Ce=kn("m"),we=kn("h"),ge=kn("d"),Je=kn("w"),k=kn("M"),_e=kn("Q"),ve=kn("y");function vn(e){return function(){return this.isValid()?this._data[e]:NaN}}var ye=vn("milliseconds"),ke=vn("seconds"),Ie=vn("minutes"),w=vn("hours"),Mn=vn("days"),Dn=vn("months"),Sn=vn("years");var Yn=Math.round,On={ss:44,s:45,m:45,h:22,d:26,w:null,M:11};function bn(e,t,n,s){var i=C(e).abs(),r=Yn(i.as("s")),a=Yn(i.as("m")),o=Yn(i.as("h")),u=Yn(i.as("d")),l=Yn(i.as("M")),h=Yn(i.as("w")),i=Yn(i.as("y")),r=(r<=n.ss?["s",r]:r<n.s&&["ss",r])||a<=1&&["m"]||a<n.m&&["mm",a]||o<=1&&["h"]||o<n.h&&["hh",o]||u<=1&&["d"]||u<n.d&&["dd",u];return(r=(r=null!=n.w?r||h<=1&&["w"]||h<n.w&&["ww",h]:r)||l<=1&&["M"]||l<n.M&&["MM",l]||i<=1&&["y"]||["yy",i])[2]=t,r[3]=0<+e,r[4]=s,function(e,t,n,s,i){return i.relativeTime(t||1,!!n,e,s)}.apply(null,r)}var xn=Math.abs;function Tn(e){return(0<e)-(e<0)||+e}function Nn(){if(!this.isValid())return this.localeData().invalidDate();var e,t,n,s,i,r,a,o=xn(this._milliseconds)/1e3,u=xn(this._days),l=xn(this._months),h=this.asSeconds();return h?(e=y(o/60),t=y(e/60),o%=60,e%=60,n=y(l/12),l%=12,s=o?o.toFixed(3).replace(/\.?0+$/,""):"",i=Tn(this._months)!==Tn(h)?"-":"",r=Tn(this._days)!==Tn(h)?"-":"",a=Tn(this._milliseconds)!==Tn(h)?"-":"",(h<0?"-":"")+"P"+(n?i+n+"Y":"")+(l?i+l+"M":"")+(u?r+u+"D":"")+(t||e||o?"T":"")+(t?a+t+"H":"")+(e?a+e+"M":"")+(o?a+s+"S":"")):"P0D"}var U=Ct.prototype;return U.isValid=function(){return this._isValid},U.abs=function(){var e=this._data;return this._milliseconds=_n(this._milliseconds),this._days=_n(this._days),this._months=_n(this._months),e.milliseconds=_n(e.milliseconds),e.seconds=_n(e.seconds),e.minutes=_n(e.minutes),e.hours=_n(e.hours),e.months=_n(e.months),e.years=_n(e.years),this},U.add=function(e,t){return yn(this,e,t,1)},U.subtract=function(e,t){return yn(this,e,t,-1)},U.as=function(e){if(!this.isValid())return NaN;var t,n,s=this._milliseconds;if("month"===(e=_(e))||"quarter"===e||"year"===e)switch(t=this._days+s/864e5,n=this._months+wn(t),e){case"month":return n;case"quarter":return n/3;case"year":return n/12}else switch(t=this._days+Math.round(pn(this._months)),e){case"week":return t/7+s/6048e5;case"day":return t+s/864e5;case"hour":return 24*t+s/36e5;case"minute":return 1440*t+s/6e4;case"second":return 86400*t+s/1e3;case"millisecond":return Math.floor(864e5*t)+s;default:throw new Error("Unknown unit "+e)}},U.asMilliseconds=pe,U.asSeconds=me,U.asMinutes=Ce,U.asHours=we,U.asDays=ge,U.asWeeks=Je,U.asMonths=k,U.asQuarters=_e,U.asYears=ve,U.valueOf=function(){return this.isValid()?this._milliseconds+864e5*this._days+this._months%12*2592e6+31536e6*g(this._months/12):NaN},U._bubble=function(){var e=this._milliseconds,t=this._days,n=this._months,s=this._data;return 0<=e&&0<=t&&0<=n||e<=0&&t<=0&&n<=0||(e+=864e5*gn(pn(n)+t),n=t=0),s.milliseconds=e%1e3,e=y(e/1e3),s.seconds=e%60,e=y(e/60),s.minutes=e%60,e=y(e/60),s.hours=e%24,t+=y(e/24),n+=e=y(wn(t)),t-=gn(pn(e)),e=y(n/12),n%=12,s.days=t,s.months=n,s.years=e,this},U.clone=function(){return C(this)},U.get=function(e){return e=_(e),this.isValid()?this[e+"s"]():NaN},U.milliseconds=ye,U.seconds=ke,U.minutes=Ie,U.hours=w,U.days=Mn,U.weeks=function(){return y(this.days()/7)},U.months=Dn,U.years=Sn,U.humanize=function(e,t){if(!this.isValid())return this.localeData().invalidDate();var n=!1,s=On;return"object"==typeof e&&(t=e,e=!1),"boolean"==typeof e&&(n=e),"object"==typeof t&&(s=Object.assign({},On,t),null!=t.s&&null==t.ss&&(s.ss=t.s-1)),e=this.localeData(),t=bn(this,!n,s,e),n&&(t=e.pastFuture(+this,t)),e.postformat(t)},U.toISOString=Nn,U.toString=Nn,U.toJSON=Nn,U.locale=Xt,U.localeData=Kt,U.toIsoString=e("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)",Nn),U.lang=Xe,s("X",0,0,"unix"),s("x",0,0,"valueOf"),v("x",De),v("X",/[+-]?\d+(\.\d{1,3})?/),D("X",function(e,t,n){n._d=new Date(1e3*parseFloat(e))}),D("x",function(e,t,n){n._d=new Date(g(e))}),f.version="2.29.4",H=W,f.fn=i,f.min=function(){return Rt("isBefore",[].slice.call(arguments,0))},f.max=function(){return Rt("isAfter",[].slice.call(arguments,0))},f.now=function(){return Date.now?Date.now():+new Date},f.utc=l,f.unix=function(e){return W(1e3*e)},f.months=function(e,t){return fn(e,t,"months")},f.isDate=V,f.locale=ct,f.invalid=I,f.duration=C,f.isMoment=h,f.weekdays=function(e,t,n){return mn(e,t,n,"weekdays")},f.parseZone=function(){return W.apply(null,arguments).parseZone()},f.localeData=mt,f.isDuration=Ut,f.monthsShort=function(e,t){return fn(e,t,"monthsShort")},f.weekdaysMin=function(e,t,n){return mn(e,t,n,"weekdaysMin")},f.defineLocale=ft,f.updateLocale=function(e,t){var n,s;return null!=t?(s=ot,null!=R[e]&&null!=R[e].parentLocale?R[e].set(X(R[e]._config,t)):(t=X(s=null!=(n=dt(e))?n._config:s,t),null==n&&(t.abbr=e),(s=new K(t)).parentLocale=R[e],R[e]=s),ct(e)):null!=R[e]&&(null!=R[e].parentLocale?(R[e]=R[e].parentLocale,e===ct()&&ct(e)):null!=R[e]&&delete R[e]),R[e]},f.locales=function(){return ee(R)},f.weekdaysShort=function(e,t,n){return mn(e,t,n,"weekdaysShort")},f.normalizeUnits=_,f.relativeTimeRounding=function(e){return void 0===e?Yn:"function"==typeof e&&(Yn=e,!0)},f.relativeTimeThreshold=function(e,t){return void 0!==On[e]&&(void 0===t?On[e]:(On[e]=t,"s"===e&&(On.ss=t-1),!0))},f.calendarFormat=function(e,t){return(e=e.diff(t,"days",!0))<-6?"sameElse":e<-1?"lastWeek":e<0?"lastDay":e<1?"sameDay":e<2?"nextDay":e<7?"nextWeek":"sameElse"},f.prototype=i,f.HTML5_FMT={DATETIME_LOCAL:"YYYY-MM-DDTHH:mm",DATETIME_LOCAL_SECONDS:"YYYY-MM-DDTHH:mm:ss",DATETIME_LOCAL_MS:"YYYY-MM-DDTHH:mm:ss.SSS",DATE:"YYYY-MM-DD",TIME:"HH:mm",TIME_SECONDS:"HH:mm:ss",TIME_MS:"HH:mm:ss.SSS",WEEK:"GGGG-[W]WW",MONTH:"YYYY-MM"},f});
//# sourceMappingURL=moment.min.js.map
//! moment.js locale configuration
//! locale : Portuguese (Brazil) [pt-br]
//! author : Caio Ribeiro Pereira : https://github.com/caio-ribeiro-pereira

;(function (global, factory) {
   typeof exports === 'object' && typeof module !== 'undefined'
       && typeof require === 'function' ? factory(require('../moment')) :
   typeof define === 'function' && define.amd ? define(['../moment'], factory) :
   factory(global.moment)
}(this, (function (moment) { 'use strict';

    //! moment.js locale configuration

    var ptBr = moment.defineLocale('pt-br', {
        months: 'janeiro_fevereiro_março_abril_maio_junho_julho_agosto_setembro_outubro_novembro_dezembro'.split(
            '_'
        ),
        monthsShort: 'jan_fev_mar_abr_mai_jun_jul_ago_set_out_nov_dez'.split('_'),
        weekdays:
            'domingo_segunda-feira_terça-feira_quarta-feira_quinta-feira_sexta-feira_sábado'.split(
                '_'
            ),
        weekdaysShort: 'dom_seg_ter_qua_qui_sex_sáb'.split('_'),
        weekdaysMin: 'do_2ª_3ª_4ª_5ª_6ª_sá'.split('_'),
        weekdaysParseExact: true,
        longDateFormat: {
            LT: 'HH:mm',
            LTS: 'HH:mm:ss',
            L: 'DD/MM/YYYY',
            LL: 'D [de] MMMM [de] YYYY',
            LLL: 'D [de] MMMM [de] YYYY [às] HH:mm',
            LLLL: 'dddd, D [de] MMMM [de] YYYY [às] HH:mm',
        },
        calendar: {
            sameDay: '[Hoje às] LT',
            nextDay: '[Amanhã às] LT',
            nextWeek: 'dddd [às] LT',
            lastDay: '[Ontem às] LT',
            lastWeek: function () {
                return this.day() === 0 || this.day() === 6
                    ? '[Último] dddd [às] LT' // Saturday + Sunday
                    : '[Última] dddd [às] LT'; // Monday - Friday
            },
            sameElse: 'L',
        },
        relativeTime: {
            future: 'em %s',
            past: 'há %s',
            s: 'poucos segundos',
            ss: '%d segundos',
            m: 'um minuto',
            mm: '%d minutos',
            h: 'uma hora',
            hh: '%d horas',
            d: 'um dia',
            dd: '%d dias',
            M: 'um mês',
            MM: '%d meses',
            y: 'um ano',
            yy: '%d anos',
        },
        dayOfMonthOrdinalParse: /\d{1,2}º/,
        ordinal: '%dº',
        invalidDate: 'Data inválida',
    });

    return ptBr;

})));

/**
 * jquery.mask.js
 * @version: v1.14.16
 * @author: Igor Escobar
 *
 * Created by Igor Escobar on 2012-03-10. Please report any bug at github.com/igorescobar/jQuery-Mask-Plugin
 *
 * Copyright (c) 2012 Igor Escobar http://igorescobar.com
 *
 * The MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

/* jshint laxbreak: true */
/* jshint maxcomplexity:17 */
/* global define */

// UMD (Universal Module Definition) patterns for JavaScript modules that work everywhere.
// https://github.com/umdjs/umd/blob/master/templates/jqueryPlugin.js
(function (factory, jQuery, Zepto) {

    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object' && typeof Meteor === 'undefined') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery || Zepto);
    }

}(function ($) {
    'use strict';

    var Mask = function (el, mask, options) {

        var p = {
            invalid: [],
            getCaret: function () {
                try {
                    var sel,
                        pos = 0,
                        ctrl = el.get(0),
                        dSel = document.selection,
                        cSelStart = ctrl.selectionStart;

                    // IE Support
                    if (dSel && navigator.appVersion.indexOf('MSIE 10') === -1) {
                        sel = dSel.createRange();
                        sel.moveStart('character', -p.val().length);
                        pos = sel.text.length;
                    }
                    // Firefox support
                    else if (cSelStart || cSelStart === '0') {
                        pos = cSelStart;
                    }

                    return pos;
                } catch (e) {}
            },
            setCaret: function(pos) {
                try {
                    if (el.is(':focus')) {
                        var range, ctrl = el.get(0);

                        // Firefox, WebKit, etc..
                        if (ctrl.setSelectionRange) {
                            ctrl.setSelectionRange(pos, pos);
                        } else { // IE
                            range = ctrl.createTextRange();
                            range.collapse(true);
                            range.moveEnd('character', pos);
                            range.moveStart('character', pos);
                            range.select();
                        }
                    }
                } catch (e) {}
            },
            events: function() {
                el
                .on('keydown.mask', function(e) {
                    el.data('mask-keycode', e.keyCode || e.which);
                    el.data('mask-previus-value', el.val());
                    el.data('mask-previus-caret-pos', p.getCaret());
                    p.maskDigitPosMapOld = p.maskDigitPosMap;
                })
                .on($.jMaskGlobals.useInput ? 'input.mask' : 'keyup.mask', p.behaviour)
                .on('paste.mask drop.mask', function() {
                    setTimeout(function() {
                        el.keydown().keyup();
                    }, 100);
                })
                .on('change.mask', function(){
                    el.data('changed', true);
                })
                .on('blur.mask', function(){
                    if (oldValue !== p.val() && !el.data('changed')) {
                        el.trigger('change');
                    }
                    el.data('changed', false);
                })
                // it's very important that this callback remains in this position
                // otherwhise oldValue it's going to work buggy
                .on('blur.mask', function() {
                    oldValue = p.val();
                })
                // select all text on focus
                .on('focus.mask', function (e) {
                    if (options.selectOnFocus === true) {
                        $(e.target).select();
                    }
                })
                // clear the value if it not complete the mask
                .on('focusout.mask', function() {
                    if (options.clearIfNotMatch && !regexMask.test(p.val())) {
                       p.val('');
                   }
                });
            },
            getRegexMask: function() {
                var maskChunks = [], translation, pattern, optional, recursive, oRecursive, r;

                for (var i = 0; i < mask.length; i++) {
                    translation = jMask.translation[mask.charAt(i)];

                    if (translation) {

                        pattern = translation.pattern.toString().replace(/.{1}$|^.{1}/g, '');
                        optional = translation.optional;
                        recursive = translation.recursive;

                        if (recursive) {
                            maskChunks.push(mask.charAt(i));
                            oRecursive = {digit: mask.charAt(i), pattern: pattern};
                        } else {
                            maskChunks.push(!optional && !recursive ? pattern : (pattern + '?'));
                        }

                    } else {
                        maskChunks.push(mask.charAt(i).replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'));
                    }
                }

                r = maskChunks.join('');

                if (oRecursive) {
                    r = r.replace(new RegExp('(' + oRecursive.digit + '(.*' + oRecursive.digit + ')?)'), '($1)?')
                         .replace(new RegExp(oRecursive.digit, 'g'), oRecursive.pattern);
                }

                return new RegExp(r);
            },
            destroyEvents: function() {
                el.off(['input', 'keydown', 'keyup', 'paste', 'drop', 'blur', 'focusout', ''].join('.mask '));
            },
            val: function(v) {
                var isInput = el.is('input'),
                    method = isInput ? 'val' : 'text',
                    r;

                if (arguments.length > 0) {
                    if (el[method]() !== v) {
                        el[method](v);
                    }
                    r = el;
                } else {
                    r = el[method]();
                }

                return r;
            },
            calculateCaretPosition: function(oldVal) {
                var newVal = p.getMasked(),
                    caretPosNew = p.getCaret();
                if (oldVal !== newVal) {
                    var caretPosOld = el.data('mask-previus-caret-pos') || 0,
                        newValL = newVal.length,
                        oldValL = oldVal.length,
                        maskDigitsBeforeCaret = 0,
                        maskDigitsAfterCaret = 0,
                        maskDigitsBeforeCaretAll = 0,
                        maskDigitsBeforeCaretAllOld = 0,
                        i = 0;

                    for (i = caretPosNew; i < newValL; i++) {
                        if (!p.maskDigitPosMap[i]) {
                            break;
                        }
                        maskDigitsAfterCaret++;
                    }

                    for (i = caretPosNew - 1; i >= 0; i--) {
                        if (!p.maskDigitPosMap[i]) {
                            break;
                        }
                        maskDigitsBeforeCaret++;
                    }

                    for (i = caretPosNew - 1; i >= 0; i--) {
                        if (p.maskDigitPosMap[i]) {
                            maskDigitsBeforeCaretAll++;
                        }
                    }

                    for (i = caretPosOld - 1; i >= 0; i--) {
                        if (p.maskDigitPosMapOld[i]) {
                            maskDigitsBeforeCaretAllOld++;
                        }
                    }

                    // if the cursor is at the end keep it there
                    if (caretPosNew > oldValL) {
                      caretPosNew = newValL * 10;
                    } else if (caretPosOld >= caretPosNew && caretPosOld !== oldValL) {
                        if (!p.maskDigitPosMapOld[caretPosNew])  {
                          var caretPos = caretPosNew;
                          caretPosNew -= maskDigitsBeforeCaretAllOld - maskDigitsBeforeCaretAll;
                          caretPosNew -= maskDigitsBeforeCaret;
                          if (p.maskDigitPosMap[caretPosNew])  {
                            caretPosNew = caretPos;
                          }
                        }
                    }
                    else if (caretPosNew > caretPosOld) {
                        caretPosNew += maskDigitsBeforeCaretAll - maskDigitsBeforeCaretAllOld;
                        caretPosNew += maskDigitsAfterCaret;
                    }
                }
                return caretPosNew;
            },
            behaviour: function(e) {
                e = e || window.event;
                p.invalid = [];

                var keyCode = el.data('mask-keycode');

                if ($.inArray(keyCode, jMask.byPassKeys) === -1) {
                    var newVal = p.getMasked(),
                        caretPos = p.getCaret(),
                        oldVal = el.data('mask-previus-value') || '';

                    // this is a compensation to devices/browsers that don't compensate
                    // caret positioning the right way
                    setTimeout(function() {
                      p.setCaret(p.calculateCaretPosition(oldVal));
                    }, $.jMaskGlobals.keyStrokeCompensation);

                    p.val(newVal);
                    p.setCaret(caretPos);
                    return p.callbacks(e);
                }
            },
            getMasked: function(skipMaskChars, val) {
                var buf = [],
                    value = val === undefined ? p.val() : val + '',
                    m = 0, maskLen = mask.length,
                    v = 0, valLen = value.length,
                    offset = 1, addMethod = 'push',
                    resetPos = -1,
                    maskDigitCount = 0,
                    maskDigitPosArr = [],
                    lastMaskChar,
                    check;

                if (options.reverse) {
                    addMethod = 'unshift';
                    offset = -1;
                    lastMaskChar = 0;
                    m = maskLen - 1;
                    v = valLen - 1;
                    check = function () {
                        return m > -1 && v > -1;
                    };
                } else {
                    lastMaskChar = maskLen - 1;
                    check = function () {
                        return m < maskLen && v < valLen;
                    };
                }

                var lastUntranslatedMaskChar;
                while (check()) {
                    var maskDigit = mask.charAt(m),
                        valDigit = value.charAt(v),
                        translation = jMask.translation[maskDigit];

                    if (translation) {
                        if (valDigit.match(translation.pattern)) {
                            buf[addMethod](valDigit);
                             if (translation.recursive) {
                                if (resetPos === -1) {
                                    resetPos = m;
                                } else if (m === lastMaskChar && m !== resetPos) {
                                    m = resetPos - offset;
                                }

                                if (lastMaskChar === resetPos) {
                                    m -= offset;
                                }
                            }
                            m += offset;
                        } else if (valDigit === lastUntranslatedMaskChar) {
                            // matched the last untranslated (raw) mask character that we encountered
                            // likely an insert offset the mask character from the last entry; fall
                            // through and only increment v
                            maskDigitCount--;
                            lastUntranslatedMaskChar = undefined;
                        } else if (translation.optional) {
                            m += offset;
                            v -= offset;
                        } else if (translation.fallback) {
                            buf[addMethod](translation.fallback);
                            m += offset;
                            v -= offset;
                        } else {
                          p.invalid.push({p: v, v: valDigit, e: translation.pattern});
                        }
                        v += offset;
                    } else {
                        if (!skipMaskChars) {
                            buf[addMethod](maskDigit);
                        }

                        if (valDigit === maskDigit) {
                            maskDigitPosArr.push(v);
                            v += offset;
                        } else {
                            lastUntranslatedMaskChar = maskDigit;
                            maskDigitPosArr.push(v + maskDigitCount);
                            maskDigitCount++;
                        }

                        m += offset;
                    }
                }

                var lastMaskCharDigit = mask.charAt(lastMaskChar);
                if (maskLen === valLen + 1 && !jMask.translation[lastMaskCharDigit]) {
                    buf.push(lastMaskCharDigit);
                }

                var newVal = buf.join('');
                p.mapMaskdigitPositions(newVal, maskDigitPosArr, valLen);
                return newVal;
            },
            mapMaskdigitPositions: function(newVal, maskDigitPosArr, valLen) {
              var maskDiff = options.reverse ? newVal.length - valLen : 0;
              p.maskDigitPosMap = {};
              for (var i = 0; i < maskDigitPosArr.length; i++) {
                p.maskDigitPosMap[maskDigitPosArr[i] + maskDiff] = 1;
              }
            },
            callbacks: function (e) {
                var val = p.val(),
                    changed = val !== oldValue,
                    defaultArgs = [val, e, el, options],
                    callback = function(name, criteria, args) {
                        if (typeof options[name] === 'function' && criteria) {
                            options[name].apply(this, args);
                        }
                    };

                callback('onChange', changed === true, defaultArgs);
                callback('onKeyPress', changed === true, defaultArgs);
                callback('onComplete', val.length === mask.length, defaultArgs);
                callback('onInvalid', p.invalid.length > 0, [val, e, el, p.invalid, options]);
            }
        };

        el = $(el);
        var jMask = this, oldValue = p.val(), regexMask;

        mask = typeof mask === 'function' ? mask(p.val(), undefined, el,  options) : mask;

        // public methods
        jMask.mask = mask;
        jMask.options = options;
        jMask.remove = function() {
            var caret = p.getCaret();
            if (jMask.options.placeholder) {
                el.removeAttr('placeholder');
            }
            if (el.data('mask-maxlength')) {
                el.removeAttr('maxlength');
            }
            p.destroyEvents();
            p.val(jMask.getCleanVal());
            p.setCaret(caret);
            return el;
        };

        // get value without mask
        jMask.getCleanVal = function() {
           return p.getMasked(true);
        };

        // get masked value without the value being in the input or element
        jMask.getMaskedVal = function(val) {
           return p.getMasked(false, val);
        };

       jMask.init = function(onlyMask) {
            onlyMask = onlyMask || false;
            options = options || {};

            jMask.clearIfNotMatch  = $.jMaskGlobals.clearIfNotMatch;
            jMask.byPassKeys       = $.jMaskGlobals.byPassKeys;
            jMask.translation      = $.extend({}, $.jMaskGlobals.translation, options.translation);

            jMask = $.extend(true, {}, jMask, options);

            regexMask = p.getRegexMask();

            if (onlyMask) {
                p.events();
                p.val(p.getMasked());
            } else {
                if (options.placeholder) {
                    el.attr('placeholder' , options.placeholder);
                }

                // this is necessary, otherwise if the user submit the form
                // and then press the "back" button, the autocomplete will erase
                // the data. Works fine on IE9+, FF, Opera, Safari.
                if (el.data('mask')) {
                  el.attr('autocomplete', 'off');
                }

                // detect if is necessary let the user type freely.
                // for is a lot faster than forEach.
                for (var i = 0, maxlength = true; i < mask.length; i++) {
                    var translation = jMask.translation[mask.charAt(i)];
                    if (translation && translation.recursive) {
                        maxlength = false;
                        break;
                    }
                }

                if (maxlength) {
                    el.attr('maxlength', mask.length).data('mask-maxlength', true);
                }

                p.destroyEvents();
                p.events();

                var caret = p.getCaret();
                p.val(p.getMasked());
                p.setCaret(caret);
            }
        };

        jMask.init(!el.is('input'));
    };

    $.maskWatchers = {};
    var HTMLAttributes = function () {
        var input = $(this),
            options = {},
            prefix = 'data-mask-',
            mask = input.attr('data-mask');

        if (input.attr(prefix + 'reverse')) {
            options.reverse = true;
        }

        if (input.attr(prefix + 'clearifnotmatch')) {
            options.clearIfNotMatch = true;
        }

        if (input.attr(prefix + 'selectonfocus') === 'true') {
           options.selectOnFocus = true;
        }

        if (notSameMaskObject(input, mask, options)) {
            return input.data('mask', new Mask(this, mask, options));
        }
    },
    notSameMaskObject = function(field, mask, options) {
        options = options || {};
        var maskObject = $(field).data('mask'),
            stringify = JSON.stringify,
            value = $(field).val() || $(field).text();
        try {
            if (typeof mask === 'function') {
                mask = mask(value);
            }
            return typeof maskObject !== 'object' || stringify(maskObject.options) !== stringify(options) || maskObject.mask !== mask;
        } catch (e) {}
    },
    eventSupported = function(eventName) {
        var el = document.createElement('div'), isSupported;

        eventName = 'on' + eventName;
        isSupported = (eventName in el);

        if ( !isSupported ) {
            el.setAttribute(eventName, 'return;');
            isSupported = typeof el[eventName] === 'function';
        }
        el = null;

        return isSupported;
    };

    $.fn.mask = function(mask, options) {
        options = options || {};
        var selector = this.selector,
            globals = $.jMaskGlobals,
            interval = globals.watchInterval,
            watchInputs = options.watchInputs || globals.watchInputs,
            maskFunction = function() {
                if (notSameMaskObject(this, mask, options)) {
                    return $(this).data('mask', new Mask(this, mask, options));
                }
            };

        $(this).each(maskFunction);

        if (selector && selector !== '' && watchInputs) {
            clearInterval($.maskWatchers[selector]);
            $.maskWatchers[selector] = setInterval(function(){
                $(document).find(selector).each(maskFunction);
            }, interval);
        }
        return this;
    };

    $.fn.masked = function(val) {
        return this.data('mask').getMaskedVal(val);
    };

    $.fn.unmask = function() {
        clearInterval($.maskWatchers[this.selector]);
        delete $.maskWatchers[this.selector];
        return this.each(function() {
            var dataMask = $(this).data('mask');
            if (dataMask) {
                dataMask.remove().removeData('mask');
            }
        });
    };

    $.fn.cleanVal = function() {
        return this.data('mask').getCleanVal();
    };

    $.applyDataMask = function(selector) {
        selector = selector || $.jMaskGlobals.maskElements;
        var $selector = (selector instanceof $) ? selector : $(selector);
        $selector.filter($.jMaskGlobals.dataMaskAttr).each(HTMLAttributes);
    };

    var globals = {
        maskElements: 'input,td,span,div',
        dataMaskAttr: '*[data-mask]',
        dataMask: true,
        watchInterval: 300,
        watchInputs: true,
        keyStrokeCompensation: 10,
        // old versions of chrome dont work great with input event
        useInput: !/Chrome\/[2-4][0-9]|SamsungBrowser/.test(window.navigator.userAgent) && eventSupported('input'),
        watchDataMask: false,
        byPassKeys: [9, 16, 17, 18, 36, 37, 38, 39, 40, 91],
        translation: {
            '0': {pattern: /\d/},
            '9': {pattern: /\d/, optional: true},
            '#': {pattern: /\d/, recursive: true},
            'A': {pattern: /[a-zA-Z0-9]/},
            'S': {pattern: /[a-zA-Z]/}
        }
    };

    $.jMaskGlobals = $.jMaskGlobals || {};
    globals = $.jMaskGlobals = $.extend(true, {}, globals, $.jMaskGlobals);

    // looking for inputs with data-mask attribute
    if (globals.dataMask) {
        $.applyDataMask();
    }

    setInterval(function() {
        if ($.jMaskGlobals.watchDataMask) {
            $.applyDataMask();
        }
    }, globals.watchInterval);
}, window.jQuery, window.Zepto));

var DateFormatter;!function(){"use strict";var e,t,a,n,r,o,i;o=864e5,i=3600,e=function(e,t){return"string"==typeof e&&"string"==typeof t&&e.toLowerCase()===t.toLowerCase()},t=function(e,a,n){var r=n||"0",o=e.toString();return o.length<a?t(r+o,a):o},a=function(e){var t,n;for(e=e||{},t=1;t<arguments.length;t++)if(n=arguments[t])for(var r in n)n.hasOwnProperty(r)&&("object"==typeof n[r]?a(e[r],n[r]):e[r]=n[r]);return e},n=function(e,t){for(var a=0;a<t.length;a++)if(t[a].toLowerCase()===e.toLowerCase())return a;return-1},r={dateSettings:{days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],meridiem:["AM","PM"],ordinal:function(e){var t=e%10,a={1:"st",2:"nd",3:"rd"};return 1!==Math.floor(e%100/10)&&a[t]?a[t]:"th"}},separators:/[ \-+\/\.T:@]/g,validParts:/[dDjlNSwzWFmMntLoYyaABgGhHisueTIOPZcrU]/g,intParts:/[djwNzmnyYhHgGis]/g,tzParts:/\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,tzClip:/[^-+\dA-Z]/g},(DateFormatter=function(e){var t=this,n=a(r,e);t.dateSettings=n.dateSettings,t.separators=n.separators,t.validParts=n.validParts,t.intParts=n.intParts,t.tzParts=n.tzParts,t.tzClip=n.tzClip}).prototype={constructor:DateFormatter,getMonth:function(e){var t,a=this;return 0===(t=n(e,a.dateSettings.monthsShort)+1)&&(t=n(e,a.dateSettings.months)+1),t},parseDate:function(t,a){var n,r,o,i,s,d,u,l,f,c,m=this,h=!1,g=!1,p=m.dateSettings,y={date:null,year:null,month:null,day:null,hour:0,min:0,sec:0};if(!t)return null;if(t instanceof Date)return t;if("U"===a)return(o=parseInt(t))?new Date(1e3*o):t;switch(typeof t){case"number":return new Date(t);case"string":break;default:return null}if(!(n=a.match(m.validParts))||0===n.length)throw new Error("Invalid date format definition.");for(r=t.replace(m.separators,"\0").split("\0"),o=0;o<r.length;o++)switch(i=r[o],s=parseInt(i),n[o]){case"y":case"Y":if(!s)return null;f=i.length,y.year=2===f?parseInt((70>s?"20":"19")+i):s,h=!0;break;case"m":case"n":case"M":case"F":if(isNaN(s)){if(!((d=m.getMonth(i))>0))return null;y.month=d}else{if(!(s>=1&&12>=s))return null;y.month=s}h=!0;break;case"d":case"j":if(!(s>=1&&31>=s))return null;y.day=s,h=!0;break;case"g":case"h":if(u=n.indexOf("a")>-1?n.indexOf("a"):n.indexOf("A")>-1?n.indexOf("A"):-1,c=r[u],u>-1)l=e(c,p.meridiem[0])?0:e(c,p.meridiem[1])?12:-1,s>=1&&12>=s&&l>-1?y.hour=s+l-1:s>=0&&23>=s&&(y.hour=s);else{if(!(s>=0&&23>=s))return null;y.hour=s}g=!0;break;case"G":case"H":if(!(s>=0&&23>=s))return null;y.hour=s,g=!0;break;case"i":if(!(s>=0&&59>=s))return null;y.min=s,g=!0;break;case"s":if(!(s>=0&&59>=s))return null;y.sec=s,g=!0}if(!0===h&&y.year&&y.month&&y.day)y.date=new Date(y.year,y.month-1,y.day,y.hour,y.min,y.sec,0);else{if(!0!==g)return null;y.date=new Date(0,0,0,y.hour,y.min,y.sec,0)}return y.date},guessDate:function(e,t){if("string"!=typeof e)return e;var a,n,r,o,i,s,d=this,u=e.replace(d.separators,"\0").split("\0"),l=/^[djmn]/g,f=t.match(d.validParts),c=new Date,m=0;if(!l.test(f[0]))return e;for(r=0;r<u.length;r++){if(m=2,i=u[r],s=parseInt(i.substr(0,2)),isNaN(s))return null;switch(r){case 0:"m"===f[0]||"n"===f[0]?c.setMonth(s-1):c.setDate(s);break;case 1:"m"===f[0]||"n"===f[0]?c.setDate(s):c.setMonth(s-1);break;case 2:if(n=c.getFullYear(),a=i.length,m=4>a?a:4,!(n=parseInt(4>a?n.toString().substr(0,4-a)+i:i.substr(0,4))))return null;c.setFullYear(n);break;case 3:c.setHours(s);break;case 4:c.setMinutes(s);break;case 5:c.setSeconds(s)}(o=i.substr(m)).length>0&&u.splice(r+1,0,o)}return c},parseFormat:function(e,a){var n,r=this,s=r.dateSettings,d=/\\?(.?)/gi,u=function(e,t){return n[e]?n[e]():t};return n={d:function(){return t(n.j(),2)},D:function(){return s.daysShort[n.w()]},j:function(){return a.getDate()},l:function(){return s.days[n.w()]},N:function(){return n.w()||7},w:function(){return a.getDay()},z:function(){var e=new Date(n.Y(),n.n()-1,n.j()),t=new Date(n.Y(),0,1);return Math.round((e-t)/o)},W:function(){var e=new Date(n.Y(),n.n()-1,n.j()-n.N()+3),a=new Date(e.getFullYear(),0,4);return t(1+Math.round((e-a)/o/7),2)},F:function(){return s.months[a.getMonth()]},m:function(){return t(n.n(),2)},M:function(){return s.monthsShort[a.getMonth()]},n:function(){return a.getMonth()+1},t:function(){return new Date(n.Y(),n.n(),0).getDate()},L:function(){var e=n.Y();return e%4==0&&e%100!=0||e%400==0?1:0},o:function(){var e=n.n(),t=n.W();return n.Y()+(12===e&&9>t?1:1===e&&t>9?-1:0)},Y:function(){return a.getFullYear()},y:function(){return n.Y().toString().slice(-2)},a:function(){return n.A().toLowerCase()},A:function(){var e=n.G()<12?0:1;return s.meridiem[e]},B:function(){var e=a.getUTCHours()*i,n=60*a.getUTCMinutes(),r=a.getUTCSeconds();return t(Math.floor((e+n+r+i)/86.4)%1e3,3)},g:function(){return n.G()%12||12},G:function(){return a.getHours()},h:function(){return t(n.g(),2)},H:function(){return t(n.G(),2)},i:function(){return t(a.getMinutes(),2)},s:function(){return t(a.getSeconds(),2)},u:function(){return t(1e3*a.getMilliseconds(),6)},e:function(){return/\((.*)\)/.exec(String(a))[1]||"Coordinated Universal Time"},I:function(){return new Date(n.Y(),0)-Date.UTC(n.Y(),0)!=new Date(n.Y(),6)-Date.UTC(n.Y(),6)?1:0},O:function(){var e=a.getTimezoneOffset(),n=Math.abs(e);return(e>0?"-":"+")+t(100*Math.floor(n/60)+n%60,4)},P:function(){var e=n.O();return e.substr(0,3)+":"+e.substr(3,2)},T:function(){return(String(a).match(r.tzParts)||[""]).pop().replace(r.tzClip,"")||"UTC"},Z:function(){return 60*-a.getTimezoneOffset()},c:function(){return"Y-m-d\\TH:i:sP".replace(d,u)},r:function(){return"D, d M Y H:i:s O".replace(d,u)},U:function(){return a.getTime()/1e3||0}},u(e,e)},formatDate:function(e,t){var a,n,r,o,i,s=this,d="";if("string"==typeof e&&!(e=s.parseDate(e,t)))return null;if(e instanceof Date){for(r=t.length,a=0;r>a;a++)"S"!==(i=t.charAt(a))&&"\\"!==i&&(a>0&&"\\"===t.charAt(a-1)?d+=i:(o=s.parseFormat(i,e),a!==r-1&&s.intParts.test(i)&&"S"===t.charAt(a+1)&&(n=parseInt(o)||0,o+=s.dateSettings.ordinal(n)),d+=o));return d}return""}}}();var datetimepickerFactory=function(e){"use strict";function t(e,t,a){this.date=e,this.desc=t,this.style=a}var a={i18n:{ar:{months:["كانون الثاني","شباط","آذار","نيسان","مايو","حزيران","تموز","آب","أيلول","تشرين الأول","تشرين الثاني","كانون الأول"],dayOfWeekShort:["ن","ث","ع","خ","ج","س","ح"],dayOfWeek:["الأحد","الاثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت","الأحد"]},ro:{months:["Ianuarie","Februarie","Martie","Aprilie","Mai","Iunie","Iulie","August","Septembrie","Octombrie","Noiembrie","Decembrie"],dayOfWeekShort:["Du","Lu","Ma","Mi","Jo","Vi","Sâ"],dayOfWeek:["Duminică","Luni","Marţi","Miercuri","Joi","Vineri","Sâmbătă"]},id:{months:["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],dayOfWeekShort:["Min","Sen","Sel","Rab","Kam","Jum","Sab"],dayOfWeek:["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"]},is:{months:["Janúar","Febrúar","Mars","Apríl","Maí","Júní","Júlí","Ágúst","September","Október","Nóvember","Desember"],dayOfWeekShort:["Sun","Mán","Þrið","Mið","Fim","Fös","Lau"],dayOfWeek:["Sunnudagur","Mánudagur","Þriðjudagur","Miðvikudagur","Fimmtudagur","Föstudagur","Laugardagur"]},bg:{months:["Януари","Февруари","Март","Април","Май","Юни","Юли","Август","Септември","Октомври","Ноември","Декември"],dayOfWeekShort:["Нд","Пн","Вт","Ср","Чт","Пт","Сб"],dayOfWeek:["Неделя","Понеделник","Вторник","Сряда","Четвъртък","Петък","Събота"]},fa:{months:["فروردین","اردیبهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن","اسفند"],dayOfWeekShort:["یکشنبه","دوشنبه","سه شنبه","چهارشنبه","پنجشنبه","جمعه","شنبه"],dayOfWeek:["یک‌شنبه","دوشنبه","سه‌شنبه","چهارشنبه","پنج‌شنبه","جمعه","شنبه","یک‌شنبه"]},ru:{months:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],dayOfWeekShort:["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],dayOfWeek:["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"]},uk:{months:["Січень","Лютий","Березень","Квітень","Травень","Червень","Липень","Серпень","Вересень","Жовтень","Листопад","Грудень"],dayOfWeekShort:["Ндл","Пнд","Втр","Срд","Чтв","Птн","Сбт"],dayOfWeek:["Неділя","Понеділок","Вівторок","Середа","Четвер","П'ятниця","Субота"]},en:{months:["January","February","March","April","May","June","July","August","September","October","November","December"],dayOfWeekShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],dayOfWeek:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]},el:{months:["Ιανουάριος","Φεβρουάριος","Μάρτιος","Απρίλιος","Μάιος","Ιούνιος","Ιούλιος","Αύγουστος","Σεπτέμβριος","Οκτώβριος","Νοέμβριος","Δεκέμβριος"],dayOfWeekShort:["Κυρ","Δευ","Τρι","Τετ","Πεμ","Παρ","Σαβ"],dayOfWeek:["Κυριακή","Δευτέρα","Τρίτη","Τετάρτη","Πέμπτη","Παρασκευή","Σάββατο"]},de:{months:["Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"],dayOfWeekShort:["So","Mo","Di","Mi","Do","Fr","Sa"],dayOfWeek:["Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag"]},nl:{months:["januari","februari","maart","april","mei","juni","juli","augustus","september","oktober","november","december"],dayOfWeekShort:["zo","ma","di","wo","do","vr","za"],dayOfWeek:["zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag"]},tr:{months:["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"],dayOfWeekShort:["Paz","Pts","Sal","Çar","Per","Cum","Cts"],dayOfWeek:["Pazar","Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi"]},fr:{months:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayOfWeekShort:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"],dayOfWeek:["dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi"]},es:{months:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],dayOfWeekShort:["Dom","Lun","Mar","Mié","Jue","Vie","Sáb"],dayOfWeek:["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"]},th:{months:["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],dayOfWeekShort:["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],dayOfWeek:["อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์","อาทิตย์"]},pl:{months:["styczeń","luty","marzec","kwiecień","maj","czerwiec","lipiec","sierpień","wrzesień","październik","listopad","grudzień"],dayOfWeekShort:["nd","pn","wt","śr","cz","pt","sb"],dayOfWeek:["niedziela","poniedziałek","wtorek","środa","czwartek","piątek","sobota"]},pt:{months:["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],dayOfWeekShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sab"],dayOfWeek:["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"]},ch:{months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayOfWeekShort:["日","一","二","三","四","五","六"]},se:{months:["Januari","Februari","Mars","April","Maj","Juni","Juli","Augusti","September","Oktober","November","December"],dayOfWeekShort:["Sön","Mån","Tis","Ons","Tor","Fre","Lör"]},km:{months:["មករា​","កុម្ភៈ","មិនា​","មេសា​","ឧសភា​","មិថុនា​","កក្កដា​","សីហា​","កញ្ញា​","តុលា​","វិច្ឆិកា","ធ្នូ​"],dayOfWeekShort:["អាទិ​","ច័ន្ទ​","អង្គារ​","ពុធ​","ព្រហ​​","សុក្រ​","សៅរ៍"],dayOfWeek:["អាទិត្យ​","ច័ន្ទ​","អង្គារ​","ពុធ​","ព្រហស្បតិ៍​","សុក្រ​","សៅរ៍"]},kr:{months:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],dayOfWeekShort:["일","월","화","수","목","금","토"],dayOfWeek:["일요일","월요일","화요일","수요일","목요일","금요일","토요일"]},it:{months:["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"],dayOfWeekShort:["Dom","Lun","Mar","Mer","Gio","Ven","Sab"],dayOfWeek:["Domenica","Lunedì","Martedì","Mercoledì","Giovedì","Venerdì","Sabato"]},da:{months:["Januar","Februar","Marts","April","Maj","Juni","Juli","August","September","Oktober","November","December"],dayOfWeekShort:["Søn","Man","Tir","Ons","Tor","Fre","Lør"],dayOfWeek:["søndag","mandag","tirsdag","onsdag","torsdag","fredag","lørdag"]},no:{months:["Januar","Februar","Mars","April","Mai","Juni","Juli","August","September","Oktober","November","Desember"],dayOfWeekShort:["Søn","Man","Tir","Ons","Tor","Fre","Lør"],dayOfWeek:["Søndag","Mandag","Tirsdag","Onsdag","Torsdag","Fredag","Lørdag"]},ja:{months:["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],dayOfWeekShort:["日","月","火","水","木","金","土"],dayOfWeek:["日曜","月曜","火曜","水曜","木曜","金曜","土曜"]},vi:{months:["Tháng 1","Tháng 2","Tháng 3","Tháng 4","Tháng 5","Tháng 6","Tháng 7","Tháng 8","Tháng 9","Tháng 10","Tháng 11","Tháng 12"],dayOfWeekShort:["CN","T2","T3","T4","T5","T6","T7"],dayOfWeek:["Chủ nhật","Thứ hai","Thứ ba","Thứ tư","Thứ năm","Thứ sáu","Thứ bảy"]},sl:{months:["Januar","Februar","Marec","April","Maj","Junij","Julij","Avgust","September","Oktober","November","December"],dayOfWeekShort:["Ned","Pon","Tor","Sre","Čet","Pet","Sob"],dayOfWeek:["Nedelja","Ponedeljek","Torek","Sreda","Četrtek","Petek","Sobota"]},cs:{months:["Leden","Únor","Březen","Duben","Květen","Červen","Červenec","Srpen","Září","Říjen","Listopad","Prosinec"],dayOfWeekShort:["Ne","Po","Út","St","Čt","Pá","So"]},hu:{months:["Január","Február","Március","Április","Május","Június","Július","Augusztus","Szeptember","Október","November","December"],dayOfWeekShort:["Va","Hé","Ke","Sze","Cs","Pé","Szo"],dayOfWeek:["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"]},az:{months:["Yanvar","Fevral","Mart","Aprel","May","Iyun","Iyul","Avqust","Sentyabr","Oktyabr","Noyabr","Dekabr"],dayOfWeekShort:["B","Be","Ça","Ç","Ca","C","Ş"],dayOfWeek:["Bazar","Bazar ertəsi","Çərşənbə axşamı","Çərşənbə","Cümə axşamı","Cümə","Şənbə"]},bs:{months:["Januar","Februar","Mart","April","Maj","Jun","Jul","Avgust","Septembar","Oktobar","Novembar","Decembar"],dayOfWeekShort:["Ned","Pon","Uto","Sri","Čet","Pet","Sub"],dayOfWeek:["Nedjelja","Ponedjeljak","Utorak","Srijeda","Četvrtak","Petak","Subota"]},ca:{months:["Gener","Febrer","Març","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","Desembre"],dayOfWeekShort:["Dg","Dl","Dt","Dc","Dj","Dv","Ds"],dayOfWeek:["Diumenge","Dilluns","Dimarts","Dimecres","Dijous","Divendres","Dissabte"]},"en-GB":{months:["January","February","March","April","May","June","July","August","September","October","November","December"],dayOfWeekShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],dayOfWeek:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]},et:{months:["Jaanuar","Veebruar","Märts","Aprill","Mai","Juuni","Juuli","August","September","Oktoober","November","Detsember"],dayOfWeekShort:["P","E","T","K","N","R","L"],dayOfWeek:["Pühapäev","Esmaspäev","Teisipäev","Kolmapäev","Neljapäev","Reede","Laupäev"]},eu:{months:["Urtarrila","Otsaila","Martxoa","Apirila","Maiatza","Ekaina","Uztaila","Abuztua","Iraila","Urria","Azaroa","Abendua"],dayOfWeekShort:["Ig.","Al.","Ar.","Az.","Og.","Or.","La."],dayOfWeek:["Igandea","Astelehena","Asteartea","Asteazkena","Osteguna","Ostirala","Larunbata"]},fi:{months:["Tammikuu","Helmikuu","Maaliskuu","Huhtikuu","Toukokuu","Kesäkuu","Heinäkuu","Elokuu","Syyskuu","Lokakuu","Marraskuu","Joulukuu"],dayOfWeekShort:["Su","Ma","Ti","Ke","To","Pe","La"],dayOfWeek:["sunnuntai","maanantai","tiistai","keskiviikko","torstai","perjantai","lauantai"]},gl:{months:["Xan","Feb","Maz","Abr","Mai","Xun","Xul","Ago","Set","Out","Nov","Dec"],dayOfWeekShort:["Dom","Lun","Mar","Mer","Xov","Ven","Sab"],dayOfWeek:["Domingo","Luns","Martes","Mércores","Xoves","Venres","Sábado"]},hr:{months:["Siječanj","Veljača","Ožujak","Travanj","Svibanj","Lipanj","Srpanj","Kolovoz","Rujan","Listopad","Studeni","Prosinac"],dayOfWeekShort:["Ned","Pon","Uto","Sri","Čet","Pet","Sub"],dayOfWeek:["Nedjelja","Ponedjeljak","Utorak","Srijeda","Četvrtak","Petak","Subota"]},ko:{months:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],dayOfWeekShort:["일","월","화","수","목","금","토"],dayOfWeek:["일요일","월요일","화요일","수요일","목요일","금요일","토요일"]},lt:{months:["Sausio","Vasario","Kovo","Balandžio","Gegužės","Birželio","Liepos","Rugpjūčio","Rugsėjo","Spalio","Lapkričio","Gruodžio"],dayOfWeekShort:["Sek","Pir","Ant","Tre","Ket","Pen","Šeš"],dayOfWeek:["Sekmadienis","Pirmadienis","Antradienis","Trečiadienis","Ketvirtadienis","Penktadienis","Šeštadienis"]},lv:{months:["Janvāris","Februāris","Marts","Aprīlis ","Maijs","Jūnijs","Jūlijs","Augusts","Septembris","Oktobris","Novembris","Decembris"],dayOfWeekShort:["Sv","Pr","Ot","Tr","Ct","Pk","St"],dayOfWeek:["Svētdiena","Pirmdiena","Otrdiena","Trešdiena","Ceturtdiena","Piektdiena","Sestdiena"]},mk:{months:["јануари","февруари","март","април","мај","јуни","јули","август","септември","октомври","ноември","декември"],dayOfWeekShort:["нед","пон","вто","сре","чет","пет","саб"],dayOfWeek:["Недела","Понеделник","Вторник","Среда","Четврток","Петок","Сабота"]},mn:{months:["1-р сар","2-р сар","3-р сар","4-р сар","5-р сар","6-р сар","7-р сар","8-р сар","9-р сар","10-р сар","11-р сар","12-р сар"],dayOfWeekShort:["Дав","Мяг","Лха","Пүр","Бсн","Бям","Ням"],dayOfWeek:["Даваа","Мягмар","Лхагва","Пүрэв","Баасан","Бямба","Ням"]},"pt-BR":{months:["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],dayOfWeekShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],dayOfWeek:["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"]},sk:{months:["Január","Február","Marec","Apríl","Máj","Jún","Júl","August","September","Október","November","December"],dayOfWeekShort:["Ne","Po","Ut","St","Št","Pi","So"],dayOfWeek:["Nedeľa","Pondelok","Utorok","Streda","Štvrtok","Piatok","Sobota"]},sq:{months:["Janar","Shkurt","Mars","Prill","Maj","Qershor","Korrik","Gusht","Shtator","Tetor","Nëntor","Dhjetor"],dayOfWeekShort:["Die","Hën","Mar","Mër","Enj","Pre","Shtu"],dayOfWeek:["E Diel","E Hënë","E Martē","E Mërkurë","E Enjte","E Premte","E Shtunë"]},"sr-YU":{months:["Januar","Februar","Mart","April","Maj","Jun","Jul","Avgust","Septembar","Oktobar","Novembar","Decembar"],dayOfWeekShort:["Ned","Pon","Uto","Sre","čet","Pet","Sub"],dayOfWeek:["Nedelja","Ponedeljak","Utorak","Sreda","Četvrtak","Petak","Subota"]},sr:{months:["јануар","фебруар","март","април","мај","јун","јул","август","септембар","октобар","новембар","децембар"],dayOfWeekShort:["нед","пон","уто","сре","чет","пет","суб"],dayOfWeek:["Недеља","Понедељак","Уторак","Среда","Четвртак","Петак","Субота"]},sv:{months:["Januari","Februari","Mars","April","Maj","Juni","Juli","Augusti","September","Oktober","November","December"],dayOfWeekShort:["Sön","Mån","Tis","Ons","Tor","Fre","Lör"],dayOfWeek:["Söndag","Måndag","Tisdag","Onsdag","Torsdag","Fredag","Lördag"]},"zh-TW":{months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayOfWeekShort:["日","一","二","三","四","五","六"],dayOfWeek:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"]},zh:{months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayOfWeekShort:["日","一","二","三","四","五","六"],dayOfWeek:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"]},ug:{months:["1-ئاي","2-ئاي","3-ئاي","4-ئاي","5-ئاي","6-ئاي","7-ئاي","8-ئاي","9-ئاي","10-ئاي","11-ئاي","12-ئاي"],dayOfWeek:["يەكشەنبە","دۈشەنبە","سەيشەنبە","چارشەنبە","پەيشەنبە","جۈمە","شەنبە"]},he:{months:["ינואר","פברואר","מרץ","אפריל","מאי","יוני","יולי","אוגוסט","ספטמבר","אוקטובר","נובמבר","דצמבר"],dayOfWeekShort:["א'","ב'","ג'","ד'","ה'","ו'","שבת"],dayOfWeek:["ראשון","שני","שלישי","רביעי","חמישי","שישי","שבת","ראשון"]},hy:{months:["Հունվար","Փետրվար","Մարտ","Ապրիլ","Մայիս","Հունիս","Հուլիս","Օգոստոս","Սեպտեմբեր","Հոկտեմբեր","Նոյեմբեր","Դեկտեմբեր"],dayOfWeekShort:["Կի","Երկ","Երք","Չոր","Հնգ","Ուրբ","Շբթ"],dayOfWeek:["Կիրակի","Երկուշաբթի","Երեքշաբթի","Չորեքշաբթի","Հինգշաբթի","Ուրբաթ","Շաբաթ"]},kg:{months:["Үчтүн айы","Бирдин айы","Жалган Куран","Чын Куран","Бугу","Кулжа","Теке","Баш Оона","Аяк Оона","Тогуздун айы","Жетинин айы","Бештин айы"],dayOfWeekShort:["Жек","Дүй","Шей","Шар","Бей","Жум","Ише"],dayOfWeek:["Жекшемб","Дүйшөмб","Шейшемб","Шаршемб","Бейшемби","Жума","Ишенб"]},rm:{months:["Schaner","Favrer","Mars","Avrigl","Matg","Zercladur","Fanadur","Avust","Settember","October","November","December"],dayOfWeekShort:["Du","Gli","Ma","Me","Gie","Ve","So"],dayOfWeek:["Dumengia","Glindesdi","Mardi","Mesemna","Gievgia","Venderdi","Sonda"]},ka:{months:["იანვარი","თებერვალი","მარტი","აპრილი","მაისი","ივნისი","ივლისი","აგვისტო","სექტემბერი","ოქტომბერი","ნოემბერი","დეკემბერი"],dayOfWeekShort:["კვ","ორშ","სამშ","ოთხ","ხუთ","პარ","შაბ"],dayOfWeek:["კვირა","ორშაბათი","სამშაბათი","ოთხშაბათი","ხუთშაბათი","პარასკევი","შაბათი"]}},ownerDocument:document,contentWindow:window,value:"",rtl:!1,format:"Y/m/d H:i",formatTime:"H:i",formatDate:"Y/m/d",startDate:!1,step:60,monthChangeSpinner:!0,closeOnDateSelect:!1,closeOnTimeSelect:!0,closeOnWithoutClick:!0,closeOnInputClick:!0,timepicker:!0,datepicker:!0,weeks:!1,defaultTime:!1,defaultDate:!1,minDate:!1,maxDate:!1,minTime:!1,maxTime:!1,minDateTime:!1,disabledMinTime:!1,disabledMaxTime:!1,allowTimes:[],opened:!1,initTime:!0,inline:!1,theme:"",onSelectDate:function(){},onSelectTime:function(){},onChangeMonth:function(){},onGetWeekOfYear:function(){},onChangeYear:function(){},onChangeDateTime:function(){},onShow:function(){},onClose:function(){},onGenerate:function(){},withoutCopyright:!0,inverseButton:!1,hours12:!1,next:"xdsoft_next",prev:"xdsoft_prev",dayOfWeekStart:0,parentID:"body",timeHeightInTimePicker:25,timepickerScrollbar:!0,todayButton:!0,prevButton:!0,nextButton:!0,defaultSelect:!0,scrollMonth:!0,scrollTime:!0,scrollInput:!0,lazyInit:!1,mask:!1,validateOnBlur:!0,allowBlank:!0,yearStart:1950,yearEnd:2050,monthStart:0,monthEnd:11,style:"",id:"",fixed:!1,roundTime:"round",className:"",weekends:[],highlightedDates:[],highlightedPeriods:[],allowDates:[],allowDateRe:null,disabledDates:[],disabledWeekDays:[],yearOffset:0,beforeShowDay:null,enterLikeTab:!0,showApplyButton:!1},n=null,r="en",o={meridiem:["AM","PM"]},i=function(){var t=a.i18n[r],i={days:t.dayOfWeek,daysShort:t.dayOfWeekShort,months:t.months,monthsShort:e.map(t.months,function(e){return e.substring(0,3)})};"function"==typeof DateFormatter&&(n=new DateFormatter({dateSettings:e.extend({},o,i)}))};e.datetimepicker={setLocale:function(e){var t=a.i18n[e]?e:"en";r!==t&&(r=t,i())},setDateFormatter:function(e){n=e},RFC_2822:"D, d M Y H:i:s O",ATOM:"Y-m-dTH:i:sP",ISO_8601:"Y-m-dTH:i:sO",RFC_822:"D, d M y H:i:s O",RFC_850:"l, d-M-y H:i:s T",RFC_1036:"D, d M y H:i:s O",RFC_1123:"D, d M Y H:i:s O",RSS:"D, d M Y H:i:s O",W3C:"Y-m-dTH:i:sP"},i(),window.getComputedStyle||(window.getComputedStyle=function(e){return this.el=e,this.getPropertyValue=function(t){var a=/(-([a-z]))/g;return"float"===t&&(t="styleFloat"),a.test(t)&&(t=t.replace(a,function(e,t,a){return a.toUpperCase()})),e.currentStyle[t]||null},this}),Array.prototype.indexOf||(Array.prototype.indexOf=function(e,t){var a,n;for(a=t||0,n=this.length;a<n;a+=1)if(this[a]===e)return a;return-1}),Date.prototype.countDaysInMonth=function(){return new Date(this.getFullYear(),this.getMonth()+1,0).getDate()},e.fn.xdsoftScroller=function(t,a){return this.each(function(){var n,r,o,i,s,d=e(this),u=function(e){var t,a={x:0,y:0};return"touchstart"===e.type||"touchmove"===e.type||"touchend"===e.type||"touchcancel"===e.type?(t=e.originalEvent.touches[0]||e.originalEvent.changedTouches[0],a.x=t.clientX,a.y=t.clientY):"mousedown"!==e.type&&"mouseup"!==e.type&&"mousemove"!==e.type&&"mouseover"!==e.type&&"mouseout"!==e.type&&"mouseenter"!==e.type&&"mouseleave"!==e.type||(a.x=e.clientX,a.y=e.clientY),a},l=100,f=!1,c=0,m=0,h=0,g=!1,p=0,y=function(){};"hide"!==a?(e(this).hasClass("xdsoft_scroller_box")||(n=d.children().eq(0),r=d[0].clientHeight,o=n[0].offsetHeight,i=e('<div class="xdsoft_scrollbar"></div>'),s=e('<div class="xdsoft_scroller"></div>'),i.append(s),d.addClass("xdsoft_scroller_box").append(i),y=function(e){var t=u(e).y-c+p;t<0&&(t=0),t+s[0].offsetHeight>h&&(t=h-s[0].offsetHeight),d.trigger("scroll_element.xdsoft_scroller",[l?t/l:0])},s.on("touchstart.xdsoft_scroller mousedown.xdsoft_scroller",function(n){r||d.trigger("resize_scroll.xdsoft_scroller",[a]),c=u(n).y,p=parseInt(s.css("margin-top"),10),h=i[0].offsetHeight,"mousedown"===n.type||"touchstart"===n.type?(t.ownerDocument&&e(t.ownerDocument.body).addClass("xdsoft_noselect"),e([t.ownerDocument.body,t.contentWindow]).on("touchend mouseup.xdsoft_scroller",function a(){e([t.ownerDocument.body,t.contentWindow]).off("touchend mouseup.xdsoft_scroller",a).off("mousemove.xdsoft_scroller",y).removeClass("xdsoft_noselect")}),e(t.ownerDocument.body).on("mousemove.xdsoft_scroller",y)):(g=!0,n.stopPropagation(),n.preventDefault())}).on("touchmove",function(e){g&&(e.preventDefault(),y(e))}).on("touchend touchcancel",function(){g=!1,p=0}),d.on("scroll_element.xdsoft_scroller",function(e,t){r||d.trigger("resize_scroll.xdsoft_scroller",[t,!0]),t=t>1?1:t<0||isNaN(t)?0:t,s.css("margin-top",l*t),setTimeout(function(){n.css("marginTop",-parseInt((n[0].offsetHeight-r)*t,10))},10)}).on("resize_scroll.xdsoft_scroller",function(e,t,a){var u,f;r=d[0].clientHeight,o=n[0].offsetHeight,f=(u=r/o)*i[0].offsetHeight,u>1?s.hide():(s.show(),s.css("height",parseInt(f>10?f:10,10)),l=i[0].offsetHeight-s[0].offsetHeight,!0!==a&&d.trigger("scroll_element.xdsoft_scroller",[t||Math.abs(parseInt(n.css("marginTop"),10))/(o-r)]))}),d.on("mousewheel",function(e){var t=Math.abs(parseInt(n.css("marginTop"),10));return(t-=20*e.deltaY)<0&&(t=0),d.trigger("scroll_element.xdsoft_scroller",[t/(o-r)]),e.stopPropagation(),!1}),d.on("touchstart",function(e){f=u(e),m=Math.abs(parseInt(n.css("marginTop"),10))}),d.on("touchmove",function(e){if(f){e.preventDefault();var t=u(e);d.trigger("scroll_element.xdsoft_scroller",[(m-(t.y-f.y))/(o-r)])}}),d.on("touchend touchcancel",function(){f=!1,m=0})),d.trigger("resize_scroll.xdsoft_scroller",[a])):d.find(".xdsoft_scrollbar").hide()})},e.fn.datetimepicker=function(o,i){var s,d,u=this,l=48,f=57,c=96,m=105,h=17,g=46,p=13,y=27,D=8,v=37,b=38,k=39,x=40,T=9,S=116,w=65,M=67,O=86,W=90,_=89,F=!1,C=e.isPlainObject(o)||!o?e.extend(!0,{},a,o):e.extend(!0,{},a),P=0,A=function(e){e.on("open.xdsoft focusin.xdsoft mousedown.xdsoft touchstart",function t(){e.is(":disabled")||e.data("xdsoft_datetimepicker")||(clearTimeout(P),P=setTimeout(function(){e.data("xdsoft_datetimepicker")||s(e),e.off("open.xdsoft focusin.xdsoft mousedown.xdsoft touchstart",t).trigger("open.xdsoft")},100))})};return s=function(a){function i(){var e,t=!1;return C.startDate?t=Y.strToDate(C.startDate):(t=C.value||(a&&a.val&&a.val()?a.val():""))?t=Y.strToDateTime(t):C.defaultDate&&(t=Y.strToDateTime(C.defaultDate),C.defaultTime&&(e=Y.strtotime(C.defaultTime),t.setHours(e.getHours()),t.setMinutes(e.getMinutes()))),t&&Y.isValidDate(t)?H.data("changed",!0):t="",t||0}function s(t){var n=function(e,t){var a=e.replace(/([\[\]\/\{\}\(\)\-\.\+]{1})/g,"\\$1").replace(/_/g,"{digit+}").replace(/([0-9]{1})/g,"{digit$1}").replace(/\{digit([0-9]{1})\}/g,"[0-$1_]{1}").replace(/\{digit[\+]\}/g,"[0-9_]{1}");return new RegExp(a).test(t)},r=function(e){try{if(t.ownerDocument.selection&&t.ownerDocument.selection.createRange)return t.ownerDocument.selection.createRange().getBookmark().charCodeAt(2)-2;if(e.setSelectionRange)return e.selectionStart}catch(e){return 0}},o=function(e,a){if(!(e="string"==typeof e||e instanceof String?t.ownerDocument.getElementById(e):e))return!1;if(e.createTextRange){var n=e.createTextRange();return n.collapse(!0),n.moveEnd("character",a),n.moveStart("character",a),n.select(),!0}return!!e.setSelectionRange&&(e.setSelectionRange(a,a),!0)};t.mask&&a.off("keydown.xdsoft"),!0===t.mask&&("undefined"!=typeof moment?t.mask=t.format.replace(/Y{4}/g,"9999").replace(/Y{2}/g,"99").replace(/M{2}/g,"19").replace(/D{2}/g,"39").replace(/H{2}/g,"29").replace(/m{2}/g,"59").replace(/s{2}/g,"59"):t.mask=t.format.replace(/Y/g,"9999").replace(/F/g,"9999").replace(/m/g,"19").replace(/d/g,"39").replace(/H/g,"29").replace(/i/g,"59").replace(/s/g,"59")),"string"===e.type(t.mask)&&(n(t.mask,a.val())||(a.val(t.mask.replace(/[0-9]/g,"_")),o(a[0],0)),a.on("keydown.xdsoft",function(i){var s,d,u=this.value,C=i.which;if(C>=l&&C<=f||C>=c&&C<=m||C===D||C===g){for(s=r(this),d=C!==D&&C!==g?String.fromCharCode(c<=C&&C<=m?C-l:C):"_",C!==D&&C!==g||!s||(s-=1,d="_");/[^0-9_]/.test(t.mask.substr(s,1))&&s<t.mask.length&&s>0;)s+=C===D||C===g?-1:1;if(u=u.substr(0,s)+d+u.substr(s+1),""===e.trim(u))u=t.mask.replace(/[0-9]/g,"_");else if(s===t.mask.length)return i.preventDefault(),!1;for(s+=C===D||C===g?0:1;/[^0-9_]/.test(t.mask.substr(s,1))&&s<t.mask.length&&s>0;)s+=C===D||C===g?-1:1;n(t.mask,u)?(this.value=u,o(this,s)):""===e.trim(u)?this.value=t.mask.replace(/[0-9]/g,"_"):a.trigger("error_input.xdsoft")}else if(-1!==[w,M,O,W,_].indexOf(C)&&F||-1!==[y,b,x,v,k,S,h,T,p].indexOf(C))return!0;return i.preventDefault(),!1}))}var d,u,P,A,Y,j,H=e('<div class="xdsoft_datetimepicker xdsoft_noselect"></div>'),J=e('<div class="xdsoft_copyright"><a target="_blank" href="http://xdsoft.net/jqplugins/datetimepicker/">xdsoft.net</a></div>'),z=e('<div class="xdsoft_datepicker active"></div>'),I=e('<div class="xdsoft_monthpicker"><button type="button" class="xdsoft_prev"></button><button type="button" class="xdsoft_today_button"></button><div class="xdsoft_label xdsoft_month"><span></span><i></i></div><div class="xdsoft_label xdsoft_year"><span></span><i></i></div><button type="button" class="xdsoft_next"></button></div>'),N=e('<div class="xdsoft_calendar"></div>'),L=e('<div class="xdsoft_timepicker active"><button type="button" class="xdsoft_prev"></button><div class="xdsoft_time_box"></div><button type="button" class="xdsoft_next"></button></div>'),E=L.find(".xdsoft_time_box").eq(0),R=e('<div class="xdsoft_time_variant"></div>'),B=e('<button type="button" class="xdsoft_save_selected blue-gradient-button">Save Selected</button>'),V=e('<div class="xdsoft_select xdsoft_monthselect"><div></div></div>'),G=e('<div class="xdsoft_select xdsoft_yearselect"><div></div></div>'),U=!1,q=0;C.id&&H.attr("id",C.id),C.style&&H.attr("style",C.style),C.weeks&&H.addClass("xdsoft_showweeks"),C.rtl&&H.addClass("xdsoft_rtl"),H.addClass("xdsoft_"+C.theme),H.addClass(C.className),I.find(".xdsoft_month span").after(V),I.find(".xdsoft_year span").after(G),I.find(".xdsoft_month,.xdsoft_year").on("touchstart mousedown.xdsoft",function(t){var a,n,r=e(this).find(".xdsoft_select").eq(0),o=0,i=0,s=r.is(":visible");for(I.find(".xdsoft_select").hide(),Y.currentTime&&(o=Y.currentTime[e(this).hasClass("xdsoft_month")?"getMonth":"getFullYear"]()),r[s?"hide":"show"](),a=r.find("div.xdsoft_option"),n=0;n<a.length&&a.eq(n).data("value")!==o;n+=1)i+=a[0].offsetHeight;return r.xdsoftScroller(C,i/(r.children()[0].offsetHeight-r[0].clientHeight)),t.stopPropagation(),!1}),I.find(".xdsoft_select").xdsoftScroller(C).on("touchstart mousedown.xdsoft",function(e){e.stopPropagation(),e.preventDefault()}).on("touchstart mousedown.xdsoft",".xdsoft_option",function(){void 0!==Y.currentTime&&null!==Y.currentTime||(Y.currentTime=Y.now());var t=Y.currentTime.getFullYear();Y&&Y.currentTime&&Y.currentTime[e(this).parent().parent().hasClass("xdsoft_monthselect")?"setMonth":"setFullYear"](e(this).data("value")),e(this).parent().parent().hide(),H.trigger("xchange.xdsoft"),C.onChangeMonth&&e.isFunction(C.onChangeMonth)&&C.onChangeMonth.call(H,Y.currentTime,H.data("input")),t!==Y.currentTime.getFullYear()&&e.isFunction(C.onChangeYear)&&C.onChangeYear.call(H,Y.currentTime,H.data("input"))}),H.getValue=function(){return Y.getCurrentTime()},H.setOptions=function(r){var o={};C=e.extend(!0,{},C,r),r.allowTimes&&e.isArray(r.allowTimes)&&r.allowTimes.length&&(C.allowTimes=e.extend(!0,[],r.allowTimes)),r.weekends&&e.isArray(r.weekends)&&r.weekends.length&&(C.weekends=e.extend(!0,[],r.weekends)),r.allowDates&&e.isArray(r.allowDates)&&r.allowDates.length&&(C.allowDates=e.extend(!0,[],r.allowDates)),r.allowDateRe&&"[object String]"===Object.prototype.toString.call(r.allowDateRe)&&(C.allowDateRe=new RegExp(r.allowDateRe)),r.highlightedDates&&e.isArray(r.highlightedDates)&&r.highlightedDates.length&&(e.each(r.highlightedDates,function(a,r){var i,s=e.map(r.split(","),e.trim),d=new t(n.parseDate(s[0],C.formatDate),s[1],s[2]),u=n.formatDate(d.date,C.formatDate);void 0!==o[u]?(i=o[u].desc)&&i.length&&d.desc&&d.desc.length&&(o[u].desc=i+"\n"+d.desc):o[u]=d}),C.highlightedDates=e.extend(!0,[],o)),r.highlightedPeriods&&e.isArray(r.highlightedPeriods)&&r.highlightedPeriods.length&&(o=e.extend(!0,[],C.highlightedDates),e.each(r.highlightedPeriods,function(a,r){var i,s,d,u,l,f,c;if(e.isArray(r))i=r[0],s=r[1],d=r[2],c=r[3];else{var m=e.map(r.split(","),e.trim);i=n.parseDate(m[0],C.formatDate),s=n.parseDate(m[1],C.formatDate),d=m[2],c=m[3]}for(;i<=s;)u=new t(i,d,c),l=n.formatDate(i,C.formatDate),i.setDate(i.getDate()+1),void 0!==o[l]?(f=o[l].desc)&&f.length&&u.desc&&u.desc.length&&(o[l].desc=f+"\n"+u.desc):o[l]=u}),C.highlightedDates=e.extend(!0,[],o)),r.disabledDates&&e.isArray(r.disabledDates)&&r.disabledDates.length&&(C.disabledDates=e.extend(!0,[],r.disabledDates)),r.disabledWeekDays&&e.isArray(r.disabledWeekDays)&&r.disabledWeekDays.length&&(C.disabledWeekDays=e.extend(!0,[],r.disabledWeekDays)),!C.open&&!C.opened||C.inline||a.trigger("open.xdsoft"),C.inline&&(U=!0,H.addClass("xdsoft_inline"),a.after(H).hide()),C.inverseButton&&(C.next="xdsoft_prev",C.prev="xdsoft_next"),C.datepicker?z.addClass("active"):z.removeClass("active"),C.timepicker?L.addClass("active"):L.removeClass("active"),C.value&&(Y.setCurrentTime(C.value),a&&a.val&&a.val(Y.str)),isNaN(C.dayOfWeekStart)?C.dayOfWeekStart=0:C.dayOfWeekStart=parseInt(C.dayOfWeekStart,10)%7,C.timepickerScrollbar||E.xdsoftScroller(C,"hide"),C.minDate&&/^[\+\-](.*)$/.test(C.minDate)&&(C.minDate=n.formatDate(Y.strToDateTime(C.minDate),C.formatDate)),C.maxDate&&/^[\+\-](.*)$/.test(C.maxDate)&&(C.maxDate=n.formatDate(Y.strToDateTime(C.maxDate),C.formatDate)),C.minDateTime&&/^\+(.*)$/.test(C.minDateTime)&&(C.minDateTime=Y.strToDateTime(C.minDateTime).dateFormat(C.formatDate)),B.toggle(C.showApplyButton),I.find(".xdsoft_today_button").css("visibility",C.todayButton?"visible":"hidden"),I.find("."+C.prev).css("visibility",C.prevButton?"visible":"hidden"),I.find("."+C.next).css("visibility",C.nextButton?"visible":"hidden"),s(C),C.validateOnBlur&&a.off("blur.xdsoft").on("blur.xdsoft",function(){if(C.allowBlank&&(!e.trim(e(this).val()).length||"string"==typeof C.mask&&e.trim(e(this).val())===C.mask.replace(/[0-9]/g,"_")))e(this).val(null),H.data("xdsoft_datetime").empty();else{var t=n.parseDate(e(this).val(),C.format);if(t)e(this).val(n.formatDate(t,C.format));else{var a=+[e(this).val()[0],e(this).val()[1]].join(""),r=+[e(this).val()[2],e(this).val()[3]].join("");!C.datepicker&&C.timepicker&&a>=0&&a<24&&r>=0&&r<60?e(this).val([a,r].map(function(e){return e>9?e:"0"+e}).join(":")):e(this).val(n.formatDate(Y.now(),C.format))}H.data("xdsoft_datetime").setCurrentTime(e(this).val())}H.trigger("changedatetime.xdsoft"),H.trigger("close.xdsoft")}),C.dayOfWeekStartPrev=0===C.dayOfWeekStart?6:C.dayOfWeekStart-1,H.trigger("xchange.xdsoft").trigger("afterOpen.xdsoft")},H.data("options",C).on("touchstart mousedown.xdsoft",function(e){return e.stopPropagation(),e.preventDefault(),G.hide(),V.hide(),!1}),E.append(R),E.xdsoftScroller(C),H.on("afterOpen.xdsoft",function(){E.xdsoftScroller(C)}),H.append(z).append(L),!0!==C.withoutCopyright&&H.append(J),z.append(I).append(N).append(B),e(C.parentID).append(H),Y=new function(){var t=this;t.now=function(e){var a,n,r=new Date;return!e&&C.defaultDate&&(a=t.strToDateTime(C.defaultDate),r.setFullYear(a.getFullYear()),r.setMonth(a.getMonth()),r.setDate(a.getDate())),C.yearOffset&&r.setFullYear(r.getFullYear()+C.yearOffset),!e&&C.defaultTime&&(n=t.strtotime(C.defaultTime),r.setHours(n.getHours()),r.setMinutes(n.getMinutes())),r},t.isValidDate=function(e){return"[object Date]"===Object.prototype.toString.call(e)&&!isNaN(e.getTime())},t.setCurrentTime=function(e,a){"string"==typeof e?t.currentTime=t.strToDateTime(e):t.isValidDate(e)?t.currentTime=e:e||a||!C.allowBlank||C.inline?t.currentTime=t.now():t.currentTime=null,H.trigger("xchange.xdsoft")},t.empty=function(){t.currentTime=null},t.getCurrentTime=function(){return t.currentTime},t.nextMonth=function(){void 0!==t.currentTime&&null!==t.currentTime||(t.currentTime=t.now());var a,n=t.currentTime.getMonth()+1;return 12===n&&(t.currentTime.setFullYear(t.currentTime.getFullYear()+1),n=0),a=t.currentTime.getFullYear(),t.currentTime.setDate(Math.min(new Date(t.currentTime.getFullYear(),n+1,0).getDate(),t.currentTime.getDate())),t.currentTime.setMonth(n),C.onChangeMonth&&e.isFunction(C.onChangeMonth)&&C.onChangeMonth.call(H,Y.currentTime,H.data("input")),a!==t.currentTime.getFullYear()&&e.isFunction(C.onChangeYear)&&C.onChangeYear.call(H,Y.currentTime,H.data("input")),H.trigger("xchange.xdsoft"),n},t.prevMonth=function(){void 0!==t.currentTime&&null!==t.currentTime||(t.currentTime=t.now());var a=t.currentTime.getMonth()-1;return-1===a&&(t.currentTime.setFullYear(t.currentTime.getFullYear()-1),a=11),t.currentTime.setDate(Math.min(new Date(t.currentTime.getFullYear(),a+1,0).getDate(),t.currentTime.getDate())),t.currentTime.setMonth(a),C.onChangeMonth&&e.isFunction(C.onChangeMonth)&&C.onChangeMonth.call(H,Y.currentTime,H.data("input")),H.trigger("xchange.xdsoft"),a},t.getWeekOfYear=function(t){if(C.onGetWeekOfYear&&e.isFunction(C.onGetWeekOfYear)){var a=C.onGetWeekOfYear.call(H,t);if(void 0!==a)return a}var n=new Date(t.getFullYear(),0,1);return 4!==n.getDay()&&n.setMonth(0,1+(4-n.getDay()+7)%7),Math.ceil(((t-n)/864e5+n.getDay()+1)/7)},t.strToDateTime=function(e){var a,r,o=[];return e&&e instanceof Date&&t.isValidDate(e)?e:((o=/^([+-]{1})(.*)$/.exec(e))&&(o[2]=n.parseDate(o[2],C.formatDate)),o&&o[2]?(a=o[2].getTime()-6e4*o[2].getTimezoneOffset(),r=new Date(t.now(!0).getTime()+parseInt(o[1]+"1",10)*a)):r=e?n.parseDate(e,C.format):t.now(),t.isValidDate(r)||(r=t.now()),r)},t.strToDate=function(e){if(e&&e instanceof Date&&t.isValidDate(e))return e;var a=e?n.parseDate(e,C.formatDate):t.now(!0);return t.isValidDate(a)||(a=t.now(!0)),a},t.strtotime=function(e){if(e&&e instanceof Date&&t.isValidDate(e))return e;var a=e?n.parseDate(e,C.formatTime):t.now(!0);return t.isValidDate(a)||(a=t.now(!0)),a},t.str=function(){return n.formatDate(t.currentTime,C.format)},t.currentTime=this.now()},B.on("touchend click",function(e){e.preventDefault(),H.data("changed",!0),Y.setCurrentTime(i()),a.val(Y.str()),H.trigger("close.xdsoft")}),I.find(".xdsoft_today_button").on("touchend mousedown.xdsoft",function(){H.data("changed",!0),Y.setCurrentTime(0,!0),H.trigger("afterOpen.xdsoft")}).on("dblclick.xdsoft",function(){var e,t,n=Y.getCurrentTime();n=new Date(n.getFullYear(),n.getMonth(),n.getDate()),e=Y.strToDate(C.minDate),n<(e=new Date(e.getFullYear(),e.getMonth(),e.getDate()))||(t=Y.strToDate(C.maxDate),n>(t=new Date(t.getFullYear(),t.getMonth(),t.getDate()))||(a.val(Y.str()),a.trigger("change"),H.trigger("close.xdsoft")))}),I.find(".xdsoft_prev,.xdsoft_next").on("touchend mousedown.xdsoft",function(){var t=e(this),a=0,n=!1;!function e(r){t.hasClass(C.next)?Y.nextMonth():t.hasClass(C.prev)&&Y.prevMonth(),C.monthChangeSpinner&&(n||(a=setTimeout(e,r||100)))}(500),e([C.ownerDocument.body,C.contentWindow]).on("touchend mouseup.xdsoft",function t(){clearTimeout(a),n=!0,e([C.ownerDocument.body,C.contentWindow]).off("touchend mouseup.xdsoft",t)})}),L.find(".xdsoft_prev,.xdsoft_next").on("touchend mousedown.xdsoft",function(){var t=e(this),a=0,n=!1,r=110;!function e(o){var i=E[0].clientHeight,s=R[0].offsetHeight,d=Math.abs(parseInt(R.css("marginTop"),10));t.hasClass(C.next)&&s-i-C.timeHeightInTimePicker>=d?R.css("marginTop","-"+(d+C.timeHeightInTimePicker)+"px"):t.hasClass(C.prev)&&d-C.timeHeightInTimePicker>=0&&R.css("marginTop","-"+(d-C.timeHeightInTimePicker)+"px"),E.trigger("scroll_element.xdsoft_scroller",[Math.abs(parseInt(R[0].style.marginTop,10)/(s-i))]),r=r>10?10:r-10,n||(a=setTimeout(e,o||r))}(500),e([C.ownerDocument.body,C.contentWindow]).on("touchend mouseup.xdsoft",function t(){clearTimeout(a),n=!0,e([C.ownerDocument.body,C.contentWindow]).off("touchend mouseup.xdsoft",t)})}),d=0,H.on("xchange.xdsoft",function(t){clearTimeout(d),d=setTimeout(function(){void 0!==Y.currentTime&&null!==Y.currentTime||(Y.currentTime=Y.now());for(var t,i,s,d,u,l,f,c,m,h,g="",p=new Date(Y.currentTime.getFullYear(),Y.currentTime.getMonth(),1,12,0,0),y=0,D=Y.now(),v=!1,b=!1,k=!1,x=[],T=!0,S="";p.getDay()!==C.dayOfWeekStart;)p.setDate(p.getDate()-1);for(g+="<table><thead><tr>",C.weeks&&(g+="<th></th>"),t=0;t<7;t+=1)g+="<th>"+C.i18n[r].dayOfWeekShort[(t+C.dayOfWeekStart)%7]+"</th>";for(g+="</tr></thead>",g+="<tbody>",!1!==C.maxDate&&(v=Y.strToDate(C.maxDate),v=new Date(v.getFullYear(),v.getMonth(),v.getDate(),23,59,59,999)),!1!==C.minDate&&(b=Y.strToDate(C.minDate),b=new Date(b.getFullYear(),b.getMonth(),b.getDate())),!1!==C.minDateTime&&(k=Y.strToDate(C.minDateTime),k=new Date(k.getFullYear(),k.getMonth(),k.getDate(),k.getHours(),k.getMinutes(),k.getSeconds()));y<Y.currentTime.countDaysInMonth()||p.getDay()!==C.dayOfWeekStart||Y.currentTime.getMonth()===p.getMonth();)x=[],y+=1,s=p.getDay(),d=p.getDate(),u=p.getFullYear(),l=p.getMonth(),f=Y.getWeekOfYear(p),h="",x.push("xdsoft_date"),c=C.beforeShowDay&&e.isFunction(C.beforeShowDay.call)?C.beforeShowDay.call(H,p):null,C.allowDateRe&&"[object RegExp]"===Object.prototype.toString.call(C.allowDateRe)?C.allowDateRe.test(n.formatDate(p,C.formatDate))||x.push("xdsoft_disabled"):C.allowDates&&C.allowDates.length>0?-1===C.allowDates.indexOf(n.formatDate(p,C.formatDate))&&x.push("xdsoft_disabled"):!1!==v&&p>v||!1!==k&&p<k||!1!==b&&p<b||c&&!1===c[0]?x.push("xdsoft_disabled"):-1!==C.disabledDates.indexOf(n.formatDate(p,C.formatDate))?x.push("xdsoft_disabled"):-1!==C.disabledWeekDays.indexOf(s)?x.push("xdsoft_disabled"):a.is("[disabled]")&&x.push("xdsoft_disabled"),c&&""!==c[1]&&x.push(c[1]),Y.currentTime.getMonth()!==l&&x.push("xdsoft_other_month"),(C.defaultSelect||H.data("changed"))&&n.formatDate(Y.currentTime,C.formatDate)===n.formatDate(p,C.formatDate)&&x.push("xdsoft_current"),n.formatDate(D,C.formatDate)===n.formatDate(p,C.formatDate)&&x.push("xdsoft_today"),0!==p.getDay()&&6!==p.getDay()&&-1===C.weekends.indexOf(n.formatDate(p,C.formatDate))||x.push("xdsoft_weekend"),void 0!==C.highlightedDates[n.formatDate(p,C.formatDate)]&&(i=C.highlightedDates[n.formatDate(p,C.formatDate)],x.push(void 0===i.style?"xdsoft_highlighted_default":i.style),h=void 0===i.desc?"":i.desc),C.beforeShowDay&&e.isFunction(C.beforeShowDay)&&x.push(C.beforeShowDay(p)),T&&(g+="<tr>",T=!1,C.weeks&&(g+="<th>"+f+"</th>")),g+='<td data-date="'+d+'" data-month="'+l+'" data-year="'+u+'" class="xdsoft_date xdsoft_day_of_week'+p.getDay()+" "+x.join(" ")+'" title="'+h+'"><div>'+d+"</div></td>",p.getDay()===C.dayOfWeekStartPrev&&(g+="</tr>",T=!0),p.setDate(d+1);if(g+="</tbody></table>",N.html(g),I.find(".xdsoft_label span").eq(0).text(C.i18n[r].months[Y.currentTime.getMonth()]),I.find(".xdsoft_label span").eq(1).text(Y.currentTime.getFullYear()),S="","",l="",m=function(t,r){var o,i,s=Y.now(),d=C.allowTimes&&e.isArray(C.allowTimes)&&C.allowTimes.length;s.setHours(t),t=parseInt(s.getHours(),10),s.setMinutes(r),r=parseInt(s.getMinutes(),10),(o=new Date(Y.currentTime)).setHours(t),o.setMinutes(r),x=[],!1!==C.minDateTime&&C.minDateTime>o||!1!==C.maxTime&&Y.strtotime(C.maxTime).getTime()<s.getTime()||!1!==C.minTime&&Y.strtotime(C.minTime).getTime()>s.getTime()?x.push("xdsoft_disabled"):!1!==C.minDateTime&&C.minDateTime>o||!1!==C.disabledMinTime&&s.getTime()>Y.strtotime(C.disabledMinTime).getTime()&&!1!==C.disabledMaxTime&&s.getTime()<Y.strtotime(C.disabledMaxTime).getTime()?x.push("xdsoft_disabled"):a.is("[disabled]")&&x.push("xdsoft_disabled"),(i=new Date(Y.currentTime)).setHours(parseInt(Y.currentTime.getHours(),10)),d||i.setMinutes(Math[C.roundTime](Y.currentTime.getMinutes()/C.step)*C.step),(C.initTime||C.defaultSelect||H.data("changed"))&&i.getHours()===parseInt(t,10)&&(!d&&C.step>59||i.getMinutes()===parseInt(r,10))&&(C.defaultSelect||H.data("changed")?x.push("xdsoft_current"):C.initTime&&x.push("xdsoft_init_time")),parseInt(D.getHours(),10)===parseInt(t,10)&&parseInt(D.getMinutes(),10)===parseInt(r,10)&&x.push("xdsoft_today"),S+='<div class="xdsoft_time '+x.join(" ")+'" data-hour="'+t+'" data-minute="'+r+'">'+n.formatDate(s,C.formatTime)+"</div>"},C.allowTimes&&e.isArray(C.allowTimes)&&C.allowTimes.length)for(y=0;y<C.allowTimes.length;y+=1)m(Y.strtotime(C.allowTimes[y]).getHours(),l=Y.strtotime(C.allowTimes[y]).getMinutes());else for(y=0,t=0;y<(C.hours12?12:24);y+=1)for(t=0;t<60;t+=C.step)m((y<10?"0":"")+y,l=(t<10?Y.now().getMinutes():"")+t);for(R.html(S),o="",y=parseInt(C.yearStart,10)+C.yearOffset;y<=parseInt(C.yearEnd,10)+C.yearOffset;y+=1)o+='<div class="xdsoft_option '+(Y.currentTime.getFullYear()===y?"xdsoft_current":"")+'" data-value="'+y+'">'+y+"</div>";for(G.children().eq(0).html(o),y=parseInt(C.monthStart,10),o="";y<=parseInt(C.monthEnd,10);y+=1)o+='<div class="xdsoft_option '+(Y.currentTime.getMonth()===y?"xdsoft_current":"")+'" data-value="'+y+'">'+C.i18n[r].months[y]+"</div>";V.children().eq(0).html(o),e(H).trigger("generate.xdsoft")},10),t.stopPropagation()}).on("afterOpen.xdsoft",function(){if(C.timepicker){var e,t,a,n;R.find(".xdsoft_current").length?e=".xdsoft_current":R.find(".xdsoft_init_time").length&&(e=".xdsoft_init_time"),e?(t=E[0].clientHeight,(a=R[0].offsetHeight)-t<(n=R.find(e).index()*C.timeHeightInTimePicker+1)&&(n=a-t),E.trigger("scroll_element.xdsoft_scroller",[parseInt(n,10)/(a-t)])):E.trigger("scroll_element.xdsoft_scroller",[0])}}),u=0,N.on("touchend click.xdsoft","td",function(t){t.stopPropagation(),u+=1;var n=e(this),r=Y.currentTime;if(void 0!==r&&null!==r||(Y.currentTime=Y.now(),r=Y.currentTime),n.hasClass("xdsoft_disabled"))return!1;r.setDate(1),r.setFullYear(n.data("year")),r.setMonth(n.data("month")),r.setDate(n.data("date")),H.trigger("select.xdsoft",[r]),a.val(Y.str()),C.onSelectDate&&e.isFunction(C.onSelectDate)&&C.onSelectDate.call(H,Y.currentTime,H.data("input"),t),H.data("changed",!0),H.trigger("xchange.xdsoft"),H.trigger("changedatetime.xdsoft"),(u>1||!0===C.closeOnDateSelect||!1===C.closeOnDateSelect&&!C.timepicker)&&!C.inline&&H.trigger("close.xdsoft"),setTimeout(function(){u=0},200)}),R.on("touchend click.xdsoft","div",function(t){t.stopPropagation();var a=e(this),n=Y.currentTime;if(void 0!==n&&null!==n||(Y.currentTime=Y.now(),n=Y.currentTime),a.hasClass("xdsoft_disabled"))return!1;n.setHours(a.data("hour")),n.setMinutes(a.data("minute")),H.trigger("select.xdsoft",[n]),H.data("input").val(Y.str()),C.onSelectTime&&e.isFunction(C.onSelectTime)&&C.onSelectTime.call(H,Y.currentTime,H.data("input"),t),H.data("changed",!0),H.trigger("xchange.xdsoft"),H.trigger("changedatetime.xdsoft"),!0!==C.inline&&!0===C.closeOnTimeSelect&&H.trigger("close.xdsoft")}),z.on("mousewheel.xdsoft",function(e){return!C.scrollMonth||(e.deltaY<0?Y.nextMonth():Y.prevMonth(),!1)}),a.on("mousewheel.xdsoft",function(e){return!C.scrollInput||(!C.datepicker&&C.timepicker?((P=R.find(".xdsoft_current").length?R.find(".xdsoft_current").eq(0).index():0)+e.deltaY>=0&&P+e.deltaY<R.children().length&&(P+=e.deltaY),R.children().eq(P).length&&R.children().eq(P).trigger("mousedown"),!1):C.datepicker&&!C.timepicker?(z.trigger(e,[e.deltaY,e.deltaX,e.deltaY]),a.val&&a.val(Y.str()),H.trigger("changedatetime.xdsoft"),!1):void 0)}),H.on("changedatetime.xdsoft",function(t){if(C.onChangeDateTime&&e.isFunction(C.onChangeDateTime)){var a=H.data("input");C.onChangeDateTime.call(H,Y.currentTime,a,t),delete C.value,a.trigger("change")}}).on("generate.xdsoft",function(){C.onGenerate&&e.isFunction(C.onGenerate)&&C.onGenerate.call(H,Y.currentTime,H.data("input")),U&&(H.trigger("afterOpen.xdsoft"),U=!1)}).on("click.xdsoft",function(e){e.stopPropagation()}),P=0,j=function(e,t){do{if(!(e=e.parentNode)||!1===t(e))break}while("HTML"!==e.nodeName)},A=function(){var t,a,n,r,o,i,s,d,u,l,f,c,m;if(d=H.data("input"),t=d.offset(),a=d[0],l="top",n=t.top+a.offsetHeight-1,r=t.left,o="absolute",u=e(C.contentWindow).width(),c=e(C.contentWindow).height(),m=e(C.contentWindow).scrollTop(),C.ownerDocument.documentElement.clientWidth-t.left<z.parent().outerWidth(!0)){var h=z.parent().outerWidth(!0)-a.offsetWidth;r-=h}"rtl"===d.parent().css("direction")&&(r-=H.outerWidth()-d.outerWidth()),C.fixed?(n-=m,r-=e(C.contentWindow).scrollLeft(),o="fixed"):(s=!1,j(a,function(e){return null!==e&&("fixed"===C.contentWindow.getComputedStyle(e).getPropertyValue("position")?(s=!0,!1):void 0)}),s?(o="fixed",n+H.outerHeight()>c+m?(l="bottom",n=c+m-t.top):n-=m):n+H[0].offsetHeight>c+m&&(n=t.top-H[0].offsetHeight+1),n<0&&(n=0),r+a.offsetWidth>u&&(r=u-a.offsetWidth)),i=H[0],j(i,function(e){if("relative"===C.contentWindow.getComputedStyle(e).getPropertyValue("position")&&u>=e.offsetWidth)return r-=(u-e.offsetWidth)/2,!1}),(f={position:o,left:r,top:"",bottom:""})[l]=n,H.css(f)},H.on("open.xdsoft",function(t){var a=!0;C.onShow&&e.isFunction(C.onShow)&&(a=C.onShow.call(H,Y.currentTime,H.data("input"),t)),!1!==a&&(H.show(),A(),e(C.contentWindow).off("resize.xdsoft",A).on("resize.xdsoft",A),C.closeOnWithoutClick&&e([C.ownerDocument.body,C.contentWindow]).on("touchstart mousedown.xdsoft",function t(){H.trigger("close.xdsoft"),e([C.ownerDocument.body,C.contentWindow]).off("touchstart mousedown.xdsoft",t)}))}).on("close.xdsoft",function(t){var a=!0;I.find(".xdsoft_month,.xdsoft_year").find(".xdsoft_select").hide(),C.onClose&&e.isFunction(C.onClose)&&(a=C.onClose.call(H,Y.currentTime,H.data("input"),t)),!1===a||C.opened||C.inline||H.hide(),t.stopPropagation()}).on("toggle.xdsoft",function(){H.is(":visible")?H.trigger("close.xdsoft"):H.trigger("open.xdsoft")}).data("input",a),q=0,H.data("xdsoft_datetime",Y),H.setOptions(C),Y.setCurrentTime(i()),a.data("xdsoft_datetimepicker",H).on("open.xdsoft focusin.xdsoft mousedown.xdsoft touchstart",function(){a.is(":disabled")||a.data("xdsoft_datetimepicker").is(":visible")&&C.closeOnInputClick||(clearTimeout(q),q=setTimeout(function(){a.is(":disabled")||(U=!0,Y.setCurrentTime(i(),!0),C.mask&&s(C),H.trigger("open.xdsoft"))},100))}).on("keydown.xdsoft",function(t){var a,n=t.which;return-1!==[p].indexOf(n)&&C.enterLikeTab?(a=e("input:visible,textarea:visible,button:visible,a:visible"),H.trigger("close.xdsoft"),a.eq(a.index(this)+1).focus(),!1):-1!==[T].indexOf(n)?(H.trigger("close.xdsoft"),!0):void 0}).on("blur.xdsoft",function(){H.trigger("close.xdsoft")})},d=function(t){var a=t.data("xdsoft_datetimepicker");a&&(a.data("xdsoft_datetime",null),a.remove(),t.data("xdsoft_datetimepicker",null).off(".xdsoft"),e(C.contentWindow).off("resize.xdsoft"),e([C.contentWindow,C.ownerDocument.body]).off("mousedown.xdsoft touchstart"),t.unmousewheel&&t.unmousewheel())},e(C.ownerDocument).off("keydown.xdsoftctrl keyup.xdsoftctrl").on("keydown.xdsoftctrl",function(e){e.keyCode===h&&(F=!0)}).on("keyup.xdsoftctrl",function(e){e.keyCode===h&&(F=!1)}),this.each(function(){var t=e(this).data("xdsoft_datetimepicker");if(t){if("string"===e.type(o))switch(o){case"show":e(this).select().focus(),t.trigger("open.xdsoft");break;case"hide":t.trigger("close.xdsoft");break;case"toggle":t.trigger("toggle.xdsoft");break;case"destroy":d(e(this));break;case"reset":this.value=this.defaultValue,this.value&&t.data("xdsoft_datetime").isValidDate(n.parseDate(this.value,C.format))||t.data("changed",!1),t.data("xdsoft_datetime").setCurrentTime(this.value);break;case"validate":t.data("input").trigger("blur.xdsoft");break;default:t[o]&&e.isFunction(t[o])&&(u=t[o](i))}else t.setOptions(o);return 0}"string"!==e.type(o)&&(!C.lazyInit||C.open||C.inline?s(e(this)):A(e(this)))}),u},e.fn.datetimepicker.defaults=a};!function(e){"function"==typeof define&&define.amd?define(["jquery","jquery-mousewheel"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(datetimepickerFactory),function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e:e(jQuery)}(function(e){function t(t){var i=t||window.event,s=d.call(arguments,1),u=0,f=0,c=0,m=0,h=0,g=0;if(t=e.event.fix(i),t.type="mousewheel","detail"in i&&(c=-1*i.detail),"wheelDelta"in i&&(c=i.wheelDelta),"wheelDeltaY"in i&&(c=i.wheelDeltaY),"wheelDeltaX"in i&&(f=-1*i.wheelDeltaX),"axis"in i&&i.axis===i.HORIZONTAL_AXIS&&(f=-1*c,c=0),u=0===c?f:c,"deltaY"in i&&(u=c=-1*i.deltaY),"deltaX"in i&&(f=i.deltaX,0===c&&(u=-1*f)),0!==c||0!==f){if(1===i.deltaMode){var p=e.data(this,"mousewheel-line-height");u*=p,c*=p,f*=p}else if(2===i.deltaMode){var y=e.data(this,"mousewheel-page-height");u*=y,c*=y,f*=y}if(m=Math.max(Math.abs(c),Math.abs(f)),(!o||m<o)&&(o=m,n(i,m)&&(o/=40)),n(i,m)&&(u/=40,f/=40,c/=40),u=Math[u>=1?"floor":"ceil"](u/o),f=Math[f>=1?"floor":"ceil"](f/o),c=Math[c>=1?"floor":"ceil"](c/o),l.settings.normalizeOffset&&this.getBoundingClientRect){var D=this.getBoundingClientRect();h=t.clientX-D.left,g=t.clientY-D.top}return t.deltaX=f,t.deltaY=c,t.deltaFactor=o,t.offsetX=h,t.offsetY=g,t.deltaMode=0,s.unshift(t,u,f,c),r&&clearTimeout(r),r=setTimeout(a,200),(e.event.dispatch||e.event.handle).apply(this,s)}}function a(){o=null}function n(e,t){return l.settings.adjustOldDeltas&&"mousewheel"===e.type&&t%120==0}var r,o,i=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],s="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],d=Array.prototype.slice;if(e.event.fixHooks)for(var u=i.length;u;)e.event.fixHooks[i[--u]]=e.event.mouseHooks;var l=e.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var a=s.length;a;)this.addEventListener(s[--a],t,!1);else this.onmousewheel=t;e.data(this,"mousewheel-line-height",l.getLineHeight(this)),e.data(this,"mousewheel-page-height",l.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var a=s.length;a;)this.removeEventListener(s[--a],t,!1);else this.onmousewheel=null;e.removeData(this,"mousewheel-line-height"),e.removeData(this,"mousewheel-page-height")},getLineHeight:function(t){var a=e(t),n=a["offsetParent"in e.fn?"offsetParent":"parent"]();return n.length||(n=e("body")),parseInt(n.css("fontSize"),10)||parseInt(a.css("fontSize"),10)||16},getPageHeight:function(t){return e(t).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};e.fn.extend({mousewheel:function(e){return e?this.bind("mousewheel",e):this.trigger("mousewheel")},unmousewheel:function(e){return this.unbind("mousewheel",e)}})});
function baseURL( url )
{
  url = url.replace(/^\//, '');
  url = url.replace(/\/$/, '');

  return SearaApp.baseURL + url;
}

function asset( url )
{
  return SearaApp.assetURL + url;
}

$.LoadingOverlaySetup({
  image: SearaApp.assetURL + 'img/ring.svg'
});

/**
 * Object Constructor que encapsula o acesso a recursos no sistema
 * @param {string} resourceURL URL base do recurso
 */
function ResourceModel(resourceURL){
  this.resourceURL = resourceURL;
}

ResourceModel.prototype.create = function (data, callback) {
  return SearaAjax.post( this.resourceURL, data, callback );
};

ResourceModel.prototype.read = function (id, callback) {
  return SearaAjax.get( this.resourceURL + '/' + id, callback );
};

ResourceModel.prototype.update = function (id, data, callback) {
  return SearaAjax.put( this.resourceURL + '/' + id, data, callback );
};

ResourceModel.prototype.delete = function (id, callback) {
  return SearaAjax.delete( this.resourceURL + '/' + id, callback );
};

String.prototype.isEmpty = function() {
    return (this.length === 0 || !this.trim());
};

/**
 * Loader para Seara
 */
var SearaLoader = (function(){

   // Funções para o Loading Overlay
  function showOverlay(sel)
  {
      if ( sel )
      {
          if ( sel.isEmpty() )
              $.LoadingOverlay("show");
          else
              $(sel).LoadingOverlay("show");
      }
      else
          $.LoadingOverlay("show");
  }

  function hideOverlay(sel)
  {
      if ( sel )
      {
          if ( sel.isEmpty() )
              $.LoadingOverlay("hide");
          else
              $(sel).LoadingOverlay("hide");
      }
      else
          $.LoadingOverlay("hide");
  }

  function showModal( title = '' )
  {
    swal({
      title: title,
      imageUrl: asset('img/ring.svg'),
      showConfirmButton: false
    })
  }

  function closeModal()
  {
    swal.close();
  }

  return {
    show: showOverlay,
    hide: hideOverlay,
    showModal: showModal,
    hideModal: closeModal
  }

}());

var SearaAlert = (function(){

  function alertError( title = '', text = '', timer = null )
  {
    return swal({
      title: title,
      text: text,
      type: 'error',
      timer: timer
    });
  }

  function alertSuccess( title = '', text = '', timer = null )
  {
    return swal({
      title: title,
      text: text,
      type: 'success',
      timer: timer
    });
  }

  function confirmAlert(title = '', textConfirm = '', textCancel = '', redirect = '')
  {
    return swal({
      title: title,
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: textConfirm,
      denyButtonText: `Don't save`,
      cancelButtonText: textCancel
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        console.log({redirect})
        swal('Saved!', '', 'success')
      } else if (result.isDenied) {
        swal('Changes are not saved', '', 'info')
      }
    })
  }

  return {
    error: alertError,
    success: alertSuccess,
    confirm: confirmAlert
  }

}());

var SearaAjax = (function(){
  function getToken()
  {
    return Cookies.get("XSRF-TOKEN");
  }

  function ajaxCall(type, url, data, callback, dataType = 'Json')
  {
    var ajaxOptions = {
      url: baseURL(url),
      headers: { 'X-XSRF-TOKEN': getToken() },
      dataType: dataType,
      type: type,
      method: type
    };

    if ( type == 'POST' || type == 'PUT' )
    {
      if ( data != null )
        ajaxOptions.data = data;
    }

    if ( callback != null )
      ajaxOptions.success = callback;

    return $.ajax( ajaxOptions );

  }

  function postAjax(url, data, callback = null, dataType = 'json')
  {
    return ajaxCall('POST', url, data, callback, dataType);
  }

  function getAjax(url, callback = null, dataType = 'json')
  {
    return ajaxCall('GET', url, null, callback, dataType);
  }

  function deleteAjax(url, callback = null, dataType = 'json')
  {
    return ajaxCall('DELETE', url, null, callback, dataType);
  }

  function putAjax(url, data, callback = null, dataType = 'json')
  {
    return ajaxCall('PUT', url, data, callback, dataType);
  }

  return {
    post: postAjax,
    get: getAjax,
    delete: deleteAjax,
    put: putAjax
  };

}());

function SearaTable(tableID, url, columns, singular = 'registro', plural = 'registros', dataFunc = () => {}){

  this.tableID = tableID;
  this.url = url;
  this.columns = columns;
  this.singular = singular;
  this.plural = plural;
  this.dataFunc = dataFunc;

};

SearaTable.prototype.reloadTable = function() {
  $("#" + this.tableID).DataTable().ajax.reload();
}

SearaTable.prototype.loadTable = function () {
  let thisSearaTable = this;
  let table = $('#'+this.tableID).DataTable({
    processing: true,
    serverSide: true,
    dom: 'lBfrtip',
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    buttons: [
      {
        extend: 'pdf',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excelHtml5',
        exportOptions: {
          columns: ':visible',
          format: {
            body: function ( data, row, column, node ) {
                if (node.className.split(/\s+/).includes("formatted_number")) {
                    return convertBrCoinToFloat(data);
                }
                return data;
            }
          }
        }
      },
      {
        extend: 'colvis',
        text: 'Selecionar colunas'
      }
    ],
    ajax: {
      url: this.url,
      data: d => {
        d.query = thisSearaTable.dataFunc();
      }
    },
    columns: this.columns,
    language: {
      "lengthMenu": "Exibir _MENU_ " + this.plural + " por página",
      "zeroRecords": "Nenhum " + this.singular + " cadastrado para essa pesquisa",
      "infoEmpty": "Exibindo 0 de 0 " + this.plural,
      "emptyTable": "Nenhum " + this.singular + " cadastrado",
      "info": "Exibindo página _PAGE_ de _PAGES_",
      "infoFiltered": "(filtrados de _MAX_ " + this.plural + ")",
      "search": "Pesquisar:",
      "paginate": {
        "previous": "Anterior",
        "next": "Próximo",
        "first": "Primeiro",
        "last": "Último"
      }
    }
  });

  let selector = $('#company-table_wrapper > div:nth-child(1) > div:nth-child(1)');
  table.buttons().container().appendTo(selector);
};


$(document).ready(function () {

  console.log(moment().format())
  // $('.collapse').collapse();
    var colunas = [
        { data: 'date_open', name: 'date_open' },
        { data: 'date_close', name: 'date_close' },
        { data: 'month', name: 'month' },
        { data: 'year', name: 'year' },
        { data: 'id_user_open', name: 'id_user_open'},
        { data: 'id_user_close', name: 'id_user_close'},
        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'no-break' }
    ];
  
    settingsBox = new SearaTable( 
      'table_settings_box',
      SearaApp.baseURL + 'caixa/datatable',
      colunas,
      'registro',
      'registros'
    );
    settingsBox.loadTable();

    // $('#date_open_box').mask('00/00/0000 00:00');
    // $('#date_close_box').mask('00/00/0000');
    jQuery.datetimepicker.setLocale('pt-BR');
    $("#date_open_box").datetimepicker({
      format:'d/m/Y H:i'
    });
    $("#date_open_box").datetimepicker({
      format:'d/m/Y H:i'
    });
    $("#date_close_box_edit").datetimepicker({
      format:'d/m/Y H:i'
    });

});

$(function () {

 
});

function editBoxOpenClose(id)
{
  let url = SearaApp.baseURL+'caixa/editar/'+id;
  window.location.href=url
}

function alterarCaixa(id)
{
  if($("#date_close_box_edit").val() !== "")
  {
    // SearaAlert.confirm('Deseja realmente fechar esse caixa?', 'Fechar Caixa', 'Desistir', id);
    swal({
      title: 'Deseja realmente fechar esse caixa?',
      showCancelButton: true,
      confirmButtonText: 'Fechar Caixa',
      cancelButtonText: 'Desistir'
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      console.log(result)
      if (result) {
        updateSettingBox(id);

      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
      }
    })
  }else{
    console.log('id', id)
    updateSettingBox(id)
  }
}

/**
 * Funcao que trata o payload variando o tipo de fechamento
 * @param {interger} id 
 * @param {string} type 
 */
function updateSettingBox(id, type)
{
  var form = '';

  switch (type) {
    case 'auto':
      let dataForm = {
        date_close: moment().format(),
        type: 'auto'
      }
      form = dataForm
      break;
    case 'form':
      form = $("#form-edit-box").serialize();
      break;
  
  }

  $.ajax({
      type: "put",
      url: SearaApp.baseURL + 'caixa/update/'+ id,
      data: form,
      dataType: "json",
      success: function (response) {
        if(response.status == 200)
        {
          notify.success('Sucesso!', response.message);
          setTimeout(() => {
            window.location.reload();
          }, 2000);
        }
      },
      error: function(res, status) {
        notify.error('Ops!', res.responseJSON.message);
      }
  });
}

function showConfirmOpenClose(id)
{
  swal({
    title: 'Deseja realmente reabrir esse caixa?',
    showCancelButton: true,
    confirmButtonText: 'Sim, reabrir!',
    cancelButtonText: 'Desistir'
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    console.log(result)
    if (result) {
      reopenBox(id);

    } else if (result.isDenied) {
      Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

function reopenBox(id)
{
  $.ajax({
    type: "put",
    url: SearaApp.baseURL + 'caixa/update/'+ id,
    data: {slug: 'open', date_close: null, id_user_close: null},
    dataType: "json",
    success: function (response) {
      notify.success('Sucesso!', 'Caixa foi reaberto');
      settingsBox.reloadTable();
    }
  });
}

// $("#btn-close-box-auto").click(function (e) { 
//   e.preventDefault();
//   console.log('btn-close-box-auto');
// });
//# sourceMappingURL=setting-box.js.map
