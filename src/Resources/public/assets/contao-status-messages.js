!function(){var t;t={init:function(){t.addMessagesToGlobalModule()},addMessagesToGlobalModule:function(){var t=document.querySelectorAll(".mod_status_messages"),e=document.querySelector(".mod_status_messages.global");null!==e&&(window.NodeList&&!NodeList.prototype.forEach&&(NodeList.prototype.forEach=Array.prototype.forEach),t.forEach((function(t){var o=t.getAttribute("class").match(/msg-[^\s]+/)[0].replace("msg-",""),s="has-"+o;t.getAttribute("class").replace("msg-"+o,""),e.querySelectorAll(".msg-"+o+':contains("'+t.textContent+'")').length<1&&(e.classList.contains(s)||e.classList.add(s),e.insertBefore(t,e.firstChild))})))}},"loading"!=document.readyState?t.init():document.addEventListener("DOMContentLoaded",t.init)}();