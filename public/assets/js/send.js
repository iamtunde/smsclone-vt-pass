$("#sendMessage").on("submit", function(e) {
    e.preventDefault();
    const csrf_token = document.head.querySelector("[name~=csrf-token][content]").content;

    const formData = new FormData(this)

    const endpoint = $("#sendMessage").attr("action")

    $.ajax({
        url: endpoint,
        type: "POST",
        data: formData,
        headers: {"X-CSRF-Token": csrf_token},
        processData: false,
        contentType: false,
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        },
        success: function(response) {
            $('#billSummaryModal').modal('show')
            $("#total_cost").html("&#x20A6;" + response.data.total_cost)
            $("#total_numbers").text(response.data.total_numbers)
            $("#total_pages").text(response.data.total_pages)
        }
    })
})