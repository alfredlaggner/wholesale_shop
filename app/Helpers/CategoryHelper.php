<?php

namespace App\Helpers;

class CategoryHelper {
    public static function getCategoryAndChildrenOfCategory($categories, $currentid, $parentfound = false, $cats = array()) {
        foreach($categories as $row) {
            if((!$parentfound && $row['id'] == $currentid) || $row['parent_id'] == $currentid)
            {
                $rowdata = array();
                foreach($row as $k => $v)
                    $rowdata[$k] = $v;
                $cats[] = $rowdata;
                if($row['parent_id'] == $currentid)
                    $cats = array_merge($cats, self::getCategoryAndChildrenOfCategory($categories, $row['id'], true));
            }
        }

        return $cats;
    }

    public static function buildTree(array $elements, $parentId = 0) {
        $branch = [];

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = self::buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }
    
    public static function categoriesAsList($categoriesGroupedByParent) {
        $categoriesAsList = [];

        $buildList = function ($category, $categories, $parents) use(&$buildList, &$categoriesAsList) {
            if (!empty($categories[$category['id']])) {
                if ($category['parent_id'] != 0) {
                    $parents = $parents + 1;
                    $category->parents = $parents;
                    $categoriesAsList[] = $category;
                }

                foreach ($categories[$category['id']] as $category) {
                    $buildList($category, $categories, $parents);
                }
            }
            // Leaves
            else {
                if ($category['parent_id'] != 0) {
                    $parents = $parents + 1;

                    $category->parents = $parents;
                    $categoriesAsList[] = $category;
                }
            }
        };

        foreach ($categoriesGroupedByParent[0] as $category) {
            $category->parents = 0;

            $categoriesAsList[] = $category;

            $buildList($category, $categoriesGroupedByParent, 0);
        }

        return $categoriesAsList;
    }
}