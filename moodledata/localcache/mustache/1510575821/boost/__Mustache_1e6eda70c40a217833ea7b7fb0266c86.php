<?php

class __Mustache_1e6eda70c40a217833ea7b7fb0266c86 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div data-region="coursecompetenciespage">
';
        $buffer .= $indent . '    <div data-region="actions" class="clearfix">
';
        $buffer .= $indent . '        <div class="pull-xs-left">
';
        // 'canmanagecoursecompetencies' section
        $value = $context->find('canmanagecoursecompetencies');
        $buffer .= $this->section792a569268537b707962688de4133a2d($context, $indent, $value);
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div data-region="configurecoursecompetencies">
';
        // 'cangradecompetencies' section
        $value = $context->find('cangradecompetencies');
        $buffer .= $this->section02cd2e112bf96473916a5f1b640fc33f($context, $indent, $value);
        $buffer .= $indent . '    </div>
';
        // 'statistics' section
        $value = $context->find('statistics');
        $buffer .= $this->sectionB501155168f9ceba653a4354a613a445($context, $indent, $value);
        $buffer .= $indent . '<div data-region="coursecompetencies">
';
        $buffer .= $indent . '<table class="generaltable fullwidth managecompetencies">
';
        $buffer .= $indent . '<tbody class="drag-parentnode">
';
        // 'competencies' section
        $value = $context->find('competencies');
        $buffer .= $this->section865419a721fc8726615c9580657097cf($context, $indent, $value);
        $buffer .= $indent . '</tbody>
';
        $buffer .= $indent . '</table>
';
        // 'competencies' inverted section
        $value = $context->find('competencies');
        if (empty($value)) {
            
            $buffer .= $indent . '<p class="alert alert-info">
';
            $buffer .= $indent . '    ';
            // 'str' section
            $value = $context->find('str');
            $buffer .= $this->section03e850bca9d66bc415422912b5bd6e07($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '</p>
';
        }
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '<div data-region="actions">
';
        // 'canmanagecompetencyframeworks' section
        $value = $context->find('canmanagecompetencyframeworks');
        $buffer .= $this->sectionFa239ecc6370f798366ffc4b2fc48682($context, $indent, $value);
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '</div>
';
        // 'js' section
        $value = $context->find('js');
        $buffer .= $this->section613613d384c0d3c987a261019bd6da90($context, $indent, $value);
        // 'canconfigurecoursecompetencies' section
        $value = $context->find('canconfigurecoursecompetencies');
        $buffer .= $this->section6452acc23e99b68630649c182e2455fe($context, $indent, $value);

        return $buffer;
    }

    private function section8e1a2521a451eb6a7b8b5f0ae4b72269(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'addcoursecompetencies, tool_lp';
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
                
                $buffer .= 'addcoursecompetencies, tool_lp';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section792a569268537b707962688de4133a2d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <button class="btn btn-secondary" disabled>{{#str}}addcoursecompetencies, tool_lp{{/str}}</button>
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
                
                $buffer .= $indent . '                <button class="btn btn-secondary" disabled>';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section8e1a2521a451eb6a7b8b5f0ae4b72269($context, $indent, $value);
                $buffer .= '</button>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA0ed9b535ed171b00353f97e30f4d0eb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'coursecompetencyratingsarepushedtouserplans, tool_lp';
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
                
                $buffer .= 'coursecompetencyratingsarepushedtouserplans, tool_lp';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE90f8c29c8184c27e498368c311f10e0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#str}}coursecompetencyratingsarepushedtouserplans, tool_lp{{/str}}
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
                
                $buffer .= $indent . '            ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionA0ed9b535ed171b00353f97e30f4d0eb($context, $indent, $value);
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7728dc32f135d1e2924b0746299af745(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'coursecompetencyratingsarenotpushedtouserplans, tool_lp';
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
                
                $buffer .= 'coursecompetencyratingsarenotpushedtouserplans, tool_lp';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAd3b4bf865abc6ce6b96cc2301a00c9b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'edit';
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
                
                $buffer .= 'edit';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFc1d4f1bf432cd9124ae3a835133dcf6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 't/edit, core, {{#str}}edit{{/str}}';
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
                
                $buffer .= 't/edit, core, ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionAd3b4bf865abc6ce6b96cc2301a00c9b($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1c2bdc7141fc65ee703e3af7f89a2bab(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <a href="#"
               data-action="configure-course-competency-settings"
               data-courseid="{{courseid}}"
               data-pushratingstouserplans="{{settings.pushratingstouserplans}}">
                {{#pix}}t/edit, core, {{#str}}edit{{/str}}{{/pix}}
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
                
                $buffer .= $indent . '            <a href="#"
';
                $buffer .= $indent . '               data-action="configure-course-competency-settings"
';
                $buffer .= $indent . '               data-courseid="';
                $value = $this->resolveValue($context->find('courseid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"
';
                $buffer .= $indent . '               data-pushratingstouserplans="';
                $value = $this->resolveValue($context->findDot('settings.pushratingstouserplans'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">
';
                $buffer .= $indent . '                ';
                // 'pix' section
                $value = $context->find('pix');
                $buffer .= $this->sectionFc1d4f1bf432cd9124ae3a835133dcf6($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '            </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section02cd2e112bf96473916a5f1b640fc33f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <p class="alert {{^settings.pushratingstouserplans}}alert-info{{/settings.pushratingstouserplans}}">
        {{#settings.pushratingstouserplans}}
            {{#str}}coursecompetencyratingsarepushedtouserplans, tool_lp{{/str}}
        {{/settings.pushratingstouserplans}}
        {{^settings.pushratingstouserplans}}
            {{#str}}coursecompetencyratingsarenotpushedtouserplans, tool_lp{{/str}}
        {{/settings.pushratingstouserplans}}
        {{#canconfigurecoursecompetencies}}
            <a href="#"
               data-action="configure-course-competency-settings"
               data-courseid="{{courseid}}"
               data-pushratingstouserplans="{{settings.pushratingstouserplans}}">
                {{#pix}}t/edit, core, {{#str}}edit{{/str}}{{/pix}}
            </a>
        {{/canconfigurecoursecompetencies}}
        </p>
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
                
                $buffer .= $indent . '        <p class="alert ';
                // 'settings.pushratingstouserplans' inverted section
                $value = $context->findDot('settings.pushratingstouserplans');
                if (empty($value)) {
                    
                    $buffer .= 'alert-info';
                }
                $buffer .= '">
';
                // 'settings.pushratingstouserplans' section
                $value = $context->findDot('settings.pushratingstouserplans');
                $buffer .= $this->sectionE90f8c29c8184c27e498368c311f10e0($context, $indent, $value);
                // 'settings.pushratingstouserplans' inverted section
                $value = $context->findDot('settings.pushratingstouserplans');
                if (empty($value)) {
                    
                    $buffer .= $indent . '            ';
                    // 'str' section
                    $value = $context->find('str');
                    $buffer .= $this->section7728dc32f135d1e2924b0746299af745($context, $indent, $value);
                    $buffer .= '
';
                }
                // 'canconfigurecoursecompetencies' section
                $value = $context->find('canconfigurecoursecompetencies');
                $buffer .= $this->section1c2bdc7141fc65ee703e3af7f89a2bab($context, $indent, $value);
                $buffer .= $indent . '        </p>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB501155168f9ceba653a4354a613a445(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
{{> tool_lp/course_competency_statistics }}
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
                
                if ($partial = $this->mustache->loadPartial('tool_lp/course_competency_statistics')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8f92e409dad2d31675245b12b8825d4e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'delete';
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
                
                $buffer .= 'delete';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1245898a9c4802f609e8da4fe72227c2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 't/delete, core, {{#str}}delete{{/str}}';
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
                
                $buffer .= 't/delete, core, ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section8f92e409dad2d31675245b12b8825d4e($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section697deca8a0dbbebd27a235aebb74de74(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <span class="drag-handlecontainer pull-xs-left"></span>
        <div class="pull-xs-right">
            <a href="#" data-action="delete-competency-link" data-id="{{competency.id}}">
                {{#pix}}t/delete, core, {{#str}}delete{{/str}}{{/pix}}
            </a>
        </div>
        <div class="clearfix"></div>
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
                
                $buffer .= $indent . '        <span class="drag-handlecontainer pull-xs-left"></span>
';
                $buffer .= $indent . '        <div class="pull-xs-right">
';
                $buffer .= $indent . '            <a href="#" data-action="delete-competency-link" data-id="';
                $value = $this->resolveValue($context->findDot('competency.id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">
';
                $buffer .= $indent . '                ';
                // 'pix' section
                $value = $context->find('pix');
                $buffer .= $this->section1245898a9c4802f609e8da4fe72227c2($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '            </a>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '        <div class="clearfix"></div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD6d7bcd5d66932580fec7960232c9fc4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'viewdetails, tool_lp';
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
                
                $buffer .= 'viewdetails, tool_lp';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section60d6697ee0bab834600a99e758d92e6d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <a href="{{pluginbaseurl}}user_competency_in_course.php?courseid={{courseid}}&competencyid={{competency.id}}&userid={{gradableuserid}}"
                   id="competency-info-link-{{competency.id}}"
                   title="{{#str}}viewdetails, tool_lp{{/str}}">
                <p><strong>{{{competency.shortname}}} <em>{{competency.idnumber}}</em></strong></p>
            </a>
            <p>{{{competency.description}}}</p>
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
                
                $buffer .= $indent . '            <a href="';
                $value = $this->resolveValue($context->find('pluginbaseurl'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= 'user_competency_in_course.php?courseid=';
                $value = $this->resolveValue($context->find('courseid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '&competencyid=';
                $value = $this->resolveValue($context->findDot('competency.id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '&userid=';
                $value = $this->resolveValue($context->find('gradableuserid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"
';
                $buffer .= $indent . '                   id="competency-info-link-';
                $value = $this->resolveValue($context->findDot('competency.id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"
';
                $buffer .= $indent . '                   title="';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->sectionD6d7bcd5d66932580fec7960232c9fc4($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '                <p><strong>';
                $value = $this->resolveValue($context->findDot('competency.shortname'), $context);
                $buffer .= $value;
                $buffer .= ' <em>';
                $value = $this->resolveValue($context->findDot('competency.idnumber'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '</em></strong></p>
';
                $buffer .= $indent . '            </a>
';
                $buffer .= $indent . '            <p>';
                $value = $this->resolveValue($context->findDot('competency.description'), $context);
                $buffer .= $value;
                $buffer .= '</p>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5db15ba4d8fa7764751fbbe00561fbe0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'path, tool_lp';
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
                
                $buffer .= 'path, tool_lp';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section83c68885d66db535504e7713314dfa34(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <span class="pull-xs-left">{{#str}}path, tool_lp{{/str}}&nbsp;</span>{{> tool_lp/competency_path }}
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
                
                $buffer .= $indent . '            <span class="pull-xs-left">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section5db15ba4d8fa7764751fbbe00561fbe0($context, $indent, $value);
                $buffer .= '&nbsp;</span>';
                if ($partial = $this->mustache->loadPartial('tool_lp/competency_path')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEb92c170729ffdec540d6848a93fb2b3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <span class="label {{^proficiency}}label-important{{/proficiency}}">{{gradename}}</span>
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
                
                $buffer .= $indent . '            <span class="label ';
                // 'proficiency' inverted section
                $value = $context->find('proficiency');
                if (empty($value)) {
                    
                    $buffer .= 'label-important';
                }
                $buffer .= '">';
                $value = $this->resolveValue($context->find('gradename'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section27b0ef03a0606ee4925c9b55cd1dbf11(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#grade}}
            <span class="label {{^proficiency}}label-important{{/proficiency}}">{{gradename}}</span>
            {{/grade}}
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
                
                // 'grade' section
                $value = $context->find('grade');
                $buffer .= $this->sectionEb92c170729ffdec540d6848a93fb2b3($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5c0c437015e88b1da78736264f954838(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'uponcoursecompletion, tool_lp';
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
                
                $buffer .= 'uponcoursecompletion, tool_lp';
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

    private function section0f47ba212e2fa1f3ed5e7ac388eacb09(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                     <option value="{{value}}" {{#selected}}selected{{/selected}}>{{text}}</option>
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
                
                $buffer .= $indent . '                     <option value="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" ';
                // 'selected' section
                $value = $context->find('selected');
                $buffer .= $this->section9e2875c627d2dbad7c957250bbb623f7($context, $indent, $value);
                $buffer .= '>';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '</option>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section08d9d84a4974a1be1392cd148f36cd22(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div data-region="coursecompetency-ruleoutcome">
            <label>
                {{#str}}uponcoursecompletion, tool_lp{{/str}}
                <select data-field="ruleoutcome" data-id="{{coursecompetency.id}}" class="custom-select">
                  {{#ruleoutcomeoptions}}
                     <option value="{{value}}" {{#selected}}selected{{/selected}}>{{text}}</option>
                  {{/ruleoutcomeoptions}}
                </select>
            </label>
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
                
                $buffer .= $indent . '        <div data-region="coursecompetency-ruleoutcome">
';
                $buffer .= $indent . '            <label>
';
                $buffer .= $indent . '                ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section5c0c437015e88b1da78736264f954838($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                <select data-field="ruleoutcome" data-id="';
                $value = $this->resolveValue($context->findDot('coursecompetency.id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '" class="custom-select">
';
                // 'ruleoutcomeoptions' section
                $value = $context->find('ruleoutcomeoptions');
                $buffer .= $this->section0f47ba212e2fa1f3ed5e7ac388eacb09($context, $indent, $value);
                $buffer .= $indent . '                </select>
';
                $buffer .= $indent . '            </label>
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA5773bade75c78d5f039ebbaae2f03f6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <li class="list-inline-item"><a href="{{url}}"><img src="{{iconurl}}"> {{name}} </a></li>
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
                
                $buffer .= $indent . '            <li class="list-inline-item"><a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"><img src="';
                $value = $this->resolveValue($context->find('iconurl'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '"> ';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= ' </a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFa4a803c089c26a0a2019bf1954e8a7d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'noactivities, tool_lp';
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
                
                $buffer .= 'noactivities, tool_lp';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section865419a721fc8726615c9580657097cf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <tr class="drag-samenode" data-id="{{competency.id}}">
    <td>
        {{#canmanagecoursecompetencies}}
        <span class="drag-handlecontainer pull-xs-left"></span>
        <div class="pull-xs-right">
            <a href="#" data-action="delete-competency-link" data-id="{{competency.id}}">
                {{#pix}}t/delete, core, {{#str}}delete{{/str}}{{/pix}}
            </a>
        </div>
        <div class="clearfix"></div>
        {{/canmanagecoursecompetencies}}
        {{#competency}}
            <a href="{{pluginbaseurl}}user_competency_in_course.php?courseid={{courseid}}&competencyid={{competency.id}}&userid={{gradableuserid}}"
                   id="competency-info-link-{{competency.id}}"
                   title="{{#str}}viewdetails, tool_lp{{/str}}">
                <p><strong>{{{competency.shortname}}} <em>{{competency.idnumber}}</em></strong></p>
            </a>
            <p>{{{competency.description}}}</p>
        {{/competency}}
        {{#comppath}}
            <span class="pull-xs-left">{{#str}}path, tool_lp{{/str}}&nbsp;</span>{{> tool_lp/competency_path }}
        {{/comppath}}
        {{#usercompetencycourse}}
            {{#grade}}
            <span class="label {{^proficiency}}label-important{{/proficiency}}">{{gradename}}</span>
            {{/grade}}
        {{/usercompetencycourse}}
        {{#canmanagecoursecompetencies}}
        <div data-region="coursecompetency-ruleoutcome">
            <label>
                {{#str}}uponcoursecompletion, tool_lp{{/str}}
                <select data-field="ruleoutcome" data-id="{{coursecompetency.id}}" class="custom-select">
                  {{#ruleoutcomeoptions}}
                     <option value="{{value}}" {{#selected}}selected{{/selected}}>{{text}}</option>
                  {{/ruleoutcomeoptions}}
                </select>
            </label>
        </div>
        {{/canmanagecoursecompetencies}}
        <div data-region="coursecompetencyactivities">
        <p>
        <ul class="inline list-inline">
        {{#coursemodules}}
            <li class="list-inline-item"><a href="{{url}}"><img src="{{iconurl}}"> {{name}} </a></li>
        {{/coursemodules}}
        {{^coursemodules}}
            <li class="list-inline-item"><span class="alert">{{#str}}noactivities, tool_lp{{/str}}</span></li>
        {{/coursemodules}}
        </ul>
        </p>
        </div>
    </td>
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
                
                $buffer .= $indent . '    <tr class="drag-samenode" data-id="';
                $value = $this->resolveValue($context->findDot('competency.id'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">
';
                $buffer .= $indent . '    <td>
';
                // 'canmanagecoursecompetencies' section
                $value = $context->find('canmanagecoursecompetencies');
                $buffer .= $this->section697deca8a0dbbebd27a235aebb74de74($context, $indent, $value);
                // 'competency' section
                $value = $context->find('competency');
                $buffer .= $this->section60d6697ee0bab834600a99e758d92e6d($context, $indent, $value);
                // 'comppath' section
                $value = $context->find('comppath');
                $buffer .= $this->section83c68885d66db535504e7713314dfa34($context, $indent, $value);
                // 'usercompetencycourse' section
                $value = $context->find('usercompetencycourse');
                $buffer .= $this->section27b0ef03a0606ee4925c9b55cd1dbf11($context, $indent, $value);
                // 'canmanagecoursecompetencies' section
                $value = $context->find('canmanagecoursecompetencies');
                $buffer .= $this->section08d9d84a4974a1be1392cd148f36cd22($context, $indent, $value);
                $buffer .= $indent . '        <div data-region="coursecompetencyactivities">
';
                $buffer .= $indent . '        <p>
';
                $buffer .= $indent . '        <ul class="inline list-inline">
';
                // 'coursemodules' section
                $value = $context->find('coursemodules');
                $buffer .= $this->sectionA5773bade75c78d5f039ebbaae2f03f6($context, $indent, $value);
                // 'coursemodules' inverted section
                $value = $context->find('coursemodules');
                if (empty($value)) {
                    
                    $buffer .= $indent . '            <li class="list-inline-item"><span class="alert">';
                    // 'str' section
                    $value = $context->find('str');
                    $buffer .= $this->sectionFa4a803c089c26a0a2019bf1954e8a7d($context, $indent, $value);
                    $buffer .= '</span></li>
';
                }
                $buffer .= $indent . '        </ul>
';
                $buffer .= $indent . '        </p>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '    </td>
';
                $buffer .= $indent . '    </tr>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section03e850bca9d66bc415422912b5bd6e07(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'nocompetenciesincourse, tool_lp';
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
                
                $buffer .= 'nocompetenciesincourse, tool_lp';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section162358c28b46626a5b0ef954763a36a3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'managecompetenciesandframeworks, tool_lp';
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
                
                $buffer .= 'managecompetenciesandframeworks, tool_lp';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFa239ecc6370f798366ffc4b2fc48682(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <p><a href="{{manageurl}}">{{#str}}managecompetenciesandframeworks, tool_lp{{/str}}</a></p>
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
                
                $buffer .= $indent . '        <p><a href="';
                $value = $this->resolveValue($context->find('manageurl'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '">';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section162358c28b46626a5b0ef954763a36a3($context, $indent, $value);
                $buffer .= '</a></p>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section613613d384c0d3c987a261019bd6da90(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'tool_lp/competencies\'], function(mod) {
    (new mod({{courseid}}, \'course\', {{pagecontextid}}));
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
                
                $buffer .= $indent . 'require([\'tool_lp/competencies\'], function(mod) {
';
                $buffer .= $indent . '    (new mod(';
                $value = $this->resolveValue($context->find('courseid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= ', \'course\', ';
                $value = $this->resolveValue($context->find('pagecontextid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '));
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0c49fd6a3b94bb73a903cd71326b01e7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'tool_lp/course_competency_settings\'], function(Mod) {
    (new Mod(\'[data-action=configure-course-competency-settings]\'));
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
                
                $buffer .= $indent . 'require([\'tool_lp/course_competency_settings\'], function(Mod) {
';
                $buffer .= $indent . '    (new Mod(\'[data-action=configure-course-competency-settings]\'));
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6452acc23e99b68630649c182e2455fe(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
{{#js}}
require([\'tool_lp/course_competency_settings\'], function(Mod) {
    (new Mod(\'[data-action=configure-course-competency-settings]\'));
});
{{/js}}
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
                
                // 'js' section
                $value = $context->find('js');
                $buffer .= $this->section0c49fd6a3b94bb73a903cd71326b01e7($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
