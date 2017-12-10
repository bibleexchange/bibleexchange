<?php

class __Mustache_2f2381c3239a7916b5f577bccaede08c extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        // 'showskiplink' section
        $value = $context->find('showskiplink');
        $buffer .= $this->sectionE887b0dd89339f00b36b22fb1a576b98($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '<aside id="';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"
';
        $buffer .= $indent . '     class="';
        // 'hidden' section
        $value = $context->find('hidden');
        $buffer .= $this->section9a7fc588e5e2ac7453379d33a752316e($context, $indent, $value);
        $buffer .= ' block block_';
        $value = $this->resolveValue($context->find('type'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= ' ';
        // 'hascontrols' section
        $value = $context->find('hascontrols');
        $buffer .= $this->section12f3cb4be977f05616300fd1301c564b($context, $indent, $value);
        $buffer .= ' card m-b-1"
';
        $buffer .= $indent . '     role="';
        $value = $this->resolveValue($context->find('ariarole'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"
';
        $buffer .= $indent . '     data-block="';
        $value = $this->resolveValue($context->find('type'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"
';
        // 'arialabel' section
        $value = $context->find('arialabel');
        $buffer .= $this->sectionBb0fe681f92c1a765e9f809357dfac18($context, $indent, $value);
        // 'arialabel' inverted section
        $value = $context->find('arialabel');
        if (empty($value)) {
            
            // 'title' section
            $value = $context->find('title');
            $buffer .= $this->sectionC269b13bd61323d840390fdebc65599f($context, $indent, $value);
            $buffer .= $indent . '     ';
        }
        $buffer .= '>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <div class="card-block">
';
        $buffer .= $indent . '
';
        // 'hascontrols' section
        $value = $context->find('hascontrols');
        $buffer .= $this->section69238aba100733e03eb4016b1a2d7feb($context, $indent, $value);
        $buffer .= $indent . '
';
        // 'title' section
        $value = $context->find('title');
        $buffer .= $this->section27be201d64bb5ea1d64f9908aac7d613($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <div class="card-text content">
';
        $buffer .= $indent . '            ';
        $value = $this->resolveValue($context->find('content'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '            <div class="footer">';
        $value = $this->resolveValue($context->find('footer'), $context);
        $buffer .= $value;
        $buffer .= '</div>
';
        $buffer .= $indent . '            ';
        $value = $this->resolveValue($context->find('annotation'), $context);
        $buffer .= $value;
        $buffer .= '
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</aside>
';
        $buffer .= $indent . '
';
        // 'showskiplink' section
        $value = $context->find('showskiplink');
        $buffer .= $this->sectionA989e574ef58b1a9ea39526a28938789($context, $indent, $value);

        return $buffer;
    }

    private function sectionB72e1405931a305b04da0656eec2aca0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'skipa, access, {{title}}';
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
                
                $buffer .= 'skipa, access, ';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE887b0dd89339f00b36b22fb1a576b98(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <a href="#sb-{{skipid}}" class="sr-only sr-only-focusable">{{#str}}skipa, access, {{title}}{{/str}}</a>
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
                
                $buffer .= $indent . '  <a href="#sb-';
                $value = $this->resolveValue($context->find('skipid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="sr-only sr-only-focusable">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionB72e1405931a305b04da0656eec2aca0($context, $indent, $value);
                $buffer .= '</a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9a7fc588e5e2ac7453379d33a752316e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'hidden';
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
                
                $buffer .= 'hidden';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section12f3cb4be977f05616300fd1301c564b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'block_with_controls';
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
                
                $buffer .= 'block_with_controls';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6443b7c1cd72c62cb76e0217440a25a3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{{arialabel}}}';
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
                
                $value = $this->resolveValue($context->find('arialabel'), $context);
                $buffer .= $value;
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBb0fe681f92c1a765e9f809357dfac18(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        aria-label={{#quote}}{{{arialabel}}}{{/quote}}
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
                
                $buffer .= $indent . '        aria-label=';
                // 'quote' section
                $value = $context->find('quote');
                $buffer .= $this->section6443b7c1cd72c62cb76e0217440a25a3($context, $indent, $value);
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC269b13bd61323d840390fdebc65599f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
          aria-labelledby="instance-{{blockinstanceid}}-header"
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
                
                $buffer .= $indent . '          aria-labelledby="instance-';
                $value = $this->resolveValue($context->find('blockinstanceid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '-header"
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section69238aba100733e03eb4016b1a2d7feb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="block-controls pull-xs-right header">
                {{{controls}}}
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
                
                $buffer .= $indent . '            <div class="block-controls pull-xs-right header">
';
                $buffer .= $indent . '                ';
                $value = $this->resolveValue($context->find('controls'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section27be201d64bb5ea1d64f9908aac7d613(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <h3 id="instance-{{blockinstanceid}}-header" class="card-title">{{{title}}}</h3>
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
                
                $buffer .= $indent . '            <h3 id="instance-';
                $value = $this->resolveValue($context->find('blockinstanceid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '-header" class="card-title">';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= $value;
                $buffer .= '</h3>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA989e574ef58b1a9ea39526a28938789(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  <span id="sb-{{skipid}}"></span>
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
                
                $buffer .= $indent . '  <span id="sb-';
                $value = $this->resolveValue($context->find('skipid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"></span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
