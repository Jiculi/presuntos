// JavaScript Document
//var r = jQuery.noConflict();
$(function(){
	$('#mInicio>li').hover(
		function(){
		$('.submenu',this).stop(true,true).slideDown();
		},
		function(){
		$('.submenu',this).slideUp();
		}
	);
 
});

$(function(){
	$('#mInicio>li>ul>li').hover(
		function(){
		$('.submenu2',this).stop(true,true).slideDown();
		},
		function(){
		$('.submenu2',this).slideUp();
		}
	);
 
});

$(function(){
	$('#mInicio>li>ul>li>ul>li').hover(
		function(){
		$('.submenu3',this).stop(true,true).slideDown();
		},
		function(){
		$('.submenu3',this).slideUp();
		}
	);
 
});

//--------------- MENU CONF ----------------------------
$(function(){
	$('#setup>li').hover(
		function(){
		$('.submenuSetup',this).stop(true,true).slideDown();
		},
		function(){
		$('.submenuSetup',this).slideUp();
		}
	);
 
});

