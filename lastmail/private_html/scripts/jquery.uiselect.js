/**
 * Use this however you feel.  If you have improvement, please
 * let me know.
 *
 * @example $('.select-wrapper).uiselect();
 * @requires jquery ui javascript and css
 *
 * @author Will Smelser (willsmelser@gmail.com)
 */
(function( $ ){

/**
 * @param classNameOrAction <string> Optional class name applied to select wrapper.
 */
jQuery.fn.uiselect = function(classNameOrAction, fn){
	if(typeof classNameOrAction === 'undefined')
		classNameOrAction = 'ui-select';

	if(classNameOrAction === 'widget')
		return $(this).parent().find('input').autocomplete('widget');

	if(classNameOrAction.match(/^(autocomplete)/))
		if(typeof fn === 'function')
			return $(this).parent().find('input').on(classNameOrAction, fn);
		else
			return $(this).parent().find('input').autocomplete(fn);

	return this.each(function(index,el){
		switch(classNameOrAction){
		case 'refresh':
			break;
		default:
			//create the dom elements needed
			var $div = $(document.createElement('div')).addClass(classNameOrAction);
			var $span = $(document.createElement('span')).addClass('ui-spinner ui-widget ui-widget-content ui-corner-all');
			var $input= $(document.createElement('input'));
			var $a    = $(document.createElement('a')).addClass('ui-spinner-button ui-spinner-down ui-state-default ui-corner-right');
			var $aspan= $(document.createElement('span')).addClass('ui-button-text');
			var $asspan=$(document.createElement('span')).addClass('ui-icon ui-icon-triangle-1-s');
			$a.append($aspan.append($asspan));
			$(this).wrap($div);
			$(this).before($span.append($input).append($a));
		}

		$(this).each(function(){
			var data = [];
			var $select = $(this).hide();

			//gather data
			$select.children().each(function(){
				data.push({label:$(this).html(),value:$(this).attr('value')});
			});

			var $input = $select.siblings().find('input').val($select.find(':selected').text());

			if(classNameOrAction === 'refresh')
				$input.autocomplete('destroy');

			$input.autocomplete({source: data, delay: 0, minLength: 0});

			var show = function(){
				$input.autocomplete("search","");
				$input.focus();
				$select.trigger('click');
			};

			//the drop down button
			$select.siblings().find('a.ui-spinner-button').click(show);

			//remove the ability to focus on input
			$input.click(show)

			//handle the autocomplete select
			.on("autocompleteselect",
				function(evt,ui){
					if(ui.item.value != $select.val()){
						$input.val(ui.item.label);
						$select.val(ui.item.value);
						$select.trigger('change');
					}
					return false;
				});

			var first = true;

			var key = function(evt){
				$(this).val($select.find(':selected').html());

				//enter or esc
				if(evt.keyCode == 13 || evt.keyCode == 27){
					first = true;
					return;
				}

				//up or down
				if((evt.keyCode == 38 || evt.keyCode == 40)){
					if(first) first = false;
					//default autocomplete action
					else{ return;}
				}
				$input.autocomplete("search","");
			};
			$input.keydown(key).keyup(key).keypress(key);
		});

	});
};
})( jQuery );