<?php

class __Mustache_039b16fd896f3ddb5342227a3f9e8b29 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="m-t-2 m-b-1">
';
        if ($parent = $this->mustache->loadPartial('core/columns-1to1to1')) {
            $context->pushBlockContext(array(
                'column1' => array($this, 'blockE6ce0b842b5f11bdd86008459d41a23f'),
                'column2' => array($this, 'block134394312aae0a63536f76d24a0002ee'),
                'column3' => array($this, 'block6734ef47886f28b5914190eb9dc6536b'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section490440062d62727ec9d762c45f0157fb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{> core/action_link }}';
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
                
                if ($partial = $this->mustache->loadPartial('core/action_link')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF38cbdd58a4e67e3cb86ecb5ee6001b3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{> core/url_select }}';
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
                
                if ($partial = $this->mustache->loadPartial('core/url_select')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function blockE6ce0b842b5f11bdd86008459d41a23f($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '        <div class="pull-left">
';
        $buffer .= $indent . '            ';
        // 'prevlink' section
        $value = $context->find('prevlink');
        $buffer .= $this->section490440062d62727ec9d762c45f0157fb($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </div>
';
    
        return $buffer;
    }

    public function block134394312aae0a63536f76d24a0002ee($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '        <div class="mdl-align">
';
        $buffer .= $indent . '            ';
        // 'activitylist' section
        $value = $context->find('activitylist');
        $buffer .= $this->sectionF38cbdd58a4e67e3cb86ecb5ee6001b3($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </div>
';
    
        return $buffer;
    }

    public function block6734ef47886f28b5914190eb9dc6536b($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '        <div class="pull-right">
';
        $buffer .= $indent . '            ';
        // 'nextlink' section
        $value = $context->find('nextlink');
        $buffer .= $this->section490440062d62727ec9d762c45f0157fb($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </div>
';
    
        return $buffer;
    }
}
