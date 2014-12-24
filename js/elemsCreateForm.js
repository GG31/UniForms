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
		this.required = obj.required;

		switch(parseInt(obj.type)){
			case 1:
				this.element = $('<input/>').attr('type', 'text');
				this.type = 'InputText';
				this.defaultValue = obj.defaultValue;
				break;
			case 2:
				this.element = $('<input/>').attr('type', 'number');
				this.type = 'InputNumber';
				this.defaultValue = obj.defaultValue;
				this.min = obj.minvalue;
				this.max = obj.maxvalue;
				break;
			case 3:
				this.element = $('<input/>').attr('type', 'time');
				this.type = 'InputTime';
				this.defaultValue = obj.defaultValue;
				break;
			case 4:
				this.element = $('<input/>').attr('type', 'date');
				this.type = 'InputDate';
				this.defaultValue = obj.defaultValue;
				break;
			case 5:
				this.element = $('<input/>').attr('type', 'tel');
				this.type = 'InputPhone';
				this.defaultValue = obj.defaultValue;
				break;
		   case 6:
		      //Checkbox
			   this.type = 'Checkbox';
            this.getValues(obj, 'checkbox');
				break;
			case 7:
			   //Radio button
			   this.type = 'RadioButton';
            this.getValues(obj, 'radio');
				break;
			case 8:
			   this.type = 'TextArea';
			   this.element = $('<textarea></textarea>');
				break;
		}

		this.attrs();
		this.element.draggable({ cancel: null });
	}
   
   Element.prototype.getValues = function(obj, type) {
      this.element = $("<fieldset></fieldset>");
      this.values = {};
      for(i=0; i<obj.options.length; i++) {
         this.values[i] = obj.options[i]['value'];
         var newNode = $('<input/>').attr('type', type)
                                    .attr('name', this.id);
         var span = $('<span>' + this.values[i] + '</span><br>');
         this.element.append(newNode);
         this.element.append(span);
      }
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
