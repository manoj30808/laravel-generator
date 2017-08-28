<?php namespace MspPack\DDSGenerate\Repositories;

use MspPack\DDSGenerate\Generator;
use MspPack\DDSGenerate\GeneratorSub;
use MspPack\DDSGenerate\Helpers\EloquentHelper;
use DB;

class ModuleRepo
{
	public function getBy($module_name='',$params = array())
	{
		$className = 'App\\' . ucfirst($module_name);
		$model = new $className;
        $table_name=$model->getTable();

        $query = DB::table($table_name);

        $query->select(array(
            $table_name.'.*',
        ));

        $EloquentHelper = new EloquentHelper();
        return $EloquentHelper->allInOne($query, $params);
	}

	public function getModuleDetails($slug)
	{
		$data = Generator::select(array(
					'modules.name',
					'modules.slug',
					'modules.icon',
					'modules.status',

					'module_fields.field',
					'module_fields.display_name',
					'module_fields.input_type',
					'module_fields.visibility',
					'module_fields.validation'
				))
				->where('modules.slug','=',$slug)
				->leftjoin('module_fields',function($j){
					$j->on('module_fields.module_id','=','modules.id');
					$j->on('module_fields.deleted','=','modules.deleted');
				})
				->where('modules.deleted','=',DB::raw('"0"'))
				->get();

		$o = array();
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$o['name']=$value->name;
				$o['slug']=$value->slug;
				$o['icon']=$value->icon;
				$o['status']=$value->status;
				$o['fields'][$key]['field'] = $value->field;
				$o['fields'][$key]['display_name'] = $value->display_name;
				$o['fields'][$key]['input_type'] = $value->input_type;
				$o['fields'][$key]['visibility'] = $value->visibility;
				$o['fields'][$key]['validation'] = $value->validation;
			}
		}
		
		return $o;
	}

	public function find($id)
	{
		return User::find($id);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data,$name='')
	{
		DB::beginTransaction();
        try{
        	$className = 'App\\' . ucfirst($name);
			$model = new $className;
			
			$model->insert(array($data));

			DB::commit();
            return true;
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
	public function update($data,$module_basic_details,$id)
	{
		DB::beginTransaction();
        try{
        	$className = 'App\\' . ucfirst($module_basic_details['name']);
			$model = new $className;
			
			$model->where('id','=',$id)->update($data);

			DB::commit();
            return true;
        }catch(Exception $e){
        DB::rollback();
        throw $e;
        }
	}


	public function delete($slug='',$id='')
	{
		$module_basic_details = $this->getModuleDetails($slug);
		DB::beginTransaction();
        try{
        	$className = 'App\\' . ucfirst($module_basic_details['name']);
			$model = new $className;
			
			$model->where('id','=',$id)->update(array('deleted'=>DB::raw('"1"')));

			DB::commit();
            return true;
        }catch(Exception $e){
        DB::rollback();
        throw $e;
        }
	}
}