src="https://code.jquery.com/jquery-1.12.4.js";
src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js";

fetch_user();

function fetch_user() {
        var action = 'fetch_user';
        $.ajax({
            url: "action.php",
            method: "POST",
            data: {action: action},
            success: function (data) {
                $('#user_list').html(data);
            }
        });
    }

    $(document).on('click', '.action_button', function(){
        var following_id = $(this).data('following_id');
        var action = $(this).data('action');
        $.ajax({
            url:"action.php",
            method:"POST",
            data:{following_id:following_id, action:action},
            success:function(data)
            {
                fetch_user();
            },
            error:function () {
                alert("Request Failed");
            }
        })
    });