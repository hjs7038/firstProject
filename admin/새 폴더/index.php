<!DOCTYPE html>
<html>
    <head>
        <style>
            input {
                color: rgba(0, 0, 0, 0.3);
            }
        </style>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script>
            var defaultID = "아이디";
            var defaultPW = "비밀번호";
            var defaultCol = "rgba(0, 0, 0, 0.3)";
            function Onfocus(obj) {
                if($(obj).css("color") == defaultCol) {
                    if($(obj).attr("class") == "id" && $(obj).val() == defaultID) {
                        $(obj).val("");
                        $(obj).css("color", "black");
                    }
                    else if($(obj).attr("class") == "password" && $(obj).val() == defaultPW) {
                        $(obj).val("");
                        $(obj).css("color", "black");
                    }
                }
            }
            function Onblur(obj) {
                if($(obj).val() == "") {
                    if($(obj).attr("class") == "id") {
                        $(obj).val(defaultID);
                        $(obj).css("color", defaultCol);
                    }
                    else if($(obj).attr("class") == "password") {
                        $(obj).val(defaultPW);
                        $(obj).css("color", defaultCol);
                    }
                }
            }
        </script>
    </head>
    <body>
        <h2>테스트 페이지</h2>
        <div>
            <span class="id">아이디</span>
            <input type="text" class="id" value="아이디" onfocus="Onfocus(this);" onblur="Onblur(this);">
            <br/>
            <span class="password">패스워드</span>
            <input type="text" class="password" value="비밀번호" onfocus="Onfocus(this);" onblur="Onblur(this);">
        </div>
    </body>
</html>