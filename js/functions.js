$(document).ready(function(){
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
                window.location.replace("http://devps1.marefx.com/testchat1-bootstrap/Home.php?page=private&do=new&user=" + result);
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
                    window.location.replace("http://devps1.marefx.com/testchat1-bootstrap/Home.php?page=private&do=new&user=" + result);
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
                    $('#ChatText').removeAttr("disabled", "disabled");
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
    $("#result1").click(function(e){ 
        var $clicked = $(e.target);
        var $name = $clicked.find('.name1').html();
        var decoded = $("<div/>").html($name).text();
        $('#searchid1').val(decoded);
    });
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