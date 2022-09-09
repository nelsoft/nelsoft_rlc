/*
 * UIMTreeProcessor Class
 * version: 1.0 (11-16-2010)
 * 
 * Copyright (c) 2010 Vlad Shamgin (uimonster.com)
 * 
 * @requires jQuery v1.3.2 or later
 * @requires jsTree 1.0-rc1 or later
 *
 * Examples and documentation at: http://uimonster.com
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

function UIMTreeProcessor(data, treeEl) {
	this.data = data;
	this.treeEl = treeEl;
}

UIMTreeProcessor.prototype.initTree = function(data){
	this.treeEl.jstree({
		"json_data" : {
			"data":data,
			"progressive_render":"true"
		},
		"plugins" : [ "themes", "ui", "json_data" ],
		"core":{"animation":0}
		});
    //this.treeEl.bind("click.jstree", function (event, data) {      
        //alert("Bind Result: " + event.type);

    //});
    this.treeEl.delegate(".jstree-open>a", "click.jstree", function(event){
    $.jstree._reference(this).close_node(this,false,false);
    }).delegate(".jstree-closed>a", "click.jstree", function(event){
        $.jstree._reference(this).open_node(this,false,false);
    });
    this.treeEl.bind("select_node.jstree", function (event, data) {      
        //alert(data.inst.get_text(data.rslt.obj) + " - " + data.rslt.obj.attr("value")); // ID - Text 
        $("#lblSelectedNode").html(data.rslt.obj.attr("value"));
        if (data.inst._get_parent(data.rslt.obj) != -1){
            $("#lblSelectedNodeP").html(data.inst._get_parent(data.rslt.obj).attr("value"));
            refreshcontent(data.rslt.obj.attr("value"));
        }
    }); 
}

UIMTreeProcessor.prototype.doProcess = function(){
	//Find root:
	var _root = $(this.data).children(':first-child');
	var _a_feed = new Array();

	this.vsTraverse($(_root), _a_feed);

	var _treedata = [{"data":_root[0].nodeName,"children":_a_feed, "state":"open"}]; //home
	this.initTree(_treedata);
}

UIMTreeProcessor.prototype.vsTraverse = function(node, arr){
	var _ch = $(node).children();
    
	for(var i=0; i<_ch.length; i++){
		var _vsArr = new Array();
		this.vsTraverse(_ch[i], _vsArr);
		var _a_att = this.vsTraverseAtt(_ch[i]);
		// if(null!=_a_att){
			// _vsArr.push([{"data":"Attributes "+"["+_ch[i].nodeName+"]","children":_a_att, attr : { "class" : "uim_attr"}}]);
		// }
        //if(null!=_ch[i].firstChild && 3==_ch[i].firstChild.nodeType){
        if(null!=_ch[i].firstChild && ("category"==_ch[i].tagName || "subcategory"==_ch[i].tagName)){
            //arr.push([{"data":_ch[i].nodeName + ": " + _ch[i].firstChild.textContent,"children":_vsArr, "state":"open"}]);
            arr.push([{"data":_ch[i].firstChild.textContent,"children":_vsArr, "state":"close", attr : { "value" : _a_att }}]);
        }
        else if(null!=_ch[i].firstChild && "page"==_ch[i].tagName){
            arr.push([{"data":_ch[i].firstChild.textContent,"children":_vsArr, "state":"leaf", attr : { "value" : _a_att }}]);
        }else{
            arr.push([{"data":_ch[i].nodeName,"children":_vsArr, "state":"open"}]);
        }
	}
}

UIMTreeProcessor.prototype.vsTraverseAtt = function(node){
	var _a_atts = null;
	if(null!=node.attributes && node.attributes.length > 0){
		_a_atts = new Array();
		for(var i=0; i<node.attributes.length; i++){
			//_a_atts.push(node.attributes[i].nodeName + ":" + node.attributes[i].nodeValue);
			_a_atts.push(node.attributes[i].nodeValue);
		}
	}
	return _a_atts;
}

