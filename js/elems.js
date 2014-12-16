Text = (function(){
	function Text(obj){
		console.log('new Text');
		text = $('<input/>');
		text.attr('id', obj.id)
			.attr('type', 'text')
			.attr('placeholder', obj.placeholder)
			;
		return text;
	}
	return Text;
})();