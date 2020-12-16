function $(){
    console.log(11111)
}




/**
 * ajax
 * @param method  请求方法  get post ..
 * @param url   请求的接口地址
 * @param callback  请求成功后的处理函数
 */

function ajax(method,url,callback,params)
{
    let p = "&"
    for (const k in params) {
        // username=zhangsan&age=11&email=lskdjflsdkfj
        p += k + '=' + params[k] + '&'
    }

    let new_url = url+p;

    // 1 实例化
    let xhr = new XMLHttpRequest()

    // 2 监控readyState
    xhr.onreadystatechange = function(){
        if(xhr.readyState==4 && xhr.status==200)
        {
            let data = JSON.parse(xhr.responseText)
            callback(data)      //处理服务器响应
        }
    }

    // 3 初始化 网络请求
    xhr.open(method,new_url)
    xhr.send()
}