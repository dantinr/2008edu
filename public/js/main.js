//服务器地址
let url = 'http://tp.2008.com/index.php?s=api/index/check';
// 获取
let oName = document.getElementById('user_name')
let oEmail = document.getElementById("email")
let oMobile = document.getElementById("mobile")

//验证用户名
oName.addEventListener('blur',function(e){
    console.log("验证用户名")
    // 发送的参数
    let params = {
        name: this.value
    }
    let callback = function(d){
        alert(d.msg)
    }
    ajax('get',url,callback,params)
})

//验证Email
oEmail.addEventListener('blur',function(e){
    console.log("验证Email")
    // 发送的参数
    let params = {
        name: this.value
    }
    //处理服务器响应
    let callback = function(d){
        alert(d.msg)
    }
    ajax('get',url,callback,params)
})

//验证Mobile
oMobile.addEventListener('blur',function(e){
    console.log("验证手机号")
    // 发送的参数
    let params = {
        mobile: this.value
    }
    //处理服务器响应
    let callback = function(d){
        alert(d.msg)
    }
    ajax('get',url,callback,params)
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
