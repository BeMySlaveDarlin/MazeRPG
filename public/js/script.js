$(document).ready(function () {
    $( ".auth-form" ).submit(function(e)
    {
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        if (confirm('Continue?'))
        {
            $.ajax({
                type: "POST",
                url: "/ajax",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response)
                {
                    if(response.status === 'success')
                    {
                        alert(response.message);
                        $('.auth-board').remove();
                        $('.board-actions').html(
                            '<div class="refresh-button">Refresh</div>' +
                            '<div class="reset-button">Full reset</div>'
                        );
                        $('.playboard').html(response.board);
                        $('#username').text(response.user.username);
                    }else{
                        console.log(response);
                        alert(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorMessage) {
                   console.log(errorMessage);
                }
            });
        }
    });

    $(document).on('click','.action-active', function(){
        var direction = $(this).attr('direction');
        var action = $(this).attr('action');

        $.ajax({
            url: "/ajax",
            type: 'POST',
            data: {
                'direction' : direction,
                'action' : action,
                'mode' : 'setAction'
            },
            success: function(response){
                if(response.status === 'success')
                {
                    $('.playboard').html(response.board);
                    $('#level').text("LVL: " + response.user.level);
                    $('#room').text("ROOM: " + response.user.room);
                    $('.health-bar').text(response.user.health_value);
                    $('.attack-bar').text(response.user.attack_value);
                    $('.boss-bar').text(response.user.boss_count);
                    $('.points-bar').text(response.user.points);
                }else{
                    console.log(response);
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorMessage) {
               console.log(errorMessage);
            }
        });
    });

    $(document).on('click','.refresh-button', function(){

        $.ajax({
            url: "/ajax",
            type: 'POST',
            data: {
                'mode' : 'setRefresh'
            },
            success: function(response){
                if(response.status === 'success')
                {
                    $('.playboard').html(response.board);
                }else{
                    console.log(response);
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorMessage) {
               console.log(errorMessage);
            }
        });
    });

    $(document).on('click','.reset-button', function(){

        $.ajax({
            url: "/ajax",
            type: 'POST',
            data: {
                'mode' : 'setReset'
            },
            success: function(response){
                if(response.status === 'success')
                {
                    alert(response.message);
                    location.reload();
                }else{
                    console.log(response);
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorMessage) {
               console.log(errorMessage);
            }
        });
    });
});
