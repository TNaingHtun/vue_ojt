$(document).ready(function() {
    $("#post-list").dataTable({
        paging: false,
        info: false
    });

    const postsTable = $("#post-list").DataTable();
    console.log(postsTable);

    $("#search-button").click(function() {
        postsTable.search($("#search-text").val()).draw();
    });
});

function showPostDetail(postInfo) {
    console.log(postInfo.created_at);
    $("#post-detail #post-title").text(postInfo.title);
    $("#post-detail #post-description").text(postInfo.description);

    $("#post-detail #post-created-at").text(
        moment(postInfo.created_at).format("DD/MM/YYYY")
    );
}

function deletePostDetail(postInfo) {
    $("#post-delete #post-id").text(postInfo.id);
    $("#post-delete #post-title").text(postInfo.title);
    $("#post-delete #post-description").text(postInfo.description);

    $("#post-delete #post-created-at").text(
        moment(postInfo.created_at).format("DD/MM/YYYY")
    );
}

async function deletePostById(csrf_token) {
    console.log($("#post-delete #post-id").text());
    var id = $("#post-delete #post-id").text();
    var route = "/posts/delete/" + id;
    await $.ajax({
        url: route,
        type: "POST",
        data: {
            _token: csrf_token,
            _method: "DELETE"
        },
        dataType: "text",
        success: function(result) {
            console.log(result);
            location.reload();
        }
    });
}