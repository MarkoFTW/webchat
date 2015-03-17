$(document).ready(function(){

    $('li').each(function(){
        if(window.location.href.indexOf($(this).find('a:first').attr('href'))>-1){
            $(this).addClass('active').siblings().removeClass('active');
        }
    });


    $("#ChatText, #sendPrivate, #sendPrivate1").focus();

    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results===null){
            return null;
        }else{
            return results[1] || 0;
        }	
    }
      
      
      
    $("#inputSend").click(function(){
        var empty = false;

        if (!$.trim($("#sendPrivate").val())) {
            empty = true;
        }

        if (empty) {
            alert("Empty message");
        }
    });
    
    $("#inputSend1").click(function(){
        var empty = false;

        if (!$.trim($("#sendPrivate1").val())) {
            empty = true;
        }

        if (empty) {
            alert("Empty message");
        } 
    });
     
      
    $("#LoadProfile").hide();
    $("#Chat").hide()
    $("a[href='#profile']").click(function(){
        $("#OnlineList").hide();
        $("#ChatBig").hide();
        $("#LoadProfile").show();
        $("#Chat").show()
    });
    $("#ClickHome").click(function(){
        $("#OnlineList").show();
        $("#ChatBig").show();
        $("#LoadProfile").hide();
        $("#Chat").hide();
    });
    $('#LogoutUser').click(function(){
        var userID = true;
        $.post( "pages/UserLogout.php", { submitlogout:userID }, function(){
            window.open('index.php', '_self');
        });
    });




    $("input[type=password]").not("#passwordCurr, #passwordCurrE").keyup(function(){
        var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	
	if($("#password1").val().length >= 8){
            $("#8char").removeClass("glyphicon-remove");
            $("#8char").addClass("glyphicon-ok");
            $("#8char").css("color","#00A41E");
	}else{
            $("#8char").removeClass("glyphicon-ok");
            $("#8char").addClass("glyphicon-remove");
            $("#8char").css("color","#FF0004");
	}
	
	if(ucase.test($("#password1").val())){
            $("#ucase").removeClass("glyphicon-remove");
            $("#ucase").addClass("glyphicon-ok");
            $("#ucase").css("color","#00A41E");
	}else{
            $("#ucase").removeClass("glyphicon-ok");
            $("#ucase").addClass("glyphicon-remove");
            $("#ucase").css("color","#FF0004");
	}
	
	if(lcase.test($("#password1").val())){
            $("#lcase").removeClass("glyphicon-remove");
            $("#lcase").addClass("glyphicon-ok");
            $("#lcase").css("color","#00A41E");
	}else{
            $("#lcase").removeClass("glyphicon-ok");
            $("#lcase").addClass("glyphicon-remove");
            $("#lcase").css("color","#FF0004");
	}
	
	if(num.test($("#password1").val())){
            $("#num").removeClass("glyphicon-remove");
            $("#num").addClass("glyphicon-ok");
            $("#num").css("color","#00A41E");
	}else{
            $("#num").removeClass("glyphicon-ok");
            $("#num").addClass("glyphicon-remove");
            $("#num").css("color","#FF0004");
	}
	
	if($("#password1").val() === $("#password2").val()){
            $("#pwmatch").removeClass("glyphicon-remove");
            $("#pwmatch").addClass("glyphicon-ok");
            $("#pwmatch").css("color","#00A41E");
	}else{
            $("#pwmatch").removeClass("glyphicon-ok");
            $("#pwmatch").addClass("glyphicon-remove");
            $("#pwmatch").css("color","#FF0004");
	}
    });

    ////////////////////////////////////////////
    $('#finduser1').click(function(){
        var empty = false;

        if (!$.trim($("#searchid1").val())) {
            empty = true;
        }

        if (empty) {
            alert("Empty user");
        } else {
            var profile = $("#searchid1").val();
            $.post( "pages/profileResult.php", { Profile:profile }, function(result){
                window.location.replace("http://devps1.marefx.com/webchat/Home.php?page=private&do=new&user=" + result);
            });
        }
    });
    $("#searchid1").keyup(function(e){
        var key = e.keyCode || e.which;               
        if(key === 13){

            var empty = false;

            if (!$.trim($("#searchid1").val())) {
                empty = true;
            }

            if (empty) {
                alert("Empty user");
            } else {
                var profile = $("#searchid1").val();
                $.post( "pages/profileResult.php", { Profile:profile }, function(result){
                    window.location.replace("http://devps1.marefx.com/webchat/Home.php?page=private&do=new&user=" + result);
                });
            }
        }
    });
    //When we press enter do
    //alert("Test");
    $("#ChatText").keyup(function(e){
        var key = e.keyCode || e.which;    
        if(key === 13){
            $('#ChatText').attr("disabled", "disabled");
            var empty = false;

            if (!$.trim($("#ChatText").val())) {
                empty = true;
            }

            if (empty) {
                alert("Empty message");
                $('#ChatText').removeAttr("disabled", "disabled");
            } else {
                var Msg = $("#ChatText").val();
                $.post( "pages/InsertMessage.php", { Message:Msg }, function(){
                    $("#ChatMessages").load("pages/DisplayMessages.php");
                    $("#ChatText").val("");
                    $("#ChatMessages").animate({ scrollTop: "+=500" }, "slow");
                    $('#ChatText').removeAttr("disabled", "disabled").focus();
                });
            }
        }
    });
    
    
    $("#sendPrivate").keyup(function(e){
        var key = e.keyCode || e.which;               
        if(key === 13){
            
            var hash = decodeURIComponent($.urlParam('hash'));
            $('#sendPrivate').attr("disabled", "disabled");
            var empty = false;
            
            if (!$.trim($("#sendPrivate").val())) {
                empty = true;
            }

            if (empty) {
                alert("Empty message");
                $('#sendPrivate').removeAttr("disabled", "disabled");
            } else {
                var Msg1 = $("#sendPrivate").val();
                $.post( "pages/SendPrivate.php", { Message1:Msg1, Hash:hash }, function(){
                    $("#sendPrivate").val("");
                    $('#sendPrivate').removeAttr("disabled", "disabled");
                    location.reload();
                });
            }
        }
    });
    $("#sendPrivate1").keyup(function(e){
        var key = e.keyCode || e.which;               
        if(key === 13){
            
            var user = decodeURIComponent($.urlParam('user'));
            $('#sendPrivate1').attr("disabled", "disabled");
            var empty = false;
            
            if (!$.trim($("#sendPrivate1").val())) {
                empty = true;
            }

            if (empty) {
                alert("Empty message");
                $('#sendPrivate').removeAttr("disabled", "disabled");
            } else {
                var Msg2 = $("#sendPrivate1").val();
                $.post( "pages/SendPrivate.php", { Message2:Msg2, User:user }, function(){
                    $("#sendPrivate").val("");
                    $('#sendPrivate').removeAttr("disabled", "disabled");
                    location.reload();
                });
            }
        }
    });

    //refresh 1500ms = 1,5s
    setInterval(function(){
        $("#ChatMessages").load("pages/DisplayMessages.php");
    },1500);

    $("#ChatMessages").load("pages/DisplayMessages.php");
    $("#ListOnlineUsers").load("pages/DisplayUsers.php");
    $("#hiddenOnline").load("pages/OnlineUsers.php");

    function load_stuff(){
        $("#hiddenOnline").load("pages/OnlineUsers.php");
        $("#ListOnlineUsers").load("pages/DisplayUsers.php");
        $("#ChatMessages").animate({ scrollTop: "+=500" }, "slow");
    }

    setInterval(function(){
        load_stuff();
    },5000);

    /////////////////////////////////////////////////
    $(".search1").keyup(function() { 
        var searchid = $(this).val();
        $.post( "pages/profileResult.php", { search1:searchid }, function(html){
            $("#result1").html(html).show();
        });
    });
    //$("#result").on("click",function(e){ 
    $("#result1").click(function(e){ 
        var $clicked = $(e.target);
        var $name = $clicked.find('.name1').html();
        var decoded = $("<div/>").html($name).text();
        $('#searchid1').val(decoded);
    });
    //$(document).on("click", function(e) { 
    $(document).click(function(e) {
        var $clicked = $(e.target);
        if (! $clicked.hasClass("search1")){
        $("#result1").fadeOut(); 
        }
    });
    $('#searchid1').click(function(){
        $("#result1").fadeIn();
    });
    
    
    
    
});  