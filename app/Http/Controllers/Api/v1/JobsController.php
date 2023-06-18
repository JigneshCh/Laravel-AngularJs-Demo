<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Jobs;
use Illuminate\Http\Request;

class JobsController extends Controller
{
	/**
     * Create pagination data for First, Previous, Next, Last and N number of page to display
     *
     * @return array $res;
     */
	public function paginationFormat($data){
		$maxNo = 5; // Use odd number for better result
		$sideMaxNo = ($maxNo-1)/2;
		$result = ['First'=>0,'Prev'=>0];
		if($data['current_page'] > 1 && $data['last_page'] >= $data['current_page']){
			$result['First'] = 1;
			$result['Prev'] = 1;
		}
		if(($data['current_page']-1) > $sideMaxNo && $data['last_page'] >= $data['current_page']){
			$result['dotsl'] = 0;
		}
		if($data['last_page'] > $maxNo){
			$counter =0;
			for($i=1; $i<= $data['last_page']; $i++ ){
				if( $i >=  ($data['current_page'] - $sideMaxNo) && $i < $data['current_page'] ){
					$result[$i] = 1;
					$counter++;
				}else if($i == $data['current_page']){
					$result[$i] = 0; // Disable current page
					$counter++;
				}else if($i > $data['current_page'] && $i <= ($data['current_page'] + $sideMaxNo)  && $i <= ($data['last_page']) ){
					$result[$i] = 1;
					$counter++;
				}else if($i > $data['current_page'] && $counter < $maxNo && $i <= ($data['last_page']) ){
					$result[$i] = 1;
					$counter++;
				}
			}
		}else{
			for($i=1; $i< $data['last_page']; $i++ ){
				if($i == $data['current_page']){
					$result[$i] = 0; // Disable current page
				}else{
					$result[$i] = 1;
				}
			}
		}
		if($data['last_page'] > $data['current_page'] + $sideMaxNo){
			$result['dotsr'] = 0;
		}
		$result['Next'] = 0;
		$result['Last'] = 0;
		if($data['last_page'] > $data['current_page']){
			$result['Next'] = 1;
			$result['Last'] = 1;
		}
		$res = [];
		foreach($result as $key=>$value){
			$val = $key;
			if($key == "First"){
				$val = 1;
			}else if($key == "Last"){
				$val = $data['last_page'];
			}else if($key == "Next"){
				$val = $data['current_page'] + 1;
			}else if($key == "Prev"){
				$val = $data['current_page'] - 1;
			}
			$res[] = [
				'lable'=>($key == 'dotsr' || $key == 'dotsl')? '...' : $key,
				'is_enable'=>$value,
				'val'=>$val,
				'is_active'=>($key == $data['current_page'])? 1 : 0,
				'is_link'=>(in_array($key,['First','Last','Next','Prev','dotsr','dotsl']))? 0 : 1,
			];
		}
		//dd($res);
		return $res;
	}
	public function JsonResponse($parameter)
    {
		return response()->json([
            'messages' => $parameter["messages"],
            'data' => $parameter["data"],
            'status' => ($parameter["code"] ==200)? "true": "false",
            'code' => $parameter["code"]
        ], 200);
		
    }
    /**
     * API to get jobs with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function findJobs(Request $request)
    {
		sleep(2); // To check loader
        $result = ["data"=>[],"code"=>200,"messages"=>""];
		$perPage = $request->get('per_page',10); // Data per page
		$jobs = Jobs::paginate($perPage)->toArray();
		$page_obj = $this->paginationFormat($jobs);
		
		$jobs['page_ob'] = $page_obj;
		$result['data'] = $jobs;		
		return $this->JsonResponse($result);
    }
}
