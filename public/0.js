webpackJsonp([0],{

/***/ 123:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(124)

var Component = __webpack_require__(36)(
  /* script */
  __webpack_require__(126),
  /* template */
  __webpack_require__(127),
  /* scopeId */
  "data-v-2778b020",
  /* cssModules */
  null
)
Component.options.__file = "F:\\project\\wheat_query\\resources\\assets\\js\\Home.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Home.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2778b020", Component.options)
  } else {
    hotAPI.reload("data-v-2778b020", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 124:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(125);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(18)("4dd70ba2", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-2778b020\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Home.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-2778b020\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Home.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 125:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(8)(undefined);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 126:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            list: []
        };
    },

    computed: {},
    methods: {
        get_wheat: function get_wheat() {
            var _this = this;

            axios.post('/get', {}).then(function (res) {
                if (res.data.code == 0) {
                    _this.list = res.data.result;
                    _this.test();
                }
            });
        },

        //判断是否节点已经存在
        exist: function exist(nodes, node) {
            for (var i in nodes) {
                if (nodes[i].data.label == node) {
                    return true;
                }
            }
            return false;
        },
        str_split: function str_split(str) {

            return arr;
        },
        test: function test() {
            var self = this;
            console.log(self.list);
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
            var line = [];
            /*var dennis = graph.newNode({
                label: 'Dennis',
                ondoubleclick: function() { console.log("Hello!"); }
            });*/

            for (var i in this.list) {
                /*if(!exist(graph.nodes,this.list[i].name)){
                    graph.addNodes(this.list[i].name)
                }*/
                graph.addNodes(this.list[i].name);
            }

            for (var _i in this.list) {
                if (this.list[_i].child != '') {
                    var _arr = new Array();
                    _arr = this.list[_i].child.split(',');
                    for (var j = 0; j < _arr.length - 1; j++) {
                        line.push([_arr[j], this.list[_i].name]);
                    }
                }
            }
            //graph.addEdges(line)
            for (var k in line) {
                graph.addEdges(line[k]);
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

            jQuery(function () {
                var springy = window.springy = jQuery('#springydemo').springy({
                    graph: graph,
                    nodeSelected: function nodeSelected(node) {
                        console.log('Node selected: ' + JSON.stringify(node.data));
                    }
                });
            });
        }
    },
    mounted: function mounted() {}
});

/***/ }),

/***/ 127:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('canvas', {
    attrs: {
      "id": "springydemo",
      "width": "640",
      "height": "480"
    }
  }), _vm._v(" "), _c('remote-script', {
    attrs: {
      "name": "js",
      "src": "/js/springy/springy.js"
    },
    on: {
      "load": _vm.get_wheat
    }
  }), _vm._v(" "), _c('remote-script', {
    attrs: {
      "name": "js",
      "src": "/js/springy/springyui.js"
    }
  })], 1)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-2778b020", module.exports)
  }
}

/***/ })

});