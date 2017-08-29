<?php

namespace MspPack\DDSGenerate\Http;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use View;
use MspPack\DDSGenerate\Repositories\GeneratorRepo;
use MspPack\DDSGenerate\Repositories\ModuleRepo;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $view_path;
    private $ctrl_url;
    private $data;
    private $ModuleRepo;
    public function __construct(Guard $auth,ModuleRepo $ModuleRepo)
    {
        parent::__construct($auth);
        $this->middleware('auth');
        $this->ModuleRepo = $ModuleRepo;
        $this->view_path = 'admin.module';
        
        View::share([
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
    public function index(Request $request,$slug='')
    {
        $module_basic_details = $this->ModuleRepo->getModuleDetails($slug);
        if (!empty($module_basic_details)) {
            $param['filter'] = $request->input("filter", array());
            $param['sort'] = $request->input("sort", array());
            $param['paginate'] = TRUE;
            if($request->input('filter.name.value')){
                $param['filter']['name']['value'] = '%'.$request->input('filter.name.value').'%';
            }
            $param['filter']['deleted']['value'] = \DB::raw('"0"');

            $items = $this->ModuleRepo->getBy($module_basic_details['name'],$param);
            
            //serial number
            $srno = ($request->input('page', 1) - 1) * config("setup.par_page", 10)  + 1;

            $compact = compact('items','srno','module_basic_details');
            
            $this->ctrl_url = "/admin/module/$slug";
            return view($this->view_path . '.index',$compact)
                    ->with('ctrl_url', $this->ctrl_url)
                    ->with('module_basic_details', $module_basic_details)
                    ->with(['module_name'=>$module_basic_details['name'],'title'=>'List']);
        }

        return view($this->view_path . '.not_found');
    }

    public function create(Request $request,$slug='')
    {
        $module_basic_details = $this->ModuleRepo->getModuleDetails($slug);
        if (!empty($module_basic_details)) {
            
            $this->ctrl_url = "/admin/module/$slug";
            return view($this->view_path . '.create')
                        ->with('ctrl_url', $this->ctrl_url)
                        ->with('module_basic_details', $module_basic_details)
                        ->with(['module_name'=>$module_basic_details['name'],'title'=>'Create']);
        }
        return view($this->view_path . '.not_found');
    }

    public function store(Request $request,$slug)
    {
        $module_basic_details = $this->ModuleRepo->getModuleDetails($slug);
        $this->ctrl_url = "/admin/module/$slug";

        $inputs = $request->except('_token');
        $data   = array_except($inputs, 'save');
        
        $rules = array();
        foreach ($module_basic_details['fields'] as $key => $value) {
            if (!empty($value['validation']))
                $rules[$value['field']] = $value['validation'];
        }
        
        if(!empty($rules)){
            // Create a new validator instance from our validation rules
            $validator = Validator::make($inputs, $rules);

            // If validation fails, we'll exit the operation now.
            if ($validator->fails()) {
                return redirect($this->ctrl_url.'/create')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        if($user = $this->ModuleRepo->create($data,$module_basic_details['name'])){
            return redirect($this->ctrl_url)
                ->with('success', 'Record added sucessfully');
        }

        return redirect($this->ctrl_url)->with('error', 'Can not be created');
    }

    public function edit($slug='',$id='')
    {
        $module_basic_details = $this->ModuleRepo->getModuleDetails($slug);
        if (!empty($module_basic_details)) {
            $param['single'] = TRUE;
            $param['filter']['id']['value'] = $id;

            $item = $this->ModuleRepo->getBy($module_basic_details['name'],$param);

            $this->ctrl_url = "/admin/module/$slug";
            return view($this->view_path . '.edit')
                        ->with('ctrl_url', $this->ctrl_url)
                        ->with('item', $item)
                        ->with('module_basic_details', $module_basic_details)
                        ->with(['module_name'=>$module_basic_details['name'],'title'=>'Update']);
        }
        return view($this->view_path . '.not_found');
    }
    public function update(Request $request ,$slug='',$id='')
    {
        $module_basic_details = $this->ModuleRepo->getModuleDetails($slug);
        $this->ctrl_url = "/admin/module/$slug";

        $inputs = $request->except('_token','_method');
        $data   = array_except($inputs, 'save');
        
        $rules = array();
        foreach ($module_basic_details['fields'] as $key => $value) {
            if (!empty($value['validation']))
                $rules[$value['field']] = $value['validation'];
        }
        
        if(!empty($rules)){
            // Create a new validator instance from our validation rules
            $validator = Validator::make($inputs, $rules);

            // If validation fails, we'll exit the operation now.
            if ($validator->fails()) {
                return redirect($this->ctrl_url.'/'.$id.'/edit')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        if($user = $this->ModuleRepo->update($data,$module_basic_details,$id)){
            return redirect($this->ctrl_url)
                ->with('success', 'Record updated sucessfully');
        }

        return redirect($this->ctrl_url)->with('error', 'Can not be updated');
    }
    public function destroy($slug='',$id='')
    {
        $this->ctrl_url = "/admin/module/$slug";
        if($this->ModuleRepo->delete($slug,$id)){
            return redirect($this->ctrl_url)->with('success', 'Record Deleted Successfully');
        }
    }
}
