<template>
    <div>
        <div class="path">
            <span><i class="el-icon-setting path-icon"></i> <span class="path-label">管理</span> / </span><span>导入</span>
        </div>
        <div class="upload" v-loading="import_loading">
            <el-upload
                    class="upload-demo"
                    drag
                    action="/import"
                    accept=".xls,.xlsx"
                    :data="csrf_token"
                    name="file"
                    :before-upload="before_upload"
                    :on-success="handleSuccess"
                    :on-error="error"
                    multiple>
                <i class="el-icon-upload"></i>
                <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                <div class="el-upload__tip upload-tip" slot="tip">只能上传扩展名为 xls、xlsx 的 Excel 文件</div>
            </el-upload>
            <div class="excel-example">
                <a href="/download">下载模板</a>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .path-label{
        color: rgb(72, 102, 106);
    }
    .path-icon{
        color: #20A0FF;
    }
    .path{
        padding:10px;
        border-bottom: 1px solid #cecece;
    }
    .upload{
        width: 365px;
        margin: 0 auto;
        margin-top: 50px;
    }
    .upload-tip{
        text-align: center;
    }
    .excel-example{
        padding-top: 50px;
        text-align: center;
    }
    .excel-example a{
        font-size: 15px;
        color: #8391a5;
        text-decoration: none;
    }
    .excel-example a:hover{
        color: #20a0ff;
    }
</style>
<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                import_loading: false,
                csrf_token: {
                    _token: Laravel.csrfToken
                },
            }
        },
        methods:{
            before_upload(file) {
                //console.log(file)
            },
            handleSuccess: function(data) {
                var self = this;
                self.import_loading = true
                if (data.result.code == 0) {
                    self.$message({
                        message: "成功导入"+data.result.count+"条记录",
                        type: "success"
                    });
                    setTimeout(function(){
                        location.href="/#/user/student";
                    },2000);
                } else {
                    self.$message({
                        message: "成功导入"+data.result.count+"条记录,失败"+data.result.error.length+"条记录",
                        type: "warning"
                    });
                    self.source = data.result.error_data;
                }
                this.import_loading = false;
            },
            error() {

            },
        },
        mounted() {

        }
    }
</script>