<?php
if(!defined('CM_VINNUM_CONTROLLER_READY')){
	if(!defined('CM_VINNUM_CONTROLLER_ONLY')){define('CM_VINNUM_CONTROLLER_ONLY',true);}
	require_once(__DIR__.'/../../controller.php');
}
?>
<?/*<script src="/<?=$ModDir?>/media/js/jquery.js"></script> */?>
<div class="CmVNBntCont">
	<div class="CmVinNumWrap">
		
		<div class="CmVNGo">
			<span>
				<div class="CmVNIcCon">
					<svg viewBox="0 0 25 25" class="CmSvgVN"><path d="M16.72 17.78a.75.75 0 1 0 1.06-1.06l-1.06 1.06ZM9 14.5A5.5 5.5 0 0 1 3.5 9H2a7 7 0 0 0 7 7v-1.5ZM3.5 9A5.5 5.5 0 0 1 9 3.5V2a7 7 0 0 0-7 7h1.5ZM9 3.5A5.5 5.5 0 0 1 14.5 9H16a7 7 0 0 0-7-7v1.5Zm3.89 10.45 3.83 3.83 1.06-1.06-3.83-3.83-1.06 1.06ZM14.5 9a5.48 5.48 0 0 1-1.61 3.89l1.06 1.06A6.98 6.98 0 0 0 16 9h-1.5Zm-1.61 3.89A5.48 5.48 0 0 1 9 14.5V16a6.98 6.98 0 0 0 4.95-2.05l-1.06-1.06Z" style="transform: translate(3px, 3px) !important;"></path></svg>
				</div>
			</span>
			<svg viewBox="0 0 25 25" class="CmVNBntAF">
				<path d="M16.72 17.78a.75.75 0 1 0 1.06-1.06l-1.06 1.06ZM9 14.5A5.5 5.5 0 0 1 3.5 9H2a7 7 0 0 0 7 7v-1.5ZM3.5 9A5.5 5.5 0 0 1 9 3.5V2a7 7 0 0 0-7 7h1.5ZM9 3.5A5.5 5.5 0 0 1 14.5 9H16a7 7 0 0 0-7-7v1.5Zm3.89 10.45 3.83 3.83 1.06-1.06-3.83-3.83-1.06 1.06ZM14.5 9a5.48 5.48 0 0 1-1.61 3.89l1.06 1.06A6.98 6.98 0 0 0 16 9h-1.5Zm-1.61 3.89A5.48 5.48 0 0 1 9 14.5V16a6.98 6.98 0 0 0 4.95-2.05l-1.06-1.06Z" style="transform: translate(3px, 3px) !important; fill:#fff;"></path>
			</svg>
		</div>
		<input type="text" id="VNValue" value="" maxlength="17" class="CmVNField c_BorderFoc" placeholder="<?=LangVN_x('VIN_Number')?>">
		<div class="CmVNLoading"><div class="CmLoadVNBl"></div><div class="CmLoadVNBl"></div><div class="CmLoadVNBl"></div><div class="CmLoadVNBl"></div></div>
		<?/* <div class="CmVNBnt CmVNGo">
			<span>Search</span>
			<svg viewBox="0 0 25 25" class="CmSrchBntAF">
				<path d="M16.72 17.78a.75.75 0 1 0 1.06-1.06l-1.06 1.06ZM9 14.5A5.5 5.5 0 0 1 3.5 9H2a7 7 0 0 0 7 7v-1.5ZM3.5 9A5.5 5.5 0 0 1 9 3.5V2a7 7 0 0 0-7 7h1.5ZM9 3.5A5.5 5.5 0 0 1 14.5 9H16a7 7 0 0 0-7-7v1.5Zm3.89 10.45 3.83 3.83 1.06-1.06-3.83-3.83-1.06 1.06ZM14.5 9a5.48 5.48 0 0 1-1.61 3.89l1.06 1.06A6.98 6.98 0 0 0 16 9h-1.5Zm-1.61 3.89A5.48 5.48 0 0 1 9 14.5V16a6.98 6.98 0 0 0 4.95-2.05l-1.06-1.06Z" style="transform: translate(3px, 3px) !important; fill:#fff;"></path>
			</svg>
		</div> */?>
		<div class="CmVNClear">
			<div id="CmVNFail" class="CmVNRes"></div>
			<div id="CmVNTypes" class="CmVNRes"></div>
		</div>
	</div>
</div>



<script type="text/javascript">
$(document).ready(function($){
	var VinNumCookie = VinNumReadCookie('VinNum');
	//if(VinNumCookie!==null && VinNumCookie!=''){$('#VNValue').val(VinNumCookie);}

	function CmVinNum(){
		var VinNum = $('#VNValue').val();
		if(VinNum!=''){
			$("#CmVNFail").hide();
			VinNum = VinNum.replace(/[^a-z. _)(A-Z0-9ÄäÖöÅå-]+/g, '').toUpperCase();

			if(VinNum.length>2 && VinNum.length<18){ //alert(VinNum);
				$('.CmVNGo').removeClass('c_fillBg'); //Hide
				$('.CmVNLoading').fadeIn(100);
				$('#VNValue').prop("disabled",true);
				$.ajax({
					url:'<?=VINNUM_PROCESSOR?>', type:'post', dataType:'html',
					data:'VinNumValue='+VinNum+'&Template=mainpage',
					statusCode:{
						202: function(Res){ //Admin result
							$('#CmVNTypes').html('').hide();
							$('#CmVNFail').html(Res).show();
							VinNumWriteCookie('VinNum',VinNum,999);
						},
						204: function(){ //User result
							$('#CmVNTypes').html('').hide();
							$('#CmVNFail').html('<?=LangVN_x('No_result')?>').show().delay(2000).fadeOut("slow");
						},
						200: function(Res){ //Redirect
							VinNumWriteCookie('VinNum',VinNum,999); //alert(Res);
							$('.CmVNLoading').fadeIn(100);
							$(location).attr('href',Res);
						},
						201: function(Res){ //Select model
							VinNumWriteCookie('VinNum',VinNum,999);
							$('#CmVNTypes').html(Res).show();
							$('.VinNumLit:first-child').click();
						},
					},
					success: function(){
						$('#VNValue').prop("disabled",false);
						$('.CmVNLoading').fadeOut(100);
					},
				});
			}else{$('#VNValue').focus(); }
		}else{$('#VNValue').focus();}
	}

	$("body").on("keyup","#VNValue", function(e){
		if(e.which == 13){
			CmVinNum(); return false;
		}else{
			var VinNum = $('#VNValue').val();
			VinNum = VinNum.replace(/[^a-z. _)(A-Z0-9ÄäÖöÅå-]+/g, '').toUpperCase();
			$('#VNValue').val(VinNum);
			//alert(VinNum);
			if(VinNum!=''){
				if(VinNum.length>2 && VinNum.length<18){
					$('.CmVNGo').addClass('c_fillBg'); //Show
				}else{
					$('.CmVNGo').removeClass('c_fillBg'); //Hide
				}
			}else{
				$('.CmVNGo').removeClass('c_fillBg'); //Hide
			}
		}
	});
	$("body").on("click",".CmVNGo", function(e){
		CmVinNum(); return false;
	});
	$("body").on("click","#VNClose", function(e){
		$('#CmVNTypes').html('').hide();
	});
	$("body").on("click",".VinNumLit", function(e){
		var TabLit = $(this).html();
		$(this).parent().find('td').each(function(){
			$(this).removeClass('VinNumLitActive');
		});
		$(this).addClass('VinNumLitActive');


		$('.VinNumTab').find('.VinNumModel').each(function(){
			$(this).hide();
		});

		$(this).parent().parent().find('tr').each(function(){
			var Lit = $(this).data('lit');
			var ModId = $(this).data('modid');
			if(Lit!=null && Lit!=''){
				if(Lit==TabLit){
					$(this).show();
					$('.ModId'+ModId).show();
				}else{
					$(this).hide();
				}
			}
		});
	});

	$("body").on("click",".CmVNSelector", function(e){
		var VinNum = $('#VNValue').val();
		var href = $(this).attr('href');
		e.preventDefault();
		$('.CmVNLoading').fadeIn(100);
		$('#CmVNTypes').hide();
		$.ajax({
			url:'<?=VINNUM_PROCESSOR?>', type:'post', dataType:'html',data:'VinNumValue='+VinNum+'&Selected='+$(this).data('typid')+'&Template=mainpage',
			success: function(){
				window.location = href;
			},
		});
	});

});
$(document).click(function(event) { //Close on click Out Side
    if(!$(event.target).closest('#CmVNFail').length) {
        if($('#CmVNFail').is(":visible")) {
            $('#CmVNFail').hide();
        }
    }
});


function VinNumWriteCookie(name, value, days){
    var expires;
    if(days){
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }else{
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
	document.cookie = 'RegNum=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function VinNumReadCookie(name){
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}
</script>
