/*Radio = (function(){
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
						.prop('checked', obj.options[i].default == '1' ? true : false)
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
						.prop('selected', obj.options[i].default == '1' ? true : false)
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
						.prop('checked', obj.options[i].default == '1' ? true : false)
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

	return Multiple;
})();
*/
Element = (function(){
	Element.prototype.element;
	Element.prototype.id;
	Element.prototype.type;
	Element.prototype.posX;
	Element.prototype.posY;

	function Element(obj){
		this.id = "elem_" + obj.id;
		this.posX = obj.x;
		this.posY = obj.y;
		this.label = obj.label;

		switch(parseInt(obj.type)){
			case 1:
				element = $('<input/>').attr('type', 'text');
				this.type = 'InputText';
				this.required = obj.required;
				this.defaultValue = obj.defaultValue;
				break;
			case 2:
				element = $('<input/>').attr('type', 'number');
				this.type = 'InputNumber';
				this.required = obj.required;
				this.defaultValue = obj.defaultValue;
				this.min = obj.minvalue;
				this.max = obj.maxvalue;
				break;
			case 3:
				element = $('<input/>').attr('type', 'time');
				this.type = 'InputTime';
				this.required = obj.required;
				this.defaultValue = obj.defaultValue;
				break;
			case 4:
				element = $('<input/>').attr('type', 'date');
				this.type = 'InputDate';
				this.required = obj.required;
				this.defaultValue = obj.defaultValue;
				break;
			case 5:
				element = $('<input/>').attr('type', 'tel');
				this.type = 'InputPhone';
				this.required = obj.required;
				this.defaultValue = obj.defaultValue;
				break;
		   case 6:
		      //Checkbox
				element = $('<input/>').css('height', obj.height + 'px');
				this.required = obj.required;
				break;
			case 7:
			   //Radio button
				element = obj.big ? new Select(obj) : new Radio(obj);
				break;
			case 8:
			   element = $('<textarea></textarea>').css('height', obj.height + 'px');
				this.required = obj.required;
				break;
				//element = new Multiple(obj);
				//break;
		}

		this.element = element;
		this.attrs();
		
	}

	Element.prototype.attrs = function() {
      this.element.attr('id', this.id);
                  /*.css('position', 'absolute');
                  .css('left', this.posX + 'px');
                  .css('top', this.posY + 'px');*/
		/*switch(parseInt(obj.type)){
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
				this.element
					.attr('id', this.id)
					.attr('placeholder', obj.placeholder)
					.attr('required', obj.required)
					.css('width', obj.width + 'px')
					;
				break;
			case 7:
			case 8:
				this.element.attrs();
				break;
		}*/
	};

	return Element;
})();

function disableForm(id){
	form = $(id);
	form.find('input').prop('disabled', true);
	form.find('textarea').prop('disabled', true);
	form.find('select').prop('disabled', true);
}
