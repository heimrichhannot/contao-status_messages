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
							hasClassName = 'has-' + $message.attr('class').replace('msg-', '');

						if ($globalMessages.find('.' + $message.attr('class') + ':contains(' + $message.text() + ')').length <= 0)
						{
							if (!$globalMessages.hasClass(hasClassName))
								$globalMessages.addClass(hasClassName);

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