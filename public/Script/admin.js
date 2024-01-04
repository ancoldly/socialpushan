function adminDeleteUser(userId) {
    if (confirm("Are you sure you want to delete this account?")) {
        $.ajax({
            url: "/admin/deleteUser/" + userId,
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                location.reload();
                alert(response.message);
            },
            error: function (error) {
                console.log(error);
            },
        });
    }
}

function adminDeletePost(postId) {
    console.log(postId);
    if (confirm("Are you sure you want to delete this account?")) {
        $.ajax({
            url: "/admin/deletePost/" + postId,
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                location.reload();
                alert(response.message);
            },
            error: function (error) {
                console.log(error);
                alert("Error delete post");
            },
        });
    }
}

const myBtns = document.querySelectorAll(".myBtn");


$(document).on('click', function (event) {
    if (!$(event.target).closest(".details-post").length) {
        $(".details-post").addClass('hidden').removeClass('grid');
    }
});


for (const myBtn of myBtns) {
    myBtn.addEventListener("click", function () {
        var postId = myBtn.value;
        $.ajax({
            url: "/admin/showDetailPost?key=" + postId,
            type: "GET",
            success: function (res) {
                var html = "";
                res.forEach((e) => {
                    e.map((a) => {
                        var html = `
                        <div class="details-post border-[3px] p-[20px] rounded-[10px] border-mainColors relative h-[500px] overflow-y-scroll scroll-container">
                            <i class='bx bx-x-circle absolute top-0 right-0 text-[30px] cursor-pointer close text-red-500'></i>
                            <div class="grid items-start gap-[20px]">
                                <div class="grid gap-[20px]">
                                    <div class="flex items-center gap-[10px]">
                                    <img src="${a.user.avatar ? a.user.avatar : '/image/user.png'}" class="w-[50px] h-[50px] rounded-full" alt="">
                                        <div>
                                            <h1 class="font-medium">${a.user.name}</h1>
                                            <span class="text-gray-500 text-[14px]">2023-12-08 00:05:35</span>
                                        </div>
                                    </div>

                                    <div class="grid gap-[10px] w-[500px]">
                                    <p>${a.content ? a.content : ''}</p>
                                        <img src="/${a.image_url}" alt="" class="rounded-[10px]">
                                    </div>

                                    <div class="flex items-center justify-between border-t-[2px] border-b-[2px] py-[10px]">
                                        <p class="font-medium">${a.likes.length} Like</p>
                                        <p class="font-medium">${a.comments.length} Comments</p>
                                    </div>
                                </div>

                                <div class="grid gap-[10px]">
                                    ${a.comments.map(b => `
                                        <div class="flex items-center gap-[10px]">
                                            <div class="flex items-center">
                                                <img src="${b.user.avatar ? b.user.avatar : '/image/user.png'}" class="w-[50px] h-[50px] rounded-full" alt="">
                                            </div>

                                            <div class="w-[300px] bg-gray-100 p-[10px] rounded-[10px]">
                                                <div>
                                                    <h1 class="font-medium">${b.user.name}</h1>
                                                     <span class="text-gray-500 text-[14px]">2023-12-08 00:05:35</span>
                                                </div>
                                                <p>${b.content}</p>
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `;
                        $(".modal-content").html(html);
                    });
                });

                $(".details-post").addClass('grid')
                var span = document.getElementsByClassName("close")[0];
                span.onclick = function () {
                    $(".details-post").addClass('hidden').removeClass('grid');
                };
            },
        });
    });
}

