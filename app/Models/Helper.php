<?php

namespace App\Models;

use App\Models\CodeMaster;
use App\Models\Species;
use App\Models\Authorization\Role;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Carbon\Carbon;

class Helper extends Model
{
    use HasFactory;

    public function uuid()
    {
        return Str::uuid();
    }

    public function localize($str)
    {
        $str = strtolower(preg_replace('/\s+/', '', $str));
        $localeStr = $str;
        foreach (__('app') as $key => $value) {
            if ($key == $str) {
                $localeStr = $value;
                break;
            }
        }
        if ($localeStr == $str) {
            foreach (__('auth') as $key => $value) {
                if ($key == $str) {
                    $localeStr = $value;
                    break;
                }
            }
        }
        return $localeStr;
    }

    public function getSingular($str, $localize = false)
    {
        $str = str_replace(str_split('_-'), ' ', $str);
        if (strcmp($str, trim($str)) === 0 && Str::contains($str, ' ')) {
            $array = array();
            $strs = explode(' ', $str);
            $lastkey = array_key_last($strs);
            foreach ($strs as $key => $value) {
                if ($key == $lastkey) {
                    $array[] = Str::singular($value);
                }
                else {
                    $array[] = $value;
                }
            }
            $new_str = $localize ? strtolower(implode('_', $array)) : implode(' ', $array);
        }
        else {
            $new_str = Str::singular($str);
        }
        return $localize ? Helper::localize($new_str) : $new_str;
    }

    public function getSingularSlug($str, $localize = false)
    {
        return Str::slug($this->getSingular($str, $localize));
    }

    public function getSingularSnake($str, $localize = false)
    {
        return Str::snake($this->getSingular($str, $localize));
    }

    public function getSingularTitle($str, $localize = false)
    {
        return Str::title($this->getSingular($str, $localize));
    }

    public function customNumberFormat($num, $format_uppercase = false)
    {
        if ($num > 1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = $format_uppercase ? array('K', 'M', 'B', 'T') : array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }
      
        return $num;
    }

    public function limitTextLength($text, $length = 50)
    {
        return strlen($text) > $length ? substr($text, 0, $length).'...' : $text;
    }

    public function isEmptyArray($array)
    {
        $rtn = false;
        if (empty($array)) {
            $rtn = true;
        } else {
            foreach ($array as $arr) {
                if (empty($arr)) {
                    $rtn = true;
                }
            }
        }
        return $rtn;
    }

    public function getCodeMastersByType($type, $parent_id = null, $parent_name = null, $parent_type = null, $orderBy = false)
    {
        $code_masters = CodeMaster::where('type', $type);

        if (!empty($parent_id)) {
            $code_masters->where('parent_id', $parent_id);
        }
        if (!empty($parent_name)) {
            if (!empty($parent_type)) {
                $parent_id = $this->getCodeMasterIdByTypeName($parent_type, $parent_name);
                $code_masters->where('parent_id', $parent_id);
            }
            else {
                $code_masters->where('parent_name', $parent_name);
            }
        }

        $code_masters->where('is_active', true);
        
        return $orderBy ? $code_masters->orderBy('order')->get() : $code_masters->orderBy('name')->get();
    }

    public function getCodeMastersByTypeOrder($type, $parent_id = null, $parent_name = null, $parent_type = null, $orderBy = false)
    {
        $code_masters = CodeMaster::where('type', $type);

        if (!empty($parent_id)) {
            $code_masters->where('parent_id', $parent_id);
        }
        if (!empty($parent_name)) {
            if (!empty($parent_type)) {
                $parent_id = $this->getCodeMasterIdByTypeName($parent_type, $parent_name);
                $code_masters->where('parent_id', $parent_id);
            }
            else {
                $code_masters->where('parent_name', $parent_name);
            }
        }

        $code_masters->where('is_active', true);
        
        return $orderBy ? $code_masters->orderBy('order')->get() : $code_masters->orderBy('order')->get();
    }

    public function getCodeMastersNameByType($type, $parent_id = null, $orderBy = false)
    {
        $code_masters = CodeMaster::where('type', $type);

        if (!empty($parent_id)) {
            $code_masters->where('parent_id', $parent_id);
        }

        $code_masters->where('is_active', true);
        
        return $orderBy ? $code_masters->orderBy('order')->get(['name']) : $code_masters->orderBy('name')->get(['name']);
    }

    public function getCodeMasterById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id) : null;
    }

    public function getCodeMasterNameById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id)->name : '';
    }

    //Asyraf
    public function getCodeMasterNameEnById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id)->name : '';
    }

    //Asyraf
    public function getCodeMasterNameMsById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id)->name_ms : '';
    }

    //Asyraf
    public function getSpeciesNameById($id)
    {
        return !empty(Species::find($id)) ? Species::find($id)->common_name : '';
    }

    //Intan
    public function getParliamentNameById($id)
    {
        return !empty(Parliament::find($id)) ? Parliament::find($id)->parliament_name : '';
    }

    public function getParliamentSeatNameById($id)
    {
        return !empty(ParliamentSeat::find($id)) ? ParliamentSeat::find($id)->parliament_seat_name : '';
    }

    //Asyraf
    public function getRoleNameEnById($id)
    {
        return !empty(Role::find($id)) ? Role::find($id)->name : '';
    }

    /*public function getCodeMasterNameByTypeCode($type, $code)
    {
		$code_master = CodeMaster::where('type', $type)->where('code', $code)->first();
		
		if ( !is_null($code_master) ) 
			return $code_master;
		else
			return '';
    }*/

    public static function getCodeMasterNameByTypeCode($type, $code)
    {
		$code_master = CodeMaster::where('type', $type)->where('name', $code)->first();
		
		if ( !is_null($code_master) ) 
			return $code_master;
		else
			return '';
    }
	
	public function getCodeMasterNameByTypeLikeCode($type, $code)
    {
		$code_master = CodeMaster::where('type', $type)->where('code','like', $code)->get();
		
		if ( !is_null($code_master) ) 
			return $code_master;
		else
			return '';
    }

    public function getCodeMasterNameByTypeLikeCodeOrder($type, $code)
    {
		$code_master = CodeMaster::where('type', $type)->where('code','like', $code)->orderBy('order')->get();
		
		if ( !is_null($code_master) ) 
			return $code_master;
		else
			return '';
    }

    public function getCodeMasterIdByTypeName($type, $name) {
        $name = ucwords(strtolower($name));
        return !empty(CodeMaster::where('type', $type)->where('name', $name)->first()) ? CodeMaster::where('type', $type)->where('name', $name)->first()->id : '';
    }

    public function codeMasterExists($slug, $name, $code = null, $id = null, $parent_id = null)
    {
        $code_master = CodeMaster::where('type', $this->getSingular($slug));

        if (!empty($code)) {
            $code_master->where(function ($query) use ($name, $code) {
                $query->where('name', $name)
                    ->orWhere('code', $code);
            });
        }
        else {
            $code_master->where('name', $name);
        }

        if (!empty($id)) {
            $code_master->where('id', '<>', $id);
        }

        if (!empty($parent_id)) {
            $code_master->where('parent_id', $parent_id);
        }

        return $code_master->get()->count() >= 1 ? true : false;
    }

    //Asyraf
    public function getApplicationTypeNameById($id)
    {
        return !empty(ApplicationType::find($id)) ? ApplicationType::find($id)->name : '';
    }

    public function getApplicationTypeNameEnById($id)
    {
        return !empty(ApplicationType::find($id)) ? ApplicationType::find($id)->name : '';
    }

    public function getApplicationTypeNameMsById($id)
    {
        return !empty(ApplicationType::find($id)) ? ApplicationType::find($id)->name_ms : '';
    }

    public function getUsersNameById($id)
    {
        return !empty(User::find($id)) ? User::find($id)->name : '';
    }

    //nazran 06/10/2022
    public function getUsersIcById($id)
    {
        return !empty(User::find($id)) ? User::find($id)->username : '';
    }

    public function getUsersEmailById($id)
    {
        return !empty(User::find($id)) ? User::find($id)->email : '';
    }
    // End Nazran

    public function getEntityNameById($id)
    {
        return !empty(Entity::find($id)) ? Entity::find($id)->entity_name : '';
    }

    public function getRoleIdByRoleName($name) {
        //$name = ucwords(strtolower($name));
        return !empty(Role::where('name', $name)->first()) ? Role::where('name', $name)->first()->id : '';
    }
	
	public function getEntityNameByStateId($id)
    {
		$cm = CodeMaster::where('id', $id)->first();
		$branch = Entity::where('state_code', $cm->code)
                        ->where('entity_level','3')
                        ->get();
		
		if ( !is_null($branch) ) 
			return $branch;
		else
			return '';
    }

    //Asyraf
    public function getPostcodeByDistrict($id)
    {
		$postcode = Postcode::where('district_id', $id)->get();
		
		if ( !is_null($postcode) ) 
			return $postcode;
		else
			return '';
    }

    //Asyraf
    public function getJuruauditByRole($id)
    {
		$juruaudit = User::where('users.is_active', true)
        ->join('user_role','user_role.user_id','=','users.id')
        ->join('roles','roles.id','=','user_role.role_id')
        ->where('roles.id','=',$id);
		
		if ( !is_null($juruaudit) ) 
			return $juruaudit->select('users.*')->get();
		else
			return '';
    }

    public function getLabNameById($id)
    {
        return !empty(Laboratory::find($id)) ? Laboratory::find($id)->lab_name : '';
    }

    public function getApplicationCompanyNameById($id)
    {
        return !empty(Application::find($id)) ? Application::find($id)->company_name : '';
    }

    public function getApplicationCompanyRegNoById($id)
    {
        return !empty(Application::find($id)) ? Application::find($id)->company_reg_no : '';
    }

    //Nazran
    public function getAddHatcheriesById($id)
    {
        return !empty(AddHatcheries::find($id)) ? AddHatcheries::find($id) : null;
    }

    public function getAddHatcheriesById2($id)
    {
        /*$juruaudit = HatcheriesAddShrimp::where('hatcheries_add_shrimps.id', $id)
        ->join('add_hatcheries', 'hatcheries_add_shrimps.hatcheries_species_id', '=', 'add_hatcheries.id')->first();*/

        $juruaudit = HatcheriesChecklistsPengawaiSokongDetails::where('hatcheries_checklists_pengawai_sokong_details.id', $id)
        ->join('hatcheries_add_shrimps', 'hatcheries_checklists_pengawai_sokong_details.jenis_udang_id', '=', 'hatcheries_add_shrimps.id')
        ->join('add_hatcheries', 'hatcheries_add_shrimps.hatcheries_species_id', '=', 'add_hatcheries.id')
        ->first();

        $id = $juruaudit->id;
            
        return !empty(AddHatcheries::find($id)) ? AddHatcheries::find($id) : null;
    }
    public function getAddHatcheriesById3($id)
    {
        //$juruaudit = HatcheriesAddShrimp::where('id', $id)->first();
        $juruaudit = HatcheriesChecklistsPengawaiSokongDetails::where('hatcheries_checklists_pengawai_sokong_details.id', $id)
        ->join('hatcheries_add_shrimps', 'hatcheries_checklists_pengawai_sokong_details.jenis_udang_id', '=', 'hatcheries_add_shrimps.id')
        ->first();
		
        $id = $juruaudit->id;

        return !empty(HatcheriesAddShrimp::find($id)) ? HatcheriesAddShrimp::find($id) : null;
    }
    public function getAddHatcheriesById4($id)
    {
        //$juruaudit = HatcheriesAddShrimp::where('id', $id)->first();
        $juruaudit = HatcheriesChecklistsPengawaiSokongDetails::where('id', $id)
        ->first();
		
        $id = $juruaudit->id;

        return !empty(HatcheriesChecklistsPengawaiSokongDetails::find($id)) ? HatcheriesChecklistsPengawaiSokongDetails::find($id) : null;
    }
    public function getNamaPenuhById($id)
    {
        $juruaudit = AngkutFQ01BBorangs::where('fq01_id', $id)
        ->first();
        if(!empty($juruaudit)){
            //$id = $juruaudit->id;
            $nama_penuh = $juruaudit->nama_penuh;
        }else{
            //$id = null;
            $nama_penuh = null;
        }

        return $nama_penuh;
    }

    //Nazran
    public function getCodeMasterCountryNameById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id)->name : '';
    }

    public static function getCodeMasterCountryIdByName($name)
    {
        return CodeMaster::where('name', $name)->first();
    }

    public function getCodeMasterStateNameById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id)->name : '';
    }

    public function getCodeMasterDistrictNameById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id)->name : '';
    }

    //Asyraf
    public function getSpeciesBySpeciesTypeId($id)
    {
		$species = Species::where('species_type_id', $id)->get();
		
		if ( !is_null($species) ) 
			return $species;
		else
			return '';
    }

    //nazran - pensempalan ikan
    /*public function getCodeMasterStateNameById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id)->name : '';
    }*/
    public function getCodeMasterKomoditiNameById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id)->name : '';
    }
    public function getCodeMasterPenyakitNameById($id)
    {
        return !empty(CodeMaster::find($id)) ? CodeMaster::find($id)->name : '';
    }

    public function getLaboratoryNameById($id)
    {
        return !empty(Laboratory::find($id)) ? Laboratory::find($id)->lab_name : '';
    }

    //Get Lab Auditor
    public function getLabAuditorByRole($rolename = null, $orderBy = false)
    {

        $rolename = 'MAKMAL - '.$rolename;

        $users = User::where('users.is_active', true)
        ->join('user_role','user_role.user_id','=','users.id')
        ->join('roles','roles.id','=','user_role.role_id')
        ->select('users.id','users.name','roles.name as rolename')
        ->whereIn('roles.name',[$rolename]);
        
        return $orderBy ? $users->orderBy('users.name')->get() : $users->orderBy('users.name')->get();
    }
	
	public function parliamentExists($name, $code, $state)
    {
        $code_master = Parliament::where('parliament_code', $code);

        if (!empty($code)) {
            $code_master->where(function ($query) use ($name, $code) {
                $query->where('parliament_name', $name)
                    ->orWhere('parliament_code', $code);
            });
        }
        
        else {
            $code_master->where('parliament_name', $name);
        }

        return $code_master->get()->count() >= 1 ? true : false;
    }

    public function parliamentSeatExists($name, $code, $parliament)
    {
        $code_master = ParliamentSeat::where('parliament_seat_code', $code);

        if (!empty($code)) {
            $code_master->where(function ($query) use ($name, $code) {
                $query->where('parliament_seat_name', $name)
                    ->orWhere('parliament_seat_code', $code);
            });
        }
        else {
            $code_master->where('parliament_seat_name', $name);
        }

        return $code_master->get()->count() >= 1 ? true : false;
    }

    public function convertDateToFormat($date)
    {
        $date = Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
      
        return $date;
    }

    //Asyraf
    public function getEntitiesByLevel($level)
    {
        $entities = Entity::where('entity_level', $level)
        ->where('is_active', true);

	//dd($level);
        
        return $entities->orderBy('entity_name')->get();
    }

    public function convertIcToAge($icNumber)
    {
        //age from ic
        $ic_first_6_digit = substr($icNumber, 0, 6);
        $date = Carbon::createFromFormat('ymd', $ic_first_6_digit);
        $age = $date->age;

        return $age;
    }

}