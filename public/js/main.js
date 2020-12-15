var oName = document.getElementById("user_name")

var oMoibile = document.getElementById("mobile")

// 1 user_name 的  blur事件
oName.addEventListener('blur',function(){
    var name = this.value;          // 用户名


    // Ajax
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState==4 && xhr.status==200)
        {
            var json_str = xhr.responseText         //接收服务器的响应
            var od = JSON.parse(json_str)
            console.log(od)
            if(od.errno==0)     //
            {
                alert("看来用户名可以使用")
            }else{
                alert("看来用户名不可以使用")
            }

        }
    }

    xhr.open('GET','/index.php?s=api/index/check&name=' + name)
    xhr.send()
})

// email 的 blur事件
var oEmail = document.getElementById("email")
oEmail.addEventListener('blur',function(e){
    //获取 input 中 value
    var email = this.value
    console.log(email)

    // Ajax
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState==4 && xhr.status==200)
        {
            var json_str = xhr.responseText         //接收服务器的响应
            var od = JSON.parse(json_str)
            console.log(od)
            if(od.errno==0)     //
            {
                alert(od.msg)
            }else{
                alert(od.msg)
            }

        }
    }

    xhr.open('GET','/index.php?s=api/index/check&email=' + email)
    xhr.send()

})

//验证电话号
var oMobile = document.getElementById("mobile")
oMobile.addEventListener('blur',function(e){
    //获取 input 中 value
    var mobile = this.value
    console.log(mobile)


    // Ajax
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState==4 && xhr.status==200)
        {
            var json_str = xhr.responseText         //接收服务器的响应
            var od = JSON.parse(json_str)
            if(od.errno==0)     //
            {
                alert(od.msg)
            }else{
                alert(od.msg)
            }

        }
    }

    xhr.open('GET','/index.php?s=api/index/check&mobile=' + mobile)
    xhr.send()

})

//验证密码
var oP1 = document.getElementById("pass1")
var oP2 = document.getElementById("pass2")

oP2.addEventListener('blur',function(){
    //先获取pass1的值
    var pass1 = oP1.value
    var pass2 = oP2.value

    if(pass1!=pass2)
    {
        alert("密码不一致")
        return
    }else{
        console.log("密码ok")
    }


})
