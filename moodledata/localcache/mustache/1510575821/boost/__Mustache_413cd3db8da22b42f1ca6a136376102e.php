<?php

class __Mustache_413cd3db8da22b42f1ca6a136376102e extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core_form/element-template')) {
            $context->pushBlockContext(array(
                'element' => array($this, 'blockFa7a29fc9d77dc6d5ecfaf8596f527d5'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        // 'element.frozen' inverted section
        $value = $context->findDot('element.frozen');
        if (empty($value)) {
            
            // 'js' section
            $value = $context->find('js');
            $buffer .= $this->sectionB93d29c4458e4d78362b66c86c22b0c5($context, $indent, $value);
        }

        return $buffer;
    }

    private function section5968b0313ca3957f90dc584bb9649f31(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'form-control-danger';
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
                
                $buffer .= 'form-control-danger';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section68b77dad2509079f30f242612e844ca4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'multiple';
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
                
                $buffer .= 'multiple';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section888b256e451d1858b9bd940c3193872e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                autofocus aria-describedby="id_error_{{element.name}}"
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
                
                $buffer .= $indent . '                autofocus aria-describedby="id_error_';
                $value = $this->resolveValue($context->findDot('element.name'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9e2875c627d2dbad7c957250bbb623f7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'selected';
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
                
                $buffer .= 'selected';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section997964a2885c2eb4bd579fee311a1a00(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <option value="{{value}}" {{#selected}}selected{{/selected}}>{{{text}}}</option>
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
                
                $buffer .= $indent . '            <option value="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" ';
                // 'selected' section
                $value = $context->find('selected');
                $buffer .= $this->section9e2875c627d2dbad7c957250bbb623f7($context, $indent, $value);
                $buffer .= '>';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= $value;
                $buffer .= '</option>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2fb44da69b92acdc5686c57615458f92(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{{text}}}
                    {{^element.hardfrozen}}
                        <input type="hidden" name="{{element.name}}" value="{{value}}">
                    {{/element.hardfrozen}}
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
                
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= $value;
                $buffer .= '
';
                // 'element.hardfrozen' inverted section
                $value = $context->findDot('element.hardfrozen');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                        <input type="hidden" name="';
                    $value = $this->resolveValue($context->findDot('element.name'), $context);
                    $buffer .= call_user_func($this->mustache->getEscape(), $value);
                    $buffer .= '" value="';
                    $value = $this->resolveValue($context->find('value'), $context);
                    $buffer .= call_user_func($this->mustache->getEscape(), $value);
                    $buffer .= '">
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5ec63854d0383de00d540c38e7ee4e98(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{#selected}}
                    {{{text}}}
                    {{^element.hardfrozen}}
                        <input type="hidden" name="{{element.name}}" value="{{value}}">
                    {{/element.hardfrozen}}
                {{/selected}}
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
                
                // 'selected' section
                $value = $context->find('selected');
                $buffer .= $this->section2fb44da69b92acdc5686c57615458f92($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3ace964f6aee0ac99d1d135fcc3c163d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#element.options}}
                {{#selected}}
                    {{{text}}}
                    {{^element.hardfrozen}}
                        <input type="hidden" name="{{element.name}}" value="{{value}}">
                    {{/element.hardfrozen}}
                {{/selected}}
            {{/element.options}}
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
                
                // 'element.options' section
                $value = $context->findDot('element.options');
                $buffer .= $this->section5ec63854d0383de00d540c38e7ee4e98($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4eefd740197eca864c800ff60b2e78a9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '#{{element.id}}';
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
                
                $buffer .= '#';
                $value = $this->resolveValue($context->findDot('element.id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section813be352d53fe0b93fb1b523beb80c9f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{element.ajax}}';
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
                
                $value = $this->resolveValue($context->findDot('element.ajax'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE1b52fb11c4923d3a9c108f6da76a23d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{element.placeholder}}';
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
                
                $value = $this->resolveValue($context->findDot('element.placeholder'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section33c1e0b2dcc3653386b6a9a0dbf15ab0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{element.noselectionstring}}';
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
                
                $value = $this->resolveValue($context->findDot('element.noselectionstring'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB93d29c4458e4d78362b66c86c22b0c5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'core/form-autocomplete\'], function(module) {
    module.enhance({{#quote}}#{{element.id}}{{/quote}},
                   {{element.tags}},
                   {{#quote}}{{element.ajax}}{{/quote}},
                   {{#quote}}{{element.placeholder}}{{/quote}},
                   {{element.casesensitive}},
                   {{element.showsuggestions}},
                   {{#quote}}{{element.noselectionstring}}{{/quote}});
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
                
                $buffer .= $indent . 'require([\'core/form-autocomplete\'], function(module) {
';
                $buffer .= $indent . '    module.enhance(';
                // 'quote' section
                $value = $context->find('quote');
                $buffer .= $this->section4eefd740197eca864c800ff60b2e78a9($context, $indent, $value);
                $buffer .= ',
';
                $buffer .= $indent . '                   ';
                $value = $this->resolveValue($context->findDot('element.tags'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= ',
';
                $buffer .= $indent . '                   ';
                // 'quote' section
                $value = $context->find('quote');
                $buffer .= $this->section813be352d53fe0b93fb1b523beb80c9f($context, $indent, $value);
                $buffer .= ',
';
                $buffer .= $indent . '                   ';
                // 'quote' section
                $value = $context->find('quote');
                $buffer .= $this->sectionE1b52fb11c4923d3a9c108f6da76a23d($context, $indent, $value);
                $buffer .= ',
';
                $buffer .= $indent . '                   ';
                $value = $this->resolveValue($context->findDot('element.casesensitive'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= ',
';
                $buffer .= $indent . '                   ';
                $value = $this->resolveValue($context->findDot('element.showsuggestions'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= ',
';
                $buffer .= $indent . '                   ';
                // 'quote' section
                $value = $context->find('quote');
                $buffer .= $this->section33c1e0b2dcc3653386b6a9a0dbf15ab0($context, $indent, $value);
                $buffer .= ');
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function blockFa7a29fc9d77dc6d5ecfaf8596f527d5($context)
    {
        $indent = $buffer = '';
        // 'element.frozen' inverted section
        $value = $context->findDot('element.frozen');
        if (empty($value)) {
            
            $buffer .= $indent . '        <select class="custom-select ';
            // 'error' section
            $value = $context->find('error');
            $buffer .= $this->section5968b0313ca3957f90dc584bb9649f31($context, $indent, $value);
            $buffer .= '" name="';
            $value = $this->resolveValue($context->findDot('element.name'), $context);
            $buffer .= call_user_func($this->mustache->getEscape(), $value);
            $buffer .= '"
';
            $buffer .= $indent . '            id="';
            $value = $this->resolveValue($context->findDot('element.id'), $context);
            $buffer .= call_user_func($this->mustache->getEscape(), $value);
            $buffer .= '"
';
            $buffer .= $indent . '            ';
            // 'element.multiple' section
            $value = $context->findDot('element.multiple');
            $buffer .= $this->section68b77dad2509079f30f242612e844ca4($context, $indent, $value);
            $buffer .= '
';
            // 'error' section
            $value = $context->find('error');
            $buffer .= $this->section888b256e451d1858b9bd940c3193872e($context, $indent, $value);
            $buffer .= $indent . '            ';
            $value = $this->resolveValue($context->findDot('element.attributes'), $context);
            $buffer .= $value;
            $buffer .= ' >
';
            // 'element.options' section
            $value = $context->findDot('element.options');
            $buffer .= $this->section997964a2885c2eb4bd579fee311a1a00($context, $indent, $value);
            $buffer .= $indent . '        </select>
';
        }
        // 'element.frozen' section
        $value = $context->findDot('element.frozen');
        $buffer .= $this->section3ace964f6aee0ac99d1d135fcc3c163d($context, $indent, $value);
    
        return $buffer;
    }
}
