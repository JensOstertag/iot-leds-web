import * as Modal from "../Modal.js";
import { t } from "../Translator.js";
import * as ButtonLoad from "../ButtonLoad.js";

export const init = async () => {
    Modal.init();

    const translations = await Promise.all([
        t("Delete user"),
        t("Do you really want to delete this user?"),
        t("Delete")
    ]);

    const deleteButton = document.querySelector("#delete-user");
    if(deleteButton !== null) {
        deleteButton.addEventListener("click", () => {
            Modal.open({
                title: translations[0],
                text: translations[1],
                confirm: translations[2]
            }, (confirm) => {
                if(confirm) {
                    ButtonLoad.load(deleteButton);
                    window.location.href = deleteButton.getAttribute("data-delete-href");
                }
            });
        });
    }
}

export default { init };
