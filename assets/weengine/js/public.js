function CheckCode(code,type){
    type = type?type : 1;
    var status = false;
    if(code%2 == 0){
        status = true;
    }
    if(type == 1){
        return status ? 'Success' : 'Error';
    }else if(type ==2 ){
        return status ? 'success' : 'error';
    }
}