


//DIVのIDを表示する

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_changeProp(objName,x,theProp,theValue) { //v6.0
  var obj = MM_findObj(objName);
  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
    if (theValue == true || theValue == false)
      eval("obj."+theProp+"="+theValue);
    else eval("obj."+theProp+"='"+theValue+"'");
  }
}

function MM_changeProp2(objName,x,theProp,theValue) { //v6.0
  var obj = MM_findObj(objName);
  
  if(obj.style.display == theValue){
  	theValue = "none";
  }
  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
    if (theValue == true || theValue == false)
      eval("obj."+theProp+"="+theValue);
    else eval("obj."+theProp+"='"+theValue+"'");
  }
}





//このページの上へ戻る

function backToTop() {
	var x1 = x2 = x3 = 0;
	var y1 = y2 = y3 = 0;
	if (document.documentElement) {
		x1 = document.documentElement.scrollLeft || 0;
		y1 = document.documentElement.scrollTop || 0;
	}
	if (document.body) {
		x2 = document.body.scrollLeft || 0;
		y2 = document.body.scrollTop || 0;
	}
	x3 = window.scrollX || 0;
	y3 = window.scrollY || 0;
	var x = Math.max(x1, Math.max(x2, x3));
	var y = Math.max(y1, Math.max(y2, y3));
	window.scrollTo(Math.floor(x / 1.4), Math.floor(y / 1.4));
	if (x > 0 || y > 0) {
		window.setTimeout("backToTop()", 10);
	}
}




//ウインドオープン


function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}










/*******画像の高さを揃える***************************************/

/*高さを揃えたい要素の直属の親要素に「fixHeight」というクラスを付けます。

 * fixHeight - jQuery Plugin
 * http://www.starryworks.co.jp/blog/tips/javascript/fixheightjs.html
 *
 * Author Koji Kimura @ STARRYWORKS inc.
 * http://www.starryworks.co.jp/
 * 
 * Licensed under the MIT License
 *
 */


(function($){
	
	var isInitialized = false;
	var parents = [];
	var textHeight = 0;
	var $fontSizeDiv;
	
	$.fn.fixHeight = function() {
		this.each(function(){
			var childrenGroups = getChildren( this );
			
			$.each( childrenGroups, function(){
				
				var $children = $(this);
				if ( !$children.filter(":visible").length ) return;
				
				var row = [];
				var top = 0;
				$children.each(function(){
					if ( top != $(this).position().top ) {
						$(row).sameHeight();
						row = [];
						top = $(this).position().top;
					}
					row.push(this);
				});
				if ( row.length ) $(row).sameHeight();
			});
			
			
		});
		init();
		return this;
	}
	
	$.checkFixHeight = function( i_force ) {
		if ( $fontSizeDiv.height() == textHeight && i_force !== true ) return;
		textHeight = $fontSizeDiv.height();
		$(parents).fixHeight();
	}
	
	$.fn.sameHeight = function() {
		var maxHeight = 0;
		this.css("height","auto");
		this.each(function(){
			if ( $(this).height() > maxHeight ) maxHeight = $(this).height();
		});
		return this.height(maxHeight);
	}
	
	function getChildren( i_parent ) {
		var $parent = $( i_parent );
		
		if ( $parent.data("fixHeightChildrenGroups") ) return $parent.data("fixHeightChildrenGroups");
		var childrenGroups = [];
		
		var $children = $parent.find(".fixHeightChild");
		if ( $children.length ) childrenGroups.push( $children );
		
		var $groupedChildren = $parent.find("*[class*='fixHeightChild']:not(.fixHeightChild)");
		if ( $groupedChildren.length ) {
			var classNames = {};
			$groupedChildren.each(function(){
				var a = $(this).attr("class").split(" ");
				var i;
				var l = a.length;
				var c;
				for ( i=0; i<l; i++ ) {
					c = a[i].match(/fixHeightChild[a-z0-9_-]+/i);
					if ( !c ) continue;
					c = c.toString();
					if ( c ) classNames[c] = c;
				}
			});
			for ( var c in classNames ) childrenGroups.push( $parent.find("."+c) );
		}
		
		if ( !childrenGroups.length ) {
			$children = $parent.children();
			if ( $children.length ) childrenGroups.push( $children );
		}
		
		$parent.data("fixHeightChildrenGroups", childrenGroups );
		parents.push( $parent );
		
		return childrenGroups;
	}
	
	
	function init() {
		if ( isInitialized ) return;
		isInitialized = true;
		$fontSizeDiv = $(document).append('<div style="position:absolute;left:-9999px;top:-9999px;">s</div>');
		setInterval($.checkFixHeight,1000);
		$(window).resize($.checkFixHeight);
		$.checkFixHeight();
		$(window).load( function(){ $.checkFixHeight(true); } );
	}
	
})(jQuery);



jQuery(document).ready(function(){
	$(".fixHeight").fixHeight();
});







/*ブロック要素ごとリンクを設定させる　個別に設定が必要、CSSも*/

$(function(){
     $(".shoplist dl").click(function(){
         window.location=$(this).find("a").attr("href");
         return false;
    });
});


/*ストライプのテーブル*/

$(function(){
     $(".table02 tr:odd").addClass("odd");
});

/*トップページの最新情報をストライプに*/
$(function(){
     $("#topinfo dl:odd").addClass("odd");
});




/*端末ごとの振り分け(重要)*/

	if( navigator.userAgent.indexOf('iPhone') > 0 || navigator.userAgent.indexOf('iPod') > 0 || (navigator.userAgent.indexOf('Android') > 0 && navigator.userAgent.indexOf('Mobile') > 0 )){
		document.write('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">');
	}else{
		document.write('<meta name="viewport" content="width=1020, maximum-scale=1.0">');
	};




/*タブ設定--*/

$(function(){
	$("a.btn_act").click(function(){
		var connectCont = $("a.btn_act").index(this);
		var showCont = connectCont+1;
		$('.motion').css({display:'none'});
		$('#motion_area'+(showCont)).fadeIn('normal');

		$('a.btn_act').removeClass('active');
		$(this).addClass('active');
	});
});
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}


$(function(){
	$("a.btn_actG").click(function(){
		var connectCont = $("a.btn_actG").index(this);
		var showCont = connectCont+1;
		$('.motionG').css({display:'none'});
		$('#motion_areaG'+(showCont)).fadeIn('normal');

		$('a.btn_actG').removeClass('active');
		$(this).addClass('active');
	});
});
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
































/*フォームに文字を出力
 * jQuery Form Tips 1.2.6
 * By Manuel Boy (http://www.manuelboy.de)
 * Copyright (c) 2012 Manuel Boy
 * Licensed under the MIT License: http://www.opensource.org/licenses/mit-license.php
*/
(function($){
  
  $.fn.formtips = function(options) {
  
    // handle options
    var settings = $.extend({
      tippedClass: "tipped"
    }, options);
  
    return this.each(function() {
      
      // prepare input elements an textareas
      var e = $(this);
      
      // do not apply form tips to inputs of type file, radio or checkbox
      var type = $(e).attr('type');
      if(type != 'file' && type != 'checkbox' && type != 'radio') {
    
        // handle focus event
        $(e).bind('focus', function() {
          var lv = $(this).attr('title');
          if($(this).val() == lv) {
            $(this).val('').removeClass(settings.tippedClass);
          }
          return true;
        });
    
        // handle blur event
        $(e).bind('blur', function() {
          var lv = $(this).attr('title');
          if($(this).val() == '') {
            $(this).val(lv).addClass(settings.tippedClass);
          }
          return true;
        });
    
        // handle initial text
        var lv = $(e).attr('title');
        if($(e).val() == '' || $(e).val() == $(this).attr('title')) {
          $(e).val(lv).addClass(settings.tippedClass);
        } else {
          $(e).removeClass(settings.tippedClass);
        }
      
        // handle removal of default value
        $(e).parentsUntil('form').parent().submit(function() {
          var lv = $(e).attr('title');
          if($(e).val() == lv) {
            $(e).val('').removeClass(settings.tippedClass);
          }
        });
      
      }
    
    });
  };
  
})(jQuery);






/*$(function(){$(".panel").hide();$(".menu").click(function(){$(this).toggleClass("menuOpen").next().slideToggle();});})*/






		$(function() {
			var pull 		= $('#pull');
				menu 		= $('.navi ul');
				menuHeight	= menu.height();

			$(pull).on('click', function(e) {
				e.preventDefault();
				menu.slideToggle();
			});

			$(window).resize(function(){
        		var w = $(window).width();
        		if(w > 320 && menu.is(':hidden')) {
        			menu.removeAttr('style');
        		}
    		});
		});























with (document) {

write('<script type="text/javascript" src="/js/jquery.easing.js"></script>');

}



//** jQuery Scroll to Top Control script- (c) Dynamic Drive DHTML code library: http://www.dynamicdrive.com.
//** Available/ usage terms at http://www.dynamicdrive.com (March 30th, 09')
//** v1.1 (April 7th, 09'):
//** 1) Adds ability to scroll to an absolute position (from top of page) or specific element on the page instead.
//** 2) Fixes scroll animation not working in Opera. 


var scrolltotop={
	//startline: Integer. Number of pixels from top of doc scrollbar is scrolled before showing control
	//scrollto: Keyword (Integer, or "Scroll_to_Element_ID"). How far to scroll document up when control is clicked on (0=top).
	setting: {startline:100, scrollto: 0, scrollduration:800, fadeduration:[500, 100]},
	controlHTML: '<img src="/img/pagetop.png" style="width:30px; height:100px" id="btn_scroll_top" />', //HTML for control, which is auto wrapped in DIV w/ ID="topcontrol"
	controlattrs: {offsetx:14, offsety:48}, //offset of control relative to right/ bottom of window corner
	anchorkeyword: '#wrap', //Enter href value of HTML anchors on the page that should also act as "Scroll Up" links

	state: {isvisible:false, shouldvisible:false},

	scrollup:function(){
		if (!this.cssfixedsupport) //if control is positioned using JavaScript
			this.$control.css({opacity:0}) //hide control immediately after clicking it
		var dest=isNaN(this.setting.scrollto)? this.setting.scrollto : parseInt(this.setting.scrollto)
		if (typeof dest=="string" && jQuery('#'+dest).length==1) //check element set by string exists
			dest=jQuery('#'+dest).offset().top
		else
			dest=0
		this.$body.animate({scrollTop: dest}, this.setting.scrollduration, "easeOutExpo");
	},

	keepfixed:function(){
		var $window=jQuery(window)
		var controlx=$window.scrollLeft() + $window.width() - this.$control.width() - this.controlattrs.offsetx
		var controly=$window.scrollTop() + $window.height() - this.$control.height() - this.controlattrs.offsety
		this.$control.css({left:controlx+'px', top:controly+'px'})
	},

	togglecontrol:function(){
		var scrolltop=jQuery(window).scrollTop()
		if (!this.cssfixedsupport)
			this.keepfixed()
		this.state.shouldvisible=(scrolltop>=this.setting.startline)? true : false
		if (this.state.shouldvisible && !this.state.isvisible){
			this.$control.stop().animate({opacity:1}, this.setting.fadeduration[0])
			this.state.isvisible=true
		}
		else if (this.state.shouldvisible==false && this.state.isvisible){
			this.$control.stop().animate({opacity:0}, this.setting.fadeduration[1])
			this.state.isvisible=false
		}
	},
	
	init:function(){
		jQuery(document).ready(function($) {
		  var mainobj = scrolltotop
		  var iebrws = document.all
		  mainobj.cssfixedsupport = !iebrws || iebrws && document.compatMode == "CSS1Compat" && window.XMLHttpRequest //not IE or IE7+ browsers in standards mode
		  mainobj.$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body')
		  mainobj.$control = $('<div id="topcontrol">' + mainobj.controlHTML + '</div>')
		    .css({
		      position: mainobj.cssfixedsupport ? 'fixed' : 'absolute',
		      bottom: /*mainobj.controlattrs.offsety*/ 50,
		      right: /*mainobj.controlattrs.offsetx*/ 0,
		      opacity: 0,
		      cursor: 'pointer'
		    })
		    .attr({
		      title: 'Scroll Back to Top'
		    })
		    .append( $('<div id="tohome">' + '' + '</div>') )
		    .attr({
		      title: 'Back to Home'
		    })
		    .appendTo('body');


		    $('#btn_scroll_top').click(function() {
		      mainobj.scrollup();
		      return false
		    });

		    $('#tohome')
		    .css({
		    	"background-image" : "url(/img/totop.png)",
		    	"margin-top" :"15px",
		    	width : "30px",
		    	height : "78px"
		    })
		    .click(function(e) {
				e.preventDefault();
				location.href = "/";
				return false
		    });

		  if (document.all && !window.XMLHttpRequest && mainobj.$control.text() != '') //loose check for IE6 and below, plus whether control contains any text
		    mainobj.$control.css({
		      width: mainobj.$control.width()
		    }) //IE6- seems to require an explicit width on a DIV containing text
		  mainobj.togglecontrol()
		  $('a[href="' + mainobj.anchorkeyword + '"]').click(function() {
		    mainobj.scrollup()
		    return false
		  })
		  $(window).bind('scroll resize', function(e) {
		    mainobj.togglecontrol()
		  })
		})
	}
}
/*
scrolltotop.init()

*/






/*ブロック要素ごとリンクを設定させる　個別に設定が必要、CSSも*/

$(function(){
     $(".gakubuindex dl").click(function(){
         window.location=$(this).find("a").attr("href");
         return false;
    });
});






/*アコーディオンボタン*/
$(function(){
	$('.accordion_btn dd').hide();
	$('.accordion_btn dt').click(function(){
		$(this).toggleClass("active");   
		$(this).siblings("dt").removeClass("active");
		$(this).next("dd").slideToggle();
		$(this).next("dd").siblings("dd").slideUp();
	});
});







/*左側のメニュー*/
$(document).ready(function() {
    $('.right-menu').sidr({
      name: 'sidr-right',
      side: 'right'
    });
});
$(document).ready(function() {
    $('.left-menu').sidr({
      name: 'sidr-left',
      side: 'left'
    });
});











$(function(){
	$setElm = $('.wideslider');
	baseWidth = 960;
	baseHeight = 450;
	minWidth = 320;

	slideSpeed = 700;
	delayTime = 5000;
	easing = 'linear';
	autoPlay = '1'; // notAutoPlay = '0'

	flickMove = '1'; // notFlick = '0'

	btnOpacity = 0.5;
	pnOpacity = 0.5;

	ua = navigator.userAgent;

	$(window).load(function(){
		$setElm.find('img').css({display:'block'});
		$setElm.each(function(){
			targetObj = $(this);
			targetObj.children('ul').wrapAll('<div class="wideslider_base"><div class="wideslider_wrap"></div><div class="slider_prev"></div><div class="slider_next"></div></div>');

			var findBase = targetObj.find('.wideslider_base'),
			findWrap = targetObj.find('.wideslider_wrap'),
			findPrev = targetObj.find('.slider_prev'),
			findNext = targetObj.find('.slider_next');

			var pagination = $('<div class="pagination"></div>');
			targetObj.append(pagination);

			var baseList = findWrap.find('li'),
			baseListLink = findWrap.find('li').children('a'),
			baseListCount = findWrap.find('li').length;

			baseList.each(function(i){
				$(this).css({width:(baseWidth),height:(baseHeight)});
				pagination.append('<a href="javascript:void(0);" class="pn'+(i+1)+'"></a>');
			});

			var findPagi = targetObj.find('.pagination');

			setSlide();
			function setSlide(){
				windowWidth = $(window).width();
				findList = findWrap.find('li');
				setParts = (findBase,findWrap,findPrev,findNext,$setElm);

				setWrapLeft = parseInt(findWrap.css('left'));
				setlistWidth = findList.find('img').width();
				setLeft = setWrapLeft / setlistWidth;

				if(windowWidth < baseWidth){
					if(windowWidth > minWidth){
						findList.css({width:(windowWidth)});
						var reImgHeight = findList.find('img').height();
						findList.css({height:(reImgHeight)});
						setParts.css({height:(reImgHeight)});
					} else if(windowWidth <= minWidth){
						findList.css({width:(minWidth)});
						var reImgHeight = findList.find('img').height();
						findList.css({height:(reImgHeight)});
						setParts.css({height:(reImgHeight)});
					}
				} else if(windowWidth >= baseWidth){
					findList.css({width:(baseWidth),height:(baseHeight)});
					setParts.css({height:(baseHeight)});
				}

				setWidth = findList.find('img').width();
				setHeight = findList.find('img').height();
				baseWrapWidth = (setWidth)*(baseListCount);

				ulCount = findWrap.find('ul').length;
				if(ulCount == 1){
					var makeClone = findWrap.children('ul');
					makeClone.clone().prependTo(findWrap);
					makeClone.clone().appendTo(findWrap);
					findWrap.children('ul').eq('1').addClass('mainList');
					var mainList = findWrap.find('.mainList').children('li');
					mainList.eq('0').addClass('mainActive')

					allListCount = findWrap.find('li').length;
				}
				allLWrapWidth = (setWidth)*(allListCount),
				posAdjust = ((windowWidth)-(setWidth))/2;

				findBase.css({left:(posAdjust),width:(setWidth),height:(setHeight)});
				findPrev.css({left:-(posAdjust),width:(posAdjust),height:(setHeight),opacity:(btnOpacity)});
				findNext.css({right:-(posAdjust),width:(posAdjust),height:(setHeight),opacity:(btnOpacity)});

				findWrap.css({width:(allLWrapWidth),height:(setHeight)});
				findWrap.children('ul').css({width:(baseWrapWidth),height:(setHeight)});

				posResetNext = -(baseWrapWidth)*2,
				posResetPrev = -(baseWrapWidth)+(setWidth);

				adjLeft = setWidth * setLeft;
				findWrap.css({left:(adjLeft)});

			}
			findWrap.css({left:-(baseWrapWidth)});

			var pnPoint = pagination.children('a'),
			pnFirst = pagination.children('a:first'),
			pnLast = pagination.children('a:last'),
			pnCount = pagination.children('a').length;

			if(ua.search(/iPhone/) != -1 || ua.search(/iPad/) != -1 || ua.search(/iPod/) != -1 || ua.search(/Android/) != -1){
				pnPoint.css({opacity:(pnOpacity)});
			} else {
				pnPoint.css({opacity:(pnOpacity)}).hover(function(){
					$(this).stop().animate({opacity:'1'},300);
				}, function(){
					$(this).stop().animate({opacity:(pnOpacity)},300);
				});
			}

			pnFirst.addClass('active');
			pnPoint.click(function(){
				if(autoPlay == '1'){clearInterval(wsSetTimer);}
				var setNum = pnPoint.index(this),
				moveLeft = ((setWidth)*(setNum))+baseWrapWidth;
				findWrap.stop().animate({left: -(moveLeft)},slideSpeed,easing);
				pnPoint.removeClass('active');
				$(this).addClass('active');
				activePos();
				if(autoPlay == '1'){wsTimer();}
			});

			if(autoPlay == '1'){wsTimer();}

			function wsTimer(){
				wsSetTimer = setInterval(function(){
					findNext.click();
				},delayTime);
			}
			findNext.click(function(){
				findWrap.not(':animated').each(function(){
					if(autoPlay == '1'){clearInterval(wsSetTimer);}
					var posLeft = parseInt($(findWrap).css('left')),
					moveLeft = ((posLeft)-(setWidth));
					findWrap.stop().animate({left:(moveLeft)},slideSpeed,easing,function(){
						var adjustLeft = parseInt($(findWrap).css('left'));
						if(adjustLeft <= posResetNext){
							findWrap.css({left: -(baseWrapWidth)});
						}
					});

					var pnPointActive = pagination.children('a.active');
					pnPointActive.each(function(){
						var pnIndex = pnPoint.index(this),
						listCount = pnIndex+1;
						if(pnCount == listCount){
							pnPointActive.removeClass('active');
							pnFirst.addClass('active');
						} else {
							pnPointActive.removeClass('active').next().addClass('active');
						}
					});
					activePos();

					if(autoPlay == '1'){wsTimer();}
				});
			}).hover(function(){
				$(this).stop().animate({opacity:((btnOpacity)+0.1)},100);
			}, function(){
				$(this).stop().animate({opacity:(btnOpacity)},100);
			});

			findPrev.click(function(){
				findWrap.not(':animated').each(function(){
					if(autoPlay == '1'){clearInterval(wsSetTimer);}

					var posLeft = parseInt($(findWrap).css('left')),
					moveLeft = ((posLeft)+(setWidth));
					findWrap.stop().animate({left:(moveLeft)},slideSpeed,easing,function(){
						var adjustLeft = parseInt($(findWrap).css('left')),
						adjustLeftPrev = (posResetNext)+(setWidth);
						if(adjustLeft >= posResetPrev){
							findWrap.css({left: (adjustLeftPrev)});
						}
					});

					var pnPointActive = pagination.children('a.active');
					pnPointActive.each(function(){
						var pnIndex = pnPoint.index(this),
						listCount = pnIndex+1;
						if(1 == listCount){
							pnPointActive.removeClass('active');
							pnLast.addClass('active');
						} else {
							pnPointActive.removeClass('active').prev().addClass('active');
						}
					});
					activePos();

					if(autoPlay == '1'){wsTimer();}
				});
			}).hover(function(){
				$(this).stop().animate({opacity:((btnOpacity)+0.1)},100);
			}, function(){
				$(this).stop().animate({opacity:(btnOpacity)},100);
			});

			function activePos(){
				var posActive = findPagi.find('a.active');
				posActive.each(function(){
					var posIndex = pnPoint.index(this),
					setMainList = findWrap.find('.mainList').children('li');
					setMainList.removeClass('mainActive').eq(posIndex).addClass('mainActive');
				});
			}

			$(window).on('resize',function(){
				if(autoPlay == '1'){clearInterval(wsSetTimer);}
				setSlide();
				if(autoPlay == '1'){wsTimer();}
			}).resize();

			if(flickMove == '1'){
				var isTouch = ('ontouchstart' in window);
				findWrap.on(
					{'touchstart mousedown': function(e){
						if(findWrap.is(':animated')){
							e.preventDefault();
						} else {
							if(autoPlay == '1'){clearInterval(wsSetTimer);}
							if(!(ua.search(/iPhone/) != -1 || ua.search(/iPad/) != -1 || ua.search(/iPod/) != -1 || ua.search(/Android/) != -1)){
								e.preventDefault();
							}
							this.pageX = (isTouch ? event.changedTouches[0].pageX : e.pageX);
							this.leftBegin = parseInt($(this).css('left'));
							this.left = parseInt($(this).css('left'));
							this.touched = true;
						}
					},'touchmove mousemove': function(e){
						if(!this.touched){return;}
						e.preventDefault();
						this.left = this.left - (this.pageX - (isTouch ? event.changedTouches[0].pageX : e.pageX) );
						this.pageX = (isTouch ? event.changedTouches[0].pageX : e.pageX);
						$(this).css({left:this.left});
					},'touchend mouseup mouseout': function(e){
						if (!this.touched) {return;}
						this.touched = false;

						var setThumbLiActive = pagination.children('a.active'),
						listWidth = parseInt(baseList.css('width')),leftMax = -((listWidth)*((baseListCount)-1));

						if(((this.leftBegin)-30) > this.left && (!((this.leftBegin) === (leftMax)))){
							$(this).stop().animate({left:((this.leftBegin)-(listWidth))},slideSpeed,easing,function(){
								var adjustLeft = parseInt($(findWrap).css('left'));
								if(adjustLeft <= posResetNext){
									findWrap.css({left: -(baseWrapWidth)});
								}
							});

							setThumbLiActive.each(function(){
								var pnIndex = pnPoint.index(this),
								listCount = pnIndex+1;
								if(pnCount == listCount){
									setThumbLiActive.removeClass('active');
									pnFirst.addClass('active');
								} else {
									setThumbLiActive.removeClass('active').next().addClass('active');
								}
							});
							activePos();
						} else if(((this.leftBegin)+30) < this.left && (!((this.leftBegin) === 0))){
							$(this).stop().animate({left:((this.leftBegin)+(listWidth))},slideSpeed,easing,function(){
								var adjustLeft = parseInt($(findWrap).css('left')),
								adjustLeftPrev = (posResetNext)+(setWidth);
								if(adjustLeft >= posResetPrev){
									findWrap.css({left: (adjustLeftPrev)});
								}
							});
							setThumbLiActive.each(function(){
								var pnIndex = pnPoint.index(this),
								listCount = pnIndex+1;
								if(1 == listCount){
									setThumbLiActive.removeClass('active');
									pnLast.addClass('active');
								} else {
									setThumbLiActive.removeClass('active').prev().addClass('active');
								}
							});
							activePos();
						} else {
							$(this).stop().animate({left:(this.leftBegin)},slideSpeed,easing);
						}
						compBeginLeft = this.leftBegin;
						compThisLeft = this.left;
						baseListLink.click(function(e){
							if(!(compBeginLeft == compThisLeft)){
								e.preventDefault();
							}
						});
						if(autoPlay == '1'){wsTimer();}
					}
				});
			}
			setTimeout(function(){setSlide();},500);
		});
	});
});