let first_page_limit = 160
let other_pages_limit = 154
let pages = 1;
let remaining;
let total_char;

function get_length(page, char_length) {
    let length = char_length;
    let difference = 0;

    if(length > first_page_limit) {
        difference = length - first_page_limit
    }

    let total_difference = (page * other_pages_limit) - first_page_limit

    let new_length = total_difference - difference

    let new_remaining = other_pages_limit - Math.abs(new_length)

    return new_remaining
}

$("#message").on("keyup", function(e) {
    const message = this.value;

    if(pages > 1)  {
        let length = total_char + message.length

        if(remaining !== other_pages_limit) {
            remaining = length - first_page_limit
        }

        let difference = 0;

        for(let i = 0; i < pages; i++) {
            if(pages > 1) {
                
                if(remaining < other_pages_limit) {
                    difference = other_pages_limit - remaining
                } else {
                    let new_typed_length = other_pages_limit - get_length(pages, message.length)
                    difference = new_typed_length;
                }
            }
        }

        
        remaining = other_pages_limit - Math.abs(difference);
        if(remaining >= 1 && pages > 1) {
            const limit = other_pages_limit - get_length(pages, message.length)
            remaining = limit
        }

        if(remaining == 0) {
            const new_remaining = other_pages_limit - Math.abs(remaining)
            remaining = new_remaining
            pages++
        }

        $("#pageMessage").text(`You have ${remaining} characters left on this page ${pages}`)
        $("#current_page").val(pages)
    } else {
        if(message.length < first_page_limit) {
            remaining = first_page_limit - message.length
            pages = 1
        } else if(message.length === first_page_limit) {
            total_char = first_page_limit;
            remaining = 0
            pages++
        }
        $("#pageMessage").text(`You have ${remaining} characters left on this page ${pages}`)
        $("#current_page").val(pages)
    }
})