import * as Modal from "../Modal.js";
import { t } from "../Translator.js";
import * as ButtonLoad from "../ButtonLoad.js";

export const init = async () => {
    Modal.init();

    const translations = await Promise.all([
        t("Delete animation"),
        t("Do you really want to delete this animation?"),
        t("Delete")
    ]);

    const colorInputContainer = document.querySelector("#color-inputs");
    colorInputContainer.addEventListener("click", (event) => {
        if(event.target.closest(".remove-color-button") && colorInputContainer.children.length > 1) {
            const colorInput = event.target.closest(".color-input-group");
            colorInput.remove();
        }
    });

    const addColorButton = document.querySelector("#add-color-button");
    if(addColorButton !== null) {
        addColorButton.addEventListener("click", () => {
            const template = document.getElementById(addColorButton.getAttribute("data-template"));
            const copy = template.cloneNode(true);
            copy.removeAttribute("id");
            copy.querySelector("input").setAttribute("name", "colors[]");

            colorInputContainer.appendChild(copy);
            copy.classList.remove("hidden");
        });
    }

    const deleteButton = document.querySelector("#delete-animation");
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
