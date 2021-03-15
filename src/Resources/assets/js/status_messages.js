(function () {
	var StatusMessages = {
		init: function() {
			StatusMessages.addMessagesToGlobalModule();
		},
		addMessagesToGlobalModule : function() {
			var messages = document.querySelectorAll('.mod_status_messages'),
				globalMessages = document.querySelector('.mod_status_messages.global');


			// var $messages = $('.mod_status_messages'),
			// 	$globalMessages = $('.mod_status_messages.global');

			if (null !== globalMessages)
			{
				if (window.NodeList && !NodeList.prototype.forEach) {
					NodeList.prototype.forEach = Array.prototype.forEach;
				}
				messages.forEach((message) => {
					var type = message.getAttribute('class').match(/msg-[^\s]+/)[0].replace('msg-', ''),
						hasClassName = 'has-' + type,
						additionalClasses = message.getAttribute('class').replace('msg-' + type, '');

					if (globalMessages.querySelectorAll('.msg-' + type + ':contains("' + message.textContent + '")').length < 1) {

						if (!globalMessages.classList.contains(hasClassName))
							globalMessages.classList.add(hasClassName);

						globalMessages.insertBefore(message, globalMessages.firstChild);
					}
				});
			}
		}
	};

	if (document.readyState != 'loading'){
		StatusMessages.init();
	} else {
		document.addEventListener('DOMContentLoaded', StatusMessages.init);
	}
})();