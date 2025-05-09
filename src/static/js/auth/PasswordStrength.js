export const init = (elementId) => {
    const pwStrength = passwordStrength;

    const element = document.getElementById(elementId);
    if(!element) {
        return;
    }

    element.addEventListener("input", () => {
        const text = element.value;

        // Calculate strength
        const passwordStrengthBar = document.getElementById("password-strength-indicator-bar");
        let passwordStrength = pwStrength(text);
        if(passwordStrength < 40) {
            passwordStrengthBar.setAttribute("data-strength", "0");
        } else if(passwordStrength < 65 ) {
            passwordStrengthBar.setAttribute("data-strength", "1");
        } else {
            passwordStrengthBar.setAttribute("data-strength", "2");
        }
        if(passwordStrength < 5) {
            passwordStrength = 5;
        }
        passwordStrengthBar.style.width = passwordStrength + "%";

        document.querySelectorAll(".password-requirement").forEach((requirement) => {
            const regex = new RegExp(requirement.getAttribute("data-regex"));
            if(regex.test(text)) {
                requirement.setAttribute("data-met", "true");
            } else {
                requirement.removeAttribute("data-met");
            }
        });
    });
}

export const passwordStrength = (password) => {
    if(password.length <= 3) {
        return 0;
    }

    let passwordKnown = false;
    const knownPasswords = [
        "password", "passwort", "123456", "654321", "qwertz", "abc"
    ];
    knownPasswords.forEach((knownPassword) => {
        if(password.toLowerCase().includes(knownPassword)) {
            passwordKnown = true;
        }
    });
    if(passwordKnown) {
        return 0;
    }

    const uppercaseWeight = 7.5;
    const lowercaseWeight = 7.5;
    const digitWeight = 10;
    const specialCharWeight = 10;
    const allCharTypesWeight = 5;
    const lengthWeight = 20;
    const unpredictabilityWeight = 20;

    const hasUppercase = /[A-Z]/.test(password);
    const uppercaseScore = (hasUppercase ? uppercaseWeight : 0);
    const hasLowercase = /[a-z]/.test(password);
    const lowercaseScore = (hasLowercase ? lowercaseWeight : 0);
    const hasDigit = /\d/.test(password);
    const digitScore = (hasDigit ? digitWeight : 0);
    const hasSpecialChar = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(password);
    const specialCharScore = (hasSpecialChar ? specialCharWeight : 0);
    const allCharTypesScore = (hasUppercase && hasLowercase && hasDigit && hasSpecialChar ? allCharTypesWeight : 0);

    const lengthScore = password.length >= 8 ? Math.min(1, (password.length / 12)) * lengthWeight : 0;

    let unpredictability = 0;
    for(let i = 1; i < password.length; i++) {
        if(Math.abs(password.charCodeAt(i) - password.charCodeAt(i - 1)) > 1) {
            unpredictability++;
        }
    }
    unpredictability = unpredictability / password.length;
    if(unpredictability < .6) {
        unpredictability = 0;
    }
    if(unpredictability > .95) {
        unpredictability = 1;
    }
    const unpredictabilityScore = unpredictability * unpredictabilityWeight;

    const totalScore =
        uppercaseScore + lowercaseScore + digitScore + specialCharScore + allCharTypesScore +
        lengthScore +
        unpredictabilityScore;

    const securityPercentage = (totalScore / (
        uppercaseWeight + lowercaseWeight + digitWeight + specialCharWeight + allCharTypesWeight +
        lengthWeight +
        unpredictabilityWeight
    )) * 100;

    return Math.min(100, securityPercentage);
}

export default { init, passwordStrength };
