<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php

N2Loader::import('libraries.form.element.list');

class N2ElementJEventsCategories extends N2ElementList
{

    function fetchElement() {
        $model     = new N2Model('jevents_categories');
        $query     = "SELECT id, parent_id, title FROM #__assets WHERE name LIKE '%com_jevents.category%' ORDER BY parent_id";
        $menuItems = $model->db->queryAll($query, false, "object");

        $parentModel = new N2Model('jevents_categories_parent');
        $query       = "SELECT id FROM #__assets WHERE name = 'com_jevents' LIMIT 1";
        $mainParent  = $parentModel->db->queryAll($query, false, "object");

        $children = array();
        if ($menuItems) {
            foreach ($menuItems as $v) {
                $pt   = $v->parent_id;
                $list = isset($children[$pt]) ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }

        jimport('joomla.html.html.menu');
        $options = JHTML::_('menu.treerecurse', $mainParent[0]->id, '', array(), $children, 9999, 0, 0);

        $this->_xml->addChild('option', htmlspecialchars(n2_('All')))
                   ->addAttribute('value', 0);
        if (count($options)) {
            foreach ($options AS $option) {
                $this->_xml->addChild('option', htmlspecialchars($option->treename))
                           ->addAttribute('value', $option->id);
            }
        }
        return parent::fetchElement();
    }
}
