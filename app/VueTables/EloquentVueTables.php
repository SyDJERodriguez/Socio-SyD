<?php

namespace App\VueTables;

Class EloquentVueTables implements VueTablesInterface
{

    public function get($model, Array $fields, Array $relations = [], $type = null)
    {
        $byColumn = request('byColumn');
        $orderBy = request('orderBy');
        $limit = request('limit');
        $page = request('page');
        $ascending = request('ascending');
        $query = json_decode(request('query'), true);
        $data = $model->select($fields)->with($relations)->orderBy('id');

        if (in_array($type,['club-dar', 'leads', 'clients']) ){
            switch ($type) {
                case 'club-dar':
                    $customer_level = 3;
                    break;
                case 'leads':
                    $customer_level = 1;
                    break;
                default:
                    $customer_level = 2;
                    break;
            }
            $data->where('customer_level', $customer_level);
        }elseif($type == 'historic'){
            $data->where('source', 'historic');
        }

        /*if($type != 'historic') {
            switch ($type) {
                case 'club-dar':
                    $customer_level = 3;
                    break;
                case 'leads':
                    $customer_level = 1;
                    break;
                default:
                    $customer_level = 2;
                    break;
            }
            $data->where('customer_level', $customer_level);
        }elseif($type == 'historic'){
            $data->where('customer_level', 'historic');
        }*/

        if (isset($query) && $query) {
            $data = $byColumn == 1 ? $this->filterByColumn($data, $query) : $this->filter($data, $query, $fields);
        }

        $results = $data;
        /*if ($isCustomer) {
            $results = $data->where('user_id', auth()->id());
        } else {
            $results = $data;
        }*/

        $count = $data->count();
        $data->limit($limit)->skip($limit * ($page - 1));
        if (isset($orderBy)) {
            $direction = $ascending == 1 ? "ASC" : "DESC";
            $data->orderBy($orderBy, $direction);
        }

        return [
            'data' => $results->get()->toArray(),
            'count' => $count
        ];
    }

    protected function filterByColumn($data, $query)
    {
        foreach ($query as $field => $query) {
            if (!$query) {
                continue;
            }
            if (is_string($query) && $field !== "status") {
                $data->where($field, 'LIKE', "%{$query}%");
            }
        }

        return $data;
    }

    protected function filter($data, $query, $fields)
    {
        foreach ($fields as $index => $field) {
            $method = $index ? "orWhere" : "where";
            $data->{$method}($field, 'LIKE', "%{$query}%");
        }

        return $data;
    }
}
