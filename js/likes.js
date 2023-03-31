$(document).ready(function () {
    // When the like button is clicked
    $('.like-btn').click(function (event) {
        event.preventDefault();
        var post_id = $(this).data('post-id');
        var action = 'like';
        $.ajax({
            url: 'likes.php',
            type: 'post',
            data: { post_id: post_id, action: action },
            success: function (response) {
                // Update the number of likes
                $('.likes-count[data-post-id=' + post_id + ']').html(response);
                // Hide the like button and show the unlike button
                $('.like-btn[data-post-id=' + post_id + ']').hide();
                $('.unlike-btn[data-post-id=' + post_id + ']').show();
            }
        });
    });

    // When the unlike button is clicked
    $('.unlike-btn').click(function (event) {
        event.preventDefault();
        var post_id = $(this).data('post-id');
        var action = 'unlike';
        $.ajax({
            url: 'likes.php',
            type: 'post',
            data: { post_id: post_id, action: action },
            success: function (response) {
                // Update the number of likes
                $('.likes-count[data-post-id=' + post_id + ']').html(response);
                // Hide the unlike button and show the like button
                $('.unlike-btn[data-post-id=' + post_id + ']').hide();
                $('.like-btn[data-post-id=' + post_id + ']').show();
            }
        });
    });
});

