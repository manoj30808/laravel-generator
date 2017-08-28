<?php

namespace MspPack\DDSGenerate\Http;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use View;
use MspPack\DDSGenerate\Repositories\GeneratorRepo;
use Illuminate\Support\Facades\Validator;
use MspPack\DDSGenerate\DatabaseUpdate\DatabaseUpdater;
use MspPack\DDSGenerate\Helpers\EloquentHelper;
class GeneratorController extends Controller
{
    /** 
     * Create a new controller instance.
     *
     * @return void
     */
    private $view_path;
    private $ctrl_url;
    private $data;
    private $helper;
    private $GeneratorRepo;
    public function __construct(Guard $auth,GeneratorRepo $GeneratorRepo,EloquentHelper $helper)
    {
        parent::__construct($auth);
        $this->middleware('auth');
        $this->GeneratorRepo = $GeneratorRepo;
        $this->ctrl_url = '/admin/generate';
        $this->view_path = 'admin.generate';
        $this->helper = $helper;
        $this->data['input_type'] = array('integer'=>'integer','string'=>'string');
        View::share([
            'data'=>$this->data,
            'ctrl_url'=>$this->ctrl_url,
            'view_path'=>$this->view_path,
            'module_name'=> 'Generate',
            'title'=>'Generate'
        ]);
        View::share('module_name','Generator');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param['filter'] = $request->input("filter", array());
        $param['sort'] = $request->input("sort", array());
        $param['paginate'] = TRUE;
        if($request->input('filter.name.value')){
            $param['filter']['name']['value'] = '%'.$request->input('filter.name.value').'%';
        }

        $items = $this->GeneratorRepo->getBy($param);

        //serial number
        $srno = ($request->input('page', 1) - 1) * config("setup.par_page", 10)  + 1;

        $compact = compact('items','srno');

        return view($this->view_path . '.index',$compact)->with('title', 'list');
    }

    public function create()
    {
        return view($this->view_path.'.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->except('_token','_method');
        $data   = array_except($inputs,array('save','save_exit'));

        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'row.*.field' => 'required'
        ];
        $validator = Validator::make($inputs, $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            return redirect($this->ctrl_url.'/create')
                ->withErrors($validator)
                ->withInput();
        }

        if($this->GeneratorRepo->create($data)){

            \Artisan::call('make:model',['name'=>ucfirst($data['name'])]);
            
            $className = 'App\\' . ucfirst($data['name']);
            $model = new $className;
            $table_name=$model->getTable();
            
            $fields = array();
            if(!empty($data['row'])){
                foreach ($data['row'] as $key => $value) {
                    $fields[] = $value['field'].':'.$value['input_type'];
                }
                $fields[]='deleted:integer:default(0)';
                $fields = implode(',', $fields);
                \Artisan::call('make:migration:schema',['name'=>'create_'.$table_name.'_table','--schema'=>$fields]);
                \Artisan::call('migrate');
            }
            
            return redirect($this->ctrl_url)
            ->with('success', 'Record created sucessfully');
        }

        return redirect('admin/setting')->with('error', 'Can not be created');
    }

    public function edit(Request $request,$id='')
    {
        $item = $this->GeneratorRepo->find($id);
        return view($this->view_path.'.edit')->with('item',$item);
    }

    public function update(Request $request,$id)
    {
        $inputs = $request->except('_token','_method');
        $data   = array_except($inputs,array('save'));

         $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'row.*.field' => 'required'
        ];

        // Create a new validator instance from our validation rules
        $validator = Validator::make($inputs, $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            return redirect($this->ctrl_url.'/'.$id.'/edit')
                ->with('old',$data)
                ->withErrors($validator)
                ->withInput();
        }
        
        $database_fields = $this->helper->updateTableField($data);
        
        DatabaseUpdater::update($database_fields);
        
        if($this->GeneratorRepo->update($data,$id)){
            return redirect($this->ctrl_url)
            ->with('success', 'Record updated sucessfully');
        }

        return redirect($this->ctrl_url)
                ->with('error', 'Can not be created');
    }
}
