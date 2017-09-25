<template>
    <div>
        <canvas id="springydemo" width="1100" height="550" />
        <remote-script name="js" src="/js/springy/springy.js" @load="get_wheat"></remote-script>
        <remote-script name="js" src="/js/springy/springyui.js"></remote-script>
    </div>
</template>
<style scoped>

</style>
<script type="text/ecmascript-6">
    export default {
        data(){
            return {
                list: [],
            }
        },
        computed: {},
        methods: {
            get_wheat(){
                axios.post('/get',{}).then(res=> {
                    if(res.data.code == 0){
                        this.list = res.data.result
                        this.test()
                    }
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
            test() {
                var self = this
                console.log(self.list)
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
                var graph = new Springy.Graph();
                let line = []
                /*var dennis = graph.newNode({
                    label: 'Dennis',
                    ondoubleclick: function() { console.log("Hello!"); }
                });*/

                for (let i in this.list){
                    /*if(!exist(graph.nodes,this.list[i].name)){
                        graph.addNodes(this.list[i].name)
                    }*/
                    graph.addNodes(this.list[i].name)
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
                //graph.addEdges(line)
                for (let k in line){
                    graph.addEdges(line[k])
                    //console.log(line[k])
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
                            console.log(node.data.href)
                            console.log('Node selected: ' + JSON.stringify(node.data));
                        }
                    });
                });
            },
        },
        mounted() {

        },
    }
</script>
