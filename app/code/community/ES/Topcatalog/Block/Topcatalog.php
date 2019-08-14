<?php
class ES_Topcatalog_Block_Topcatalog extends Mage_Page_Block_Html_Topmenu
{
    protected function _getHtml(Varien_Data_Tree_Node $menuTree, $childrenWrapClass)
    {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;

        $counter = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        if ($childLevel == 1) {
            $category = Mage::getModel('catalog/category')->load($menuTree->getData('category_id'));
            $imgUrl = $category->getImageUrl();
            $shortDesc = $category->getDescription();
            if ($imgUrl || $shortDesc)
                $navClass = ' tc-img';
            else
                $navClass = ' tc-without-img';
        }

        if ($childLevel == 1) {
            $html .= '<ul class="nav-left'.$navClass.'">';
        }
        foreach ($children as $child) {
            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }

            $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
            $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '><span>'
                . $this->escapeHtml($child->getName()) . '</span></a>';

            if ($child->hasChildren()) {
                if (!empty($childrenWrapClass)) {
                    $html .= '<div class="' . $childrenWrapClass . '">';
                }
                $html .= '<ul class="level' . $childLevel . '">';
                $html .= $this->_getHtml($child, $childrenWrapClass);
                $html .= '</ul>';

                if (!empty($childrenWrapClass)) {
                    $html .= '</div>';
                }
            }
            $html .= '</li>';


            $counter++;
        }
        if ($childLevel == 1) {
            if ($imgUrl || $shortDesc) {
                $html .= '</ul><ul class="nav-right">';
                if ($imgUrl)
                    $html .= '<img width="196px" src="'.$imgUrl.'" /><br/>';
                if ($shortDesc)
                    $html .= '<span>'.$shortDesc.'</span>';
            }
            $html .= '</ul>';
        }
        return $html;
    }


}