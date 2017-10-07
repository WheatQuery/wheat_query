<template>
    <div class="from">
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

            <el-form-item>
                <el-button type="primary" @click="onSubmit">立即创建</el-button>
                <el-button>取消</el-button>
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
                <el-input v-model="form.panicle_num"></el-input>
            </el-form-item>
            <el-form-item label="穗粒数">
                <el-input v-model="form.grain_num"></el-input>
            </el-form-item>
            <el-form-item label="千粒重">
                <el-input v-model="form.ths_weight"></el-input>
            </el-form-item>
            <el-form-item label="抗病性">
                <el-input v-model="form.resistance"></el-input>
            </el-form-item>
            <el-form-item label="蛋白质含量(两位小数百分比)">
                <el-input v-model="form.protein"></el-input>
            </el-form-item>
            <el-form-item label="容重(g/L)">
                <el-input v-model="form.volume"></el-input>
            </el-form-item>
            <el-form-item label="湿面筋含量（一位小数%">
                <el-input v-model="form.wet_gluten"></el-input>
            </el-form-item>
            <el-form-item label="降落数值">
                <el-input v-model="form.fall_num"></el-input>
            </el-form-item>
            <el-form-item label="沉淀指数（整数mL）">
                <el-input v-model="form.precipitate"></el-input>
            </el-form-item>
            <el-form-item label="吸水量（一位小数 mL/100g）">
                <el-input v-model="form.water_uptake"></el-input>
            </el-form-item>
            <el-form-item label="形成时间（一位小数min）">
                <el-input v-model="form.format_time"></el-input>
            </el-form-item>
            <el-form-item label="稳定时间（一位小数min）">
                <el-input v-model="form.steady_time"></el-input>
            </el-form-item>
            <el-form-item label="弱化度（整数F.U.）">
                <el-input v-model="form.weaken"></el-input>
            </el-form-item>
            <el-form-item label="硬度（整数HI）">
                <el-input v-model="form.hardness"></el-input>
            </el-form-item>
            <el-form-item label="白度（一位小数%）">
                <el-input v-model="form.white"></el-input>
            </el-form-item>
            <el-form-item label="出粉率（一位小数%）">
                <el-input v-model="form.powder"></el-input>
            </el-form-item>
            <el-form-item label="产量表现">
                <el-input type="textarea" v-model="form.yield_result"></el-input>
            </el-form-item>
            <el-form-item label="栽培技术要点">
                <el-input type="textarea" v-model="form.tech_point"></el-input>
            </el-form-item>


        </el-form>
    </div>

</template>
<script>
    export default {
        data() {
            return {
                form: {
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
            onSubmit() {
                axios.post("/adds", {
                    data: this.form
                }).then(
                    res => {
                        if(res.code == 200){
                            this.$message({
                                showClose: true,
                                message: '添加成功',
                                type: 'success'
                            });
                        }else{
                            this.$message({
                                showClose: true,
                                message: '',
                                type: 'error'
                            });
                        }

                    }
                )

            }
        }
    }
</script>
<style>
    .from {
        width: 500px;
        margin: 0 auto;
    }
</style>