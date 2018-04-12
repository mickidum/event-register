jQuery(document).ready(function($) {
    $('.htmllinks').on('click', 'a', function(event) {
        event.preventDefault();
        $('#popup').show();
        $('.loading').show();
        $('#event_c_name').html($(this).attr('id'));
        $.get('html/' + $(this).attr('id'), function(data) {
            setTimeout(function(){
                $('.loading').fadeOut();
                $('#popup table').html(data + '</tbody>');
            }, 200);
            
            
        });
    });
    $('body').on('click', '.closebtn', function(event) {
        event.preventDefault();
        $('#popup').hide();
    });

    $('body').on('click', '.old-lists-btn', function(event) {
        event.preventDefault();
        $('.show-hide').fadeIn();
    });

    $('body').on('click', '.closebtnall', function(event) {
        event.preventDefault();
        $('.show-hide').hide();
        $('#popup').hide();
    });
});