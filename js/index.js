$(document).ready(function(){
      //点击菜单切换场景
      $("span.submenu").click(function(){
        var url=$(this).attr("_url");
        var stage=$("#stage");
        changeStage(stage,url);
      });

});