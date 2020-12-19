$(".btn").click(function(){
    var self = $(this)          // 将当前点击的 对象保存 供后续使用

    //座位是否已被预订
    var status = self.parent().attr('data-status')  //1已被预订 0可预订
    if(status==1)
    {
        alert("座位已被预订了，请选择其他座位")
        return
    }

    if(confirm('确定预订吗？')){          //  confirm()  确认窗口提示

        let id = self.parent().attr('data-id')          //获取 编号
        $("#apply").show(1500)                      //显示form表单 div

        //预订填写资料表单
        $("#apply_form").submit(function(e){
            e.preventDefault()
            var form = $(this)      //获取表单
            var mobile = $("#mobile").val()     //获取手机号
            var email = $("#email").val()       //获取email
            var userid = $("#userid").val()     // 获取身份证号

            //请求后台
            $.ajax({
                url: '/index.php?s=index/index/reserve',
                method: 'post',
                data:{id:id,mobile:mobile,email:email,userid:userid},       //向后台发送的数据
                dataType:'json',
            }).done(function(){
                //Ajax请求成功后 修改当前页面状态
                self.parent().css('background-color','red')
                self.parent().attr('data-status',1)
                self.text('已预订').attr('disabled','disabled')    //禁用 button
                form.parent().hide(1500)        //隐藏表单div
            })
        })
    }
})

//重置
$("#reset").click(function(){
    if(confirm("确定重置吗？")){
        $.ajax({
            url: '/index.php?s=index/index/reserveCancel',
            method: 'get',
            dataType:'json',
        }).done(function(){
            //重新加载页面
            window.location.reload()
        })
    }

})

