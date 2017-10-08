@extends('layouts.app')

@section('content')
    <div id="error" style="width: 400px;margin: 0 auto;position: relative"></div>
    <div class="login">

        <div class="titlediv">
            <h4 class="title">
                <div style="border-bottom: 2px solid #f48686">
                    <a href="#">登录</a>
                </div>

            </h4>
            <div style="width: 100%;padding: 25px;">
                <form>
                    <div class="from">
                        <div style="height: 75px">
                            <input type="text" id="phone" placeholder="请输入您的邮箱" maxlength="30">
                            <span id="phoneError" style="margin-left: 42px; color: red" ></span>
                        </div>
                        <div class="passwrod" style="height: 75px">
                            <input type="password" id="password" placeholder="请输入您的密码" maxlength="20">
                            <span id="passwordError" style="margin-left: 42px;color: red"></span>
                        </div>
                        <button type="button" onclick="login()"><b>登录</b></button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            outline: none;
        }

        a {
            text-decoration: none;
        }

        body {
            background-color: #f0f0f0;
        }

        .login {
            background-color: #fff;
            margin: 60px auto;
            border-radius: 5px;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.11);
            width: 400px;
        }

        .login .titlediv {
            width: 100%;
            height: 500px;
            padding: 50px 25px 25px 25px;
        }

        .title {
            width: 350px;
            margin: 0 auto;
            font-size: 18px;
            height: 40px;
            text-align: center;
            margin-bottom: 50px;
        }

        .title div {
            height: 55px;

        }

        .title a {
            display: inline-block;
            color: #969696;
            height: 40px;
            line-height: 40px;
            padding: 0 10px;
            color: #f48686;
            font-size: 22px;
        }

        .title b {
            color: #969696;
        }

        .from {
            width: 100%;
        }

        .from input {
            height: 50px;
            width: 100%;
            border: 1px solid #c8c8c8;
            border-radius: 4px;
            padding-left: 40px;
            font-size: 13.5px;


        }

        .from .passwrod {
            margin-bottom: 25px;
        }

        .from button {
            border: 0;
            width: 100%;
            height: 45px;
            border-radius: 30px;
            background-color: #187cb7;
            color: white;
            font-size: 18px;

        }

        button:hover {
            background-color: #2274a6;
        }
    </style>
    <script>
        function login() {
            if($("#phone").val() == ""){
                $("#phoneError").text("邮箱为空")
                $("#phone").css({"border":"1px solid red"})
                return;
            }else if(!$("#phone").val().match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/)){
                $("#phoneError").text("邮箱格式错误")
                $("#phone").css({"border":"1px solid red"})
                return;
            }else if($("#password").val() == ""){
                $("#passwordError").text("密码为空")
                $("#password").css({"border":"1px solid red"})
                return;
            }


            $.ajax({
                method: 'post',
                url: "{{ url('/logining') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'phone': document.getElementById('phone').value,
                    'password': document.getElementById('password').value
                },
                success: function (data) {
                    if (data.code == 200) {
                        location.assign("{{ url('/') }}");
                    } else if (data.code == 500) {
                        for (var i = 0; i < data.result.length; i++) {
                            console.log(1)
                            $("#error").append('<div class="alert alert-warning alert-dismissable">\n' +
                                '\t<button type="button" class="close" data-dismiss="alert"\n' +
                                '\t\t\taria-hidden="true">\n' +
                                '\t\t&times;\n' +
                                '\t</button>\n' +
                                data.result[i] +
                                '</div>')
                        }

                    }

                }

            })
        }
    </script>
@endsection
