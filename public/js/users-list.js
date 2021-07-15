$(document).ready(function() {
    $.fn.dataTableExt.afnFiltering.push(
        function(oSettings, aData, iDataIndex) {
            if (!$("#dateStart").val() && !$("#dateEnd").val()) {
                return true;
            }
            console.log(aData);
            var dateStart = moment($("#dateStart").val(), "YYYY-MM-DD").valueOf();
            var dateEnd = moment($("#dateEnd").val(), "YYYY-MM-DD").valueOf();
            var date = moment(aData[7], "YYYY/MM/DD").valueOf();
            if (date >= dateStart && date <= dateEnd) {
                return true;
            } else {
                return false;
            }
        });

    $("#user-list").dataTable({
        paging: false,
        info: false
    });

    const usersTable = $("#user-list").DataTable();
    console.log(usersTable);

    $("#search-button").click(function() {
        usersTable
            .columns(0)
            .search($("#search-name").val())
            .columns(1)
            .search($("#search-email").val())
            .draw();
    });
});


function showUserDetail(userInfo) {
    console.log(userInfo);
    $("#user-detail #user-name").text(userInfo.name);
    if (userInfo.type == "0") {
        $("#user-detail #user-type").text("Admin");
    } else {
        $("#user-detail #user-type").text("User");
    }
    $("#user-detail #user-email").text(userInfo.email);
    $("#user-detail #user-phone").text(userInfo.phone);
    $("#user-detail #user-dob").text(moment(userInfo.dob).format("YYYY/MM/DD"));
    $("#user-detail #user-address").text(userInfo.address);

    $("#user-detail #user-created-at").text(
        moment(userInfo.created_at).format("YYYY/MM/DD")
    );
    $("#user-detail #user-created-user").text(userInfo.created_user);
    $("#user-detail #user-updated-at").text(
        moment(userInfo.updated_at).format("YYYY/MM/DD")
    );
    $("#user-detail #user-updated-user").text(userInfo.updated_user);
}

function showDeleteConfirm(userInfo) {
    $("#user-delete #user-id").text(userInfo.id);
    $("#user-delete #user-name").text(userInfo.name);
    if (userInfo.type == "0") {
        $("#user-delete #user-type").text("Admin");
    } else if (userInfo.type == "1") {
        $("#user-delete #user-type").text("User");
    } else {
        $("#user-delete #user-type").text("Visitor");
    }
    $("#user-delete #user-email").text(userInfo.email);
    $("#user-delete #user-phone").text(userInfo.phone);
    $("#user-delete #user-dob").text(userInfo.dob);
    $("#user-delete #user-address").text(userInfo.address);
}

function deleteUserById(csrf_token) {
    console.log($("#user-delete #user-id").text());
    var id = $("#user-delete #user-id").text();
    var route = "/users/delete/" + id;
    $.ajax({
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