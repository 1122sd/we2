$(function(){
    $(document).on('click','.upd',function(){
        $('#hh').html('');
		var mid = $(this).attr('mid');
      //  alert(mid);
		$.post(index_3,{id:mid},function(msg){
        //  alert(msg);
            //alert(msg['wx_name'])
           var str='';
             str +=  '<table>';
             str +=  '<tr> <div class="form-group">';
             str +=  '<span style="width: 120px; float: left; padding-top: 6px; margin-left: 300px;">微信公众号名称 : </span>';
             str +=  '<input  style="width: 200px;" type="text" name="wx_name" value="'+msg['wx_name']+'" class="form-control" required=""> </div>';
             str +=  '<tr> <div class="form-group">';
             str +=  '<span style="width: 120px; float: left; padding-top: 6px; margin-left: 300px;">公众号AppID : </span>';
             str +=  '<input  style="width: 200px;" type="text" name="wx_appid" value="'+msg['wx_appid']+'" class="form-control" required=""> </div>';
             str +=  '<tr> <div class="form-group">';
             str +=  '<span style="width: 120px; float: left; padding-top: 6px; margin-left: 300px;">公众号AppSecret : </span>';
             str +=  '<input  style="width: 200px;" type="text" name="wx_secret" value="'+msg['wx_secret']+'" class="form-control" required=""> </div>';
             str +=  '<tr> <div class="form-group">';
             str +=  '<span style="width: 120px; float: left; padding-top: 6px; margin-left: 300px;">备      注 : </span>';
             str +=  '<textarea name="" rows="3" cols="21">'+msg['wx_remark']+'</textarea> </div>';
             str+=  '</table>' ;


           $('#hh').html(str);
        },'json');
	});
})