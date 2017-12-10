<?php

class __Mustache_66bf3198388686373fc4426198445f27 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="dropdown d-inline">
';
        $buffer .= $indent . '    <a href="#" class="dropdown-toggle" id="dropdown-';
        $value = $this->resolveValue($context->find('instance'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '" title="';
        $value = $this->resolveValue($context->find('title'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        $value = $this->resolveValue($context->find('actiontext'), $context);
        $buffer .= $value;
        $value = $this->resolveValue($context->find('menutrigger'), $context);
        $buffer .= $value;
        // 'icon' section
        $value = $context->find('icon');
        $buffer .= $this->section606e6621754ae76959f7024860b353d5($context, $indent, $value);
        // 'rawicon' section
        $value = $context->find('rawicon');
        $buffer .= $this->sectionFb8e8ddc9ca3702110812af7d06781d6($context, $indent, $value);
        // 'menutrigger' section
        $value = $context->find('menutrigger');
        $buffer .= $this->sectionB2b7dd14b5febc547904549ba2729da2($context, $indent, $value);
        $buffer .= '</a>
';
        // 'secondary' section
        $value = $context->find('secondary');
        $buffer .= $this->section903050589b4e7860ae654b04676604a5($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section742f292d21ddb913fc8403f697e86cab(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{key}},{{component}},{{title}}';
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
                
                $value = $this->resolveValue($context->find('key'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= ',';
                $value = $this->resolveValue($context->find('component'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= ',';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section606e6621754ae76959f7024860b353d5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{#pix}}{{key}},{{component}},{{title}}{{/pix}}';
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
                
                // 'pix' section
                $value = $context->find('pix');
                $buffer .= $this->section742f292d21ddb913fc8403f697e86cab($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFb8e8ddc9ca3702110812af7d06781d6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{{.}}}';
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
                
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= $value;
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB2b7dd14b5febc547904549ba2729da2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<b class="caret"></b>';
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
                
                $buffer .= '<b class="caret"></b>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAd20463c348991d5bbd2fb97358ea7c0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{name}}="{{value}}"';
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
                
                $buffer .= ' ';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE1aa2fd25fafc048534b66e7545a9f28(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{value}}';
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
                
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFc3485bbb00697cbbcc11dddb9d4d420(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{name}}={{#quote}}{{value}}{{/quote}} ';
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
                $buffer .= '=';
                // 'quote' section
                $value = $context->find('quote');
                $buffer .= $this->sectionE1aa2fd25fafc048534b66e7545a9f28($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD60def43e2872f03f0ef6a4a082400b1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'aria-labelledby="actionmenuaction-{{instance}}"';
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
                
                $buffer .= 'aria-labelledby="actionmenuaction-';
                $value = $this->resolveValue($context->find('instance'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCd059ca9cc57dddd453569df0f3746b8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<span class="menu-action-text" id="actionmenuaction-{{instance}}">{{{text}}}</span>';
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
                
                $buffer .= '<span class="menu-action-text" id="actionmenuaction-';
                $value = $this->resolveValue($context->find('instance'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= $value;
                $buffer .= '</span>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC556dc3bd8e1d73cdb8814ddb7584ec9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<a href="{{url}}" class="dropdown-item {{classes}}" {{#attributes}}{{name}}={{#quote}}{{value}}{{/quote}} {{/attributes}}{{#showtext}}aria-labelledby="actionmenuaction-{{instance}}"{{/showtext}}>{{#icon}}{{#pix}}{{key}},{{component}},{{title}}{{/pix}}{{/icon}}{{#showtext}}<span class="menu-action-text" id="actionmenuaction-{{instance}}">{{{text}}}</span>{{/showtext}}</a>';
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
                
                $buffer .= '<a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="dropdown-item ';
                $value = $this->resolveValue($context->find('classes'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" ';
                // 'attributes' section
                $value = $context->find('attributes');
                $buffer .= $this->sectionFc3485bbb00697cbbcc11dddb9d4d420($context, $indent, $value);
                // 'showtext' section
                $value = $context->find('showtext');
                $buffer .= $this->sectionD60def43e2872f03f0ef6a4a082400b1($context, $indent, $value);
                $buffer .= '>';
                // 'icon' section
                $value = $context->find('icon');
                $buffer .= $this->section606e6621754ae76959f7024860b353d5($context, $indent, $value);
                // 'showtext' section
                $value = $context->find('showtext');
                $buffer .= $this->sectionCd059ca9cc57dddd453569df0f3746b8($context, $indent, $value);
                $buffer .= '</a>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5dcadd4c046d6ae7246de01cd0536384(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<div class="dropdown-divider"></div>';
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
                
                $buffer .= '<div class="dropdown-divider"></div>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5af5f6f19e2b81688e6e7255eb9e79a0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{!
                }}{{#actionmenulink}}<a href="{{url}}" class="dropdown-item {{classes}}" {{#attributes}}{{name}}={{#quote}}{{value}}{{/quote}} {{/attributes}}{{#showtext}}aria-labelledby="actionmenuaction-{{instance}}"{{/showtext}}>{{#icon}}{{#pix}}{{key}},{{component}},{{title}}{{/pix}}{{/icon}}{{#showtext}}<span class="menu-action-text" id="actionmenuaction-{{instance}}">{{{text}}}</span>{{/showtext}}</a>{{/actionmenulink}}{{!
                }}{{#actionmenufiller}}<div class="dropdown-divider"></div>{{/actionmenufiller}}{{!
                }}{{^actionmenulink}}{{^actionmenufiller}}<div class="dropdown-item">{{> core/action_menu_item }}</div>{{/actionmenufiller}}{{/actionmenulink}}{{!
            }}';
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
                
                // 'actionmenulink' section
                $value = $context->find('actionmenulink');
                $buffer .= $this->sectionC556dc3bd8e1d73cdb8814ddb7584ec9($context, $indent, $value);
                // 'actionmenufiller' section
                $value = $context->find('actionmenufiller');
                $buffer .= $this->section5dcadd4c046d6ae7246de01cd0536384($context, $indent, $value);
                // 'actionmenulink' inverted section
                $value = $context->find('actionmenulink');
                if (empty($value)) {
                    
                    // 'actionmenufiller' inverted section
                    $value = $context->find('actionmenufiller');
                    if (empty($value)) {
                        
                        $buffer .= '<div class="dropdown-item">';
                        if ($partial = $this->mustache->loadPartial('core/action_menu_item')) {
                            $buffer .= $partial->renderInternal($context);
                        }
                        $buffer .= '</div>';
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section903050589b4e7860ae654b04676604a5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="dropdown-menu dropdown-menu-right {{classes}}"{{#attributes}} {{name}}="{{value}}"{{/attributes}}>
            {{#items}}{{!
                }}{{#actionmenulink}}<a href="{{url}}" class="dropdown-item {{classes}}" {{#attributes}}{{name}}={{#quote}}{{value}}{{/quote}} {{/attributes}}{{#showtext}}aria-labelledby="actionmenuaction-{{instance}}"{{/showtext}}>{{#icon}}{{#pix}}{{key}},{{component}},{{title}}{{/pix}}{{/icon}}{{#showtext}}<span class="menu-action-text" id="actionmenuaction-{{instance}}">{{{text}}}</span>{{/showtext}}</a>{{/actionmenulink}}{{!
                }}{{#actionmenufiller}}<div class="dropdown-divider"></div>{{/actionmenufiller}}{{!
                }}{{^actionmenulink}}{{^actionmenufiller}}<div class="dropdown-item">{{> core/action_menu_item }}</div>{{/actionmenufiller}}{{/actionmenulink}}{{!
            }}{{/items}}
        </div>
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
                
                $buffer .= $indent . '        <div class="dropdown-menu dropdown-menu-right ';
                $value = $this->resolveValue($context->find('classes'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"';
                // 'attributes' section
                $value = $context->find('attributes');
                $buffer .= $this->sectionAd20463c348991d5bbd2fb97358ea7c0($context, $indent, $value);
                $buffer .= '>
';
                $buffer .= $indent . '            ';
                // 'items' section
                $value = $context->find('items');
                $buffer .= $this->section5af5f6f19e2b81688e6e7255eb9e79a0($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
