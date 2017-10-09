<template>
    <div>
        <div class="path">
            <span><i class="el-icon-setting path-icon"></i> <span class="path-label">管理</span> / </span><span>查看</span>
        </div>
        <div class="content" v-loading="query_loading">
            <div class="content-head">
                <div class="but">
                    <el-button type="primary" :disabled="button_click" @click="batch_del">已选 {{ selectVal.length
                        }} / {{ tableData.length }} | 批量删除
                    </el-button>
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
                                            @click="handleEdit(scope.$index, scope.row)">编辑
                                    </el-button>
                                    <el-button
                                            size="small"
                                            type="danger"
                                            @click="handleDelete(scope.$index, scope.row)">删除
                                    </el-button>
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
        <el-dialog title="收货地址" :visible.sync="dialogFormVisible" v-loading="dialog_loding">
            <el-form ref="form" :model="form" label-width="80px">
                <el-form-item label="品种名称">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="子产品">
                    <el-input v-model="form.child"></el-input>
                </el-form-item>
                <el-form-item label="审定编号">
                    <el-input v-model="form.code"></el-input>
                </el-form-item>
                <el-form-item label="育种者">
                    <el-input v-model="form.breeder"></el-input>
                </el-form-item>
                <el-form-item label="育种地点">
                    <el-input v-model="form.place"></el-input>
                </el-form-item>
                <el-form-item label="审定意见">
                    <el-input type="textarea" v-model="form.opinion"></el-input>
                </el-form-item>
                <el-form-item label="活动时间">
                    <el-col :span="11">
                        <el-date-picker type="date" placeholder="选择日期" v-model="form.date1"
                                        style="width: 100%;"></el-date-picker>
                    </el-col>
                </el-form-item>
                <el-form-item label="生态类型">
                    <el-input v-model="form.ecology_type"></el-input>
                </el-form-item>
                <el-form-item label="苗性">
                    <el-input v-model="form.seed_nature"></el-input>
                </el-form-item>
                <el-form-item label="分蘖特性">
                    <el-input v-model="form.tiler_nature"></el-input>
                </el-form-item>
                <el-form-item label="株型">
                    <el-input v-model="form.plant_type"></el-input>
                </el-form-item>
                <el-form-item label="穗下节长度">
                    <el-input v-model="form.spike_length"></el-input>
                </el-form-item>
                <el-form-item label="旗叶特征">
                    <el-input v-model="form.leaf_nature"></el-input>
                </el-form-item>
                <el-form-item label="穗层">
                    <el-input v-model="form.spike_layer"></el-input>
                </el-form-item>
                <el-form-item label="株高">
                    <el-input v-model="form.plant_height"></el-input>
                </el-form-item>
                <el-form-item label="抗倒特性">
                    <el-input v-model="form.lodging"></el-input>
                </el-form-item>
                <el-form-item label="穗型">
                    <el-input v-model="form.panicle_type"></el-input>
                </el-form-item>
                <el-form-item label="根系活力">
                    <el-input v-model="form.root_activ"></el-input>
                </el-form-item>
                <el-form-item label="落黄">
                    <el-input v-model="form.yellow"></el-input>
                </el-form-item>
                <el-form-item label="母穗数">
                        <el-input-number v-model="form.panicle_num" :min="0" :step="0.1"></el-input-number>
                </el-form-item>
                <el-form-item label="穗粒数">
                        <el-input-number v-model="form.grain_num" :min="0" :step="0.1"></el-input-number>
                </el-form-item>
                <el-form-item label="千粒重">
                    <el-input-number v-model="form.ths_weight" :min="0" :step="0.1"></el-input-number>
                </el-form-item>
                <el-form-item label="抗病性">
                    <el-input v-model="form.resistance"></el-input>
                </el-form-item>
                <el-form-item label="蛋白质含量(两位小数百分比)">
                    <el-input-number v-model="form.protein" :min="0" :step="0.01"></el-input-number>
                </el-form-item>
                <el-form-item label="容重(g/L)">
                    <el-input-number v-model="form.volume" :min="0" :step="0.01"></el-input-number>
                </el-form-item>
                <el-form-item label="湿面筋含量（一位小数%">
                    <el-input-number v-model="form.wet_gluten" :min="0" :step="0.1"></el-input-number>
                </el-form-item>
                <el-form-item label="降落数值">
                    <el-input-number v-model="form.fall_num" :min="0" :step="1"></el-input-number>
                </el-form-item>
                <el-form-item label="沉淀指数（整数mL）">
                    <el-input-number v-model="form.precipitate" :min="0" :step="1"></el-input-number>
                </el-form-item>
                <el-form-item label="吸水量（一位小数 mL/100g）">
                    <el-input-number v-model="form.water_uptake" :min="0" :step="0.1"></el-input-number>
                </el-form-item>
                <el-form-item label="形成时间（一位小数min）">
                    <el-input-number v-model="form.format_time" :min="0" :step="0.1"></el-input-number>
                </el-form-item>
                <el-form-item label="稳定时间（一位小数min）">
                    <el-input-number v-model="form.steady_time" :min="0" :step="0.1"></el-input-number>
                </el-form-item>
                <el-form-item label="弱化度（整数F.U.）">
                    <el-input-number v-model="form.weaken" :min="0" :step="1"></el-input-number>
                </el-form-item>
                <el-form-item label="硬度（整数HI）">
                    <el-input-number v-model="form.hardness" :min="0" :step="1"></el-input-number>
                </el-form-item>
                <el-form-item label="白度（一位小数%）">
                    <el-input-number v-model="form.white" :min="0" :step="0.1"></el-input-number>
                </el-form-item>
                <el-form-item label="出粉率（一位小数%）">
                    <el-input-number v-model="form.powder" :min="0" :step="0.1"></el-input-number>
                </el-form-item>
                <el-form-item label="产量表现">
                    <el-input type="textarea" v-model="form.yield_result" style="height: 40px"></el-input>
                </el-form-item>
                <el-form-item label="栽培技术要点">
                    <el-input type="textarea" v-model="form.tech_point"  style="height: 40px"></el-input>
                </el-form-item>


            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="submit()">确 定</el-button>
            </div>
        </el-dialog>
    </div>

</template>
<style scoped>
    .path-label {
        color: rgb(72, 102, 106);
    }

    .path-icon {
        color: #20A0FF;
    }

    .path {
        padding: 10px;
        border-bottom: 1px solid #cecece;
    }

    .content-head {
        padding: 10px;
    }

    .but {
        display: inline-block;
    }

    .search-input {
        margin-left: 20px;
        display: inline-block;
    }

    .content {
        width: 1100px;
        min-height: 600px;
        margin: 20px;
        background: white;
    }

    .page {
        margin-top: 10px;
        padding-bottom: 20px;
    }

    .name-wrapper {
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
                dialogFormVisible: false,
                query_loading: false,
                button_click: true,
                currentPage: 1,     //当前页数
                pageNum: 10,
                total: 0,     //总数
                searchVal: '',      //搜索框的值
                tableData: [],
                showPage: true,
                selectVal: [],       //批量选中的小麦品种
                dialog_loding:false,
                form: {
                    id:'',
                    name: '',
                    child: '',
                    code: '',
                    breeder: '',
                    place: '',
                    opinion: '',
                    date1: '',
                    ecology_type: ',',
                    seed_nature: '',
                    tiler_nature: '',
                    plant_type: '',
                    spike_length: '',
                    leaf_nature: '',
                    spike_layer: '',
                    plant_height: '',
                    lodging: '',
                    panicle_type: '',
                    root_activ: '',
                    panicle_num: '',
                    yellow: '',
                    grain_num: '',
                    ths_weight: '',
                    resistance: '',
                    protein: '',
                    volume: '',
                    wet_gluten: '',
                    fall_num: '',
                    precipitate: '',
                    water_uptake: '',
                    format_time: '',
                    steady_time: '',
                    weaken: '',
                    white: '',
                    hardness: '',
                    powder: '',
                    yield_result: '',
                    tech_point: '',
                }
            }
        },
        methods: {
            get() {
                this.query_loading = true
                axios.post('/get', {num: ((this.currentPage - 1) * this.pageNum), page: this.pageNum}).then(res => {
                    if (res.data.code == 0) {
                        this.tableData = res.data.result['wheat']
                        this.total = res.data.result['count']
                    }
                    this.query_loading = false
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
                if (value.length != 0) {
                    this.button_click = false
                } else {
                    this.button_click = true
                }
                this.selectVal = value
            },
            search() {
                console.log(this.searchVal)
                axios.post('/search', {value: this.searchVal}).then(res => {
                    if (res.data.code == 0) {
                        this.tableData = res.data.result
                    } else {
                        this.tableData = []
                    }
                    this.showPage = false
                })
            },
            searchChange() {
                if (this.searchVal == '') {
                    this.get()
                }
            },
            batch_del() {
                let wheat_id = []
                for (let i in this.selectVal) {
                    wheat_id[i] = this.selectVal[i].id
                }
                this.$confirm('是否要删除选中的小麦品种?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post('/batch_delete', {id: wheat_id}).then(res => {
                        this.$message({
                            type: res.data.msg,
                            message: res.data.result
                        });
                        if (res.data.code == 0) {
                            this.get()
                        }
                    })
                }).catch(() => {
                })
            },
            handleEdit(index, row) {
                console.log(row.id)
                axios.post('/queryAll', {id: row.id}).then(res => {

                    if (res.data.code == 200) {
                        this.form.id = row.id;
                        this.form.name = res.data.result[0]['name'];
                        this.form.child = res.data.result[0]['child'];
                        this.form.code = res.data.result[0]['code'];
                        this.form.breeder = res.data.result[0]['breeder'];
                        this.form.place = res.data.result[0]['place'];
                        this.form.opinion = res.data.result[0]['opinion'];
                        this.form.date1 = res.data.result[0]['verify_time'];
                        this.form.ecology_type = res.data.result[0]['ecology_type'];
                        this.form.seed_nature = res.data.result[0]['seed_nature'];
                        this.form.tiler_nature = res.data.result[0]['tiler_nature'];
                        this.form.plant_type = res.data.result[0]['plant_type'];
                        this.form.spike_length = res.data.result[0]['spike_length'];
                        this.form.leaf_nature = res.data.result[0]['leaf_nature'];
                        this.form.spike_layer = res.data.result[0]['spike_layer'];
                        this.form.plant_height = res.data.result[0]['plant_height'];
                        this.form.lodging = res.data.result[0]['lodging'];
                        this.form.panicle_type = res.data.result[0]['panicle_type'];
                        this.form.root_activ = res.data.result[0]['root_activ'];
                        this.form.panicle_num = res.data.result[0]['panicle_num'];
                        this.form.yellow = res.data.result[0]['yellow'];
                        this.form.grain_num = res.data.result[0]['grain_num'];
                        this.form.ths_weight = res.data.result[0]['ths_weight'];
                        this.form.resistance = res.data.result[0]['resistance'];
                        this.form.protein = res.data.result[0]['protein'];
                        this.form.volume = res.data.result[0]['protein'];
                        this.form.wet_gluten = res.data.result[0]['wet_gluten'];
                        this.form.fall_num = res.data.result[0]['fall_num'];
                        this.form.precipitate = res.data.result[0]['precipitate'];
                        this.form.water_uptake = res.data.result[0]['water_uptake'];
                        this.form.format_time = res.data.result[0]['format_time'];
                        this.form.steady_time = res.data.result[0]['steady_time'];
                        this.form.weaken = res.data.result[0]['weaken'];
                        this.form.white = res.data.result[0]['white'];
                        this.form.hardness = res.data.result[0]['hardness'];
                        this.form.powder = res.data.result[0]['powder'];
                        this.form.yield_result = res.data.result[0]['yield_result'];
                        this.form.tech_point = res.data.result[0]['yield_result'];
                        this.dialogFormVisible = true;
                    }else{
                        this.$message({
                            showClose: true,
                            message: '未找到数据',
                            type: 'error'
                        });
                    }
                });


            },
            handleDelete(index, row) {
                this.$confirm('是否要删除该小麦品种?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    let wheat_id = []
                    wheat_id.push(row.id)
                    axios.post('/batch_delete', {id: wheat_id}).then(res => {
                        this.$message({
                            type: res.data.msg,
                            message: res.data.result
                        });
                        if (res.data.code == 0) {
                            this.get()
                        }
                    })
                }).catch(() => {
                });
            },
            submit(){
                this.dialog_loding = true;
                axios.post("/update", {
                    data: this.form
                }).then(
                    res => {
                        if(res.data.code == 200){
                            this.$message({
                                showClose: true,
                                message: '修改成功',
                                type: 'success'
                            });
                            axios.post('/get', {num: ((this.currentPage - 1) * this.pageNum), page: this.pageNum}).then(res => {
                                if (res.data.code == 0) {
                                    this.tableData = res.data.result['wheat']
                                    this.total = res.data.result['count']
                                }
                            })
                            this.dialog_loding = false;
                        }else{
                            this.$message({
                                showClose: true,
                                message: '修改失败',
                                type: 'error'
                            });
                            this.dialog_loding = false;
                        }

                    }
                )
            }
        },
        mounted() {
            this.get()
        }
    }
</script>