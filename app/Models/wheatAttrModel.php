<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2017/10/2
 * Time: 15:27
 */

namespace app\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class wheatAttrModel extends Model
{

    protected $table = 'wheat_attr';
    public $timestamps = false;
    protected $fillable = ['wheat_id', 'ecology_type', 'seed_nature', 'tiler_nature', 'plant_type', 'spike_length', 'leaf_nature', 'spike_layer', 'plant_height', 'lodging', 'panicle_type',
        'root_activ', 'yellow', 'panicle_num', 'grain_num', 'ths_weight', 'resistance', 'protein', 'volume', 'wet_gluten', 'fall_num', 'precipitate', 'water_uptake', 'format_time',
        'steady_time', 'weaken', 'hardness', 'white', 'powder', 'yield_result', 'tech_point'];

    public function addAttr($id, $data)
    {

        $this->create(['wheat_id' => $id, 'ecology_type' => $data['ecology_type'], 'seed_nature' => $data['seed_nature'], 'tiler_nature' => $data['tiler_nature'], 'plant_type' => $data['plant_type'],
            'spike_length' => $data['spike_length'], 'plant_height' => $data['plant_height'], 'lodging' => $data['lodging'], 'panicle_type' => $data['panicle_type'], 'root_activ' => $data['root_activ'],
            'yellow' => $data['yellow'], 'panicle_num' => $data['panicle_num'], 'grain_num' => $data['grain_num'], 'ths_weight' => $data['ths_weight'], 'resistance' => $data['resistance'], 'protein' => $data['protein'],
            'volume' => $data['volume'], 'wet_gluten' => $data['wet_gluten'], 'fall_num' => $data['fall_num'], 'precipitate' => $data['precipitate'], 'water_uptake' => $data['water_uptake'], 'format_time' => $data['format_time'],
            'steady_time' => $data['steady_time'], 'weaken' => $data['weaken'], 'hardness' => $data['hardness'], 'white' => $data['white'], 'powder' => $data['powder'], 'yield_result' => $data['yield_result'], 'tech_point' => $data['tech_point']]);


    }

    public function updates($id,$data){
        $this->where('wheat_id',$id)->update(['ecology_type' => $data['ecology_type'], 'seed_nature' => $data['seed_nature'], 'tiler_nature' => $data['tiler_nature'], 'plant_type' => $data['plant_type'],
            'spike_length' => $data['spike_length'], 'plant_height' => $data['plant_height'], 'lodging' => $data['lodging'], 'panicle_type' => $data['panicle_type'], 'root_activ' => $data['root_activ'],
            'yellow' => $data['yellow'], 'panicle_num' => $data['panicle_num'], 'grain_num' => $data['grain_num'], 'ths_weight' => $data['ths_weight'], 'resistance' => $data['resistance'], 'protein' => $data['protein'],
            'volume' => $data['volume'], 'wet_gluten' => $data['wet_gluten'], 'fall_num' => $data['fall_num'], 'precipitate' => $data['precipitate'], 'water_uptake' => $data['water_uptake'], 'format_time' => $data['format_time'],
            'steady_time' => $data['steady_time'], 'weaken' => $data['weaken'], 'hardness' => $data['hardness'], 'white' => $data['white'], 'powder' => $data['powder'], 'yield_result' => $data['yield_result'], 'tech_point' => $data['tech_point']]);
    }
}