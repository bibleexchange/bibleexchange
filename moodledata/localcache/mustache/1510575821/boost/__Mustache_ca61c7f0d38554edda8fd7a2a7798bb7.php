<?php

class __Mustache_ca61c7f0d38554edda8fd7a2a7798bb7 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<span class="loading-icon">';
        // 'pix' section
        $value = $context->find('pix');
        $buffer .= $this->sectionE421bb21f3c875da92c8cb82d305478b($context, $indent, $value);
        $buffer .= '</span>
';

        return $buffer;
    }

    private function section201a1e0d87e2bf754decb79303412b27(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' loading ';
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
                
                $buffer .= ' loading ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE421bb21f3c875da92c8cb82d305478b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' y/loading, core, {{#str}} loading {{/str}} ';
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
                
                $buffer .= ' y/loading, core, ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section201a1e0d87e2bf754decb79303412b27($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
