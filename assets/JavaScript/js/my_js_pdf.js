
function jspdf_purchase_order(po_head,po_detail) {
	var doc = new jsPDF("p","mm","letter");
	var rowtracer = 0;
	var coltracer = 0;
	var margintop = 10;
	var marginleft = 10;
	var marginleft_right = 155;
	var font_size = 12;
	var line_gap = 6;
	var margin_amount_lbl = 145;
	
	var col1_width = 20;
	var col2_width = 15;
	var col3_width = 100;
	var col4_width = 30;
	var col5_width = 30;
	
	doc.setFont("times", "bold");

	doc.setFontSize(font_size);
		
	//upperleft headers
	rowtracer = margintop;
	doc.text(marginleft,rowtracer,'NELSOFT TECHNOLOGY SERVICE');
	rowtracer += line_gap;
	doc.text(marginleft,rowtracer, 'TEL NO.: (02)442-0298 | FAX: (02)442-0298');
	doc.setFontStyle("normal");
	rowtracer += line_gap;
	doc.text(marginleft,rowtracer, '57 SGT. RIVERA ST. QUEZON CITY, NCR');
	
	//upperr right headers
	doc.setFontStyle("bold");
	rowtracer = margintop;
	doc.text(marginleft_right,rowtracer,'Purchase Order');
	rowtracer += line_gap;
	doc.text(marginleft_right,rowtracer, po_head.ponumber);
	doc.setFontStyle("normal");
	rowtracer += line_gap;
	doc.text(marginleft_right,rowtracer, 'Prepared By: NELSON LIAO');
	
	//----space-----
	rowtracer += line_gap;
	rowtracer += line_gap;
	
	//Supplier
	doc.setFontStyle("bold");
	doc.text(marginleft,rowtracer,'Supplier:');
	doc.setFontStyle("normal");
	doc.text(marginleft+20,rowtracer, po_head.supplier);
	
	//Date
	doc.setFontStyle("bold");
	doc.text(marginleft_right,rowtracer, 'Date:');
	doc.setFontStyle("normal");
	doc.text(marginleft_right+15,rowtracer, po_head.date);
	
	rowtracer += line_gap;
	
	//Address
	doc.setFontStyle("bold");
	doc.text(marginleft,rowtracer, 'Address:');
	doc.setFontStyle("normal");
	var supplier_address_arr = doc.splitTextToSize(po_head.supp_add, 110);
	doc.text(marginleft+20,rowtracer, supplier_address_arr);
	
	//Terms
	doc.setFontStyle("bold");
	doc.text(marginleft_right,rowtracer, 'Term:');
	doc.setFontStyle("normal");
	doc.text(marginleft_right+15,rowtracer, po_head.term);
	
	rowtracer = rowtracer + line_gap*(supplier_address_arr.length-1);
	rowtracer += line_gap/2;
	
	//Memo
	doc.setFontStyle("bold");
	doc.text(marginleft,rowtracer, 'Memo:');
	doc.setFontStyle("normal");
	var memo_arr = doc.splitTextToSize(po_head.memo, 110);
	doc.text(marginleft+20,rowtracer, memo_arr);
	
	rowtracer = rowtracer + line_gap*memo_arr.length;
	rowtracer += line_gap/2;

	//table headers
	doc.setFontStyle("bold");
	coltracer = marginleft;
	doc = text_align_center(doc, coltracer, rowtracer, col1_width, "QTY");
	coltracer += col1_width;
	doc = text_align_center(doc, coltracer, rowtracer, col2_width, "Unit");
	coltracer += col2_width;
	doc = text_align_center(doc, coltracer, rowtracer, col3_width, "Description");
	coltracer += col3_width;
	doc = text_align_center(doc, coltracer, rowtracer, col4_width, "Price");
	coltracer += col4_width;
	doc = text_align_center(doc, coltracer, rowtracer, col5_width, "Amount");
	
	rowtracer += line_gap;
	
	//table data
	doc.setFontStyle("normal");
	for(var i in po_detail){
		coltracer = marginleft;
		doc = text_align_center(doc, coltracer, rowtracer, col1_width, po_detail[i].qty);
		coltracer += col1_width;
		doc = text_align_center(doc, coltracer, rowtracer, col2_width, po_detail[i].unit_d);
		coltracer += col2_width;
		var description_arr = doc.splitTextToSize(po_detail[i].description, col3_width);
		doc.text(coltracer, rowtracer, description_arr);
		//doc.text(coltracer, rowtracer, po_detail[i].description);
		coltracer += col3_width;
		doc = text_align_right(doc, coltracer, rowtracer, col4_width, po_detail[i].price);
		coltracer += col4_width;
		doc = text_align_right(doc, coltracer, rowtracer, col5_width, po_detail[i].amount);
		
		rowtracer += line_gap * description_arr.length;
	}
	
	doc.line(marginleft,rowtracer,205,rowtracer);
	
	doc.setFontStyle("bold");
	rowtracer += line_gap;
	doc = text_align_right(doc, margin_amount_lbl, rowtracer, 25, "SUB TOTAL:");
	doc = text_align_right(doc, margin_amount_lbl+35, rowtracer, 25, po_head.subtotal);
	
	rowtracer += line_gap;
	doc = text_align_right(doc, margin_amount_lbl, rowtracer, 25, "ADJUST:");
	doc = text_align_right(doc, margin_amount_lbl+35, rowtracer, 25, po_head.adjust);
	
	rowtracer += line_gap;
	doc = text_align_right(doc, margin_amount_lbl, rowtracer, 25, "NET TOTAL:");
	doc = text_align_right(doc, margin_amount_lbl+35, rowtracer, 25, po_head.nettotal);
	
	doc.output('datauri');
}

function text_align_right(pdf, x, y, width, str){
	var str_width = pdf.getStringUnitWidth(str);
	str_width = ( str_width * pdf.internal.getFontSize() ) / pdf.internal.scaleFactor;
	var new_x = x + (width-str_width);
	pdf.text( new_x, y, str);
	return pdf;
}

function text_align_center(pdf, x, y, width, str){
	var str_width = pdf.getStringUnitWidth(str);
	str_width = ( str_width * pdf.internal.getFontSize() ) / pdf.internal.scaleFactor;
	var new_x = x + ( (width-str_width)/2 );
	pdf.text( new_x, y, str);
	return pdf;
}