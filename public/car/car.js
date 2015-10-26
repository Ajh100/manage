var DragImage = {
	
	imgListCount: 0,
	currentEditIndex: 0,
	
	addImage:function(sname) {
		$('#div_prompt').hide();
		
		var src = '/uploads/' + sname;
		DragImage.imgListCount = $('#CarImgsUl li').length;
		DragImage.imgListCount += 1;
		
		str = '<li id="imageLi' + DragImage.imgListCount + '"><dl><dt class="click_cover"><img width="120" height="90" src="'+ src +'" /></dt><dd style="display:block;"><a href="javascript:void(0);" onclick="DragImage.editImageLi(\''+ src +'\',' + DragImage.imgListCount + ')">编辑</a></dd><dd style="display:block;"><a href="javascript:void(0);" onclick="DragImage.delImageLi(' + DragImage.imgListCount + ')">删除</a></dd></dl><input name="filelist[]" type="hidden" value="'+ sname +'" /></li>';
		
		$('#CarImgsUl').append(str);
	},
	

	/* 删除图片 */
	delImageLi:function(imageIndex){
		var curObj = $('#CarImgsUl #imageLi' + imageIndex),
		picName = curObj.find('img').attr('src');
		$.ajax({
			type: 'GET',
			dataType: 'text',
			url: '/index.php/ajax/ajax_delimg',
			data: {'picname': picName},
			success: function (data) {
				if (data == 1) {
					curObj.remove();		
				} else {
					alert('图片删除失败');
					curObj.remove();
				}
			}
		});
	},	
	
	
	editImageLi:function(f, a){
		DragImage.currentEditIndex = a;
		var c = {
			app: "02",
			callback: "api",
			backurl: "",
			image_url: f,
			upload_url: "/index.php/upload/meituupload",
			id: f,
			meituUploadImgsResponseFun: "DragImage.meituUploadImgsResponse",
			closePhotoEditorFun: "DragImage.closePhotoEditor"
		},
			d = {
				menu: "false",
				scale: "noScale",
				allowFullscreen: "true",
				allowScriptAccess: "always",
				bgcolor: "#ffffff",
				wmode: "window"
			},
			b = {
				id: "PhotoEditor"
			},
			e = "/public/car/ImageEditor.swf?v=20140818";
		swfobject.embedSWF(e, "flashEditorContent", "800", "550", "10.0.0", "/public/swfobject/expressInstall.swf", c, d, b);
		$('.mydivbox').show();
		$('.bgpopo').show();
	},
	meituUploadImgsResponse:function (a, h){
		var b = eval("(" + h + ")");
		if(b.msg == 1){
			var cImageA = $('#imageLi' + DragImage.currentEditIndex);
			var srcolder = cImageA.find('dl>dt>img').attr('src');
			cImageA.find('dl>dt>img').attr('src', b.msgbox);
			cImageA.find('input').val(b.msgbox.substr(9));
			cImageA.find('dl>dd').eq(0).html('<a href="javascript:void(0);" onclick="DragImage.editImageLi(\''+ b.msgbox +'\',' + DragImage.currentEditIndex + ')">编辑</a>');
		
		}else{

			alert('编辑失败');	
		}
		DragImage.closePhotoEditor();
	},
	closePhotoEditor:function (){
		$('.mydivbox').hide();
		$('.bgpopo').hide();
		DragImage.currentEditIndex = 0;
		$(".mydivbox").html('<div id="flashEditorContent"></div>');
	},
};


var SlectMenu = {
	
	init:function(){
		$(document).bind('click',function(){ 
			$('.dropdownUlList').hide(); 
		}); 

		$(".input_select").click(function(e){
			e.stopPropagation();
			$('.dropdownUlList').hide(); 
			var ul = $(this).next('.dropdown ul'); 
			if(ul.css("display")=="none"){ 
				ul.show();
			}else{ 
				ul.hide(); 
			} 
		});
		

		$.ajax({ 
			url: "/index.php/ajax/ajax_brand",
			cache: false,
			success: function(data, textStatus){
				$('#brand_div').html('');
				$('#brand_div').html(data);
			}
		});		
		
		if($('#brand_value').val() !== ''){
			$.ajax({ 
				url: "/index.php/ajax/ajax_series", 
				data: {id:$('#brand_value').val()},
				cache: false,
				success: function(data, textStatus){
					$('#series_div').html('');
					$('#series_div').html(data);
				}
			});				
		};
		
		if($('#series_value').val() !== ''){
			$.ajax({ 
				url: "/index.php/ajax/ajax_carclass", 
				data: {id:$('#series_value').val(),brand_id:$('#brand_value').val()},
				cache: false,
				success: function(data, textStatus){
					$('#class_div').html('');
					$('#class_div').html(data);
				}
			});				
		};
		
		$('.zhijian').toggle(
			function () {
			  $('#quality').slideDown();
			},
			function () {
			  $('#quality').slideUp();
			}
		);
		
		$('.damageopen').toggle(
			function () {
			  $('#generatecarbox').show();
			},
			function () {
			  $('#generatecarbox').hide();
			}
		);
	},
	
	brand_click:function (title, id){
		$('#brand_div').hide();
		$('#brand_title').val(title);
		$('#brand_value').val(id);
		$('#series_title').val('请选择车系').next('.dropdown ul').hide().html('');
		$('#class_title').val('请选择车型').next('.dropdown ul').hide().html('');
		$.ajax({ 
			url: "/index.php/ajax/ajax_series", 
			data: {id:id},
			cache: false,
			success: function(data, textStatus){
				$('#series_div').html('');
				$('#series_div').html(data).show();
			}
		});	
	},
	
	series_click:function(title, id, obj){
                var brand_id = $('#brand_value:input').val();
		$('#series_div').hide();
		$('#series_title').val(title);
		$('#series_value').val(id);
		$('#class_title').val('请选择车型').next('.dropdown ul').hide().html('');
		$.ajax({ 
			url: "/index.php/ajax/ajax_carclass", 
			data: {brand_id:brand_id, id:id},
			cache: false,
			success: function(data, textStatus){
				$('#class_div').html('');
				$('#class_div').html(data).show();
			}
		});	
	},
	
	class_click:function(title, id){
		$('#class_div').hide();
		$('#class_title').val(title);
		$('#class_value').val(id);	
	},
	//上牌时间
	regtime_click:function(value){
		$('#regtime_title').val(value);
		$('#regtime_div').hide();
		$('#regtimedate_checkclick').attr('class','');
		$('#regtimedate_checkclick').addClass('checkclick');
	},
	
	regtimedate_click:function(value){
		$('#regtimedate_title').val(value);
		$('#regtimedate_div').hide();
		$('#regtimedate_checkclick').attr('class','');
		$('#regtimedate_checkclick').addClass('checkclick');
	},
	
	//年检到期
	inspeyear_click:function(value){
		$('#inspeyear_title').val(value);
		$('#inspeyear_div').hide();
		$('#inspeyear_checkclick').attr('class','');
		$('#inspeyear_checkclick').addClass('checkclick');
	},
	
	inspemonth_click:function(value){
		$('#inspemonth_title').val(value);
		$('#inspemonth_div').hide();
		$('#inspeyear_checkclick').attr('class','');
		$('#inspeyear_checkclick').addClass('checkclick');
	},
	
	//交强险到期
	inuyear_click:function(value){
		$('#inuyear_title').val(value);
		$('#inuyear_div').hide();
		$('#inuyear_checkclick').attr('class','');
		$('#inuyear_checkclick').addClass('checkclick');
	},
	
	inumonth_click:function(value){
		$('#inumonth_title').val(value);
		$('#inumonth_div').hide();
		$('#inuyear_checkclick').attr('class','');
		$('#inuyear_checkclick').addClass('checkclick');
	},
	
	
	/* 选择车体颜色 */
	SelectColor:function(value) {
		$('#color_id').val(value);
		$("#colorall").find('.click').attr('class', '');
		$("#color" + value).attr("class", "click");
	},	
	
	
	SelectShangPai:function(obj) {
		$('#regtime_title').val('年份');
		$('#regtimedate_title').val('日期');
		$(obj).attr('class', '');
		$(obj).attr("class", "checkclickon");
	},	
	
	SelectInspeyear:function(obj) {
		$('#inspeyear_title').val('年份');
		$('#inspemonth_title').val('日期');
		$(obj).attr('class', '');
		$(obj).attr("class", "checkclickon");
	},
	
	SelectInuyear:function(obj) {
		$('#inuyear_title').val('年份');
		$('#inumonth_title').val('日期');
		$(obj).attr('class', '');
		$(obj).attr("class", "checkclickon");
	}
};

var CarValidate = {
	patrn:{
		'telphone':/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/,
		'peopel':/^\s*[\u4e00-\u9fa5]{1,}[\u4e00-\u9fa5.·]{0,15}[\u4e00-\u9fa5]{1,}\s*$/,
		'price':/^(d*.d{0,2}|d+).*$/,
		'mileage':/^(([1-9][0-9]{0,1})|([0-9]{1,2}\.[0-9]{1,2}))$/
	},
	validate:function(){
		//验证品牌
		if($('#brand_title').val() == '请选择品牌'){
			alert('请选择品牌');
			$('#brand_title').focus().click();
			return;
		}
		//验证车系
		if($('#series_title').val() == '请选择车系'){
			alert('请选择车系');
			$('#series_title').focus().click();
			return;
		}
		//验证车型
		if($('#class_title').val() == '请选择车型'){
			alert('请选择车型');
			$('#class_title').focus().click();
			return;
		}
		//验证上牌时间
		if($('#regtime_title').val() != '年份' && $('#regtimedate_title').val() == '日期'){
			alert('上牌时间');
			$('#regtimedate_title').focus();
			return;
		}
		if($('#regtime_title').val() == '年份' && $('#regtimedate_title').val() != '日期'){
			alert('上牌时间');
			$('#regtime_title').focus();
			return;
		}
		//验证行驶公里
		if($('#mileage').val() == ''){
			alert('行驶里程不能为空');
			$('#mileage').focus();
			return;
		}else if(!CarValidate.patrn['mileage'].exec($('#mileage').val())){
			alert('行驶里程格式不正确，最多为2位整数，2位小数');
			$('#mileage').focus();
			return;
		}
		//验证车身颜色
		if($('#color_id').val() == ''){
			alert('车身颜色');
			return;
		}
		//验证年间到期
		if($('#inspeyear_title').val() != '年份' && $('#inspemonth_title').val() == '日期'){
			alert('请选择年检到期时间');
			$('#regtimedate_title').focus();
			return;
		}
		if($('#inspemonth_title').val() == '年份' && $('#inspeyear_title').val() != '日期'){
			alert('请选择年检到期时间');
			$('#inspemonth_title').focus();
			return;
		}
		//验证交强险
		if($('#inuyear_title').val() != '年份' && $('#inumonth_title').val() == '日期'){
			alert('请选择交强险到期时间');
			$('#inuyear_title').focus();
			return;
		}
		if($('#inuyear_title').val() == '年份' && $('#inumonth_title').val() != '日期'){
			alert('请选择交强险到期时间');
			$('#inumonth_title').focus();
			return;
		}
		//验证损伤图片
		var damageImgsullt = $('#DamageImgsUl').find('li').length;
		var generformlt = $('#generform').find('input').length;
		if(damageImgsullt != 0 && damageImgsullt>generformlt){
			alert('请对照已上传损伤图片绘制锚点,锚点数和图片数相同,锚点编号对应图片排列顺序');
			return;
		}				
		//验证上传图片
		if($('#CarImgsUl').find('li').length == 0){
			alert('请上传图片');
			return;
		}
		//验证车主描述
		if($('#description').val() == ''){
			alert('请输入车主描述');
			$('#description').focus();
			return;
		}else if($('#description').val().length > 500){
			alert('车主描述最多500个字符');
			$('#description').focus();
			return;
		}
		//验证收车价格
		if($('#price').val() == ''){
			alert('请输入车主报价');
			$('#price').focus();
			return;
		}else if(!CarValidate.patrn['price'].exec($('#price').val())){
			alert('请输入正确的价格');
			$('#price').focus();
			return;		
		}
		//验证车主姓名	
		if($('#owner').val() == ''){
			alert('请输入车主姓名');
			$('#owner').focus();
			return;
		}else if(!CarValidate.patrn['peopel'].exec($('#owner').val())){
			alert('请输入正确的车主姓名');
			$('#owner').focus();
			return;		
		}
		//验证车主电话
		if($('#tel').val() == ''){
			alert('请输入车主电话');
			$('#tel').focus();
			return;
		}else if(!CarValidate.patrn['telphone'].exec($('#tel').val())){
			alert('电话号码格式不正确');
			$('#tel').focus();
			return;
		}
		
		return true;
	},
};


var DragDamage = {
	lsi:0,
	init:function(lsi){
		DragDamage.lsi = lsi;
		if($(".damage_ls").length>0){
			$(".damage_ls").remove();
		}
		var div=$("<div class='damage_ls'></div>");
		div.appendTo("body");
		var ex,ey;
		$("#generatecar").mousemove(function(e){
			var e=e||event;
			var x0=e.clientX;
			var x=x0-($(this).offset().left);
				 //x=e.pageX;
			ex=x;
			var y0=e.clientY;
			var y=y0-($(this).offset().top);
				//y=e.pageY;
			ey=y;
			setTimeout(function(){
				div.css({"left":x0-7+"px","top":y0-7+"px"});
			},1);
		})
		
		$(".damage_ls").click(function(e){
			DragDamage.lsi++;
			$("<div class='damage_lss'></div>").appendTo("#generatecar").css({"left":ex-7+"px","top":ey-7+"px"}).text(DragDamage.lsi);
			$("#generform").append("<input value=\""+ex+","+ey+"\" name=\"damagexy[]\" type=\"hidden\" />");
		})
		$('a.opengenerater').click(function(){
			$('#generatecar').fadeIn();
			$('#generatecartool').fadeIn();
			$('.damage_ls').fadeIn();
		});
		$('#generatecartool a.repic').click(function(){
			$('#generatecar').html('');
			$("#generform").html('');
			DragDamage.lsi = 0;
		});
		$('#generatecartool a.close').click(function(){
			$('#generatecar').fadeOut();
			$('#generatecartool').fadeOut();
			$('.damage_ls').fadeOut();
		});
		$('.damage_lss').live('mouseover', function() {
			$(".damage_ls").hide();
			var index = $(this).text();
			$("#"+index).css({background:'red'});
		}).live('mouseout', function() {
			$(".damage_ls").show();
			$(".formbox").css({background:'white'});
		})
	}
};


var DamageDragImage = {
	
	imgListCount: 0,
	currentEditIndex: 0,
	
	addImage:function(sname) {
		$('#div_prompt').hide();
		var src = '/uploads/' + sname;
		DamageDragImage.imgListCount = $('#DamageImgsUl li').length;
		DamageDragImage.imgListCount += 1;
		
		str = '<li id="imageLi' + DamageDragImage.imgListCount + '"><dl><dt class="click_cover"><img width="120" height="90" src="'+ src +'"><div class="click"></div></dt><dd style="display:block;"><a href="javascript:void(0);" onclick="DragImage.editImageLi(\''+ src +'\',' + DamageDragImage.imgListCount + ')">编辑</a></dd><dd style="display:block;"><a href="javascript:void(0);" onclick="DamageDragImage.delImageLi(' + DamageDragImage.imgListCount + ')">删除</a></dd></dl><input name="damagefilelist[]" type="hidden" value="'+ sname +'" /></li>';
		
		$('#DamageImgsUl').append(str);
		
	},
	
	/* 删除图片 */
	delImageLi:function(imageIndex){
		var curObj = $('#imageLi' + imageIndex);
		var picName = curObj.find('img').attr('src');
		$('#generform').html('');
		$('#generatecar').html('');
		$.ajax({
			type: 'GET',
			dataType: 'text',
			url: '/index.php/ajax/ajax_delimg',
			data: {'picname': picName},
			success: function (data) {
				if (data == 1) {
					curObj.remove();
					DragDamage.init(0);
					alert('删除成功，请重新绘制锚点');
				} else {
					alert('图片删除失败');
					curObj.remove();
				}
			}
		});
	},	
	
	
	editImageLi:function(f, a){
		DragImage.currentEditIndex = a;
		var c = {
			app: "02",
			callback: "api",
			backurl: "",
			image_url: f,
			upload_url: "/index.php/upload/meituupload",
			id: f,
			meituUploadImgsResponseFun: "DamageDragImage.meituUploadImgsResponse",
			closePhotoEditorFun: "DamageDragImage.closePhotoEditor"
		},
			d = {
				menu: "false",
				scale: "noScale",
				allowFullscreen: "true",
				allowScriptAccess: "always",
				bgcolor: "#ffffff",
				wmode: "window"
			},
			b = {
				id: "PhotoEditor"
			},
			e = "/public/car/ImageEditor.swf?v=20140818";
		swfobject.embedSWF(e, "flashEditorContent", "800", "550", "10.0.0", "/public/swfobject/expressInstall.swf", c, d, b);
		$('.mydivbox').show();
		$('.bgpopo').show();
	},
	meituUploadImgsResponse:function (a, h){
		var b = eval("(" + h + ")");
		if(b.msg == 1){
			var cImageA = $('#imageLi' + DragImage.currentEditIndex);
			var srcolder = cImageA.find('dl>dt>img').attr('src');
			cImageA.find('dl>dt>img').attr('src', b.msgbox);
			cImageA.find('input').val(b.msgbox.substr(9));
			cImageA.find('dl>dd').eq(0).html('<a href="javascript:void(0);" onclick="DamageDragImage.editImageLi(\''+ b.msgbox +'\',' + DragImage.currentEditIndex + ')">编辑</a>');
			if($('#carCover').val() == srcolder.substr(9)){
				$('#carCover').val(b.msgbox.substr(9));
			}
		}else{

			alert('编辑失败');	
		}
		DragImage.closePhotoEditor();
	},
	closePhotoEditor:function (){
		$('.mydivbox').hide();
		$('.bgpopo').hide();
		DragImage.currentEditIndex = 0;
		$(".mydivbox").html('<div id="flashEditorContent"></div>');
	}
};