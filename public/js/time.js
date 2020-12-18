function getTime()
{
    var now=new Date();
    var year=now.getFullYear();
    var month=now.getMonth()+1;
    if(month<10){
        month="0"+month;
    }
    var date=now.getDate();
    if(date<10){
        date="0"+date;
    }
    var hour=now.getHours();
    if(hour<10){
        hour="0"+hour;
    }
    var minute=now.getMinutes();
    if(minute<10){
        minute="0"+minute;
    }
    var second=now.getSeconds();
    if(second<10){
        second="0"+second;
    }
    nowstr=year+"年"+month+"月"+date+"日  "+hour+":"+minute+":"+second;
    $("#time").html(nowstr)
}
setInterval(getTime,1000)