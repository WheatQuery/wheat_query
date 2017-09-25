<template>
    <div style="height: 100%;background-color: white;">
        <table style="width: 100%;height: 100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td class="sidebar" style="width: 200px;" id="navleft">
                    <div style="background-color:#2F4050;height: 100%;width: 200px;">
                        <div class="logo">
                            小麦品种查询系统
                        </div>
                        <div class="user">
                            <img :src="user.avatar">
                            <span class="info">
                                {{user.name}}
                            </span>
                        </div>
                        <ul class="menu">
                            <!--<li class="active">
                                <router-link to="home"><i class="ion-ios-grid-view"></i>查询</router-link>
                            </li>
                            <li>
                                <router-link to="admin"><i class="ion-ios-folder"></i>管理</router-link>
                            </li>-->
                            <el-menu default-active="2" class="el-menu-vertical-demo" @open="handleOpen" theme="dark" @close="handleClose">
                                <router-link class="link-a" to="/"><el-menu-item index="3"><i class="el-icon-menu"></i>查询</el-menu-item></router-link>
                                <el-submenu index="1">
                                    <template slot="title"><i class="el-icon-setting"></i>管理</template>
                                    <router-link class="link-a" to="/import"><el-menu-item index="1-1">导入</el-menu-item></router-link>
                                    <router-link class="link-a" to="/add"><el-menu-item index="1-2">添加</el-menu-item></router-link>
                                    <router-link class="link-a" to="/query"><el-menu-item index="1-3">查看</el-menu-item></router-link>
                                </el-submenu>
                            </el-menu>
                        </ul>
                        <div class="logout">
                            <a href="/logout"><i class="ion-log-out"></i>&nbsp;退出</a>
                        </div>
                    </div>
                </td>
                <td style="background-color: #EEEEEE;height: 100%;" valign="top">
                    <router-view></router-view>
                </td>
            </tr>
        </table>
    </div>
</template>
<style>
    .sidebar {
        display: table-cell;
    }
    img {
        max-width: 100%;
    }
     .el-menu-vertical-demo:not(.el-menu--collapse) {
         width: 200px;
         min-height: 400px;
     }
</style>
<style scoped>
    .user {
        text-align: center;
        padding: 20px 0;
        height: 150px;
        overflow: hidden;
    }

    .user > img {
        width: 100px;
        border-radius: 100%;
        height: 100px;
        display: block;
        margin: 0 auto;
    }

    .info {
        cursor: pointer;
        display: inline-block;
        color: white;
        font-size: 14px;
        border-radius: 20px;
        padding: 5px 20px;
        border: 1px solid white;
        min-width: 60px;
        min-height: 21px;
        margin: 0px auto;
        margin-top: 10px;
    }

    .logo {
        background: url('/img/admin/logo-bg.png');
        height: 70px;
        color: white;
        font-weight: bolder;
        text-align: center;
        line-height: 30px;
        padding-top: 30px;
        font-size: 16px;
    }

    .logout {
        border-top: 2px solid #1b6d85;
        position: fixed;
        left: 0;
        bottom: 0px;
        height: 50px;
        width: 200px;
        line-height: 50px;
        background-color: #263A4A;
    }

    .menu {
        list-style: none;
        padding: 0px;
        margin: 0px;
    }

    .menu > li > a > i {
        font-size: 20px;
        position: relative;
        top: 2px;
        padding-right: 5px;
    }

    .menu > li > a {
        color: #a7b1c2;
        text-decoration: none;
        height: 50px;
        line-height: 50px;
        margin-left: 60px;
        display: block;
        width: 100%;
    }

    .menu > li.active {
        background-color: #293846;
        border-left: 2px solid #19AA8D;
    }

    .menu > li.active > a {
        color: white;

    }

    .menu > li:hover {
        background-color: #1b6d85;
    }

    .menu > li:hover > a {
        color: white;
    }

    .logout > a {
        color: white;
        text-align: center;
        font-size: 14px;
        text-decoration: none;
        display: block;
    }

    div.logout > a:hover, .info:hover {
        background-color: #1b6d85;
    }
    .link-a{
        text-decoration: none;
    }
</style>
<script type="text/ecmascript-6">
    export default {
        data(){
            return {
                user: [{
                    name:'username',
                    avarar:''
                }],
                isCollapse: false
            }
        },
        computed: {},
        methods: {
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            },
            get () {
                /*var self = this
                axios.post('info/get', {}).then(function (response) {
                    self.user = response.data.result
                })*/
            },
        },
        mounted() {

        },
    }
</script>