<?php

class __Mustache_18bcd05d50be023ce9b633cc90334bec extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core_form/element-template-inline')) {
            $context->pushBlockContext(array(
                'element' => array($this, 'block5ba19b3f0e0f19d585f27f2961a0d7b9'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }

        return $buffer;
    }

    private function section7713fb9bb0a8d8b8319336ba7f44185c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'btn-secondary';
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
                
                $buffer .= 'btn-secondary';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section23ce7dc23500e90c16e1d0ec5df66d6b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' btn-danger ';
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
                
                $buffer .= ' btn-danger ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block5ba19b3f0e0f19d585f27f2961a0d7b9($context)
    {
        $indent = $buffer = '';
        // 'element.frozen' inverted section
        $value = $context->findDot('element.frozen');
        if (empty($value)) {
            
            $buffer .= $indent . '        <input type="submit"
';
            $buffer .= $indent . '                class="btn
';
            $buffer .= $indent . '                    ';
            // 'element.secondary' inverted section
            $value = $context->findDot('element.secondary');
            if (empty($value)) {
                
                $buffer .= 'btn-primary';
            }
            $buffer .= '
';
            $buffer .= $indent . '                    ';
            // 'element.secondary' section
            $value = $context->findDot('element.secondary');
            $buffer .= $this->section7713fb9bb0a8d8b8319336ba7f44185c($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '                    ';
            // 'error' section
            $value = $context->find('error');
            $buffer .= $this->section23ce7dc23500e90c16e1d0ec5df66d6b($context, $indent, $value);
            $buffer .= '"
';
            $buffer .= $indent . '                name="';
            $value = $this->resolveValue($context->findDot('element.name'), $context);
            $buffer .= call_user_func($this->mustache->getEscape(), $value);
            $buffer .= '"
';
            $buffer .= $indent . '                id="';
            $value = $this->resolveValue($context->findDot('element.id'), $context);
            $buffer .= call_user_func($this->mustache->getEscape(), $value);
            $buffer .= '"
';
            $buffer .= $indent . '                value="';
            $value = $this->resolveValue($context->findDot('element.value'), $context);
            $buffer .= call_user_func($this->mustache->getEscape(), $value);
            $buffer .= '"
';
            $buffer .= $indent . '                ';
            $value = $this->resolveValue($context->findDot('element.attributes'), $context);
            $buffer .= $value;
            $buffer .= ' >
';
        }
    
        return $buffer;
    }
}
