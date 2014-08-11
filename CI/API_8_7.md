#怎样 RESTful API Doc
===
##Overview
**怎样**，采用的框架方案为**后端框架[CodeIgniter](http://codeigniter.org.cn/user_guide/toc.html)**加**前端框架[AngularJS](http://www.angularjs.cn/tag/AngularJS)**的组合，前后端框架的信息交换通过**RESTful API**，具体为**[codeigniter-restserver](https://github.com/chriskacerguis/codeigniter-restserver)**，本文档即为**API描述文档**。文档内容以页面功能划分和组织。
***
---
#登录/注册/登出
---
**1.[POST]**	```index.php/signup/basic```  
---
####param:
none
####post names:
``email password firstname lastname``  
####response:  
``{state:'success'}``  
``{state:'fail', detail:'emailInvalid'}``//非法email地址  
``{state:'fail', detail:'emailOccupied'}``//email已注册
``{state:'fail', detail:'emailRequire'}``//没有输入邮箱
``{state:'fail', detail:'passwordLength'}``//非法密码长度(6-16)  
``{state:'fail', detail:'passwordInvalid'}``//非法密码字符(字母数字下划线)
``{state:'fail', detail:'passwordRequire'}``//没有输入密码
``{state:'fail', detail:'firstnameLength'}``//非法名长度(8-char max)
``{state:'fail', detail:'firstnameRequire'}``//没有输入
``{state:'fail', detail:'lastnameLength'}``//非法姓长度(8-char max)
``{state:'fail', detail:'lastnameRequire'}``//没有输入
``{state:'fail', detail:'nameLength'}``//非法姓名长度(12-char max)  
``{state:'fail', detail:'nameInvalid'}``//非法姓名字符(字母中文)  
***
**2.[POST]** ```index.php/signup/info```
---
####param:
none
####post names:
``gender`` //**'M'** for male & **'F'** for female  
``occupation`` //**'S'** for student & **'W'** for non-student  
``bio`` //一句话描述(optional)  
####response:
``{state:'success'}``  
``{state:'fail', detail:'Unlogin'}``//没有登陆
``{state:'fail', detail:'genderRequire'}``//没有选
``{state:'fail', detail:'occupationRequire'}``//没有选
``{state:'fail', detail:'bioLength'}``//非法个人描述长度(40-char max)
``{state:'fail', detail:'bioInvalid'}``//非法个人描述字符(字母中文常用标点)  
***
**3.[POST]** ```index.php/signup/more```
---
####param:
none
####post names:
``province college major year``// for student  
``province company position``// for non-student  
####response:
``{state:'success'}``
``{state:'fail', detail:'Unlogin'}``//没有登陆
``{state:'fail', detail:'provinceInvalid'}``//非法城市名字符(字母中文 下同)   
``{state:'fail', detail:'collegeInvalid'}``  
``{state:'fail', detail:'majorInvalid'}``  
``{state:'fail', detail:'companyInvalid'}``  
``{state:'fail', detail:'positionInvalid'}``  
``{state:'fail', detail:'yearInvalid'}``//非法入学年份(数字 1900-2100)  
``{state:'fail', detail:'provinceLength'}``//非法城市名长度(30-char max 下同)  
``{state:'fail', detail:'collegeLength'}``  
``{state:'fail', detail:'majorLength'}``  
``{state:'fail', detail:'companyLength'}``  
``{state:'fail', detail:'positionLength'}``  
``{state:'fail', detail:'provinceRequire'}``//没有选，以下同
``{state:'fail', detail:'collegeRequire'}``
``{state:'fail', detail:'majorRequire'}``
``{state:'fail', detail:'yearRequire'}``
``{state:'fail', detail:'companyRequire'}``
``{state:'fail', detail:'positionRequire'}``
***
**4.[GET]** ```index.php/signup/provincelist```
---
####param:
none
####response:
``['上海市','北京市',...]``
***
**5.[GET]** ```index.php/signup/collegelist/param1```
---
####param:
``param1: provincename`` eg. 上海
####response:
``['上海交通大学', '复旦大学',...]``  
***
**6.[GET]** ```index.php/signup/majorlist/param1```
---
####param1:
``param: college`` eg.上海交通大学
####response:
``['计算机科学','土木工程',...]``
***
**7.[GET]** ```index.php/signup/companylist/param1```
---
####param:
``param1: provincename`` eg. Shanghai
####response:
``['百度','阿里巴巴',...]``
***
**8.[GET]** ```index.php/signup/positionlist```
---
####param:
none
####response:
``['首席执行官(CEO)','项目经理(PM)','教授','副教授',...]``
***
**9.[POST]** ```index.php/log/login```
---
####param:
none
####post names:
``email password``
####response:
``{state:'success'}``  
``{state:'fail', detail:'emailNotExist'}``//邮箱未注册  
``{state:'fail', detail:'pswWrong'}``//密码错误
``{state:'fail', detail:'wait15Min'}``//封15分钟
***
**10.[GET]** ``index.php/log/logout``
---
####praram:
none
####response:
``{state:'success'}``  
***

---
#首页
---

---
**1.[GET]** `index.php/home/question_date_list/param1/param2 按问题时间顺序排列`
---
####param:
param1: limit => 每页显示数目
param2: offset => 下一道题目的偏移量
####response:
<pre>
{'state':'fail','detail':'Unlogin'}
{ 0 => (
          id =>问题id
          title => 提问标题
          uid => 提问者id
          realname => 提问者名字
          location => 提问者头像路径
          follow => (Y/N)当前用户是否关注此问题
          follow_num => 有多少人关注此问题
          view_num => 有多少人游览过此问题
          answer_num => 有多少人回答此问题
          date => 提问时间
          best_answer => 最佳回答(
                            id => 回答id
                            content => 回答内容
                            uid =>回答者id
                            realname => 回答者名字
                            location => 回答者头像路径
                            mygood => (-1,0,1) 当前用户是否评价了
                            good => 膜拜数
                            bad => 呵呵数
                            date => 回答时间
                         )
         ),
 1 => (同上),
 2 => ...}
</pre>
---
**2.[GET]** `index.php/home/question_day_list 当日精华`
---
###response:同上

---
**3.[GET]** `index.php/home/question_day_list 关注的话题`
---
###response:同上


---
#私信系统#
---
**1.[GET]**`index.php/letter/letter_notify 私信提示`
---
####param:
none
####response:
<pre>
{'num': 表示消息数目}
{'state':'fail','detail':Unlogin}
</pre>

---
**2.[GET]**`index.php/letter/letter_home 私信主页`
---
####param:
none
####response:
<pre>
{ 0 => (
          uid => 对话朋友的id
          realname => 对话朋友的名字
          location => 对话朋友的头像路径
          msg_total => 与他共有几条私信
          msg_unread => 与他有几条未读私信
          date => 最后一条私信的时间
       ),
  1 => (
          同上
       )}
{'state':'fail','detail':Unlogin}
</pre>

---
**3.[GET]**`index.php/letter/letter_talk/param1 聊天历史`
---
####param:
param1:uid => 聊天对象
####response:
<pre>
{ 
 0 => (
          dir => 此条对话方向（0是发出,1是接受）
          letter => 此条私信内容
          date => 此条私信时间
       ),
 1 => (
          同上
      )
}
{'state':'fail','detail':'Unlogin'}
</pre>
---
**4.[GET]**`index.php/letter/letter_set_look 全部设为已读`
---
####param:
none
####response:
<pre>
{'state':'success'}
{'state':'fail','detail':'Unlogin'}
</pre>

---
**5.[POST]**`index.php/letter/letter_send 发私信`
---
####param:
none
####postname:
 uid => 发给谁
 letter => 私信内容
####response:
<pre>
  {'state':'success'}
  {'state':'fail','detail':'Unlogin'}
</pre>

---
#通知系统#
---
**1.[GET]**`index.php/notify/new_notification`
---
####param:
none
####response:
<pre>
{
 'num' => 总通知数目
 'num_1'=> 关注的问题有新回答 + 自己的提问有新回答}
 'num_2'=> 回答被赞，被感谢
 'num_3'=> 有人关注了我
}
{'state':'fail','detail':'Unlogin'}
</pre>

---
**2.[GET]**`index.php/notify/follow_new_answer 关注的问题有了新回答`
---
####param:
none
####response:
<pre>
{
  0 => (
         'qid' => 关注的问题id
         'title' => 问题标题
         'uid' => 回答者id
         'realname' => 回答者名字
       ),
  1 =>(
        同上
      )
}
{'state':'fail','detail':'Unlogin'}
</pre>

---
**3.[GET]**`index.php/notify/myquestion_new_answer 我的提问被回答了`
---
####param:
none
####response:
<pre>
{ 
  0 => (
          'qid' => 问题id
          'title' => 问题标题
          'uid' => 回答者id
          'realname' => 回答者姓名
       )
  1 => (
          同上
       )
}       
</pre>

---
**4.[GET]**`index.php/notify/answer_good 回答被赞了`
---
####param:
none
####response:
<pre>
{
  0 => (
         'qid' => 赞的回答对应的问题id
         'title' => 问题标题
         'uid' => 赞的人id
         'realname' => 赞的人名字
       )
  1 => (
         同上
       )
}
</pre>

---
**5.[GET]**`index.php/notify/followed 被关注了`
---
####param:
none
####response:
<pre>
{
   0 => (
           'uid' => 关注我的人id
           'realname' => 关注我的人的名字
        )
   1 => (
           同上
        )
}
</pre>

---
#问答系统
---
**1.[POST]**`index.php/qa_center/question_ask 提问`
---
####param:
none
####postname:
title content
####response:
<pre>
{'state':'success'}
{'state':'fail','detail':'timeInterval'}
{'state':'fail','detail':'titleRequire'}
{'state':'fail','detail':'titleLength'} 6字~40字
{'state':'fail','detail':'contentLength'} 少于400字
{'state':'fail','detail':'Unlogin'}
</pre>

---
**2.[POST]**`index.php/qa_center/question_answer/param1 回答某个问题`
---
####param:
param1 : qid
####response:
<pre>
{'state':'fail','detail':'Unlogin'}
{'state':'fail','detail':'contentRequire'}
{'state':'fail','detail':'contentLength'} (不能少于6字不能超过4000字)
{
  'content' => 回答内容
}
</pre>

---
**3.[GET]**`index.php/qa_center/view_question/param1 查看某个问题内容`
---
####param:
param1:qid => 查看问题的id
####response:
<pre>
{'state':'fail','detail':'Unlogin'}
{ 
    id =>问题id
    title => 提问标题
    uid => 提问者id
    realname => 提问者名字
    location => 提问者头像路径
    follow => (Y/N)当前用户是否关注此问题
    follow_num => 有多少人关注此问题
    answer_num => 有多少人回答此问题
    date => 提问时间
}
</pre>

---
**4.[GET]**`index.php/qa_center/view_answer/param1/param2/param3/parm4 查看某个问题的回答列表`
---
####param:
param1: qid => 此问题id 
param2: aid => 0|other(0表示看全部回答，other表示看特定回答，用于个人中心中点我的回答时的展示)
param3: limit => 一页要显示多少条回答
param4: offset => 对于第0条的偏移量
####response:
<pre>
{'state':'fail','detail':'Unlogin'}
{
 0 =>(
       id => 回答id
       content => 回答内容
       uid =>回答者id
       realname => 回答者名字
       location => 回答者头像路径
       mygood => (-1,0,1) 当前用户是否评价了
       good => 膜拜数
       bad => 呵呵数
       date => 回答时间
     ), 
 1 =>(
        同上
     ),      
}
</pre>

---
**5.[GET]**`index.php/qa_center/good/param1/param2 膜拜某回答`
---
####param:
param1:qid => 被回答的问题的id
param2:aid => 回答的id
####response:
<pre>
{state:'fail','detail':'Unlogin'}
{state:'success','good':更新后的膜拜数目,'bad'：更新后的呵呵数,'mygood'：当前评论是1,-1,0}
</pre>

---
**6.[GET]**`index.php/qa_center/bad/param1/param2 呵呵某回答`
---
####param:
param1:qid => 被回答的问题的id
param2:aid => 回答的id
####response:
<pre>
{state:'fail','detail':'Unlogin'}
{state:'success','bad':更新后的呵呵数目,'good'：更新后的呵呵数,'mygood'：当前评论是1,-1,0}
</pre>

---
**7.[GET]**`index.php/qa_center/question_follow/param1 （取消）关注某问题`
---
####param:
param: qid => 对应问题的id
####response:
<pre>
{'follow':'Y/N'=>当前是是否关注}
{'state':'fail','detail':'Unlogin'}
</pre>

---
#个人中心
---
**1.[GET] ** `index.php/personal_center/get_profile/param1 查看个人资料`
---
####param:
param1: uid => 用户id
####response:
<pre>
{'state':'fail','detail':'Unlogin'}
  {
    realname => 姓名
    gender => (F/M)性别
    occupation => ('S'/'W') 学生或者工作 ,
    job => 工作内容/学习专业,
    jobtime => 入职/学时间,
    province => 省份,
    jobplace => 公司/学校,
    bio => 一句话介绍,
    'location' => 大头像存储路径
  }
</pre>

---
**2.[POST]** `index.php/personal_center/modify_profile 修改个人资料`
---
####param:
none
####postname:
 注册时的所有信息都可以post
####response:
<pre>
{'state':'success'}
{'state':'fail','detail':'Unlogin'}
</pre>
####p.s`修改后要再get一次个人信息刷新页面`

---
**3.[GET]** `index.php/personal_center/my_follow/param1/param2 我关注的问题`
---
####param:
param1: limit 每页显示数目
param2: offset 相对第0条的偏移
####response:
<pre>
{'state':'fail','detail':'Unlogin'}
{
   0 =>  (
            id =>问题id
            title => 提问标题
            uid => 提问者id
            realname => 提问者名字
            location => 提问者头像路径
            follow => (Y/N)当前用户是否关注此问题
            follow_num => 有多少人关注此问题
            answer_num => 有多少人回答此问题
            date => 提问时间)
        )
   1 => (
            同上
        )        
}
</pre>

---
**4.[GET]** `index.php/personal_center/my_question/param1/param2 我提的问题`
---
####param:
param1: limit 每页显示数目
param2: offset 相对第0条的偏移
####response:
<pre>
{'state':'fail','detail':'Unlogin'}
{
  0 => (
        id =>问题id
        title => 提问标题
        follow => (Y/N)当前用户是否关注此问题
        follow_num => 有多少人关注此问题
        answer_num => 有多少人回答此问题
        date => 提问时间
        ),
  1 => (
         同上
       )    
}
</pre>

---
**5.[GET]** `index.php/personal_center/my_answer/param1/param2 我回答的问题`
---
####param:
param1: limit 每页显示数目
param2: offset 相对第0条的偏移
####response:
<pre>
{'state':'fail','detail':'Unlogin'}
{
   0 => (
            qid =>问题id
            title => 提问标题
            aid => 回答id
            description => 回答内容
            good => 被膜拜数目
            bad => 被呵呵数目
        ),
   1 => (
        )        
}
</pre>

---
**6.[POST]** `index.php/personal_center/modify_my_answer 修改我的回答`
---
####param:
none
####postname
 aid => 回答的id
 content => 回答的内容
####response:
<pre>
  {'state':'fail','detail':'Unlogin'}
  {'state':'success'}
</pre>

---
**7.[GET]** `index.php/personal_center/show_my_answer/param1 查看那我的回答（用于修改回答时显示内容）`
---
####param:
param1:aid
####response:
<pre>
  {'state':'fail','detail':'Unlogin'}
  {'content' => 回答内容}
</pre>

---
#搜索系统
---

---
**1.[POST] ** `index.php/search/search 搜索框`
---
####param:
####postname:
 target
####response:
<pre>
{'state':'fail','detail':'Unlogin'}
{
   'question' => (
                   0 => (
                          qid => 问题id
                          title => 问题标题
                         )
                   1 => ()         
                  ),
  'people' => ( 
                  0 => (
                         uid => 人物id
                         realname => 人物姓名
                       ),
                  1 => (
                       )       
              )
   'tag' => (
                 0 => (
                         tag_id => 话题id
                         tag_name => 话题名字
                      )
            )
 }
</pre>
####p.s.`各显示5条`


---
#评论系统
---
---
**1.[POST]** `index.php/comment/comment 评论某个回答`
---
####postname:
 aid => 评论的id
 comment => 评论内容
####response:
<pre>
 {'state':'success'}
 {'state':'fail','detail':'Unlogin'}
</pre>

---
**2.[GET]** `index.php/comment/commitlist/param1 得到某个回答的评论列表`
---
####param:
 param1: aid => 回答的id
####response:
<pre>
 {'state':'fail','detail':'Unlogin'}
 { 0 => (
          com_uid => 评论者id
          com_realname => 评论者姓名
          com_location => 评论者小头像
          com_comment => 评论者的评论
          com_date => 评论时间
        )
   1 => （同上）        
 }
</pre>

---
#常用API
---

---
**1.[GET]** `index.php/public_function/myinfo 获取我的姓名,uid和头像`
---
####response:
<pre>
 {'state':'fail','detail':'Unlogin'}
 {
  'id' => 我的id
  'realname' => 姓名
  'location' => 大头像}
</pre>

---
**2.[GET]** `index.php/public_function/uidinfo 查询某个人的信息`
---
####param:
param1:
uid=>查询人的信息
####response:
<pre>
 {'state':'fail','detail':'Unlogin'}
 {
  'realname' => 姓名
  'location' => 大头像
 }
</pre>

---
**3.[GET]** `index.php/public_function/large_photo/param 获取某人大头像`
---
####param
param1:
uid => 查询人的id
####response
<pre>
 {'state':'fail','detail':'Unlogin'}
 {'location' => 照片地址}
</pre>

---
**3.[GET]** `index.php/public_function/large_photo/param 获取某人中头像`
---
####param
param1:
uid => 查询人的id
####response
<pre>
 {'state':'fail','detail':'Unlogin'}
 {'location' => 照片地址}
</pre>

---
**3.[GET]** `index.php/public_function/large_photo/param 获取某人小头像`
---
####param
param1:
uid => 查询人的id
####response
<pre>
 {'state':'fail','detail':'Unlogin'}
 {'location' => 照片地址}
</pre>





