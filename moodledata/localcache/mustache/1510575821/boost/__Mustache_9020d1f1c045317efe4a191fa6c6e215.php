<?php

class __Mustache_9020d1f1c045317efe4a191fa6c6e215 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'unmappedIcon' inverted section
        $value = $context->find('unmappedIcon');
        if (empty($value)) {
            
            $buffer .= $indent . '<i class="icon fa ';
            $value = $this->resolveValue($context->find('key'), $context);
            $buffer .= call_user_func($this->mustache->getEscape(), $value);
            $buffer .= ' fa-fw ';
            $value = $this->resolveValue($context->find('extraclasses'), $context);
            $buffer .= call_user_func($this->mustache->getEscape(), $value);
            $buffer .= '" aria-hidden="true" ';
            // 'title' section
            $value = $context->find('title');
            $buffer .= $this->section1d04a4421b605626e85381e9e441321b($context, $indent, $value);
            $buffer .= ' aria-label="';
            $value = $this->resolveValue($context->find('alt'), $context);
            $buffer .= call_user_func($this->mustache->getEscape(), $value);
            $buffer .= '"></i>
';
        }
        // 'unmappedIcon' section
        $value = $context->find('unmappedIcon');
        $buffer .= $this->section74dc57770389b674cd12e33cbfbd8914($context, $indent, $value);

        return $buffer;
    }

    private function section1d04a4421b605626e85381e9e441321b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'title="{{title}}"';
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
                
                $buffer .= 'title="';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6805fd502f1e55bd3a63b02c625bf221(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{name}}="{{value}}" ';
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
                
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section74dc57770389b674cd12e33cbfbd8914(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
{{! We cannot include the pix_icon template directly here because we don\'t have all the mustache helpers loaded. }}
<img class="icon {{extraclasses}}" {{#attributes}}{{name}}="{{value}}" {{/attributes}}/>
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
                
                $buffer .= $indent . '<img class="icon ';
                $value = $this->resolveValue($context->find('extraclasses'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" ';
                // 'attributes' section
                $value = $context->find('attributes');
                $buffer .= $this->section6805fd502f1e55bd3a63b02c625bf221($context, $indent, $value);
                $buffer .= '/>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
