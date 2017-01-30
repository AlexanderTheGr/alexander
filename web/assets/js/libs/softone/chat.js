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
$("#triggeroffcanvaschat").click(function() {
    $("#offcanvas-chat").css("transform","translate(-500px, 0px)")
})