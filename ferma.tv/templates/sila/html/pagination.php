<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

function pagination_list_footer($list)
{
	$html = "<div class=\"pagination\">\n";
	$html .= $list['pageslinks'];
	$html .= "\n<input type=\"hidden\" name=\"" . $list['prefix'] . "limitstart\" value=\"" . $list['limitstart'] . "\" />";
	$html .= "\n</div>";

	return $html;
}

/**
 * Renders the pagination list
 *
 * @param   array   $list  Array containing pagination information
 *
 * @return  string         HTML markup for the full pagination object
 *
 * @since   3.0
 */
function pagination_list_render($list)
{
	// Calculate to display range of pages
	$currentPage = 1;
	$range = 1;
	$step = 5;
	foreach ($list['pages'] as $k => $page)
	{
		if (!$page['active'])
		{
			$currentPage = $k;
		}
	}
	if ($currentPage >= $step)
	{
		if ($currentPage % $step == 0)
		{
			$range = ceil($currentPage / $step) + 1;
		}
		else
		{
			$range = ceil($currentPage / $step);
		}
	}
	$html= '';
	$html .= '<ul class="Pagination">';
	//$html .= $list['start']['data'];
	//$html .= $list['previous']['data'];

	foreach ($list['pages'] as $k => $page)
	{
		if (in_array($k, range($range * $step - ($step + 1), $range * $step)))
		{
			if (($k % $step == 0 || $k == $range * $step - ($step + 1)) && $k != $currentPage && $k != $range * $step - $step)
			{
				/*$page['data'] = preg_replace('#(<a.*?>).*?(</a>)#', '$1...$2', $page['data']);*/
			}
		}

		$html .= $page['data'];
	}

	//$html .= $list['next']['data'];
	//$html .= $list['end']['data'];

	$html .= '</ul>';
	return $html;
}

/**
 * Renders an active item in the pagination block
 *
 * @param   JPaginationObject  $item  The current pagination object
 *
 * @return  string                    HTML markup for active item
 *
 * @since   3.0
 */
function pagination_item_active(&$item)
{
	$class = '';

	// Check for "Start" item
	if ($item->text == JText::_('JLIB_HTML_START'))
	{
		//$display = '&laquo;';
		//$class = 'Arrow ArrowLeft';
	}

	// Check for "Prev" item
	if ($item->text == JText::_('JPREV'))
	{
		//$display = '<i class="icon-previous">'.JText::_('PAGINATION_PREV').'</i>';
		//$display = '<i class="icon-previous"></i>';
		//$class .= ' nav left ';
	}

	// Check for "Next" item
	if ($item->text == JText::_('JNEXT'))
	{
		//$display = '<i class="icon-next">'.JText::_('PAGINATION_NEXT').'</i>';
		//$display = '<i class="icon-next">>></i>';
		//$class .= ' nav right ';
	}

	// Check for "End" item
	if ($item->text == JText::_('JLIB_HTML_END'))
	{
		//$display = '&raquo;';
		//$class = 'Arrow ArrowRight';
	}

	// If the display object isn't set already, just render the item with its text
	if (!isset($display))
	{
		$display = $item->text;
		$class .= 'pagination-item';
	}

	return '<li class="'. $class .'" ><a title="' . $item->text . '" href="' . $item->link . '" class="pagenav">' . $display . '</a></li>';

}

/**
 * Renders an inactive item in the pagination block
 *
 * @param   JPaginationObject  $item  The current pagination object
 *
 * @return  string  HTML markup for inactive item
 *
 * @since   3.0
 */
function pagination_item_inactive(&$item)
{
	
	// Check for "Start" item
	if ($item->text == JText::_('JLIB_HTML_START'))
	{
		//return '<li class="Arrow ArrowLeft"><a></a></li>';
		return '';
	}

	// Check for "Prev" item
	if ($item->text == JText::_('JPREV'))
	{
	//	return '<li class="disabled  nav left"><a><i class="icon-previous">'.JText::_('PAGINATION_PREV').'</i></a></li>';
		return '';
	}

	// Check for "Next" item
	if ($item->text == JText::_('JNEXT'))
	{
	//	return '<li class="disabled  nav right"><a><i class="icon-next">'.JText::_('PAGINATION_NEXT').'</i></a></li>';
		return '';
	}

	// Check for "End" item
	if ($item->text == JText::_('JLIB_HTML_END'))
	{
		//return '<li class="Arrow ArrowRight"><a></a></li>';
		return '';
	}

	// Check if the item is the active page
	if (isset($item->active) && ($item->active))
	{
		return '<li class="pagination-item active"><span>' . $item->text . '</span></li>';
	}

	// Doesn't match any other condition, render a normal item
	return '<li class="pagination-item active"><a>' . $item->text . '</a></li>';
}
