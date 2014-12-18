Container = (function(){
	function Container(obj){
		container = $('<div></div>')
						.attr('id', 'container-' + obj.id)
						.css('position', 'relative')
						.css('top', obj.x + 'px')
						.css('left', obj.y + 'px')
						;

		label = $('<label></label>')
						.attr('for', 'elem-' + obj.id)
						.text(obj.label);

		// ! : this 'class' returns a jQuery object !
		return container.append(label);
	}

	return Container;
})();

Radio = (function(){
	Radio.prototype.obj;
	Radio.prototype.element;

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

		this.element = radio;
	}

	Radio.prototype.attrs = function(){
		// TODO
		return this;
	}

	Radio.prototype.get = function(){
		return this.element;
	}

	Radio.prototype.getAnswers = function(){
		return this.element.find(':checked').val();
	}

	Radio.prototype.setAnswers = function(answer){// answer is option id ?
		this.element.find('input')
						.prop('checked', false)
					.filter('input[value=option-' + answer + ']')
						.prop('checked', true);
	}

	return Radio;
})();

Select = (function(){
	Select.prototype.obj;
	Select.prototype.element;

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

		this.element = div.append(select);
	}

	Select.prototype.attrs = function(){
		// TODO
		return this;
	}

	Select.prototype.get = function(){
		return this.element;
	}

	Select.prototype.getAnswers = function(){
		return this.element.find(':selected').val();
	}

	Select.prototype.setAnswers = function(answer){// answer is option id ?
		this.element.find('option')
						.prop('selected', false)
					.filter('option[value=option-' + answer + ']')
						.prop('selected', true);
	}

	return Select;
})();

Multiple = (function(){
	Multiple.prototype.obj;
	Multiple.prototype.element;
	
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

		this.element = multiple;
	}

	Multiple.prototype.attrs = function(){
		// TODO
		return this;
	}

	Multiple.prototype.get = function(){
		return this.element;
	}

	Multiple.prototype.getAnswers = function(){
		return this.element.find(':checked').map(function(){
												return $(this).val();
											}).get();
	}

	Multiple.prototype.setAnswers = function(answers){// answer is option id array ?
		this.element.find('input').each(function(){
			id = parseInt($(this).val().split('-')[1]);
			inAnswers = answers.indexOf(id) >= 0;

			if(inAnswers)
				$(this).prop('checked', true);
			else
				$(this).prop('checked', false);
		});
	}

	return Multiple;
})();

Element = (function(){
	Element.prototype.element;
	Element.prototype.obj;

	function Element(obj, id){
		console.log('new Element ' + obj.id + ' (' + obj.type + ')');
		console.log(obj);
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
				element = $('<textarea></textarea>').css('height', obj.height + 'px');
				break;
			case 7:
				element = obj.big ? new Select(obj) : new Radio(obj);
				element = element;
				break;
			case 8:
				element = new Multiple(obj);
				element = element;
				break;
		}

		this.element = element;
		this.attrs();

		container = new Container(obj);

		// element.get() : 
		// 		case 1-6 : jQuery function;
		// 		case 7-8 : Class method.
		// :] 
		container.append(element.get()).appendTo(id);
	}

	Element.prototype.attrs = function() {
		obj = this.obj;

		switch(parseInt(obj.type)){
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
				this.element
					.attr('id', 'elem-' + obj.id)
					.attr('placeholder', obj.placeholder)
					.attr('required', obj.required)
					.css('width', obj.width + 'px')
					;
				break;
			case 7:
			case 8:
				this.element.attrs();
				break;
		}
	};

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
				res = get ? this.getAnswers() : this.setAnswers(answers);
				break;
			case 7:
			case 8:
				res = get ? this.element.getAnswers() : this.element.setAnswers(answers);
				break;
		}

		return res;	
	};

	Element.prototype.getAnswers = function() {
		return this.element.val();
	};

	Element.prototype.setAnswers = function(answer) {
		this.element.val(answer);
	};

	return Element;
})();