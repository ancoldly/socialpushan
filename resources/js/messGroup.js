import "./bootstrap";
import moment from "moment";

const roomGroup_id = document.getElementById("roomGroup_id").value;
const createGroup_id = document.getElementById("createGroup_id").value;

Echo.channel("chatGroup." + roomGroup_id).listen(
    "MessageGroupChat",
    (event) => {
        const formattedTime = moment(event.created_at).format(
            "YYYY-MM-DD HH:mm:ss"
        );

        const messageContainer = document.createElement("div");
        messageContainer.className = "mb-4";

        const innerContent = `
        <div class="flex justify-star items-end gap-[10px] message-result">
            <img src="${
                event.avatar ? event.avatar : "/image/user.png"
            }" class="w-[35px] h-[35px] rounded-full" alt="">
            <div class="p-[10px] rounded-[10px] bg-blue-100 max-w-[500px] h-max">
                <span class="font-medium flex items-center gap-[5px]">
                ${event.name}
                ${
                    event.user_id == createGroup_id
                        ? '<i class="bx bxs-group text-[20px] text-blue-500"></i>'
                        : ""
                }
                </span>
                <p>${event.message ? event.message : ''}</p>
                ${
                    event.image
                        ? `<img src="${event.image}" alt="" class="w-[250px] my-[10px] rounded-[10px]">`
                        : ""
                }
                <p class="text-[14px] font-medium text-gray-500">${formattedTime}</p>
            </div>
        </div>
    `;

        const ipMessage = document.getElementById("message");
        ipMessage.value = "";
        const ipFile = document.getElementById('image');
        ipFile.value = '';

        const image_preview = document.getElementById("image-preview");
        image_preview.classList.add("hidden");
        image_preview.classList.remove("flex");

        messageContainer.innerHTML = innerContent;

        const chatMessagesDiv = document.getElementById("chat-messages");
        chatMessagesDiv.appendChild(messageContainer);

        const container_message = document.getElementById("container-message");
        container_message.scrollTop = container_message.scrollHeight;
    }
);
