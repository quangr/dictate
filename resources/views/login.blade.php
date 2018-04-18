<!DOCTYPE html>
<html>
<head>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("input#login").click(function(){

    $.ajax({
    url: "/auth/login",
    type: "post",
    dataType: "json",
    data: {
      email:$("#email").val(),
      password:$("#password").val(),
    },
    success: function (data) {
        alert(data['message']);
        window.location.replace("/user/add");
    },
    error: function (data) {
        var errors = $.parseJSON(data.responseText);
        $.each(errors, function (key, value) {
            alert(value);
        });
    }
});


  });
});

</script>

</head>
<body>
<div id="login"> 
      <h3>用户登录</h3> 
     
      <div id="login_form"> 
          <p><label>用户名：</label> <input type="text" id="email" /></p> 
          <p><label>密 码：</label> <input type="password" id="password" /> 
</p> 
          <div class="sub"> 
              <input type="submit" id="login" value="登 录" /> 
          </div> 
      </div> 
    
</div>
</body>
</html>

