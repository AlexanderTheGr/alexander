/* 
 Created by: Kenrick Beckett
 
 Name: Chat Engine
 */

var instanse = false;
var state;
var mes;
var file;
//var url = "/developing/partbox/users/user/chatprocess";

function Chat() {
    this.update = updateChat;
    this.send = sendChat;
    this.getState = getStateOfChat;
}

//gets the state of the chat
function getStateOfChat() {

    if (!instanse) {
        instanse = true;
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'function': 'getState',
                'file': file
            },
            dataType: "json",
            success: function (data) {
                if (data.text) {
                    for (var i = 0; i < data.text.length; i++) {
                        $('#chat-area').append($(data.text[i]));
                    }
                }
                document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
                instanse = false;
                state = data.state;
            },
        });
    }
}

//Updates the chat
function updateChat() {
    if (!instanse) {
        instanse = true;
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'function': 'update',
                'state': state,
                'file': file
            },
            dataType: "json",
            success: function (data) {
                if (data.text) {
                    for (var i = 0; i < data.text.length; i++) {
                        $('#chat-area').append($(data.text[i]));
                        if (!$("#offcanvas-chat").hasClass("active")) {
                            $("#offcanvaschat").click();
                        }
                        $(".togglechat").text("Hide Chat");
                        var $target = $(".nano > .nano-content ")
                        $target.animate({scrollTop: $("#chat-area").height() + 100}, 500);
                    }
                }
                document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
                instanse = false;
                state = data.state;
            },
        });
    }
    else {
        setTimeout(updateChat, 1500);
    }
}

//send the message
function sendChat(message, from, to)
{
    updateChat();

    $.ajax({
        type: "POST",
        url: url,
        data: {
            'function': 'send',
            'message': message,
            'from': from,
            'to': to,
            'file': file
        },
        dataType: "json",
        success: function (data) {
            updateChat();

        },
    });
}
$("#triggeroffcanvaschat").click(function () {

})


var url = "/user/chatprocess";
var from = 'admin';
$("#page-wrap").hide();
$(".togglechat").click(function () {
    $("#page-wrap").toggle();
    if ($(this).text() == 'Show Chart') {
        $(this).text("Hide Chat");
    } else {
        $(this).text("Show Chart");
    }
})
// default name is 'Guest'
if (!from || from === ' ') {
    from = "Guest";
}
$(".chat-left").live("click", function () {
    $("#user_email").val($(this).attr("from"));
    ;
})

// strip tags
from = from.replace(/(<([^>]+)>)/ig, "");

// display name on page
$("#name-area").html("You are: <span>" + from + "</span>");

// kick off chat
var chat = new Chat();

setInterval('chat.update()', 2000);

$(function () {

    chat.getState();

    // watch textarea for key presses
    $("#sidebarChatMessage").keydown(function (event) {

        var key = event.which;
        //all keys including return.  
        if (key >= 33) {

            var maxLength = $(this).attr("maxlength");
            var length = this.value.length;

            // don't allow new content if length is maxed out
            if (length >= maxLength) {
                event.preventDefault();
            }
        }
    });
    // watch textarea for release of key press
    $('.sidebarChatMessage').keyup(function (e) {
        if (e.keyCode == 13) {
            var to = $("#user_email").val();
            var text = $(this).val();
            var maxLength = $(this).attr("maxlength");
            var length = text.length;
            //alert(text.length)
            // send 
            if (length <= maxLength + 1) {
                chat.send(text, from, to);
                $(this).val("");
            } else {
                $(this).val(text.substring(0, maxLength));
            }
        }
    });
});