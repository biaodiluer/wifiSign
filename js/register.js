$(document).ready(function(){
      $(".register").click(function(){
        var userId=$(".userId").val();
        var userName=$(".userName").val();
        var macAddress=$(".macAddress").text();
        
        var jsonData=
        {
        	"userId":userId,
        	"userName":userName,
            "macAddress":macAddress
        };

        var ret=_ajax("../src/dealAction.php?method=register",jsonData,"JSON")
        for(var index in ret)
        {
          //alert(index);
            var d=ret[index]
            
            /*alert(d["userId"]);
            alert(d["userName"]);
            alert(d["macAddress"]);*/
            
        }
        //alert(ret);
        //alert(JSON.stringify(ret));//json字符串可以看看
        /*
        if(ret!=0x12341234)
        {
        	alert("注册成功，为您自动登录");
        	window.locaion="../front/index.php";
        }
        else
            alert("后台代码有问题");
        */
      });

});
