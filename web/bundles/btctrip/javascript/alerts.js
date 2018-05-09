/*!
FRAMEWORK_VERSION:1.1.197
*/
/*! jQuery UI - v1.8.23 - 2012-08-15
* https://github.com/jquery/jquery-ui
* Includes: jquery.ui.core.js
* Copyright (c) 2012 AUTHORS.txt; Licensed MIT, GPL */
(function(f,e){function h(a,l){var k=a.nodeName.toLowerCase();if("area"===k){var j=a.parentNode,i=j.name,d;return !a.href||!i||j.nodeName.toLowerCase()!=="map"?!1:(d=f("img[usemap=#"+i+"]")[0],!!d&&g(d))}return(/input|select|textarea|button|object/.test(k)?!a.disabled:"a"==k?a.href||l:l)&&g(a)}function g(a){return !f(a).parents().andSelf().filter(function(){return f.curCSS(this,"visibility")==="hidden"||f.expr.filters.hidden(this)}).length}f.ui=f.ui||{};if(f.ui.version){return}f.extend(f.ui,{version:"1.8.23",keyCode:{ALT:18,BACKSPACE:8,CAPS_LOCK:20,COMMA:188,COMMAND:91,COMMAND_LEFT:91,COMMAND_RIGHT:93,CONTROL:17,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,INSERT:45,LEFT:37,MENU:93,NUMPAD_ADD:107,NUMPAD_DECIMAL:110,NUMPAD_DIVIDE:111,NUMPAD_ENTER:108,NUMPAD_MULTIPLY:106,NUMPAD_SUBTRACT:109,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SHIFT:16,SPACE:32,TAB:9,UP:38,WINDOWS:91}}),f.fn.extend({propAttr:f.fn.prop||f.fn.attr,_focus:f.fn.focus,focus:function(a,d){return typeof a=="number"?this.each(function(){var b=this;setTimeout(function(){f(b).focus(),d&&d.call(b)},a)}):this._focus.apply(this,arguments)},scrollParent:function(){var a;return f.browser.msie&&/(static|relative)/.test(this.css("position"))||/absolute/.test(this.css("position"))?a=this.parents().filter(function(){return/(relative|absolute|fixed)/.test(f.curCSS(this,"position",1))&&/(auto|scroll)/.test(f.curCSS(this,"overflow",1)+f.curCSS(this,"overflow-y",1)+f.curCSS(this,"overflow-x",1))}).eq(0):a=this.parents().filter(function(){return/(auto|scroll)/.test(f.curCSS(this,"overflow",1)+f.curCSS(this,"overflow-y",1)+f.curCSS(this,"overflow-x",1))}).eq(0),/fixed/.test(this.css("position"))||!a.length?f(document):a},zIndex:function(j){if(j!==e){return this.css("zIndex",j)}if(this.length){var i=f(this[0]),b,a;while(i.length&&i[0]!==document){b=i.css("position");if(b==="absolute"||b==="relative"||b==="fixed"){a=parseInt(i.css("zIndex"),10);if(!isNaN(a)&&a!==0){return a}}i=i.parent()}}return 0},disableSelection:function(){return this.bind((f.support.selectstart?"selectstart":"mousedown")+".ui-disableSelection",function(b){b.preventDefault()})},enableSelection:function(){return this.unbind(".ui-disableSelection")}}),f("<a>").outerWidth(1).jquery||f.each(["Width","Height"],function(l,k){function a(m,p,o,n){return f.each(j,function(){p-=parseFloat(f.curCSS(m,"padding"+this,!0))||0,o&&(p-=parseFloat(f.curCSS(m,"border"+this+"Width",!0))||0),n&&(p-=parseFloat(f.curCSS(m,"margin"+this,!0))||0)}),p}var j=k==="Width"?["Left","Right"]:["Top","Bottom"],i=k.toLowerCase(),b={innerWidth:f.fn.innerWidth,innerHeight:f.fn.innerHeight,outerWidth:f.fn.outerWidth,outerHeight:f.fn.outerHeight};f.fn["inner"+k]=function(d){return d===e?b["inner"+k].call(this):this.each(function(){f(this).css(i,a(this,d)+"px")})},f.fn["outer"+k]=function(d,m){return typeof d!="number"?b["outer"+k].call(this,d):this.each(function(){f(this).css(i,a(this,d,!0,m)+"px")})}}),f.extend(f.expr[":"],{data:f.expr.createPseudo?f.expr.createPseudo(function(a){return function(b){return !!f.data(b,a)}}):function(a,j,i){return !!f.data(a,i[3])},focusable:function(a){return h(a,!isNaN(f.attr(a,"tabindex")))},tabbable:function(a){var i=f.attr(a,"tabindex"),c=isNaN(i);return(c||i>=0)&&h(a,!c)}}),f(function(){var a=document.body,d=a.appendChild(d=document.createElement("div"));d.offsetHeight,f.extend(d.style,{minHeight:"100px",height:"auto",padding:0,borderWidth:0}),f.support.minHeight=d.offsetHeight===100,f.support.selectstart="onselectstart" in d,a.removeChild(d).style.display="none"}),f.curCSS||(f.curCSS=f.css),f.extend(f.ui,{plugin:{add:function(a,l,k){var j=f.ui[a].prototype;for(var i in k){j.plugins[i]=j.plugins[i]||[],j.plugins[i].push([l,k[i]])}},call:function(j,i,m){var l=j.plugins[i];if(!l||!j.element[0].parentNode){return}for(var k=0;k<l.length;k++){j.options[l[k][0]]&&l[k][1].apply(j.element,m)}}},contains:function(d,c){return document.compareDocumentPosition?d.compareDocumentPosition(c)&16:d!==c&&d.contains(c)},hasScroll:function(a,k){if(f(a).css("overflow")==="hidden"){return !1}var j=k&&k==="left"?"scrollLeft":"scrollTop",i=!1;return a[j]>0?!0:(a[j]=1,i=a[j]>0,a[j]=0,i)},isOverAxis:function(i,d,j){return i>d&&i<d+j},isOver:function(a,m,l,k,j,i){return f.ui.isOverAxis(a,l,j)&&f.ui.isOverAxis(m,k,i)}})})(jQuery);
/*! jQuery UI - v1.8.23 - 2012-08-15
* https://github.com/jquery/jquery-ui
* Includes: jquery.ui.widget.js
* Copyright (c) 2012 AUTHORS.txt; Licensed MIT, GPL */
(function(f,e){if(f.cleanData){var h=f.cleanData;f.cleanData=function(a){for(var j=0,i;(i=a[j])!=null;j++){try{f(i).triggerHandler("remove")}catch(c){}}h(a)}}else{var g=f.fn.remove;f.fn.remove=function(a,d){return this.each(function(){return d||(!a||f.filter(a,[this]).length)&&f("*",this).add([this]).each(function(){try{f(this).triggerHandler("remove")}catch(c){}}),g.call(f(this),a,d)})}}f.widget=function(a,m,l){var k=a.split(".")[0],j;a=a.split(".")[1],j=k+"-"+a,l||(l=m,m=f.Widget),f.expr[":"][j]=function(b){return !!f.data(b,a)},f[k]=f[k]||{},f[k][a]=function(d,c){arguments.length&&this._createWidget(d,c)};var i=new m;i.options=f.extend(!0,{},i.options),f[k][a].prototype=f.extend(!0,i,{namespace:k,widgetName:a,widgetEventPrefix:f[k][a].prototype.widgetEventPrefix||a,widgetBaseClass:j},l),f.widget.bridge(a,f[k][a])},f.widget.bridge=function(b,a){f.fn[b]=function(j){var i=typeof j=="string",d=Array.prototype.slice.call(arguments,1),c=this;return j=!i&&d.length?f.extend.apply(null,[!0,j].concat(d)):j,i&&j.charAt(0)==="_"?c:(i?this.each(function(){var l=f.data(this,b),k=l&&f.isFunction(l[j])?l[j].apply(l,d):l;if(k!==l&&k!==e){return c=k,!1}}):this.each(function(){var k=f.data(this,b);k?k.option(j||{})._init():f.data(this,b,new a(j,this))}),c)}},f.Widget=function(d,c){arguments.length&&this._createWidget(d,c)},f.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",options:{disabled:!1},_createWidget:function(a,j){f.data(j,this.widgetName,this),this.element=f(j),this.options=f.extend(!0,{},this.options,this._getCreateOptions(),a);var i=this;this.element.bind("remove."+this.widgetName,function(){i.destroy()}),this._create(),this._trigger("create"),this._init()},_getCreateOptions:function(){return f.metadata&&f.metadata.get(this.element[0])[this.widgetName]},_create:function(){},_init:function(){},destroy:function(){this.element.unbind("."+this.widgetName).removeData(this.widgetName),this.widget().unbind("."+this.widgetName).removeAttr("aria-disabled").removeClass(this.widgetBaseClass+"-disabled ui-state-disabled")},widget:function(){return this.element},option:function(i,b){var a=i;if(arguments.length===0){return f.extend({},this.options)}if(typeof i=="string"){if(b===e){return this.options[i]}a={},a[i]=b}return this._setOptions(a),this},_setOptions:function(a){var d=this;return f.each(a,function(i,c){d._setOption(i,c)}),this},_setOption:function(d,c){return this.options[d]=c,d==="disabled"&&this.widget()[c?"addClass":"removeClass"](this.widgetBaseClass+"-disabled ui-state-disabled").attr("aria-disabled",c),this},enable:function(){return this._setOption("disabled",!1)},disable:function(){return this._setOption("disabled",!0)},_trigger:function(a,m,l){var k,j,i=this.options[a];l=l||{},m=f.Event(m),m.type=(a===this.widgetEventPrefix?a:this.widgetEventPrefix+a).toLowerCase(),m.target=this.element[0],j=m.originalEvent;if(j){for(k in j){k in m||(m[k]=j[k])}}return this.element.trigger(m,l),!(f.isFunction(i)&&i.call(this.element[0],m,l)===!1||m.isDefaultPrevented())}}})(jQuery);
/*! jQuery UI - v1.8.23 - 2012-08-15
* https://github.com/jquery/jquery-ui
* Includes: jquery.ui.mouse.js
* Copyright (c) 2012 AUTHORS.txt; Licensed MIT, GPL */
(function(e,d){var f=!1;e(document).mouseup(function(b){f=!1}),e.widget("ui.mouse",{options:{cancel:":input,option",distance:1,delay:0},_mouseInit:function(){var a=this;this.element.bind("mousedown."+this.widgetName,function(b){return a._mouseDown(b)}).bind("click."+this.widgetName,function(b){if(!0===e.data(b.target,a.widgetName+".preventClickEvent")){return e.removeData(b.target,a.widgetName+".preventClickEvent"),b.stopImmediatePropagation(),!1}}),this.started=!1},_mouseDestroy:function(){this.element.unbind("."+this.widgetName),this._mouseMoveDelegate&&e(document).unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate)},_mouseDown:function(a){if(f){return}this._mouseStarted&&this._mouseUp(a),this._mouseDownEvent=a;var h=this,g=a.which==1,c=typeof this.options.cancel=="string"&&a.target.nodeName?e(a.target).closest(this.options.cancel).length:!1;if(!g||c||!this._mouseCapture(a)){return !0}this.mouseDelayMet=!this.options.delay,this.mouseDelayMet||(this._mouseDelayTimer=setTimeout(function(){h.mouseDelayMet=!0},this.options.delay));if(this._mouseDistanceMet(a)&&this._mouseDelayMet(a)){this._mouseStarted=this._mouseStart(a)!==!1;if(!this._mouseStarted){return a.preventDefault(),!0}}return !0===e.data(a.target,this.widgetName+".preventClickEvent")&&e.removeData(a.target,this.widgetName+".preventClickEvent"),this._mouseMoveDelegate=function(b){return h._mouseMove(b)},this._mouseUpDelegate=function(b){return h._mouseUp(b)},e(document).bind("mousemove."+this.widgetName,this._mouseMoveDelegate).bind("mouseup."+this.widgetName,this._mouseUpDelegate),a.preventDefault(),f=!0,!0},_mouseMove:function(a){return !e.browser.msie||document.documentMode>=9||!!a.button?this._mouseStarted?(this._mouseDrag(a),a.preventDefault()):(this._mouseDistanceMet(a)&&this._mouseDelayMet(a)&&(this._mouseStarted=this._mouseStart(this._mouseDownEvent,a)!==!1,this._mouseStarted?this._mouseDrag(a):this._mouseUp(a)),!this._mouseStarted):this._mouseUp(a)},_mouseUp:function(a){return e(document).unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate),this._mouseStarted&&(this._mouseStarted=!1,a.target==this._mouseDownEvent.target&&e.data(a.target,this.widgetName+".preventClickEvent",!0),this._mouseStop(a)),!1},_mouseDistanceMet:function(b){return Math.max(Math.abs(this._mouseDownEvent.pageX-b.pageX),Math.abs(this._mouseDownEvent.pageY-b.pageY))>=this.options.distance},_mouseDelayMet:function(b){return this.mouseDelayMet},_mouseStart:function(b){},_mouseDrag:function(b){},_mouseStop:function(b){},_mouseCapture:function(b){return !0}})})(jQuery);
/*! jQuery UI - v1.8.23 - 2012-08-15
* https://github.com/jquery/jquery-ui
* Includes: jquery.ui.position.js
* Copyright (c) 2012 AUTHORS.txt; Licensed MIT, GPL */
(function(j,i){j.ui=j.ui||{};var p=/left|center|right/,o=/top|center|bottom/,n="center",m={},l=j.fn.position,k=j.fn.offset;j.fn.position=function(c){if(!c||!c.of){return l.apply(this,arguments)}c=j.extend({},c);var q=j(c.of),g=q[0],f=(c.collision||"flip").split(" "),e=c.offset?c.offset.split(" "):[0,0],d,a,r;return g.nodeType===9?(d=q.width(),a=q.height(),r={top:0,left:0}):g.setTimeout?(d=q.width(),a=q.height(),r={top:q.scrollTop(),left:q.scrollLeft()}):g.preventDefault?(c.at="left top",d=a=0,r={top:c.of.pageY,left:c.of.pageX}):(d=q.outerWidth(),a=q.outerHeight(),r=q.offset()),j.each(["my","at"],function(){var b=(c[this]||"").split(" ");b.length===1&&(b=p.test(b[0])?b.concat([n]):o.test(b[0])?[n].concat(b):[n,n]),b[0]=p.test(b[0])?b[0]:n,b[1]=o.test(b[1])?b[1]:n,c[this]=b}),f.length===1&&(f[1]=f[0]),e[0]=parseInt(e[0],10)||0,e.length===1&&(e[1]=e[0]),e[1]=parseInt(e[1],10)||0,c.at[0]==="right"?r.left+=d:c.at[0]===n&&(r.left+=d/2),c.at[1]==="bottom"?r.top+=a:c.at[1]===n&&(r.top+=a/2),r.left+=e[0],r.top+=e[1],this.each(function(){var z=j(this),y=z.outerWidth(),x=z.outerHeight(),w=parseInt(j.curCSS(this,"marginLeft",!0))||0,v=parseInt(j.curCSS(this,"marginTop",!0))||0,u=y+w+(parseInt(j.curCSS(this,"marginRight",!0))||0),t=x+v+(parseInt(j.curCSS(this,"marginBottom",!0))||0),s=j.extend({},r),b;c.my[0]==="right"?s.left-=y:c.my[0]===n&&(s.left-=y/2),c.my[1]==="bottom"?s.top-=x:c.my[1]===n&&(s.top-=x/2),m.fractions||(s.left=Math.round(s.left),s.top=Math.round(s.top)),b={left:s.left-w,top:s.top-v},j.each(["left","top"],function(A,h){j.ui.position[f[A]]&&j.ui.position[f[A]][h](s,{targetWidth:d,targetHeight:a,elemWidth:y,elemHeight:x,collisionPosition:b,collisionWidth:u,collisionHeight:t,offset:e,my:c.my,at:c.at})}),j.fn.bgiframe&&z.bgiframe(),z.offset(j.extend(s,{using:c.using}))})},j.ui.position={fit:{left:function(a,h){var g=j(window),f=h.collisionPosition.left+h.collisionWidth-g.width()-g.scrollLeft();a.left=f>0?a.left-f:Math.max(a.left-h.collisionPosition.left,a.left)},top:function(a,h){var g=j(window),f=h.collisionPosition.top+h.collisionHeight-g.height()-g.scrollTop();a.top=f>0?a.top-f:Math.max(a.top-h.collisionPosition.top,a.top)}},flip:{left:function(a,u){if(u.at[0]===n){return}var t=j(window),s=u.collisionPosition.left+u.collisionWidth-t.width()-t.scrollLeft(),r=u.my[0]==="left"?-u.elemWidth:u.my[0]==="right"?u.elemWidth:0,q=u.at[0]==="left"?u.targetWidth:-u.targetWidth,e=-2*u.offset[0];a.left+=u.collisionPosition.left<0?r+q+e:s>0?r+q+e:0},top:function(a,u){if(u.at[1]===n){return}var t=j(window),s=u.collisionPosition.top+u.collisionHeight-t.height()-t.scrollTop(),r=u.my[1]==="top"?-u.elemHeight:u.my[1]==="bottom"?u.elemHeight:0,q=u.at[1]==="top"?u.targetHeight:-u.targetHeight,e=-2*u.offset[1];a.top+=u.collisionPosition.top<0?r+q+e:s>0?r+q+e:0}}},j.offset.setOffset||(j.offset.setOffset=function(a,v){/static/.test(j.curCSS(a,"position"))&&(a.style.position="relative");var u=j(a),t=u.offset(),s=parseInt(j.curCSS(a,"top",!0),10)||0,r=parseInt(j.curCSS(a,"left",!0),10)||0,q={top:v.top-t.top+s,left:v.left-t.left+r};"using" in v?v.using.call(a,q):u.css(q)},j.fn.offset=function(a){var d=this[0];return !d||!d.ownerDocument?null:a?j.isFunction(a)?this.each(function(b){j(this).offset(a.call(this,b,j(this).offset()))}):this.each(function(){j.offset.setOffset(this,a)}):k.call(this)}),j.curCSS||(j.curCSS=j.css),function(){var a=document.getElementsByTagName("body")[0],v=document.createElement("div"),u,t,s,r,q;u=document.createElement(a?"div":"body"),s={visibility:"hidden",width:0,height:0,border:0,margin:0,background:"none"},a&&j.extend(s,{position:"absolute",left:"-1000px",top:"-1000px"});for(var f in s){u.style[f]=s[f]}u.appendChild(v),t=a||document.documentElement,t.insertBefore(u,t.firstChild),v.style.cssText="position: absolute; left: 10.7432222px; top: 10.432325px; height: 30px; width: 201px;",r=j(v).offset(function(d,c){return c}).offset(),u.innerHTML="",t.removeChild(u),q=r.top+r.left+(a?2000:0),m.fractions=q>21&&q<22}()})(jQuery);(function(b,c){var a=0;b.widget("ech.multiselect",{options:{header:true,height:175,minWidth:225,classes:"",checkAllText:"Check all",uncheckAllText:"Uncheck all",noneSelectedText:"Select options",selectedText:"# selected",selectedList:0,show:null,hide:null,autoOpen:false,multiple:true,position:{}},_create:function(){var g=this.element.hide(),i=this.options;this.speed=b.fx.speeds._default;this._isOpen=false;var f=(this.button=b('<button type="button"><span class="ui-icon ui-icon-triangle-2-n-s"></span></button>')).addClass("ui-multiselect ui-widget ui-state-default ui-corner-all").addClass(i.classes).attr({title:g.attr("title"),"aria-haspopup":true,tabIndex:g.attr("tabIndex")}).insertAfter(g),d=(this.buttonlabel=b("<span />")).html(i.noneSelectedText).appendTo(f),h=(this.menu=b("<div />")).addClass("ui-multiselect-menu ui-widget ui-widget-content ui-corner-all").addClass(i.classes).appendTo(document.body),k=(this.header=b("<div />")).addClass("ui-widget-header ui-corner-all ui-multiselect-header ui-helper-clearfix").appendTo(h),e=(this.headerLinkContainer=b("<ul />")).addClass("ui-helper-reset").html(function(){if(i.header===true){return'<li><a class="ui-multiselect-all" href="#"><span class="ui-icon ui-icon-check"></span><span>'+i.checkAllText+'</span></a></li><li><a class="ui-multiselect-none" href="#"><span class="ui-icon ui-icon-closethick"></span><span>'+i.uncheckAllText+"</span></a></li>"}else{if(typeof i.header==="string"){return"<li>"+i.header+"</li>"}else{return""}}}).append('<li class="ui-multiselect-close"><a href="#" class="ui-multiselect-close"><span class="ui-icon ui-icon-circle-close"></span></a></li>').appendTo(k),j=(this.checkboxContainer=b("<ul />")).addClass("ui-multiselect-checkboxes ui-helper-reset").appendTo(h);this._bindEvents();this.refresh(true);if(!i.multiple){h.addClass("ui-multiselect-single")}},_init:function(){if(this.options.header===false){this.header.hide()}if(!this.options.multiple){this.headerLinkContainer.find(".ui-multiselect-all, .ui-multiselect-none").hide()}if(this.options.autoOpen){this.open()}if(this.element.is(":disabled")){this.disable()}},refresh:function(i){var f=this.element,h=this.options,g=this.menu,k=this.checkboxContainer,d=[],e="",j=f.attr("id")||a++;f.find("option").each(function(n){var o=b(this),t=this.parentNode,r=this.innerHTML,v=this.title,s=this.value,m="ui-multiselect-"+(this.id||j+"-option-"+n),w=this.disabled,l=this.selected,q=["ui-corner-all"],p=(w?"ui-multiselect-disabled ":" ")+this.className,u;if(t.tagName==="OPTGROUP"){u=t.getAttribute("label");if(b.inArray(u,d)===-1){e+='<li class="ui-multiselect-optgroup-label '+t.className+'"><a href="#">'+u+"</a></li>";d.push(u)}}if(w){q.push("ui-state-disabled")}if(l&&!h.multiple){q.push("ui-state-active")}e+='<li class="'+p+'">';e+='<label for="'+m+'" title="'+v+'" class="'+q.join(" ")+'">';e+='<input id="'+m+'" name="multiselect_'+j+'" type="'+(h.multiple?"checkbox":"radio")+'" value="'+s+'" title="'+r+'"';if(l){e+=' checked="checked"';e+=' aria-selected="true"'}if(w){e+=' disabled="disabled"';e+=' aria-disabled="true"'}e+=" /><span>"+r+"</span></label></li>"});k.html(e);this.labels=g.find("label");this.inputs=this.labels.children("input");this._setButtonWidth();this._setMenuWidth();this.button[0].defaultValue=this.update();if(!i){this._trigger("refresh")}},update:function(){var h=this.options,e=this.inputs,d=e.filter(":checked"),f=d.length,g;if(f===0){g=h.noneSelectedText}else{if(b.isFunction(h.selectedText)){g=h.selectedText.call(this,f,e.length,d.get())}else{if(/\d/.test(h.selectedList)&&h.selectedList>0&&f<=h.selectedList){g=d.map(function(){return b(this).next().html()}).get().join(", ")}else{g=h.selectedText.replace("#",f).replace("#",e.length)}}}this.buttonlabel.html(g);return g},_bindEvents:function(){var d=this,e=this.button;function f(){d[d._isOpen?"close":"open"]();return false}e.find("span").bind("click.multiselect",f);e.bind({click:f,keypress:function(g){switch(g.which){case 27:case 38:case 37:d.close();break;case 39:case 40:d.open();break}},mouseenter:function(){if(!e.hasClass("ui-state-disabled")){b(this).addClass("ui-state-hover")}},mouseleave:function(){b(this).removeClass("ui-state-hover")},focus:function(){if(!e.hasClass("ui-state-disabled")){b(this).addClass("ui-state-focus")}},blur:function(){b(this).removeClass("ui-state-focus")}});this.header.delegate("a","click.multiselect",function(g){if(b(this).hasClass("ui-multiselect-close")){d.close()}else{d[b(this).hasClass("ui-multiselect-all")?"checkAll":"uncheckAll"]()}g.preventDefault()});this.menu.delegate("li.ui-multiselect-optgroup-label a","click.multiselect",function(k){k.preventDefault();var j=b(this),i=j.parent().nextUntil("li.ui-multiselect-optgroup-label").find("input:visible:not(:disabled)"),g=i.get(),h=j.parent().text();if(d._trigger("beforeoptgrouptoggle",k,{inputs:g,label:h})===false){return}d._toggleChecked(i.filter(":checked").length!==i.length,i);d._trigger("optgrouptoggle",k,{inputs:g,label:h,checked:g[0].checked})}).delegate("label","mouseenter.multiselect",function(){if(!b(this).hasClass("ui-state-disabled")){d.labels.removeClass("ui-state-hover");b(this).addClass("ui-state-hover").find("input").focus()}}).delegate("label","keydown.multiselect",function(g){g.preventDefault();switch(g.which){case 9:case 27:d.close();break;case 38:case 40:case 37:case 39:d._traverse(g.which,this);break;case 13:b(this).find("input")[0].click();break}}).delegate('input[type="checkbox"], input[type="radio"]',"click.multiselect",function(j){var i=b(this),k=this.value,h=this.checked,g=d.element.find("option");if(this.disabled||d._trigger("click",j,{value:k,text:this.title,checked:h})===false){j.preventDefault();return}i.focus();i.attr("aria-selected",h);g.each(function(){if(this.value===k){this.selected=h}else{if(!d.options.multiple){this.selected=false}}});if(!d.options.multiple){d.labels.removeClass("ui-state-active");i.closest("label").toggleClass("ui-state-active",h);d.close()}d.element.trigger("change");setTimeout(b.proxy(d.update,d),10)});b(document).bind("mousedown.multiselect",function(g){if(d._isOpen&&!b.contains(d.menu[0],g.target)&&!b.contains(d.button[0],g.target)&&g.target!==d.button[0]){d.close()}});b(this.element[0].form).bind("reset.multiselect",function(){setTimeout(b.proxy(d.refresh,d),10)})},_setButtonWidth:function(){var d=this.element.outerWidth(),e=this.options;if(/\d/.test(e.minWidth)&&d<e.minWidth){d=e.minWidth}this.button.width(d)},_setMenuWidth:function(){var d=this.menu,e=this.button.outerWidth()-parseInt(d.css("padding-left"),10)-parseInt(d.css("padding-right"),10)-parseInt(d.css("border-right-width"),10)-parseInt(d.css("border-left-width"),10);d.width(e||this.button.outerWidth())},_traverse:function(h,i){var f=b(i),e=h===38||h===37,d=f.parent()[e?"prevAll":"nextAll"]("li:not(.ui-multiselect-disabled, .ui-multiselect-optgroup-label)")[e?"last":"first"]();if(!d.length){var g=this.menu.find("ul").last();this.menu.find("label")[e?"last":"first"]().trigger("mouseover");g.scrollTop(e?g.height():0)}else{d.find("label").trigger("mouseover")}},_toggleState:function(e,d){return function(){if(!this.disabled){this[e]=d}if(d){this.setAttribute("aria-selected",true)}else{this.removeAttribute("aria-selected")}}},_toggleChecked:function(d,h){var g=(h&&h.length)?h:this.inputs,f=this;g.each(this._toggleState("checked",d));g.eq(0).focus();this.update();var e=g.map(function(){return this.value}).get();this.element.find("option").each(function(){if(!this.disabled&&b.inArray(this.value,e)>-1){f._toggleState("selected",d).call(this)}});if(g.length){this.element.trigger("change")}},_toggleDisabled:function(e){this.button.attr({disabled:e,"aria-disabled":e})[e?"addClass":"removeClass"]("ui-state-disabled");var d=this.menu.find("input");var f="ech-multiselect-disabled";if(e){d=d.filter(":enabled").data(f,true)}else{d=d.filter(function(){return b.data(this,f)===true}).removeData(f)}d.attr({disabled:e,"arial-disabled":e}).parent()[e?"addClass":"removeClass"]("ui-state-disabled");this.element.attr({disabled:e,"aria-disabled":e})},open:function(i){var m=this,h=this.button,d=this.menu,g=this.speed,f=this.options,j=[];if(this._trigger("beforeopen")===false||h.hasClass("ui-state-disabled")||this._isOpen){return}var l=d.find("ul").last(),n=f.show,k=h.offset();if(b.isArray(f.show)){n=f.show[0];g=f.show[1]||m.speed}if(n){j=[n,g]}l.scrollTop(0).height(f.height);if(b.ui.position&&!b.isEmptyObject(f.position)){f.position.of=f.position.of||h;d.show().position(f.position).hide()}else{d.css({top:k.top+h.outerHeight(),left:k.left})}b.fn.show.apply(d,j);this.labels.eq(0).trigger("mouseover").trigger("mouseenter").find("input").trigger("focus");h.addClass("ui-state-active");this._isOpen=true;this._trigger("open")},close:function(){if(this._trigger("beforeclose")===false){return}var g=this.options,e=g.hide,f=this.speed,d=[];if(b.isArray(g.hide)){e=g.hide[0];f=g.hide[1]||this.speed}if(e){d=[e,f]}b.fn.hide.apply(this.menu,d);this.button.removeClass("ui-state-active").trigger("blur").trigger("mouseleave");this._isOpen=false;this._trigger("close")},enable:function(){this._toggleDisabled(false)},disable:function(){this._toggleDisabled(true)},checkAll:function(d){this._toggleChecked(true);this._trigger("checkAll")},uncheckAll:function(){this._toggleChecked(false);this._trigger("uncheckAll")},getChecked:function(){return this.menu.find("input").filter(":checked")},destroy:function(){b.Widget.prototype.destroy.call(this);this.button.remove();this.menu.remove();this.element.show();return this},isOpen:function(){return this._isOpen},widget:function(){return this.menu},getButton:function(){return this.button},_setOption:function(d,e){var f=this.menu;switch(d){case"header":f.find("div.ui-multiselect-header")[e?"show":"hide"]();break;case"checkAllText":f.find("a.ui-multiselect-all span").eq(-1).text(e);break;case"uncheckAllText":f.find("a.ui-multiselect-none span").eq(-1).text(e);break;case"height":f.find("ul").last().height(parseInt(e,10));break;case"minWidth":this.options[d]=parseInt(e,10);this._setButtonWidth();this._setMenuWidth();break;case"selectedText":case"selectedList":case"noneSelectedText":this.options[d]=e;this.update();break;case"classes":f.add(this.button).removeClass(this.options.classes).addClass(e);break;case"multiple":f.toggleClass("ui-multiselect-single",!e);this.options.multiple=e;this.element[0].multiple=e;this.refresh()}b.Widget.prototype._setOption.apply(this,arguments)}})})(jQuery);define(["jquery","nibbler.amplify","nibbler.handlebars","nibbler.json","nibbler.alerts.options","nibbler.alerts.autocomplete"],function(h,t,k,f,g,z){var u=null;var x={};var m;function I(J){m=J;u=k.compile(h("#nibbler-alerts-template").html());h(m.container).html(u(m.model))}function G(){i();d();b();j();o();p();v();n();h(m.container+" .alerts-save a").on("click",function(){var J={flightType:e(),origin:q("origin"),destination:q("destination"),months:A(),durations:C(),amount:y(),currency:w(),email:l(),promotions:E()};var K=H(J);if(K!==false){s(K)}})}function H(J){var L=true;h.each(J,function(N,M){if(M.isValid===false){L=false;return false}});if(L===true){var K={};K.post={origin:J.origin.data.code,destination:J.destination.data.code,maxPrice:J.amount.data+"-"+J.currency.data,email:J.email.data,addToNewsletter:J.promotions.data,country:g.country};K.extra={destinationDescription:J.destination.data.description};if(!((J.months.data.length==1)&&(J.months.data[0]=="option0"))){K.post.dateRanges=J.months.data}if(J.durations.data=="w"){K.post.onWeekends=true}else{K.post.stay=J.durations.data}if(m.model.OID!=null){K.post.OID=m.model.OID}return K}else{return false}}function s(J){if(!h(".alerts-save a").hasClass("disabled")){h(".alerts-save a").addClass("disabled");h.ajax({url:m.url,data:J.post,type:"POST",contentType:"application/x-www-form-urlencoded; charset=UTF-8",traditional:true,dataType:"json",success:function(K){t.publish("nibbler.alerts.response",true,K,J);h(".alerts-save a").removeClass("disabled")},error:function(K){t.publish("nibbler.alerts.response",false,K,J);h(".alerts-save a").removeClass("disabled")}})}}function j(){if(m.model.email!=null){var J=h(m.container+" .alerts-email");J.val(m.model.email);J.closest("label").hide()}}function o(){if(m.model.price!=null){if(m.model.price.currencyCode!=null){h(m.container+" .alerts-currency").val(m.model.price.currencyCode)}if(m.model.price.amount!=null){h(m.container+" .alerts-amount").val(m.model.price.amount)}}}function p(){if((m.model.months!=null)&&(m.model.months.length>0)){F(false);for(var J=0;J<m.model.months.length;J++){var L=m.model.months[J];var K=h(".alerts-months").multiselect("widget").find(":checkbox[value="+L+"]");K.attr("checked",true)}h(".alerts-months").multiselect("update")}}function v(){if(m.model.duration!=null){h(m.container+" .alerts-duration").val(m.model.duration)}}function n(){if(m.model.promotions){if(m.model.promotions.value){h(m.container+" .alerts-promotions").attr("checked",m.model.promotions.value)}if((m.model.promotions.show!=null)&&(!m.model.promotions.show)){h(m.container+" .alerts-promotions").closest(".alerts-promotion-container").hide()}}}function d(){var J={origin:"",destination:""};if(m.model.origin!=null){J.origin={place:m.model.origin.description+" ("+m.model.origin.code+")",code:m.model.origin.code,facet:"c"}}if(m.model.destination!=null){J.destination={place:m.model.destination.description+" ("+m.model.destination.code+")",code:m.model.destination.code,facet:"c"}}h.each(J,function(K,L){x[K]=new z({element:".alerts-"+K,url:g.autocomplete.url,type:g.autocomplete.type,initial:L})})}function i(){h(m.container+" .alerts-months").multiselect({header:false,minWidth:155,selectedText:function(J,K,L){if(J>1){return J+" "+g.multiselect.selectedText}else{return h(L[0]).attr("title")}},click:r,optgrouptoggle:D,noneSelectedText:g.multiselect.noneSelectedText});h(m.container+" .alerts-months").multiselect("getChecked").parents("label").addClass("ui-multiselect-selected");h(".ui-multiselect-checkboxes input").on("click",function(){var K=h(this);var J=K.parents("label");if(J.hasClass("ui-multiselect-selected")===false){J.addClass("ui-multiselect-selected")}else{J.removeClass("ui-multiselect-selected")}})}function r(K,L){if(L.checked){if(L.value=="option0"){var J=h(".alerts-months").multiselect("widget").find(":checkbox[value!=option0]");J.each(function(){h(this).attr("checked",false)})}else{F(false)}}else{if(L.value=="option0"){F(true)}}}function D(J,K){if(K.checked){F(false)}else{if(h(m.container+" .alerts-months").multiselect("getChecked").length==0){F(true)}}h(".alerts-months").multiselect("update")}function F(K){var J=h(".alerts-months").multiselect("widget").find(":checkbox[value=option0]");J.attr("checked",K)}function b(){if(a()===false){$selector=h(m.container+" .alerts-amount, .alerts-email");$selector.each(function(){var K=h(this);var J=K.attr("placeholder");K.val(J)});$selector.on({focus:function(J){if(h(this).val()==h(this).attr("placeholder")){h(this).select()}},blur:function(J){if(h(this).val()===""){h(this).val(h(this).attr("placeholder"))}},mouseup:function(J){J.preventDefault()}})}}function e(){var J={};J.data=h(m.container+" .alerts-types input:checked").val();J.isValid=true;return J}function q(L){var J=h(x[L].element);var K={};K.data={};K.data.code=x[L].getCode();K.data.description=x[L].getPlace();K.isValid=true;if(K.data.code===null||K.data.description===""){K.isValid=false;c(J)}else{B(J)}return K}function A(){var K=h(m.container+" .alerts-months");var J={};J.data=K.multiselect("getChecked").map(function(){return this.value}).get();J.isValid=true;if(J.data.length===0){J.isValid=false;c(K)}else{B(K)}return J}function C(){var J={};J.data=h(m.container+" .alerts-duration").find(":selected").val();J.isValid=true;return J}function w(){var J={};J.data=h(m.container+" .alerts-currency").find(":selected").val();J.isValid=true;return J}function y(){var J=h(m.container+" .alerts-amount");var K={};K.data=J.val();K.isValid=true;var L=/^(0|[1-9][0-9]*)$/;if(K.data.match(L)===null){K.isValid=false;c(J)}else{B(J)}return K}function l(){var J=h(m.container+" .alerts-email");var K={};K.data=J.val();K.isValid=true;var L=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;if(K.data.match(L)===null){K.isValid=false;c(J)}else{B(J)}return K}function E(){var J={};J.data=h(m.container+" .alerts-promotions").prop("checked");J.isValid=true;return J}function c(J){J.parents("label").addClass("alerts-invalid")}function B(J){J.parents("label").removeClass("alerts-invalid")}function a(){var J=document.createElement("input");return"placeholder" in J}return{init:G,render:I}});