<template>
    <div v-loading="dialog_loding" style="width: 400px;margin: 200px auto;">
        <el-form ref="user" :model="user" label-width="80px" :label-position="postion" :rules="rules">
            <el-form-item label="输入密码" prop="ppap">
                <el-input v-model="user.oldPass" placeholder="请输入旧密码" type="password"></el-input>
            </el-form-item>
            <el-form-item label="请输入新密码" prop="checknull1">
                <el-input v-model="user.newPass" placeholder="请输入新密码" type="password"></el-input>
            </el-form-item>
            <el-form-item label="请再次输入新密码" prop="checking" >
                <el-input v-model="user.againPass" placeholder="请再次输入新密码" type="password"></el-input>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer" style="width: 200px;margin: 0 auto">
            <el-button type="primary" @click="submit()" style="width: 100%">确 定</el-button>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">

    export default {
        data() {
            var checknull = (rule, value, callback)=>{
                if(this.user.oldPass == null){
                    callback(new Error('请输入密码'));
                }
                callback();
            };
            var checknull1 = (rule, value, callback)=>{
                if(this.user.newPass == null){
                    callback(new Error('请输入密码'));
                }
                callback();
            };
            var checking =  (rule, value, callback) => {
                if(this.user.againPass == null)
                    callback(new Error('请再次输入密码'))
                if (this.user.newPass != this.user.againPass) {
                    callback(new Error('两次密码输入不一致'));
                } else {
                    callback();
                }
            };

            return {
                postion:'top',
                dialog_loding:false,
                user:{
                    oldPass:'',
                    newPass:'',
                    againPass:''
                },rules:{
                    ppap: [
                        { validator: checknull, trigger: 'blur' }
                    ],
                    checknull1:[
                        { validator: checknull1, trigger: 'blur' }
                    ],
                    checking:[
                        {   validator:checking,trigger: 'blur'  }
                    ]
                }

            }

        },
        methods:{
            submit(){
                this.dialog_loding = true;
                axios.post("/rePass", {
                    data: this.user
                }).then(
                    res => {
                        if(res.data.code == 200){
                            this.$message({
                                showClose: true,
                                message: '修改成功',
                                type: 'success'
                            });
                            this.dialog_loding = false;
                        }else{
                            this.$message({
                                showClose: true,
                                message: res.data.result[0],
                                type: 'error'
                            });
                            this.dialog_loding = false;
                        }

                    }
                )
            }
        }
    }
</script>