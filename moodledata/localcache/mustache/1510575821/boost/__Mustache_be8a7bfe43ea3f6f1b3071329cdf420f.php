<?php

class __Mustache_be8a7bfe43ea3f6f1b3071329cdf420f extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'children' section
        $value = $context->find('children');
        $buffer .= $this->section94e8b1a04ee8bfad18ccee91e85549f3($context, $indent, $value);

        return $buffer;
    }

    private function sectionDc159bce537d2ac3a05478bc10b9d3f9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <li><a href="{{{url}}}" title="{{{title}}}">{{{text}}}</a></li>
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
                
                $buffer .= $indent . '                <li><a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= $value;
                $buffer .= '" title="';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= $value;
                $buffer .= '">';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= $value;
                $buffer .= '</a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD2ce8dade3ebe52dac92dc5ff29a2d61(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <li>
                <ul class="list-unstyled m-l-1">
                    {{> theme_boost/custom_menu_footer }}
                </ul>
            </li>
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
                
                $buffer .= $indent . '            <li>
';
                $buffer .= $indent . '                <ul class="list-unstyled m-l-1">
';
                if ($partial = $this->mustache->loadPartial('theme_boost/custom_menu_footer')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                    ');
                }
                $buffer .= $indent . '                </ul>
';
                $buffer .= $indent . '            </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section94e8b1a04ee8bfad18ccee91e85549f3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{^divider}}
            {{#url}}
                <li><a href="{{{url}}}" title="{{{title}}}">{{{text}}}</a></li>
            {{/url}}
            {{^url}}
                <li>{{{text}}}</li>
            {{/url}}
        {{/divider}}
        {{#haschildren}}
            <li>
                <ul class="list-unstyled m-l-1">
                    {{> theme_boost/custom_menu_footer }}
                </ul>
            </li>
        {{/haschildren}}
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
                
                // 'divider' inverted section
                $value = $context->find('divider');
                if (empty($value)) {
                    
                    // 'url' section
                    $value = $context->find('url');
                    $buffer .= $this->sectionDc159bce537d2ac3a05478bc10b9d3f9($context, $indent, $value);
                    // 'url' inverted section
                    $value = $context->find('url');
                    if (empty($value)) {
                        
                        $buffer .= $indent . '                <li>';
                        $value = $this->resolveValue($context->find('text'), $context);
                        $buffer .= $value;
                        $buffer .= '</li>
';
                    }
                }
                // 'haschildren' section
                $value = $context->find('haschildren');
                $buffer .= $this->sectionD2ce8dade3ebe52dac92dc5ff29a2d61($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
