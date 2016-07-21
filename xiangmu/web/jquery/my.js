$(function(){
    //删除数据
$(document).on('click','.del',function(){
    $('#hh').html('');
     var _this = $(this);
     var mid =  _this.attr('mid');
    //alert(mid)
    $.post(Wxdel,{mid:mid},function(e){
   if(e!=2){
        _this.parents('tr').fadeOut(1000);        // alert('删除成功');//将删除的那一条隐藏将查询到的一条信息附上
   }else{
       alert('删除失败');
   }
    })
})
//分页实现
$(document).on('click','.page',function(){
    $('#hh').html('');
   var mid = $(this).attr('mid');
   // alert(mid);
    //将页码传递到控制器获取想要的内容
    $.get(Index_2,{page:mid},function(e){
     //alert(e.data[0]);
      var str = '<tr  style="height: 30px"> ' +
        '<div class="form-group"> ' +
        '<th style="padding-left: 5px;padding-right: 5px;">ID</th> ' +
        '<th style="padding-left: 5px;padding-right: 5px;">公众号名称</th> ' +
        '<th style="padding-left: 5px;padding-right: 5px;">备注</th> ' +
        '<th style="padding-left: 5px;padding-right: 5px;">上传日期</th> ' +
        '<th style="padding-left: 5px;padding-right: 5px;">操作</th> ' +
        '</div> ' +
        '</tr>';
        $.each(e.data,function(k,v){
            str += ' <tr  style="height: 30px">' +
            '<div class="form-group">' +
            '<td>&nbsp; '+ v.wx_id+'&nbsp;</td>' +
            '<td>&nbsp; '+ v.wx_name+'&nbsp;</td>' +
            '<td>&nbsp; '+ v.wx_remark+'&nbsp;</td>' +
            '<td>&nbsp; '+ v.wx_time+'&nbsp;</td>' +
            '<td><a href="javascript:;" mid="'+ v.wx_id+'" class="del">&nbsp;删&nbsp;除&nbsp;</a>&nbsp;||' +
            '&nbsp;<a href="javascript:;"  mid="'+ v.wx_id+'" class="upd">查看详细信息&nbsp;</a></td>' +
            '</div></tr>';
        });
      //alert(str);
        var ste = '<a href="javascript:;" class=\"page\" mid="'+ e.up+'" >&nbsp;上一页&nbsp;</a>' +
            '<a href="javascript:;" class=\"page\" mid="'+ e.down+'">&nbsp;下一页&nbsp;</a>';
        $("#pagess").html(ste);
        $("#show11").html(str);
    },'json')
});


})
