function abc()
{
    let data = ['a','b','c','d'];

    return  data
}

// 求两个数的和
function add(num1,num2)
{
   return num1 + num2
}

//封装ajax函数
function ajax(method,url,callback)
{
    // 1 实例化
    let xhr = new XMLHttpRequest()

    // 2 监控readyState
    xhr.onreadystatechange = function(){
        if(xhr.readyState==4 && xhr.status==200)
        {
            callback()      //处理服务器响应
        }
    }

    // 3 初始化 网络请求
    xhr.open(method,url)
    xhr.send()
}