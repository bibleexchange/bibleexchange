<?php

class __Mustache_225d8733aca4a40453ca7342f071e5e2 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div id="timeline-view-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '" data-region="timeline-view">
';
        $buffer .= $indent . '    <div class="row text-xs-center">
';
        $buffer .= $indent . '        <div class="btn-group m-t-2" role="group" data-toggle="btns">
';
        $buffer .= $indent . '            <a class="btn btn-default active" href="#myoverview_timeline_dates" data-toggle="tab">
';
        $buffer .= $indent . '                ';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->sectionA0a09a26782b7b2b1a0bcc22146e1543($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            </a>
';
        $buffer .= $indent . '            <a class="btn btn-default" href="#myoverview_timeline_courses" data-toggle="tab">
';
        $buffer .= $indent . '                ';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section21be91719fa9b31bf4b1e8d52d95786f($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            </a>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <div class="tab-content">
';
        $buffer .= $indent . '        <div class="tab-pane active fade in" id="myoverview_timeline_dates">
';
        if ($partial = $this->mustache->loadPartial('block_myoverview/timeline-view-dates')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="tab-pane fade" id="myoverview_timeline_courses">
';
        if ($partial = $this->mustache->loadPartial('block_myoverview/timeline-view-courses')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        // 'js' section
        $value = $context->find('js');
        $buffer .= $this->section1e4ff22787a1b4ee4c744652e30d4fc3($context, $indent, $value);

        return $buffer;
    }

    private function sectionA0a09a26782b7b2b1a0bcc22146e1543(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' sortbydates, block_myoverview ';
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
                
                $buffer .= ' sortbydates, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section21be91719fa9b31bf4b1e8d52d95786f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' sortbycourses, block_myoverview ';
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
                
                $buffer .= ' sortbycourses, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1e4ff22787a1b4ee4c744652e30d4fc3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'jquery\', \'core/custom_interaction_events\'], function($, customEvents) {
    var root = $(\'#timeline-view-{{uniqid}}\');
    customEvents.define(root, [customEvents.events.activate]);
    root.on(customEvents.events.activate, \'[data-toggle="btns"] > .btn\', function() {
        root.find(\'.btn.active\').removeClass(\'active\');
    });
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
                
                $buffer .= $indent . 'require([\'jquery\', \'core/custom_interaction_events\'], function($, customEvents) {
';
                $buffer .= $indent . '    var root = $(\'#timeline-view-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '\');
';
                $buffer .= $indent . '    customEvents.define(root, [customEvents.events.activate]);
';
                $buffer .= $indent . '    root.on(customEvents.events.activate, \'[data-toggle="btns"] > .btn\', function() {
';
                $buffer .= $indent . '        root.find(\'.btn.active\').removeClass(\'active\');
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
