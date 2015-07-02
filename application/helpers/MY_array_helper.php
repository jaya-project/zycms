<?php 

/**
 *  @brief 获取分类树
 *  
 *  @param [in] $array 分类ID 
 *  @return 分类树数组
 *  
 */
function gen_tree($array, $pid='pid', $id='id', $son='children') {
	$tree = array();
	array_walk($array, function($item, $index) use (&$tree, &$array, $pid, $id, $son) {
		if(isset($array[$item[$pid]])){
            $array[$item[$pid]][$son][] = &$array[$item[$id]];
        } else{
            $tree[] = &$array[$item[$id]];
        }
	});
	return $tree;
}

/**
 * 如何取数据格式化的树形数据
 */
function getTreeData($tree, $son='children'){
	static $data = array();
    foreach($tree as $key=>&$t){
		$data[] = array_diff_key($t, array($son=>''));
        if(isset($t[$son])){
            getTreeData($t[$son]);
        }
		
    }
	return $data;
	
}


/**
 *  获取某颗树某个结点的后代结点
 */
function get_node_children($tree, $node) {
	$arr = find_grand_node($tree, $node);
	
	$ids = array();
	array_walk_recursive($arr, function($item, $index) use (&$ids) {
		if($index == 'id') {
			$ids[] = $item;
		}
	});
	return $ids;
}


function find_grand_node($tree, $node) {
	$arr = array();
	foreach($tree as $key=>$value) {
		if(isset($value['id']) && $value['id'] == $node) {
			$arr = $value;
			return $arr;
		}
		if(isset($value['children']) && is_array($value['children'])) {
			$arr[] = find_grand_node($value['children'], $node);
		}
	}
	
	return $arr;
}


function array_has_empty($arr) {
	$flag = FALSE;
	array_walk($arr, function($item) use (&$flag) {
		if ($item === '') {
			$flag = TRUE;
		}
	});
	
	return $flag;
}


if(!function_exists("array_column"))
{

    function array_column($array,$column_name)
    {

        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);

    }

}

