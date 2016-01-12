(function ($) {

	var StatusMessages = {
		init: function() {
			StatusMessages.addMessagesToGlobalModule();
		},
		addMessagesToGlobalModule : function() {
			var $messages = $('.mod_status_messages'),
				$globalMessages = $('.mod_status_messages.global');

			if ($globalMessages.length > 0)
			{
				$messages.each(function() {
					var $this = $(this);

					$this.find('[class*="msg-"]').each(function() {
						var $message = $(this),
							type = $message.attr('class').match(/msg-[^\s]+/)[0].replace('msg-', ''),
							hasClassName = 'has-' + type,
							additionalClasses = $message.attr('class').replace('msg-' + type, '');

						if ($globalMessages.find('.msg-' + type + ':contains("' + $message.text() + '")').length <= 0)
						{
							if (!$globalMessages.hasClass(hasClassName))
								$globalMessages.addClass(hasClassName);

							// commented due to formhybrid
							//if (!$globalMessages.hasClass(additionalClasses))
							//	$globalMessages.addClass(additionalClasses);

							$globalMessages.prepend($message);
						}
					});
				});
			}
		}
	};


	$(document).ready(function () {
		StatusMessages.init();
	});

})(jQuery);