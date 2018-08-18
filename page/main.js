(function($) {

    window.onload=function () {
        getDisplayList()
    }

    // mui.init()
    // window.onload=function() {
    //     submitFn();
    // }
    //
    // function submitFn () {
    //     var newprojectSite=mui("#studentDorm")[0];
    //     var projectClass=document.getElementById("projectClass");
    //     var projectSummary=mui("#projectSummary")[0];
    //     var projectSchool="余家头校区";
    //     var studentPhone=mui("#studentPhone")[0];
    //
    //     mui("#submit_btn")[0].onclick=function() {
    //         if(check()){ // TODO check function
    //             mui.alert("请填写完整信息");// TODO 优化
    //         }else{
    //             var a = new FormData();
    //             a.append("projectClass",projectClass.innerHTML);
    //             a.append("projectSite",newprojectSite.innerHTML);
    //             a.append("projectSummary",projectSummary.value);
    //             a.append("projectSchool",projectSchool);
    //             a.append("orderTime",orderTime);
    //             a.append("studentPhone",studentPhone.value);
    //             a.append("image1",img1);
    //             a.append("image2",img2);
    //             a.append("image3",img3);
    //             $.ajax({
    //                 url:"http://localhost:8888/OnlineJudge/public/index/Notice/getdisplaylist",// TODO update
    //                 xhrFields:{
    //                     withCredentials:true
    //                 },
    //                 type: "GET",
    //                 cache: false,
    //                 data: a,
    //                 processData: false,
    //                 contentType:false,
    //                 async: false,
    //                 success: function (str) {
                        // TODO update

                        // if(str.errMsg=="OK"){
                        //     mui.openWindow("student_project_list.html");
                        // }else{
                        //     mui.alert(str.errMsg+".3秒后自动跳转列表页面");
                        //     setTimeout(function(){
                        //         mui.openWindow("student_project_list.html");
                        //     }, 3000);
                        //
                        // }
    //                 },
    //             })
    //         }
    //     }
    // }

    //弹出式注册框
    $(document).ready(function(){
        $('#register').click(function() {
            // $('.login-form-mask').fadeIn(100);
            $('#registeBox').slideDown(200);
        })
        // $('.login-close').click(function() {
        //     $('.login-form-mask').fadeOut(100);
        //     $('.login-form').slideUp(200);
        // })
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
    setInterval("lunbo('#myul','-36px')", 4000)

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

})(jQuery);