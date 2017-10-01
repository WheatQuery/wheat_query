<template>
    <div id="home" v-loading="get_wheat_loading">
        <canvas id="springydemo" width="1150" height="1000" />
        <div class="page">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="[10, 15, 20, 30, 40]"
                    :page-size="100"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </div>
        <remote-script name="js" src="/js/springy/springy.js" @load="get_wheat"></remote-script>
        <remote-script name="js" src="/js/springy/springyui.js"></remote-script>
        <div><!--小麦品种详情弹出框-->
            <el-dialog
                    title="小麦品种详情"
                    :visible.sync="wheatVisible"
                    size="small">
                <div class="wheat-nature" v-loading="get_nature_loading">
                    <p><span>品种名称：</span><span> {{ details.wheat.name }} </span></p>
                    <p><span>审定编号：</span><span> {{ details.wheat.code }} </span></p>
                    <p><span>申请单位：</span><span> {{ details.wheat. place}} </span></p>
                    <p><span>育 种 者：</span><span> {{ details.wheat.breeder}} </span></p>
                    <p><span>品种来源：</span><span> {{ details.wheat.child}} </span></p>
                    <p><span>特性特征：</span></p>
                    <div class="nature">
                        <p><span>生态类型：</span><span> {{ details.nature.ecology_type}} </span></p>
                        <p><span>苗性：</span><span> {{ details.nature.seed_nature}} </span></p>
                        <p><span>分蘖特性：</span><span> {{ details.nature.tiler_nature}} </span></p>
                        <p><span>株型：</span><span> {{ details.nature.plant_type}} </span></p>
                        <p><span>穗下节长度：</span><span> {{ details.nature.spike_length}} </span></p>
                        <p><span>旗叶特性：</span><span> {{ details.nature.leaf_nature}} </span></p>
                        <p><span>穗层：</span><span> {{ details.nature.spike_layer}} </span></p>
                        <p><span>株高：</span><span> {{ details.nature.plant_height}} </span></p>
                        <p><span>抗倒特性：</span><span> {{ details.nature.lodging}} </span></p>
                        <p><span>穗型：</span><span> {{ details.nature.panicle_type}} </span></p>
                        <p><span>根系活力：</span><span> {{ details.nature.root_activ}} </span></p>
                        <p><span>落黄：</span><span> {{ details.nature.yellow}} </span></p>
                        <p><span>亩穗数：</span><span> {{ details.nature.panicle_num}} 万</span></p>
                        <p><span>穗粒数：</span><span> {{ details.nature.grain_num}} 粒</span></p>
                        <p><span>千粒重：</span><span> {{ details.nature.ths_weight}} g</span></p>
                        <p><span>抗病性：</span><span> {{ details.nature.resistance}} </span></p>
                        <p><span>品质特性：</span></p>
                        <p><span>蛋白质含量：</span><span> {{ details.nature.protein}} %</span></p>
                        <p><span>容重：</span><span> {{ details.nature.volume}} g/L</span></p>
                        <p><span>湿面筋含量：</span><span> {{ details.nature.wet_gluten}} %</span></p>
                        <p><span>降落数值：</span><span> {{ details.nature.fall_num}} s</span></p>
                        <p><span>沉淀指数：</span><span> {{ details.nature.precipitate}} mL</span></p>
                        <p><span>吸水量：</span><span> {{ details.nature.water_uptake}} mL/100g</span></p>
                        <p><span>形成时间：</span><span> {{ details.nature.format_time}} min</span></p>
                        <p><span>稳定时间：</span><span> {{ details.nature.steady_time}} min</span></p>
                        <p><span>弱化度：</span><span> {{ details.nature.weaken}} F.U.</span></p>
                        <p><span>硬度：</span><span> {{ details.nature.hardness}} HI</span></p>
                        <p><span>白度：</span><span> {{ details.nature.white}} %</span></p>
                        <p><span>出粉率：</span><span> {{ details.nature.powder}} %</span></p>
                        <p><span>产量表现：</span><span> {{ details.nature.yield_result}} </span></p>
                        <p><span>栽培技术要点：</span><span> {{ details.nature.tech_point}} </span></p>
                        <p><span>审定意见：</span><span> {{ details.wheat.opinion }} </span></p>
                    </div>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="wheatVisible = false"> 关 闭 </el-button>
                    <!--<el-button type="primary" @click="wheatVisible = false">确 定</el-button>-->
                </span>
            </el-dialog>
        </div>
    </div>
</template>
<style scoped>
    .wheat-nature{
        font-size: 15px;
        /*line-height: 16px;*/
    }
    .wheat-nature span{
        line-height: 25px;
    }
    .nature{
        margin-left: 20px;
    }
    .page{
        padding: 20px 0 50px 50px;
        background: white;
    }
</style>
<script type="text/ecmascript-6">
    export default {
        data(){
            return {
                currentPage: 1,     //当前页
                pageNum:10,     //每页条数
                list: [],
                total: 0,   //下麦总数
                wheatVisible: false,
                details: {wheat:'',nature:''},
                get_wheat_loading: false,
                get_nature_loading: false
            }
        },
        computed: {},
        methods: {
            handleSizeChange(val) {
                this.pageNum = val
                this.get_wheat()
                //console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                this.currentPage = val
                this.get_wheat()
                //console.log(`当前页: ${val}`);
            },
            get_wheat(){
                this.get_wheat_loading = true
                axios.post('/get',{num:((this.currentPage-1)*this.pageNum),page:this.pageNum}).then(res=> {
                    if(res.data.code == 0){
                        this.list = res.data.result['wheat']
                        this.total = res.data.result['count']
                        this.query_all()
                    }
                    this.get_wheat_loading = false
                })
            },
            //判断是否节点已经存在
            exist(nodes,node) {
                for (let i in nodes){
                    if(nodes[i].data.label == node){
                        return true
                    }
                }
                return false
            },
            str_split(str){

                return arr
            },
            query_all() {
                var self = this
                //setTimeout(function () {
                    /*var graph = new Springy.Graph();
                    graph.addNodes('A', 'B', 'C', 'D', 'E','F', 'G', 'H', 'I')

                    graph.addEdges(
                        ['A', 'B', {color: '#00A0B0', label: 'Foo bar'}],
                        ['A', 'C', {color: '#CC333F'}],
                        ['C', 'D', {color: '#EB6841'}],
                        ['A', 'E', {color: '#EDC951'}],
                        ['F', 'G', {color: '#7DBE3C'}],
                        ['F', 'H', {color: '#BE7D3C'}],
                        ['G', 'H'],
                        ['F', 'I'],
                        ['G', 'I', {color: '#6A4A3C'}]
                    );
                    jQuery(function(){
                        var springy = jQuery('#springydemo').springy({
                            graph: graph,
                            nodeSelected: function(node){
                                console.log(graph,node)
                                console.log('Node selected: ' + JSON.stringify(node.data));
                            }
                        });

                    });*/
                //},0)
                /*var dennis = graph.newNode({
                    label: 'Dennis',
                    ondoubleclick: function() { console.log("Hello!"); }
                });*/

                //添加一个canvas标签
                $('#springydemo').remove()
                $('.page').before('<canvas id="springydemo" width="1150" height="1000" />')
                //开始画节点，包括连线
                var graph = new Springy.Graph();
                let line = []
                for (let i in this.list){
                    let arr = new Array()
                    graph.addNodes(this.list[i].name)
                    arr = this.list[i].child.split(',')
                    for (let j = 0;j<arr.length-1;j++){
                        graph.addNodes(arr[j])
                    }
                }

                for (let i in this.list){
                    if(this.list[i].child != ''){
                        let arr = new Array()
                        arr = this.list[i].child.split(',')
                        for (let j = 0;j<arr.length-1;j++){
                            line.push([arr[j],this.list[i].name])
                        }
                    }
                }
                for (let k in line){
                    graph.addEdges(line[k])
                }
                /*var michael = graph.newNode({label: 'Michael'});
                var jessica = graph.newNode({label: 'Jessica'});
                var timothy = graph.newNode({label: 'Timothy'});
                var barbara = graph.newNode({label: 'Barbara'});
                var franklin = graph.newNode({label: 'Franklin'});
                var monty = graph.newNode({label: 'Monty'});
                var james = graph.newNode({label: 'James'});
                var bianca = graph.newNode({label: 'Bianca'});

                graph.newEdge(dennis, michael, {color: '#00A0B0'});
                graph.newEdge(michael, dennis, {color: '#6A4A3C'});
                graph.newEdge(michael, jessica, {color: '#CC333F'});
                graph.newEdge(jessica, barbara, {color: '#EB6841'});
                graph.newEdge(michael, timothy, {color: '#EDC951'});
                graph.newEdge(franklin, monty, {color: '#7DBE3C'});
                graph.newEdge(dennis, monty, {color: '#000000'});
                graph.newEdge(monty, james, {color: '#00A0B0'});
                graph.newEdge(barbara, timothy, {color: '#6A4A3C'});
                graph.newEdge(dennis, bianca, {color: '#CC333F'});
                graph.newEdge(bianca, monty, {color: '#EB6841'});*/
                jQuery(function(){
                    var springy = window.springy = jQuery('#springydemo').springy({
                        graph: graph,
                        nodeSelected: function(node){
                            self.wheat_detail(node.data.label)
                            console.log(node.data.label)
                        }
                    });
                });
            },
            wheat_detail(name){
                this.get_nature_loading = true
                axios.post('/detail',{name:name}).then( res => {
                    if(res.data.code == 0){
                        if(res.data.result['nature'] == null){
                            this.$message({
                                message: '没有该品种的详情信息',
                                type: 'warning',
                                showClose: true
                            })
                        }else{
                            this.details = res.data.result
                            this.wheatVisible = true
                        }
                    }else{
                        this.$message({
                            message: res.data.result,
                            type: 'warning',
                            showClose: true
                        });
                    }
                    this.get_nature_loading = false
                })
            }
        },
        mounted() {

        },
    }
</script>
