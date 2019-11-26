$(document).ready(function() {
    var tid;

    $(window).on("unload", function(e) {
        saveSettings();
    });
    loadSettings();
    $('#start').click(function(){
        $('#start').hide();
        $('#stop').show();
        tid = setInterval(consume, 2000);
    });
    $('#stop').click(function(){
        $('#start').show();
        $('#stop').hide();
        clearInterval(tid);
    });
});

function consume()
{
    $.post( "/consume", $( "#form :input" ).serialize() )
        .done(function( data ) {
            var d = new Date();
            if(data){
                $('#console').prepend(d + " <br>" + data + "<br><br>");
            }
        });
}

function loadSettings()
{
    $('#topic').val(localStorage.topic);
    $('#broker').val(localStorage.broker);
}

function saveSettings()
{
    localStorage.broker = $('#broker').val();
    localStorage.topic = $('#topic').val();
}