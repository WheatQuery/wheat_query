<template>
    <div>
        <div class="path">
            <span><i class="el-icon-setting path-icon"></i> <span class="path-label">管理</span> / </span><span>查看</span>
        </div>
        <div class="content" v-loading="query_loading">
            <div class="content-head">
                <div class="but">
                    <el-button type="primary" :disabled="button_click" @click="batch_del">已选 {{ selectVal.length }} / {{ tableData.length }} | 批量删除</el-button>
                </div>
                <div class="search-input">
                    <el-input
                            placeholder="请输入小麦名称"
                            icon="search"
                            v-model="searchVal"
                            @keyup.enter.native="search"
                            @change="searchChange"
                            :on-icon-click="search">
                    </el-input>
                </div>
            </div>
            <div class="data-table">
                <template>
                    <template>
                        <el-table
                                ref="multipleTable"
                                :data="tableData"
                                :border="false"
                                tooltip-effect="dark"
                                style="width: 100%"
                                @selection-change="selectChange">
                            <el-table-column
                                    type="selection"
                                    width="55">
                            </el-table-column>
                            <el-table-column
                                    label="名称"
                                    width="180">
                                <template scope="scope">
                                    <span style="margin-left: 10px">{{ scope.row.name }}</span>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="组合"
                                    width="200">
                                <template scope="scope">
                                    <el-popover trigger="hover" placement="top">
                                        <p>组合: {{ scope.row.child }} </p>
                                        <div slot="reference" class="name-wrapper">
                                            <el-tag>{{ scope.row.child }}</el-tag>
                                        </div>
                                    </el-popover>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="育种单位"
                                    width="300">
                                <template scope="scope">
                                    <span>{{ scope.row.place }}</span>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="审定年份"
                                    width="100">
                                <template scope="scope">
                                    <span>2017</span>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="利用次数"
                                    width="100">
                                <template scope="scope">
                                    <span> {{ scope.row.use_times }} </span>
                                </template>
                            </el-table-column>
                            <el-table-column label="操作">
                                <template scope="scope">
                                    <el-button
                                            size="small"
                                            @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                                    <el-button
                                            size="small"
                                            type="danger"
                                            @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                                </template>
                            </el-table-column>
                        </el-table>
                    </template>
                </template>
                <div class="page" v-if="showPage">
                    <el-pagination
                            @size-change="handleSizeChange"
                            @current-change="handleCurrentChange"
                            :current-page="currentPage"
                            :page-sizes="[10, 20, 50, 100]"
                            :page-size="pageNum"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="total">
                    </el-pagination>
                </div>
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
    .content-head{
        padding:10px;
    }
    .but {
        display: inline-block;
    }
    .search-input {
        margin-left: 20px;
        display: inline-block;
    }
    .content{
        width: 1100px;
        min-height: 600px;
        margin: 20px;
        background: white;
    }
    .page{
        margin-top:10px;
        padding-bottom: 20px;
    }
    .name-wrapper{
        width: 180px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                query_loading: false,
                button_click: true,
                currentPage: 1,     //当前页数
                pageNum: 10,
                total: 0,     //总数
                searchVal: '',      //搜索框的值
                tableData: [],
                showPage: true,
                selectVal:[],       //批量选中的小麦品种
            }
        },
        methods:{
            get(){
                this.query_loading = true
                axios.post('/get',{num:((this.currentPage-1)*this.pageNum),page:this.pageNum}).then( res => {
                    if(res.data.code == 0){
                        this.tableData = res.data.result['wheat']
                        this.total = res.data.result['count']
                    }
                    this.query_loading= false
                    this.showPage = true
                })
            },
            handleSizeChange(val) {
                this.pageNum = val
                this.get()
                //console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                this.currentPage = val
                this.get()
                //console.log(`当前页: ${val}`);
            },
            selectChange(value) {
                if(value.length != 0){
                    this.button_click = false
                }else{
                    this.button_click = true
                }
                this.selectVal = value
            },
            search() {
                console.log(this.searchVal)
                axios.post('/search',{value:this.searchVal}).then( res => {
                    if(res.data.code == 0){
                        this.tableData = res.data.result
                    }else{
                        this.tableData = []
                    }
                    this.showPage = false
                })
            },
            searchChange() {
                if(this.searchVal == ''){
                    this.get()
                }
            },
            batch_del() {
                let wheat_id = []
                for (let i in this.selectVal){
                    wheat_id[i] = this.selectVal[i].id
                }
                this.$confirm('是否要删除选中的小麦品种?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post('/batch_delete',{id:wheat_id}).then( res => {
                        this.$message({
                            type: res.data.msg,
                            message: res.data.result
                        });
                        if(res.data.code == 0){
                            this.get()
                        }
                    })
                }).catch(() => {
                })
            },
            handleEdit(index, row) {
                console.log(index, row)
            },
            handleDelete(index, row) {
                this.$confirm('是否要删除该小麦品种?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    let wheat_id = []
                    wheat_id.push(row.id)
                    axios.post('/batch_delete',{id:wheat_id}).then( res => {
                        this.$message({
                            type: res.data.msg,
                            message: res.data.result
                        });
                        if(res.data.code == 0){
                            this.get()
                        }
                    })
                }).catch(() => {
                });
            },
        },
        mounted() {
            this.get()
        }
    }
</script>