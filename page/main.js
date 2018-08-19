mui.init();
window.onload=function () {
    getDisplayList();
    submitFn();
    setInterval("lunbo('#myul','-36px')", 4000);
};

$(document).ready(function(){
    //弹出式注册框打开
    $('#register').click(function() {
        $('#registeBox').slideDown(200);
        $('#mask').fadeIn(200);
    });
    //弹出式注册框关闭
    $('#mask').click(function() {
        $('#registeBox').slideUp(200);
        $('#mask').fadeOut(200);
    });
});

//公告轮播
function lunbo(id, height) {
    var ul = $(id);
    var liFirst = ul.find('li:first');
    $(id).animate({
        top: height
    }).animate({
        "top": 0
    }, 0, function() {
        var clone = liFirst.clone();
        $(id).append(clone);
        liFirst.remove();
    })
}

// 获取公告
function getDisplayList(){
    $.ajax({
        url:'http://localhost:8888/OnlineJudge/public/index/Notice/getdisplaylist',
        data:"",
        dataType:"json",
        type:"post",
        success:function (str) {
            if(str[0]==0){
                drawProjectList(str[2])
            }else{
                alert(str[1])
            }
        },
        error:function(str){

        }
    })
}

//画出接口内容
function drawProjectList(str){
    var projectList=document.getElementById('myul');
    projectList.innerHTML="";
    for(let i=0;i<str.length;i++){
        var title = str[i].title;
        var href = str[i].href||'#';
        var otr=document.createElement('li');
        otr.innerHTML = "<a href=\"" + href + "\"><span>" + title + "</span></a>";
        projectList.appendChild(otr);
    }
}

//  表单前端检测--BEGIN
var cnt=0;
function checkForm(obj) {
    var opt = obj.name;
    var v = obj.value;
    var re = /^$/;
    var num=0;
    switch(opt)
    {
        case 'name':re=/^[\u4e00-\u9fa5]+$/;num=0;break;
        case 'qq':re=/^[1-9][0-9]{4,}$/;num=1;break;
        case 'sex':re=/^[01]$/;num=2;break;
        case 'class':re=/^[\u4e00-\u9fa5]+[a-zA-Z]*[0-9]{4}$/;num=3;break;
        case 'cardNo':re=/^[0-9]{6}$/;num=4;break;
        case 'date':re=/^[1-9][0-9]{3}\/[0-9]{1,2}\/[0-9]{1,2}$/;num=5;break;
        case 'tel':re=/^1[3|4|5|8][0-9]\d{4,8}$/;num=6;break;
        case 'dorm':re=/^[\u4e00-\u9fa5a-zA-Z0-9]+$/;num=7;break;
    }
    if(re.test(v) === true)
    {
        cnt = cnt | (1<<num);
        $(obj).css('box-shadow','0 0 12px #00ff99');
    }else{
        if(((cnt>>num) & 1 )=== 1)cnt-=1<<num;
        $(obj).css('box-shadow','0 0 12px #eb341c');
    }
}

var rulecnt = 52;
function checkFormBtn() {
    var tt=document.styleSheets[0];
    if(cnt === (1<<8)-1)
    {
        tt.deleteRule(rulecnt);//清除之前写入的动画样式
        rulecnt = 0;
        tt.insertRule("@keyframes button-onfocus {0% {box-shadow:;border: 1px solid #c0c0c0;color: #000000}100% {box-shadow:0 0 12px #00ff99;border: 1px solid #00ff99;color: #00ff99;");
    }else{
        tt.deleteRule(rulecnt);//清除之前写入的动画样式
        rulecnt = 0;
        tt.insertRule("@keyframes button-onfocus {0% {box-shadow:;border: 1px solid #c0c0c0;color: #000000}100% {box-shadow:0 0 12px #eb341c;border: 1px solid #eb341c9;color: #eb341c;");
    }
}

function initBtn()
{
    var tt=document.styleSheets[0];
    tt.deleteRule(rulecnt);//清除之前写入的动画样式
    rulecnt = 0;
    tt.insertRule("@keyframes button-onfocus {0% {box-shadow:;border: 1px solid #c0c0c0;color: #c0c0c0}100% {box-shadow:;border: 1px solid #ffffff;color: #ffffff;");
}
//  表单前端检测--END


//  notice-bar
function changeBar(opt, content)
{
    document.getElementById('notice-bar').innerHTML = content;
    if(opt == 'right')
    {
        $('#notice-bar')
            .css('background-color','lime')
            .css('border','1px solid lime')
            .fadeToggle(200)
            .fadeToggle(200);
    }
    if(opt == 'wrong')
    {
        $('#notice-bar')
            .css('background-color','#eb341c')
            .css('border','1px solid #eb341c')
            .fadeToggle(200)
            .fadeToggle(200);
    }
}
//  notice-bar-end

// 招新比赛报名接口
function submitFn () {
    var infoName = mui('#name')[0];
    var infoSex = mui('#sex')[0];
    var infoClass = mui('#class')[0];
    var infoCardNo = mui('#cardNo')[0];
    var infoDate = mui('#date')[0];
    var infoQQ = mui('#qq')[0];
    var infoTel = mui('#tel')[0];
    var infoDorm = mui('#dorm')[0];

    mui("#submit_btn")[0].onclick=function() {
        if(cnt !== (1<<8)-1){
            changeBar('wrong', '请填写完整信息');
        }else{
            var a = new FormData();
            a.append("name",infoName.value);
            a.append("sex",infoSex.value);
            a.append("class",infoClass.value);
            a.append("cardNo",infoCardNo.value);
            a.append("date",infoDate.value);
            a.append("qq",infoQQ.value);
            a.append("tel",infoTel.value);
            a.append("dorm",infoDorm.value);
            $.ajax({
                url:"http://localhost:8888/OnlineJudge/public/panel/Sign/addsign",
                xhrFields:{
                    withCredentials:true
                },
                type: "GET",
                cache: false,
                data: a,
                processData: false,
                contentType:false,
                async: false,
                success: function (str) {
                    if(str.code == 0){
                        changeBar('right', '注册成功');
                    }else{
                        changeBar('wrong', str.message);
                    }
                },
            })
        }
    }
}