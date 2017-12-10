<?php

class __Mustache_89c3c645f4df10f1cc7b2deb1ba16ef7 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div data-region="timeline-view-dates" id="timeline-view-dates-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '">
';
        $buffer .= $indent . '    ';
        if ($parent = $this->mustache->loadPartial('block_myoverview/event-list')) {
            $context->pushBlockContext(array(
                'limit' => array($this, 'blockEbe1cf21f20428aa851e30f3f4b7bf7f'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= '</div>
';
        // 'js' section
        $value = $context->find('js');
        $buffer .= $this->section287cebca3bd0a0ff965ffa63508f9515($context, $indent, $value);

        return $buffer;
    }

    private function section287cebca3bd0a0ff965ffa63508f9515(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    require([\'jquery\', \'block_myoverview/event_list\'], function($, EventList) {
    var root = $("#timeline-view-dates-{{uniqid}}").find(\'[data-region="event-list-container"]\');
    EventList.load(root);
    });
';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    require([\'jquery\', \'block_myoverview/event_list\'], function($, EventList) {
';
                $buffer .= $indent . '    var root = $("#timeline-view-dates-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '").find(\'[data-region="event-list-container"]\');
';
                $buffer .= $indent . '    EventList.load(root);
';
                $buffer .= $indent . '    });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function blockEbe1cf21f20428aa851e30f3f4b7bf7f($context)
    {
        $indent = $buffer = '';
        $buffer .= '20';
    
        return $buffer;
    }
}
