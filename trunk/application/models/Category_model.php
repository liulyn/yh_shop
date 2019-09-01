<?php


class Category_model extends MY_model
{
    /** @var string 表名 */
    protected $table_name = 'category';

    public function __construct()
    {
        parent::__construct();
    }

    public function category_tree($all){
        $tree = [];
        foreach ($all as $first) {
            if ($first['parent_id'] != 0) continue;
            $twoTree = [];
            foreach ($all as $two) {
                if ($two['parent_id'] != $first['category_id']) continue;
                $threeTree = [];
                foreach ($all as $three){
                    $three['create_time'] = date('Y-m-d H:i:s',$three['create_time']);
                    $three['parent_id'] == $two['category_id']
                    && $threeTree[$three['category_id']] = $three;
                }
                !empty($threeTree) && $two['child'] = $threeTree;
                $two['create_time'] = date('Y-m-d H:i:s',$two['create_time']);
                $twoTree[$two['category_id']] = $two;
            }
            if (!empty($twoTree)) {
                array_multisort(array_column($twoTree, 'sort'), SORT_ASC, $twoTree);
                $first['child'] = $twoTree;
            }
            $first['create_time'] = date('Y-m-d H:i:s',$first['create_time']);
            $tree[$first['category_id']] = $first;
        }
        return $tree;
    }
}
