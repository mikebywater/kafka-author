$(document).ready(function() {
    var tid;

    $(window).on("unload", function(e) {
        saveSettings();
    });
    loadSettings();
    $('#start').click(function(){
        $('#start').hide();
        $('#stop').show();
        toggleInputs(true);
        tid = setInterval(consume, 2000);
    });
    $('#stop').click(function(){
        $('#start').show();
        $('#stop').hide();
        toggleInputs(false);
        clearInterval(tid);
    });
});

function consume()
{
    $.post( "/consume", $( "#form :input" ).serialize() )
        .done(function( data ) {
            if(data){
                $('#console').prepend(getFormattedDate() + " on " + $('#topic').val()  + " <br>" + data + "<br><br>");
            }
        });
}

function toggleInputs(bool)
{
    $('#broker').prop("readonly",bool);
    $('#topic').prop("readonly",bool);
}

function getFormattedDate()
{
    var date = new Date();
    return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + " @ " +  add_leading_zeros(date.getHours()) + ":" + add_leading_zeros(date.getMinutes()) + ":" + add_leading_zeros(date.getSeconds());
}

function add_leading_zeros(digit)
{
    return (digit < 10 ? '0' : '') + digit;
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