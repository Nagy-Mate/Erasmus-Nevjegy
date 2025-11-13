emailjs.init("7FLSkJKbCg6jSUBeu");

const form = document.getElementById("contact-form");
const senderName = document.getElementById("user_name");
const senderEmail = document.getElementById("user_email");
const content = document.getElementById("message");
const status = document.getElementById("form-status");

form.addEventListener("submit", function (e) {
  e.preventDefault();
  emailjs
    .sendForm("service_66wc4fj", "template_5yzxe7a", form)
    .then(() => {
      status.textContent = "✅ Üzeneted sikeresen elküldve!";
      status.style.color = "#00ffb3";
      form.reset();
    })
    .catch((e) => {
      status.textContent = "❌ Hiba történt az üzenet küldése közben.";
      status.style.color = "#ff6b6b";
    });
});
