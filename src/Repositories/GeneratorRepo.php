<?php namespace MspPack\DDSGenerate\Repositories;

use MspPack\DDSGenerate\Generator;
use MspPack\DDSGenerate\GeneratorSub;
use MspPack\DDSGenerate\Helpers\EloquentHelper;
use DB;

class GeneratorRepo
{
	public function getBy($params = array())
	{
		$query = DB::table('modules');

        $query->select(array(
            'modules.*',
        ));

        $EloquentHelper = new EloquentHelper();
        return $EloquentHelper->allInOne($query, $params);
	}

	public function find($id)
	{
		$data = Generator::find($id);
		$data['sub'] = GeneratorSub::where('module_id','=',$id)
						->where('deleted','=',DB::raw('"0"'))
						->get();
		return $data;
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		DB::beginTransaction();
        try{
        	$generator = new Generator;
			$module['name']  = $data['name'];
			$module['slug']  = $data['slug'];
			$module['icon']  = !empty($data['icon'])?$data['icon']:'a';
			$module['is_display_in_menu']  = isset($data['is_display_in_menu'])?$data['is_display_in_menu']:0;
			$module['is_model']  = isset($data['is_model'])?$data['is_model']:0;
			$module['status']  = isset($data['status'])?$data['status']:0;

			$module_id = $generator->create($module)->getKey();
			
			if(!empty($module_id) && isset($data['row']) ){
				$row = $data['row'];
				
				$insert_ary = array();
				foreach ($row as $key => $value) {
					$insert_ary[$key]=array(
						'module_id' => $module_id,
						'field' => $value['field'],
						'display_name' => $value['display_name'],
						'input_type' => $value['input_type'],
						'visibility' => implode(',',array_filter($value['visibility'])),
						'validation' => implode('|',array_filter($value['validation']))
					);
				}

				$generatorsub = new GeneratorSub;
				$generatorsub->insert($insert_ary);

			}
			
			DB::commit();
            return $module_id;
        }catch(Exception $e){
        DB::rollback();
        throw $e;
        }
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function update(array $data,$id)
	{
		DB::beginTransaction();
        try{
        	$generator = new Generator;
			$module['name']  = $data['name'];
			$module['slug']  = $data['slug'];
			$module['icon']  = !empty($data['icon'])?$data['icon']:'a';
			$module['is_display_in_menu']  = isset($data['is_display_in_menu'])?$data['is_display_in_menu']:0;
			$module['is_model']  = isset($data['is_model'])?$data['is_model']:0;
			$module['status']  = isset($data['status'])?$data['status']:0;

			$generator->where('id','=',$id)->update($module);
			
			if(!empty($id) && isset($data['row']) ){
				$row = $data['row'];
				
				$insert_ary = array();
				foreach ($row as $key => $value) {
					$insert_ary[$key]=array(
						'module_id' => $id,
						'field' => $value['field'],
						'display_name' => $value['display_name'],
						'input_type' => $value['input_type'],
						'visibility' => implode(',',array_filter($value['visibility'])),
						'validation' => implode('|',array_filter($value['validation']))
					);
				}

				$generatorsub = new GeneratorSub;
				$generatorsub->where('module_id','=',$id)->delete();
				$generatorsub->insert($insert_ary);

			}
			
			DB::commit();
            return true;
        }catch(Exception $e){
        DB::rollback();
        throw $e;
        }
	}
}