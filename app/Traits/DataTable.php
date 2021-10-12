<?php

namespace App\Traits;

trait DataTable{

    public function selectData($actions){
        return array();
    }

    public function dataTableQuery(){
        return array();
    }

    public function dataTable($actions, array $data){

        $selectData = $this->selectData($actions);

        ## Read value
        $draw = $data['draw'];
        $row = $data['start'];
        $rowperpage = $data['length']; // Rows display per page
        $columnIndex = $data['order'][0]['column']; // Column index
        $columnName = $data['columns'][$columnIndex]['name']; // Column name
        $columnSortOrder = $data['order'][0]['dir']; // asc or desc
        $searchValue = $data['search']['value']; // Search value

        ## Total number of records without filtering
        $getData = $this->dataTableQuery();
        $totalRecords = $getData->count();

        ## Total number of records with filtering  
        ## Search
        $searchQuery = " ";
        if($searchValue != ''){
           if(count($data['columns']) > 0){
                $getData->where(function($q) use ($searchValue, $data) {
                    $i = 0;
                    foreach($data['columns'] as $row){
                        if(isset($row["name"]) && $row["name"]!= ''){
                            $filter = $row["name"];
                            if ($i == 0) {
                                $q->Where($filter, 'like', '%' . $searchValue . '%');
                            } else {
                                $q->orWhere($filter, 'like', '%' . $searchValue . '%');
                            }
                            $i++;
                        }
                    }   
                });
           }
        }
        $totalRecordwithFilter = $getData->count();

        ## Fetch records
        $getData->orderBy($columnName, $columnSortOrder);
        $getData->skip((int)$row)->take((int)$rowperpage);

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $getData->get($selectData)
        );

        return $response;
    }

}