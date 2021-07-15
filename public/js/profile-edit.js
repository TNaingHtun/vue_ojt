$(document).ready(function() {
    $('#clearBtn').click(function() {
        $('#name').val('');
        $('#email').val('');
        $('#phone').val('');
        $('#dob').val('');
        $('#address').val('');
        $('#profile').val('');
        $('#img-preview').css({
            display: 'none'
        });
    });
});