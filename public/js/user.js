$("#user_name").on('blur',function(){
    var name = this.value       //获取当前input中的value
    //正则验证

    //ajax查询用户名是否可用
    $.ajax({
        url: "http://tp.2008.com/index.php?s=api/index/check&name=" + name,
        method: 'get',
        dataType: 'json',           //服务器返回的数据格式
    }).done(function (data){
        console.log(data)
        if(data.errno>0){
            //提示用户出错
        }
    })
})