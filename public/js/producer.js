$(document).ready(function() {
    $(window).on("unload", function(e) {
        saveSettings();
    });
    loadSettings();
    $('#submit').click(function(){
        $.post( "/", $( "#form :input" ).serialize() )
            .done(function( data ) {
                var d = new Date();
                $('#console').prepend(d + " Payload Successfully Sent<br>" + data + "<br><br>");
                saveSettings();
            });
    });
    $(".topic-name").click(function(e){
        e.preventDefault();
        loadTopic($(this).html());
    });
});

function loadSettings() {
    $('#topic').val(localStorage.topic);
    $('#broker').val(localStorage.broker);
    $('#payload').val(localStorage.payload);
    if(localStorage.topics){
        var topics =  JSON.parse(localStorage.topics);
    }else{
        var topics = [];
    }
    for(i=0;i<topics.length;i++){
        $('#topics').append("<li><a href='#' class='topic-name'>" + topics[i] + "</a></li>");
    }
}

function loadTopic(topic) {
    $('#topic').val(localStorage['t_' + topic]);
    $('#broker').val(localStorage['b_' + topic]);
    $('#payload').val(localStorage['p_' + topic]);
}

function saveSettings() {
    var broker = $('#broker').val();
    var topic = $('#topic').val();
    var payload = $('#payload').val();
    if(localStorage.topics){
        var topics =  JSON.parse(localStorage.topics);
    }else{
        var topics = [];
    }
    console.log(topics.indexOf(topic));
    if(topics.indexOf(topic) === -1){
        topics.push(topic);
        $('#topics').append("<li><a href='#' class='topic-name'>" + topic + "</a></li>");
    }
    localStorage.topics = JSON.stringify(topics);
    localStorage.broker = broker;
    localStorage.topic = topic;
    localStorage.payload = payload;

    localStorage['t_' + topic] = topic;
    localStorage['b_' + topic] = broker;
    localStorage['p_' + topic] = payload;
}