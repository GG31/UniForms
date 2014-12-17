Container = (function(){
	function Container(obj){
		console.log(' --- new Container');

		container = $('<div></div>')
						.attr('id', 'container-' + obj.id)
						.css('position', 'relative')
						.css('top', obj.x + 'px')
						.css('left', obj.y + 'px')
						;

		label = $('<label></label>')
						.attr('for', 'elem-' + obj.id)
						.text(obj.label);

		return container.append(label);
	}

	return Container;
})();

Unique = (function(){
	function Unique(obj){
		unique = '';
		if(obj.big)
			unique = this.select(obj);
		else
			unique = this.radio(obj);

		return unique;
	}

	Unique.prototype.radio = function(obj) {
		div = $('<div></div>');

		length = obj.options.length;
		for(i = 0; i < length; i++){
			label = $('<label></label>');
			input = $('<input/>')
						.attr('type', 'radio')
						.attr('name', 'elem-' + obj.id)
						.attr('value', 'option-' + obj.options[i].elementoption_id)
						.attr('checked', obj.options[i].default == '1' ? true : false)
						;
			label.append(input).append(obj.options[i].value);
			div.append(label);
		}

		return div;
	};

	return Unique;
})();

Element = (function(){
	function Element(obj, id){
		console.log('new Element');

		element = '';
		switch(parseInt(obj.type)){
			case 1:
				element = $('<input/>').attr('type', 'text');
				break;
			case 2:
				element = $('<input/>').attr('type', 'number');
				break;
			case 3:
				element = $('<input/>').attr('type', 'date');
				break;
			case 4:
				element = $('<input/>').attr('type', 'time');
				break;
			case 5:
				element = $('<input/>').attr('type', 'tel');
				break;
			case 6:
				element = $('<textarea></textarea>').attr('height', obj.height + 'px');
				break;
			case 7:// TODO pb w/ global attrs
				element = new Unique(obj);
				break;
			default:
				element = $('<input/>').attr('type', 'text');
				break;
		}

		// TODO 'global' attrs here ! ou pas (textarea)
		element
			.attr('id', 'elem-' + obj.id)
			.attr('placeholder', obj.placeholder)
			.attr('required', obj.required)
			.css('width', obj.width + 'px')
			;
		container = new Container(obj);

		container.append(element).appendTo(id);
	}

	return Element;
})();