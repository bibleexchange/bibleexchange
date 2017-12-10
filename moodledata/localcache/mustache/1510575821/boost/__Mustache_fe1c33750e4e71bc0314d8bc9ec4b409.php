<?php

class __Mustache_fe1c33750e4e71bc0314d8bc9ec4b409 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div';
        $buffer .= ' id="month-mini-';
        $value = $this->resolveValue($context->findDot('date.year'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '-';
        $value = $this->resolveValue($context->findDot('date.month'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"';
        $buffer .= ' class="calendarwrapper"';
        $buffer .= ' data-courseid="';
        $value = $this->resolveValue($context->find('courseid'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"';
        $buffer .= ' data-categoryid="';
        $value = $this->resolveValue($context->find('categoryid'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"';
        $buffer .= ' data-month="';
        $value = $this->resolveValue($context->findDot('date.mon'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"';
        $buffer .= ' data-year="';
        $value = $this->resolveValue($context->findDot('date.year'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"';
        $buffer .= ' data-view="month"';
        $buffer .= '>
';
        if ($partial = $this->mustache->loadPartial('core/overlay_loading')) {
            $buffer .= $partial->renderInternal($context, $indent . '    ');
        }
        $buffer .= $indent . '    <table class="minicalendar calendartable">
';
        $buffer .= $indent . '        <caption class="calendar-controls">
';
        // 'includenavigation' section
        $value = $context->find('includenavigation');
        $buffer .= $this->section3b91cc300bb436e5ac1dd4512a49b5ec($context, $indent, $value);
        // 'includenavigation' inverted section
        $value = $context->find('includenavigation');
        if (empty($value)) {
            
            $buffer .= $indent . '                <h3>
';
            $buffer .= $indent . '                    <a href="';
            $value = $this->resolveValue($context->find('url'), $context);
            $buffer .= $value;
            $buffer .= '" title="';
            // 'str' section
            $value = $context->find('str');
            $buffer .= $this->section95c6799cb30cd89f1344831aab6696c3($context, $indent, $value);
            $buffer .= '">';
            $value = $this->resolveValue($context->find('periodname'), $context);
            $buffer .= call_user_func($this->mustache->getEscape(), $value);
            $buffer .= '</a>
';
            $buffer .= $indent . '                </h3>
';
        }
        $buffer .= $indent . '        </caption>
';
        $buffer .= $indent . '        <thead>
';
        $buffer .= $indent . '          <tr>
';
        // 'daynames' section
        $value = $context->find('daynames');
        $buffer .= $this->section3c340cd0e7cdb5c04f1f9c978b87bf83($context, $indent, $value);
        $buffer .= $indent . '            </tr>
';
        $buffer .= $indent . '        </thead>
';
        $buffer .= $indent . '        <tbody>
';
        // 'weeks' section
        $value = $context->find('weeks');
        $buffer .= $this->sectionB061c3bf0b53ad36002b090db71724ea($context, $indent, $value);
        $buffer .= $indent . '        </tbody>
';
        $buffer .= $indent . '    </table>
';
        $buffer .= $indent . '</div>
';
        // 'js' section
        $value = $context->find('js');
        $buffer .= $this->sectionCfbe066aada6aa686f20e98cfbb1f1b7($context, $indent, $value);

        return $buffer;
    }

    private function section79d01ec0a9380fe9e2b8dce0d84217d2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'monthprev, calendar';
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
                
                $buffer .= 'monthprev, calendar';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section95c6799cb30cd89f1344831aab6696c3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'monththis, calendar';
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
                
                $buffer .= 'monththis, calendar';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3b91cc300bb436e5ac1dd4512a49b5ec(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <a{{!
                    }} href="#"{{!
                    }} class="arrow_link previous"{{!
                    }} title="{{#str}}monthprev, calendar{{/str}}"{{!
                    }} data-year="{{previousperiod.year}}"{{!
                    }} data-month="{{previousperiod.mon}}"{{!
                }}>
                    <span class="arrow">{{{larrow}}}</span>
                </a>
                <span class="hide"> | </span>
                <span class="current">
                    <a href="{{{url}}}" title="{{#str}}monththis, calendar{{/str}}">{{periodname}}</a>
                </span>
                <span class="hide"> | </span>
                <a{{!
                    }} href="#"{{!
                    }} class="arrow_link next"{{!
                    }} title="{{#str}}monthprev, calendar{{/str}}"{{!
                    }} data-year="{{nextperiod.year}}"{{!
                    }} data-month="{{nextperiod.mon}}"{{!
                }}>
                    <span class="arrow">{{{rarrow}}}</span>
                </a>
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
                
                $buffer .= $indent . '                <a';
                $buffer .= ' href="#"';
                $buffer .= ' class="arrow_link previous"';
                $buffer .= ' title="';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section79d01ec0a9380fe9e2b8dce0d84217d2($context, $indent, $value);
                $buffer .= '"';
                $buffer .= ' data-year="';
                $value = $this->resolveValue($context->findDot('previousperiod.year'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"';
                $buffer .= ' data-month="';
                $value = $this->resolveValue($context->findDot('previousperiod.mon'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"';
                $buffer .= '>
';
                $buffer .= $indent . '                    <span class="arrow">';
                $value = $this->resolveValue($context->find('larrow'), $context);
                $buffer .= $value;
                $buffer .= '</span>
';
                $buffer .= $indent . '                </a>
';
                $buffer .= $indent . '                <span class="hide"> | </span>
';
                $buffer .= $indent . '                <span class="current">
';
                $buffer .= $indent . '                    <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= $value;
                $buffer .= '" title="';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section95c6799cb30cd89f1344831aab6696c3($context, $indent, $value);
                $buffer .= '">';
                $value = $this->resolveValue($context->find('periodname'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '</a>
';
                $buffer .= $indent . '                </span>
';
                $buffer .= $indent . '                <span class="hide"> | </span>
';
                $buffer .= $indent . '                <a';
                $buffer .= ' href="#"';
                $buffer .= ' class="arrow_link next"';
                $buffer .= ' title="';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section79d01ec0a9380fe9e2b8dce0d84217d2($context, $indent, $value);
                $buffer .= '"';
                $buffer .= ' data-year="';
                $value = $this->resolveValue($context->findDot('nextperiod.year'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"';
                $buffer .= ' data-month="';
                $value = $this->resolveValue($context->findDot('nextperiod.mon'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"';
                $buffer .= '>
';
                $buffer .= $indent . '                    <span class="arrow">';
                $value = $this->resolveValue($context->find('rarrow'), $context);
                $buffer .= $value;
                $buffer .= '</span>
';
                $buffer .= $indent . '                </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3c340cd0e7cdb5c04f1f9c978b87bf83(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <th class="header text-xs-center" scope="col">
                    <abbr title="{{fullname}}">{{shortname}}</abbr>
                </th>
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
                
                $buffer .= $indent . '                <th class="header text-xs-center" scope="col">
';
                $buffer .= $indent . '                    <abbr title="';
                $value = $this->resolveValue($context->find('fullname'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">';
                $value = $this->resolveValue($context->find('shortname'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '</abbr>
';
                $buffer .= $indent . '                </th>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section30ad4cd62bbcce6b32c5d2ea63ba3dca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <td class="dayblank">&nbsp;</td>
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
                
                $buffer .= $indent . '                    <td class="dayblank">&nbsp;</td>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCce61e3fee851e8b66112494c048a58a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' today';
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
                
                $buffer .= ' today';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section84f949a8191b4daaac38d5ac1997cd7a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' weekend';
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
                
                $buffer .= ' weekend';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE28f621eb042f18284779ecc71990758(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' hasevent';
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
                
                $buffer .= ' hasevent';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8aa9feca8669cbbfdc6a37548f193ebe(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' duration';
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
                
                $buffer .= ' duration';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC090550ce065bf0ee1844d93a2f5c5bc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' duration_{{.}}';
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
                
                $buffer .= ' duration_';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB786f62feecbd1b2b3eaf0a04a4d40f3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' duraction_finish';
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
                
                $buffer .= ' duraction_finish';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6b9e1faf6dd22472e3bfefeb73470f9e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{!
                            }} calendar_event_{{.}}{{!
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
                
                $buffer .= ' calendar_event_';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section83917a04d3d8116850091e3dc79e37f9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{!
                            }} duration_finish{{!
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
                
                $buffer .= ' duration_finish';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC7135d539a6e01c773bccf5ca6b5dd9a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{!
                        }} data-eventtype-{{.}}="1"{{!
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
                
                $buffer .= ' data-eventtype-';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '="1"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDaed2e929d0e7585d426c393e8ac958e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'eventnone, calendar';
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
                
                $buffer .= 'eventnone, calendar';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4ac19e0573954dd94c88676d5f3bcb05(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' icon, {{modulename}} ';
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
                
                $buffer .= ' icon, ';
                $value = $this->resolveValue($context->find('modulename'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7906265934e0baa52fafb9819a312ad9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                                {{#pix}} icon, {{modulename}} {{/pix}}
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
                
                $buffer .= $indent . '                                                ';
                // 'pix' section
                $value = $context->find('pix');
                $buffer .= $this->section4ac19e0573954dd94c88676d5f3bcb05($context, $indent, $value);
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9c97b4f60a629a62913fd45093511e80(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/{{eventtype}}event, core ';
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
                
                $buffer .= ' i/';
                $value = $this->resolveValue($context->find('eventtype'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= 'event, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section63b4aa462f1fa0f207b421ce43bd7a5f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                        <div data-popover-eventtype-{{calendareventtype}}="1">
                                            {{#modulename}}
                                                {{#pix}} icon, {{modulename}} {{/pix}}
                                            {{/modulename}}
                                            {{^modulename}}
                                                {{#pix}} i/{{eventtype}}event, core {{/pix}}
                                            {{/modulename}}
                                            {{{popupname}}}
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
                
                $buffer .= '                                        <div data-popover-eventtype-';
                $value = $this->resolveValue($context->find('calendareventtype'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '="1">
';
                // 'modulename' section
                $value = $context->find('modulename');
                $buffer .= $this->section7906265934e0baa52fafb9819a312ad9($context, $indent, $value);
                // 'modulename' inverted section
                $value = $context->find('modulename');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                                                ';
                    // 'pix' section
                    $value = $context->find('pix');
                    $buffer .= $this->section9c97b4f60a629a62913fd45093511e80($context, $indent, $value);
                    $buffer .= '
';
                }
                $buffer .= $indent . '                                            ';
                $value = $this->resolveValue($context->find('popupname'), $context);
                $buffer .= $value;
                $buffer .= '
';
                $buffer .= $indent . '                                        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEb761f41bdf8f24ab8b29c2621c04128(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                            {{< core_calendar/minicalendar_day_link }}
                                {{$day}}{{mday}}{{/day}}
                                {{$url}}{{viewdaylink}}{{/url}}
                                {{$title}}{{popovertitle}}{{/title}}
                                {{$nocontent}}{{#str}}eventnone, calendar{{/str}}{{/nocontent}}
                                {{$content}}
                                    {{#events}}
                                        <div data-popover-eventtype-{{calendareventtype}}="1">
                                            {{#modulename}}
                                                {{#pix}} icon, {{modulename}} {{/pix}}
                                            {{/modulename}}
                                            {{^modulename}}
                                                {{#pix}} i/{{eventtype}}event, core {{/pix}}
                                            {{/modulename}}
                                            {{{popupname}}}
                                        </div>
                                    {{/events}}
                                {{/content}}
                            {{/ core_calendar/minicalendar_day_link }}
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
                
                $buffer .= '
';
                $buffer .= $indent . '                            ';
                if ($parent = $this->mustache->loadPartial('core_calendar/minicalendar_day_link')) {
                    $context->pushBlockContext(array(
                        'day' => array($this, 'blockAae4908e03e92f01a0b1705dd3588760'),
                        'url' => array($this, 'block831596ddaf6cbde2745e4660f5b31066'),
                        'title' => array($this, 'block1c882004ed0b8c7e2514534f032c872e'),
                        'nocontent' => array($this, 'block36d7e0728fb3c91b9ae9e4672d9ef678'),
                        'content' => array($this, 'block69978810ee87f7e5e0cea731399e4d89'),
                    ));
                    $buffer .= $parent->renderInternal($context, $indent);
                    $context->popBlockContext();
                }
                $buffer .= $indent . '                        ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB1c0b3d8d0713d8f190d2c8828e4cff4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <td class="day text-center{{!
                            This is the list of additional classes to display.

                            This cell is for today.
                            }}{{#istoday}} today{{/istoday}}{{!

                            This day falls on a weekend.
                            }}{{#isweekend}} weekend{{/isweekend}}{{!

                            There is at least one event.
                            }}{{#events.0}} hasevent{{/events.0}}{{!

                            There are events on this day which span multiple days.
                            }}{{#durationevents.0}} duration{{/durationevents.0}}{{!
                            }}{{#durationevents}} duration_{{.}}{{/durationevents}}{{!
                            }}{{#islastday}} duraction_finish{{/islastday}}{{!

                            These event types fall on this day.
                            }}{{#calendareventtypes}}{{!
                            }} calendar_event_{{.}}{{!
                            }}{{/calendareventtypes}}{{!

                            This day contains the last day of an event.
                            }}{{#haslastdayofevent}}{{!
                            }} duration_finish{{!
                            }}{{/haslastdayofevent}}{{!
                        }}"{{!

                        Add data-eventtype-[eventtype] data attributes.
                        These are used to show and hide events using the filter.
                        }}{{#calendareventtypes}}{{!
                        }} data-eventtype-{{.}}="1"{{!
                        }}{{/calendareventtypes}}{{!

                        This is the timestamp for this month.
                        }} data-day-timestamp="{{timestamp}}"{{!
                    }}>{{!
                        }}{{#popovertitle}}
                            {{< core_calendar/minicalendar_day_link }}
                                {{$day}}{{mday}}{{/day}}
                                {{$url}}{{viewdaylink}}{{/url}}
                                {{$title}}{{popovertitle}}{{/title}}
                                {{$nocontent}}{{#str}}eventnone, calendar{{/str}}{{/nocontent}}
                                {{$content}}
                                    {{#events}}
                                        <div data-popover-eventtype-{{calendareventtype}}="1">
                                            {{#modulename}}
                                                {{#pix}} icon, {{modulename}} {{/pix}}
                                            {{/modulename}}
                                            {{^modulename}}
                                                {{#pix}} i/{{eventtype}}event, core {{/pix}}
                                            {{/modulename}}
                                            {{{popupname}}}
                                        </div>
                                    {{/events}}
                                {{/content}}
                            {{/ core_calendar/minicalendar_day_link }}
                        {{/popovertitle}}{{!
                        }}{{^popovertitle}}
                            {{mday}}
                        {{/popovertitle}}{{!
                    }}</td>
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
                
                $buffer .= $indent . '                    <td class="day text-center';
                // 'istoday' section
                $value = $context->find('istoday');
                $buffer .= $this->sectionCce61e3fee851e8b66112494c048a58a($context, $indent, $value);
                // 'isweekend' section
                $value = $context->find('isweekend');
                $buffer .= $this->section84f949a8191b4daaac38d5ac1997cd7a($context, $indent, $value);
                // 'events.0' section
                $value = $context->findDot('events.0');
                $buffer .= $this->sectionE28f621eb042f18284779ecc71990758($context, $indent, $value);
                // 'durationevents.0' section
                $value = $context->findDot('durationevents.0');
                $buffer .= $this->section8aa9feca8669cbbfdc6a37548f193ebe($context, $indent, $value);
                // 'durationevents' section
                $value = $context->find('durationevents');
                $buffer .= $this->sectionC090550ce065bf0ee1844d93a2f5c5bc($context, $indent, $value);
                // 'islastday' section
                $value = $context->find('islastday');
                $buffer .= $this->sectionB786f62feecbd1b2b3eaf0a04a4d40f3($context, $indent, $value);
                // 'calendareventtypes' section
                $value = $context->find('calendareventtypes');
                $buffer .= $this->section6b9e1faf6dd22472e3bfefeb73470f9e($context, $indent, $value);
                // 'haslastdayofevent' section
                $value = $context->find('haslastdayofevent');
                $buffer .= $this->section83917a04d3d8116850091e3dc79e37f9($context, $indent, $value);
                $buffer .= '"';
                // 'calendareventtypes' section
                $value = $context->find('calendareventtypes');
                $buffer .= $this->sectionC7135d539a6e01c773bccf5ca6b5dd9a($context, $indent, $value);
                $buffer .= ' data-day-timestamp="';
                $value = $this->resolveValue($context->find('timestamp'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"';
                $buffer .= '>';
                // 'popovertitle' section
                $value = $context->find('popovertitle');
                $buffer .= $this->sectionEb761f41bdf8f24ab8b29c2621c04128($context, $indent, $value);
                // 'popovertitle' inverted section
                $value = $context->find('popovertitle');
                if (empty($value)) {
                    
                    $buffer .= '
';
                    $buffer .= $indent . '                            ';
                    $value = $this->resolveValue($context->find('mday'), $context);
                    $buffer .= call_user_func($this->mustache->getEscape(), $value);
                    $buffer .= '
';
                    $buffer .= $indent . '                        ';
                }
                $buffer .= '</td>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB061c3bf0b53ad36002b090db71724ea(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <tr data-region="month-view-week">
                {{#prepadding}}
                    <td class="dayblank">&nbsp;</td>
                {{/prepadding}}
                {{#days}}
                    <td class="day text-center{{!
                            This is the list of additional classes to display.

                            This cell is for today.
                            }}{{#istoday}} today{{/istoday}}{{!

                            This day falls on a weekend.
                            }}{{#isweekend}} weekend{{/isweekend}}{{!

                            There is at least one event.
                            }}{{#events.0}} hasevent{{/events.0}}{{!

                            There are events on this day which span multiple days.
                            }}{{#durationevents.0}} duration{{/durationevents.0}}{{!
                            }}{{#durationevents}} duration_{{.}}{{/durationevents}}{{!
                            }}{{#islastday}} duraction_finish{{/islastday}}{{!

                            These event types fall on this day.
                            }}{{#calendareventtypes}}{{!
                            }} calendar_event_{{.}}{{!
                            }}{{/calendareventtypes}}{{!

                            This day contains the last day of an event.
                            }}{{#haslastdayofevent}}{{!
                            }} duration_finish{{!
                            }}{{/haslastdayofevent}}{{!
                        }}"{{!

                        Add data-eventtype-[eventtype] data attributes.
                        These are used to show and hide events using the filter.
                        }}{{#calendareventtypes}}{{!
                        }} data-eventtype-{{.}}="1"{{!
                        }}{{/calendareventtypes}}{{!

                        This is the timestamp for this month.
                        }} data-day-timestamp="{{timestamp}}"{{!
                    }}>{{!
                        }}{{#popovertitle}}
                            {{< core_calendar/minicalendar_day_link }}
                                {{$day}}{{mday}}{{/day}}
                                {{$url}}{{viewdaylink}}{{/url}}
                                {{$title}}{{popovertitle}}{{/title}}
                                {{$nocontent}}{{#str}}eventnone, calendar{{/str}}{{/nocontent}}
                                {{$content}}
                                    {{#events}}
                                        <div data-popover-eventtype-{{calendareventtype}}="1">
                                            {{#modulename}}
                                                {{#pix}} icon, {{modulename}} {{/pix}}
                                            {{/modulename}}
                                            {{^modulename}}
                                                {{#pix}} i/{{eventtype}}event, core {{/pix}}
                                            {{/modulename}}
                                            {{{popupname}}}
                                        </div>
                                    {{/events}}
                                {{/content}}
                            {{/ core_calendar/minicalendar_day_link }}
                        {{/popovertitle}}{{!
                        }}{{^popovertitle}}
                            {{mday}}
                        {{/popovertitle}}{{!
                    }}</td>
                {{/days}}
                {{#postpadding}}
                    <td class="dayblank">&nbsp;</td>
                {{/postpadding}}
            </tr>
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
                
                $buffer .= $indent . '            <tr data-region="month-view-week">
';
                // 'prepadding' section
                $value = $context->find('prepadding');
                $buffer .= $this->section30ad4cd62bbcce6b32c5d2ea63ba3dca($context, $indent, $value);
                // 'days' section
                $value = $context->find('days');
                $buffer .= $this->sectionB1c0b3d8d0713d8f190d2c8828e4cff4($context, $indent, $value);
                // 'postpadding' section
                $value = $context->find('postpadding');
                $buffer .= $this->section30ad4cd62bbcce6b32c5d2ea63ba3dca($context, $indent, $value);
                $buffer .= $indent . '            </tr>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCfbe066aada6aa686f20e98cfbb1f1b7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([
    \'jquery\',
    \'core_calendar/selectors\',
    \'core_calendar/events\',
], function(
    $,
    CalendarSelectors,
    CalendarEvents
) {

    $(\'body\').on(CalendarEvents.filterChanged, function(e, data) {
        M.util.js_pending("month-mini-{{uniqid}}-filterChanged");
        // A filter value has been changed.
        // Find all matching cells in the popover data, and hide them.
        $("#month-mini-{{date.year}}-{{date.month}}-{{uniqid}}")
            .find(CalendarSelectors.popoverType[data.type])
            .toggleClass(\'hidden\', !!data.hidden);
        M.util.js_complete("month-mini-{{uniqid}}-filterChanged");
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
                
                $buffer .= $indent . 'require([
';
                $buffer .= $indent . '    \'jquery\',
';
                $buffer .= $indent . '    \'core_calendar/selectors\',
';
                $buffer .= $indent . '    \'core_calendar/events\',
';
                $buffer .= $indent . '], function(
';
                $buffer .= $indent . '    $,
';
                $buffer .= $indent . '    CalendarSelectors,
';
                $buffer .= $indent . '    CalendarEvents
';
                $buffer .= $indent . ') {
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    $(\'body\').on(CalendarEvents.filterChanged, function(e, data) {
';
                $buffer .= $indent . '        M.util.js_pending("month-mini-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '-filterChanged");
';
                $buffer .= $indent . '        // A filter value has been changed.
';
                $buffer .= $indent . '        // Find all matching cells in the popover data, and hide them.
';
                $buffer .= $indent . '        $("#month-mini-';
                $value = $this->resolveValue($context->findDot('date.year'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '-';
                $value = $this->resolveValue($context->findDot('date.month'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '")
';
                $buffer .= $indent . '            .find(CalendarSelectors.popoverType[data.type])
';
                $buffer .= $indent . '            .toggleClass(\'hidden\', !!data.hidden);
';
                $buffer .= $indent . '        M.util.js_complete("month-mini-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '-filterChanged");
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

    public function blockAae4908e03e92f01a0b1705dd3588760($context)
    {
        $indent = $buffer = '';
        $value = $this->resolveValue($context->find('mday'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
    
        return $buffer;
    }

    public function block831596ddaf6cbde2745e4660f5b31066($context)
    {
        $indent = $buffer = '';
        $value = $this->resolveValue($context->find('viewdaylink'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
    
        return $buffer;
    }

    public function block1c882004ed0b8c7e2514534f032c872e($context)
    {
        $indent = $buffer = '';
        $value = $this->resolveValue($context->find('popovertitle'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
    
        return $buffer;
    }

    public function block36d7e0728fb3c91b9ae9e4672d9ef678($context)
    {
        $indent = $buffer = '';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->sectionDaed2e929d0e7585d426c393e8ac958e($context, $indent, $value);
    
        return $buffer;
    }

    public function block69978810ee87f7e5e0cea731399e4d89($context)
    {
        $indent = $buffer = '';
        // 'events' section
        $value = $context->find('events');
        $buffer .= $this->section63b4aa462f1fa0f207b421ce43bd7a5f($context, $indent, $value);
    
        return $buffer;
    }
}
