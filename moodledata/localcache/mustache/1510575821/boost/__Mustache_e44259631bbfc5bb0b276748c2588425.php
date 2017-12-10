<?php

class __Mustache_e44259631bbfc5bb0b276748c2588425 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div data-region="event-list-group-container"
';
        $buffer .= $indent . '     data-start-day="';
        $blockFunction = $context->findInBlock('startday');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= '0';
        }
        $buffer .= '"
';
        $buffer .= $indent . '     data-end-day="';
        $blockFunction = $context->findInBlock('endday');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '"
';
        $buffer .= $indent . '     class="hidden">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <h5 class="h6 m-t-1 ';
        $blockFunction = $context->findInBlock('extratitleclasses');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '" id="event-list-title-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"><strong>';
        $blockFunction = $context->findInBlock('title');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '</strong></h5>
';
        $buffer .= $indent . '    <ul class="list-group unstyled" data-region="event-list" aria-describedby="event-list-title-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '">
';
        $blockFunction = $context->findInBlock('eventlistitems');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            if ($partial = $this->mustache->loadPartial('block_myoverview/event-list-items')) {
                $buffer .= $partial->renderInternal($context, $indent . '            ');
            }
        }
        $buffer .= $indent . '    </ul>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }
}
