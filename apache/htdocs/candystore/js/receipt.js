
function writeMTable() {
	top.wRef=window.open('','myconsole',
		'width=500,height=450,left=10,top=10'
		+',menubar=1'
		+',toolbar=0'
		+',status=1'
		+',scrollbars=1'
		+',resizable=1');
	top.wRef.document.writeln(
		'<html><head><title>Multiplication Table</title></head>'
		+'<body bgcolor=white onLoad="self.focus()">'
		+'<center><font color=red><b><i>For printing, <a href=# onclick="window.print();return false;">click here</a> or press Ctrl+P</i></b></font>'
		+'<H3>Multiplication Table</H3>'
		+'<table border=0 cellspacing=3 cellpadding=3>'
	);
	buf='';
	for (j=1;j<11;j++) {
		if ((j-1)%10==0) buf+='<tr>';
		buf+='<td align=right><font size=2 face=Arial,Helvetica>';
		for (i=1;i<11;i++) {
			buf+=j+" x "+i+" = "+(j*i)+"<br>";
		}
		buf+='</font></td>';
		if (j%5==0) buf+='</tr>';
	}
	top.wRef.document.writeln(buf+'</table></center></body></html>');
	top.wRef.document.close();
}  
