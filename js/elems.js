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

Radio = (function(){
	Radio.prototype.obj;

	function Radio(obj){
		this.obj = obj;

		radio = $('<div></div>');

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
			radio.append(label);
		}

		return radio;
	}

	Radio.prototype.attrs = function(){
		// TODO
		console.log(this);
	}

	return Radio;
})();

Select = (function(){
	Select.prototype.obj;

	function Select(obj){
		this.obj = obj;

		div = $('<div></div>');
		select = $('<select></select>');

		length = obj.options.length;
		for(i = 0; i < length; i++){
			option = $('<option></option>')
						.attr('value', 'option-' + obj.options[i].elementoption_id)
						.attr('selected', obj.options[i].default == '1' ? true : false)
						.text(obj.options[i].value)
						;
			select.append(option);
		}

		return div.append(select);
	}

	Select.prototype.attrs = function(){
		// TODO
	}

	return Select;
})();

Multiple = (function(){
	Multiple.prototype.obj;
	
	function Multiple(obj){
		this.obj = obj;

		multiple = $('<div></div>');

		length = obj.options.length;
		for(i = 0; i < length; i++){
			label = $('<label></label>');
			box = $('<input/>')
						.attr('type', 'checkbox')
						.attr('name', 'elem-' + obj.id)
						.attr('value', 'option-' + obj.options[i].elementoption_id)
						.attr('checked', obj.options[i].default == '1' ? true : false)
						;
			label.append(box).append(obj.options[i].value);
			multiple.append(label);
		}

		return multiple;
	}

	Multiple.prototype.attrs = function(){
		// TODO
	}

	return Multiple;
})();

Element = (function(){
	Element.prototype.element;
	Element.prototype.obj;

	function Element(obj, id){
		console.log('new Element');
		this.obj = obj;

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
			case 7:
				element = obj.big ? new Select(obj) : new Radio(obj);
				// console.log(typeof element);
				(new Radio(obj)).attrs();
				break;
			case 8:
				element = new Multiple(obj);
				break;
		}

		this.element = element;
		this.attrs();

		container = new Container(obj);

		container.append(element).appendTo(id);
	}

	Element.prototype.attrs = function() {
		switch(parseInt(this.obj.type)){
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
				this.element = this.attrs1();
			case 7:
			case 8:
				//this.element = this.element.attrs();
		}
	};

	Element.prototype.attrs1 = function(){// caca TODO rename
		obj = this.obj;
		return this.element
					.attr('id', 'elem-' + obj.id)
					.attr('placeholder', obj.placeholder)
					.attr('required', obj.required)
					.css('width', obj.width + 'px')
					;
	}

	Element.prototype.answers = function(answers) {
		get = typeof answers == 'undefined';
		res = '';

		switch(parseInt(this.obj.type)){
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
				res = get ? this.getAnswers() : this.setAnswers();
			case 7:
			case 8:
				res = get ? this.element.getAnswers() : this.element.setAnswers();
		}

		return res;	
	};

	return Element;
})();