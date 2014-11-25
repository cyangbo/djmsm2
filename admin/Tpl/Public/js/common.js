function add(id){
    
    if (id){
            location.href  = URL+"/add/id/"+id;
    }else{
            location.href  = URL+"/add/";
    }
}

function foreverdel(id){
    var keyValue;
    if (id){
        keyValue = id;
    }else {
        keyValue = getSelectCheckboxValues();
    }

    if (!keyValue){
        alert('请选择删除项！');
        return false;
    }
    if (window.confirm('确实要永久删除选择项吗？')){
        location.href =  URL+"/foreverdelete/id/"+keyValue;
        //ThinkAjax.send(URL+"/foreverdelete/","id="+keyValue+'&ajax=1',doDelete);
    }
}
//批量通过审核
function checkPass(id){
    var keyValue;
    if (id)
    {
        keyValue = id;
    }else {
        keyValue = getSelectCheckboxValues();
    }

    if (!keyValue)
    {
            alert('请选择审核项！');
            return false;
    }

    if (window.confirm('确实要通过选择项吗？'))
    {
        location.href =  URL+"/checkPass/id/"+keyValue;
        
        //ThinkAjax.send(URL+"/foreverdelete/","id="+keyValue+'&ajax=1',doDelete);

    }
}
//批量取消审核
function forbid(id){
    var keyValue;
    if (id)
    {
        keyValue = id;
    }else {
        keyValue = getSelectCheckboxValues();
    }

    if (!keyValue)
    {
            alert('请选择审核项！');
            return false;
    }

    if (window.confirm('确实要取消选择项吗？'))
    {
        location.href =  URL+"/forbid/id/"+keyValue;
        //ThinkAjax.send(URL+"/foreverdelete/","id="+keyValue+'&ajax=1',doDelete);

    }
}
function getSelectCheckboxValues(){
	var obj = document.getElementsByName('key');
	var result ='';
	var j= 0;
	for (var i=0;i<obj.length;i++){
		if (obj[i].checked==true){
//                        selectRowIndex[j] = i+1;
                        result += obj[i].value+",";
                        j++;
		}
	}
	return result.substring(0, result.length-1);
}
