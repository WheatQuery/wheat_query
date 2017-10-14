<template>
    <div class="from">
        <el-form ref="form" :model="form" label-width="80px" :rules="rules" style="margin-top: 50px"
                 :label-position="postion">

            <el-form-item label="品种名称" prop="name">
                <el-input v-model="form.name" placeholder="请输入产品名称"></el-input>
            </el-form-item>
            <el-form-item label="子产品" prop="child">
                <el-input v-model="form.child" placeholder="请输入一个以上不重复的产品并用英文逗号分隔"></el-input>
            </el-form-item>
            <el-form-item label="审定编号" prop="name">
                <el-input v-model="form.code" placeholder="请输入审定批号"></el-input>
            </el-form-item>
            <el-form-item label="育种者" prop="name">
                <el-input v-model="form.breeder" placeholder="请输入育种者"></el-input>
            </el-form-item>
            <el-form-item label="育种地点" prop="name">
                <el-input v-model="form.place" placeholder="请输入育种地点"></el-input>
            </el-form-item>

            <el-form-item label="生态类型">
                <el-input v-model="form.ecology_type" placeholder="请输入产品的生态类型"></el-input>
            </el-form-item>
            <el-form-item label="苗性">
                <el-input v-model="form.seed_nature" placeholder="请输入产品的苗性"></el-input>
            </el-form-item>
            <el-form-item label="分蘖特性">
                <el-input v-model="form.tiler_nature" placeholder="请输入产品的分蘖特性"></el-input>
            </el-form-item>
            <el-form-item label="株型">
                <el-input v-model="form.plant_type" placeholder="请输入产品的株型"></el-input>
            </el-form-item>
            <el-form-item label="穗下节长度">
                <el-input v-model="form.spike_length" placeholder="请输入产品的穗下节长度"></el-input>
            </el-form-item>
            <el-form-item label="旗叶特征">
                <el-input v-model="form.leaf_nature" placeholder="请输入产品的旗叶特征"></el-input>
            </el-form-item>
            <el-form-item label="穗层">
                <el-input v-model="form.spike_layer" placeholder="请输入产品的穗层"></el-input>
            </el-form-item>
            <el-form-item label="株高">
                <el-input v-model="form.plant_height" placeholder="请输入产品的株高"></el-input>
            </el-form-item>
            <el-form-item label="抗倒特性">
                <el-input v-model="form.lodging" placeholder="请输入产品的抗倒特性"></el-input>
            </el-form-item>
            <el-form-item label="穗型">
                <el-input v-model="form.panicle_type" placeholder="请输入产品的穗型"></el-input>
            </el-form-item>
            <el-form-item label="根系活力">
                <el-input v-model="form.root_activ" placeholder="请输入产品的根系活力"></el-input>
            </el-form-item>
            <el-form-item label="落黄">
                <el-input v-model="form.yellow" placeholder="请输入产品的落黄"></el-input>
            </el-form-item>
            <el-form-item label="抗病性">
                <el-input v-model="form.resistance" placeholder="请输入产品的抗病性"></el-input>
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

            <el-form-item label="蛋白质含量(两位小数百分比)">
                <el-input-number v-model="form.protein" :min="0" :step="0.01"></el-input-number>
            </el-form-item>
            <el-form-item label="容重(g/L)">
                <el-input-number v-model="form.volume" :min="0" :step="0.01"></el-input-number>
            </el-form-item>
            <el-form-item label="湿面筋含量（一位小数%）">
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
            <el-form-item label="审定意见">
                <el-input type="textarea" v-model="form.opinion" :autosize="{ minRows: 2, maxRows: 4}"
                          placeholder="请输入产品的审定意见"></el-input>
            </el-form-item>

            <el-form-item label="产量表现">
                <el-input type="textarea" v-model="form.yield_result" :autosize="{ minRows: 2, maxRows: 4}"
                          placeholder="请输入产品的产量表现"></el-input>
            </el-form-item>
            <el-form-item label="栽培技术要点">
                <el-input type="textarea" v-model="form.tech_point" :autosize="{ minRows: 2, maxRows: 4}"
                          placeholder="请输入产品的栽培技术要点"></el-input>
            </el-form-item>
            <el-form-item label="审核日期" prop="name">
                <el-col :span="11">
                    <el-date-picker type="date" placeholder="选择日期" v-model="form.date1"
                                    style="width: 100%;"></el-date-picker>
                </el-col>
            </el-form-item>
            <el-button type="primary" @click="onSubmit('form')">立即添加</el-button>
        </el-form>
    </div>

</template>
<script>

    export default {

        data() {
            var validatePass = (rule, value, callback) => {
                if (!value.match(/^(?!.*(^|,)([^,]*),.*\2)\w+(,\w+)+$/)) {
                    callback(new Error('格式输入错误'));
                } else {

                    callback();
                }
            };

            return {
                postion: 'top',
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
                }, rules: {
                    name: [
                        { required: true, message: '输入内容不得为空', trigger: 'blur' }
                    ],
                    child:[
                        { validator: validatePass, trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            onSubmit(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.post("/adds", {
                            data: this.form,

                        }).then(
                            res => {

                                if (res.data.code == 200) {

                                    this.$message({
                                        showClose: true,
                                        message: '添加成功',
                                        type: 'success'
                                    });
                                }
                                else {

                                    this.$message({
                                        showClose: true,
                                        message: res.data.result[0],
                                        type: 'error'
                                    });
                                }
                            }
                        )
                    } else {

                        return false;
                    }
                });


            }
        }
    }
</script>
<style>
    .from {
        width: 400px;
        margin: 0 auto;
    }
</style>