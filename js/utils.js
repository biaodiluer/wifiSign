function _ajax(_url,jsonData,_dataType)
{
  var ret="init_AJAX";
  $.ajax({
     url: _url,
     type: "GET",
     data:jsonData,
     dataType:_dataType,
     async:false,
     success: function(data)
     {//请求成功完成后要执行的方法
      if(data!=null)
        ret=data;
      else
        ret=0x12341234;
     }
  });
  return ret;
}

function changeStage(stage,url)
{
  var ret=_ajax(url,[],"HTML");
  stage.html(ret);
}
