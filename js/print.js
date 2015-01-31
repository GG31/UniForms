/**
 * BENATHMANE Ayoub
 */

function PrintElem(elem){
	Popup($(elem).html());
}

function Popup(data){
	var mywindow = window.open('', 'my div', 'height=400,width=600');
	
	mywindow.document.write('<html><head><title>my div</title>');
	/*optional stylesheet*/ 
	mywindow.document.write('<link rel="stylesheet" href="../css/print.css" type="text/css" />');
	mywindow.document.write('</head><body >');
	mywindow.document.write(data);
	mywindow.document.write('</body></html>');
	
	mywindow.document.close(); // necessary for IE >= 10
	mywindow.focus(); // necessary for IE >= 10
	
	mywindow.print();
	mywindow.close();

    return true;
}