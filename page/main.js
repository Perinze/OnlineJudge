var noticeDisplayUrl = 'http://localhost:8888/OnlineJudge/public/index/Notice/getdisplaylist';
var addSignUrl = "http://localhost:8888/OnlineJudge/public/panel/Sign/addsign";

window.onload=function () {
    IsPC();
    getDisplayList();
    submitFn();
    acmGraph();
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
    //锚点平滑滚动
    $(document).on("click",'a[href*=#],area[href*=#]',function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');
            if ($target.length) {
                var targetOffset = $target.offset().top;
                $('html,body').animate({
                        scrollTop: targetOffset
                    },
                    1000);
                return false;
            }
        }
    });
    //引导页
    // $('body').pagewalkthrough({
    //     name: 'introduction',
    //     steps: [{
    //         popup: { //定义弹出提示引导层
    //             content: '#walkthrough-1',
    //             type: 'modal',
    //             position: 'bottom'
    //         }
    //     }]
    // });
    // $('body').pagewalkthrough('show');
});

//设备检测
function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
        "SymbianOS", "Windows Phone",
        "iPad", "iPod"];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    if(!flag) {
        changeBar("right", "电脑端访问页面更美");
    }
}

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
        url:noticeDisplayUrl,
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
        otr.innerHTML = '<a href="' + href + '">' + title + "</a>";
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

var rulecnt = 53;
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
function changeBar(opt, content, url)
{
    document.getElementById('notice-bar-content').innerHTML = content;
    if(opt == 'right')
    {
        $('#notice-bar')
            .css('background-color','rgba(135,179,117,0.7)')
            .css('border','1px solid rgba(135,179,117,0.7)')
            .fadeIn(200);
    }
    if(opt == 'wrong')
    {
        $('#notice-bar')
            .css('background-color','rgba(251,52,28,0.7)')
            .css('border','1px solid rgba(251,52,28,0.7)')
            .fadeIn(200);
    }
    if(url)
    {
        window.setTimeout("location.href='" + url + "'", 2000);
    }else{
        setTimeout('$("#notice-bar").fadeOut(170)', 2000);
    }
}
//  notice-bar-end

// 招新比赛报名接口
function submitFn () {
    $("#submit_btn").click(function() {
        var infoName = document.getElementById("name").value;
        var infoSex = document.getElementById("sex").value;
        var infoClass = document.getElementById("class").value;
        var infoCardNo = document.getElementById("cardNo").value;
        var infoDate = document.getElementById("date").value;
        var infoQQ = document.getElementById("qq").value;
        var infoTel = document.getElementById("tel").value;
        var infoDorm = document.getElementById("dorm").value;
        var infoContent = document.getElementById("info-content").value;
        if(cnt !== (1<<8)-1){
            changeBar('wrong', '请填写完整信息');
        }else{
            var a = {
                'name' : infoName,
                'sex' : infoSex,
                'class' : infoClass,
                'cardNo' : infoCardNo,
                'date' : infoDate,
                'qq' : infoQQ,
                'tel' : infoTel,
                'dorm' : infoDorm,
                'content' : infoContent
            };
            $.ajax({
                url:addSignUrl,
                type: "get",
                data: a,
                success: function (str) {
                    if(str.status == 0){
                        changeBar('right', '注册成功');
                        $('#mask').click(function() {
                            $('#registeBox').slideUp(200);
                            $('#mask').fadeOut(200);
                        });
                    }else{
                        changeBar('wrong', str.message);
                    }
                },
                error: function(){
                    changeBar('wrong', '发生错误，请联系管理员');
                }
            })
        }
    })
}

//字符画
function acmGraph(){
    const costomPatternCode = "%c";
    const blueFont = "color:blue; fontfamily: 'Courier New', Courier, monospace;";
    const greatFont = "font-size:14px; font-family: Helvetica, Tahoma, Arial, 'PingFang SC', 'Hiragino Sans GB', 'Heiti SC', STXihei, 'Microsoft YaHei', SimHei, 'WenQuanYi Micro Hei';";
    const joinUs = "font-size:24px; font-weight: 400; text-shadow:5px 5px 2px #fff, 5px 5px 2px #373E40, 5px 5px 5px #A2B4BA, 5px 5px 10px #82ABBA; font-family: Helvetica, Tahoma, Arial, 'PingFang SC', 'Hiragino Sans GB', 'Heiti SC', STXihei, 'Microsoft YaHei', SimHei, 'WenQuanYi Micro Hei';";

    // 下面代码长这样
    //             _____                    _____                    _____
    //            /\    \                  /\    \                  /\    \
    //           /::\    \                /::\    \                /::\____\
    //          /::::\    \              /::::\    \              /::::|   |
    //         /::::::\    \            /::::::\    \            /:::::|   |
    //        /:::/\:::\    \          /:::/\:::\    \          /::::::|   |
    //       /:::/__\:::\    \        /:::/  \:::\    \        /:::/|::|   |
    //      /::::\   \:::\    \      /:::/    \:::\    \      /:::/ |::|   |
    //     /::::::\   \:::\    \    /:::/    / \:::\    \    /:::/  |::|___|______
    //    /:::/\:::\   \:::\    \  /:::/    /   \:::\    \  /:::/   |::::::::\    \
    //   /:::/  \:::\   \:::\____\/:::/____/     \:::\____\/:::/    |:::::::::\____\
    //   \::/    \:::\  /:::/    /\:::\    \      \::/    /\::/    / ~~~~~/:::/    /
    //    \/____/ \:::\/:::/    /  \:::\    \      \/____/  \/____/      /:::/    /
    //             \::::::/    /    \:::\    \                          /:::/    /
    //              \::::/    /      \:::\    \                        /:::/    /
    //              /:::/    /        \:::\    \                      /:::/    /
    //             /:::/    /          \:::\    \                    /:::/    /
    //            /:::/    /            \:::\    \                  /:::/    /
    //           /:::/    /              \:::\____\                /:::/    /
    //           \::/    /                \::/    /                \::/    /
    //            \/____/                  \/____/                  \/____/
    // 你能看到这里，说明你已经掌握了一定的网页设计基础
    // 诚而言之，这个网页并没有什么值得你学习的地方
    // 时间所限，我们并未花太多心思在这上面
    // 你可以看到，这个网页使用的技术并不算先进
    // 如果你抱着“想学习一下这个网页”的出发点打开开发者工具
    // 很抱歉让你失望了
    //
    // 那么，对于这个“原始”的前端架构，你是否有更好的想法？
    // 或者，你是否对算法、对数学有浓厚的兴趣？
    // 我想，你也许适合加入我们！
    // 就是现在，向我们展示你独到的一面吧！

    console.log(costomPatternCode + "             _____                    _____                    _____\n" + "            /\\    \\                  /\\    \\                  /\\    \\  \n" + "           /::\\    \\                /::\\    \\                /::\\____\\             \n" + "          /::::\\    \\              /::::\\    \\              /::::|   |             \n" + "         /::::::\\    \\            /::::::\\    \\            /:::::|   |             \n" + "        /:::/\\:::\\    \\          /:::/\\:::\\    \\          /::::::|   |             \n" + "       /:::/__\\:::\\    \\        /:::/  \\:::\\    \\        /:::/|::|   |             \n" + "      /::::\\   \\:::\\    \\      /:::/    \\:::\\    \\      /:::/ |::|   |             \n" + "     /::::::\\   \\:::\\    \\    /:::/    / \\:::\\    \\    /:::/  |::|___|______       \n" + "    /:::/\\:::\\   \\:::\\    \\  /:::/    /   \\:::\\    \\  /:::/   |::::::::\\    \\      \n" + "   /:::/  \\:::\\   \\:::\\____\\/:::/____/     \\:::\\____\\/:::/    |:::::::::\\____\\     \n" + "   \\::/    \\:::\\  /:::/    /\\:::\\    \\      \\::/    /\\::/    / ~~~~~/:::/    /     \n" + "    \\/____/ \\:::\\/:::/    /  \\:::\\    \\      \\/____/  \\/____/      /:::/    /      \n" + "             \\::::::/    /    \\:::\\    \\                          /:::/    /       \n" + "              \\::::/    /      \\:::\\    \\                        /:::/    /        \n" + "              /:::/    /        \\:::\\    \\                      /:::/    /         \n" + "             /:::/    /          \\:::\\    \\                    /:::/    /          \n" + "            /:::/    /            \\:::\\    \\                  /:::/    /           \n" + "           /:::/    /              \\:::\\____\\                /:::/    /            \n" + "           \\::/    /                \\::/    /                \\::/    /             \n" + "            \\/____/                  \\/____/                  \\/____/              \n", blueFont);
    console.log(costomPatternCode +  "你能看到这里，说明你已经掌握了一定的网页设计基础\n" + "诚而言之，这个网页并没有什么值得你学习的地方\n" + "时间所限，我们并未花太多心思在这上面\n" + "你可以看到，这个网页使用的技术并不算先进\n" + "如果你抱着“想学习一下这个网页”的出发点打开开发者工具\n" + "很抱歉让你失望了\n" + "\n" + "那么，对于这个“原始”的前端架构，你是否有更好的想法？\n" + "或者，你是否对算法、对数学有浓厚的兴趣？\n" + "我想，你也许适合加入我们！\n" + "就是现在，向我们展示你独到的一面吧！\n" + "\n", greatFont);
    console.log(costomPatternCode + "加入我们: http://acmwhut.com", joinUs);
}