$(document).ready(function() {


    $(window).on("unload", function(e) {
        saveSettings();
    });

    loadSettings();

    $('#submit').click(function() {

        changeSubmitState(true)

        $( "#form :input" ).each(function() {

            if (this.value === "" && this.id !== "submit") {

                var message = "Please set a " + this.id;

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: message,
                });

                changeSubmitState(false)

                throw message;
            }
        });

        if ($("#amount").val() > 10) {

            var message = "Cannot send more than 10 events at once.";

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            });

            changeSubmitState(false)

            throw message;
        }

        $.post( "/", $( "#form :input" ).serialize())
        .done(function( data ) {

            data = JSON.parse(data);

            data.forEach(function (payload) {

                $('#console').prepend("Payload sent with topic '" + $('#topic').val() + "' and broker '" + $('#broker').val() + "' on " + getFormattedDate() + "<br>" + payload + "<br><br>");
            });

            changeSubmitState(false)

        }).fail(function(e) {

            console.log(e);

            changeSubmitState(false)
        });

        saveSettings();
    });

    $("html").on('click', '.topic-name' ,function(e) {

        e.preventDefault();

        console.log("hit");

        loadTopic($(this).html());
    });

});

function loadSettings() {

    var height = $("#send_event").css("height");
    $("#topics").css("max-height",height);
    $("#topics").css("height",height);
    $("#console").css("max-height",height);

    $('#topic').val(localStorage.topic);
    $('#broker').val(localStorage.broker);
    $('#payload').val(localStorage.payload);
    $('#amount').val(localStorage.amount);

    if(localStorage.topics){
        var topics =  JSON.parse(localStorage.topics);
    }else{
        var topics = [];
    }
    for(i=0;i<topics.length;i++){
        $('#topics').append("<tr><td><a href='#' class='topic-name'>" + topics[i] + "</a></td><</tr>");
    }

    dtable();

}

function dtable() {
    $("#basic-datatable").DataTable(
        {"aLengthMenu": [[5, 10, 15, 20], [5, 10, 15, 20]],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}
    );
}

function loadTopic(topic) {
    $('#topic').val(localStorage['t_' + topic]);
    $('#broker').val(localStorage['b_' + topic]);
    $('#payload').val(localStorage['p_' + topic]);
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

function changeSubmitState(bool)
{
    var submit = $("#submit");

    if(bool) {
        submit.html("Processing...");
    } else {
        submit.html("Submit");
    }

    submit.prop("disabled",bool);
}

function saveSettings()
{
    var broker = $('#broker').val();
    var topic = $('#topic').val();
    var payload = $('#payload').val();
    var amount = $("#amount").val();

    if (localStorage.topics) {

        var topics =  JSON.parse(localStorage.topics);
    } else {

        var topics = [];
    }

    if (topics.indexOf(topic) === -1) {

        topics.push(topic);

        var table = $("#basic-datatable").DataTable();
        table.destroy();
        $('#topics').append("<tr><td><a href='#' class='topic-name'>" + topic + "</a></td><</tr>");
        dtable()
    }

    localStorage.topics = JSON.stringify(topics);
    localStorage.broker = broker;
    localStorage.topic = topic;
    localStorage.payload = payload;
    localStorage.amount = amount;

    localStorage['t_' + topic] = topic;
    localStorage['b_' + topic] = broker;
    localStorage['p_' + topic] = payload;
}