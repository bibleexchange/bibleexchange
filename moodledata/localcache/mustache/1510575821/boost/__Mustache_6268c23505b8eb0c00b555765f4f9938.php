<?php

class __Mustache_6268c23505b8eb0c00b555765f4f9938 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div id="sort-by-courses-view-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '">
';
        // 'coursesview' section
        $value = $context->find('coursesview');
        $buffer .= $this->section6308c3fb489bf5ded00c8b74931078c9($context, $indent, $value);
        $buffer .= $indent . '</div>
';
        // 'js' section
        $value = $context->find('js');
        $buffer .= $this->section379dadfe063ca43747b3206c1f772ecf($context, $indent, $value);

        return $buffer;
    }

    private function section634e0aa2c8cdf41ce8fc3cbde9cb0898(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{> block_myoverview/course-item }} ';
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
                if ($partial = $this->mustache->loadPartial('block_myoverview/course-item')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3c1afe42ccb2734e8341a6e090746dab(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <ul class="list-group unstyled hidden" data-region="course-block">
                        {{#courses}} {{> block_myoverview/course-item }} {{/courses}}
                    </ul>
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
                
                $buffer .= $indent . '                    <ul class="list-group unstyled hidden" data-region="course-block">
';
                $buffer .= $indent . '                        ';
                // 'courses' section
                $value = $context->find('courses');
                $buffer .= $this->section634e0aa2c8cdf41ce8fc3cbde9cb0898($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                    </ul>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5b5d7f649c45b60df5cfc8efe6989d0f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' morecourses, block_myoverview ';
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
                
                $buffer .= ' morecourses, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB784e7168646278227c84ed767da695a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{#pages}}
                    <ul class="list-group unstyled hidden" data-region="course-block">
                        {{#courses}} {{> block_myoverview/course-item }} {{/courses}}
                    </ul>
                {{/pages}}
                <div class="text-xs-center text-center m-t-1">
                    <button type="button" class="btn btn-secondary" data-action="more-courses">
                        {{#str}} morecourses, block_myoverview {{/str}}
                        <span class="hidden" data-region="loading-icon-container">
                            {{> core/loading }}
                        </span>
                    </button>
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
                
                // 'pages' section
                $value = $context->find('pages');
                $buffer .= $this->section3c1afe42ccb2734e8341a6e090746dab($context, $indent, $value);
                $buffer .= $indent . '                <div class="text-xs-center text-center m-t-1">
';
                $buffer .= $indent . '                    <button type="button" class="btn btn-secondary" data-action="more-courses">
';
                $buffer .= $indent . '                        ';
                // 'str' section
                $value = $context->find('str');
                $buffer .= $this->section5b5d7f649c45b60df5cfc8efe6989d0f($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                        <span class="hidden" data-region="loading-icon-container">
';
                if ($partial = $this->mustache->loadPartial('core/loading')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                            ');
                }
                $buffer .= $indent . '                        </span>
';
                $buffer .= $indent . '                    </button>
';
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFbb484deb1c2186e4ba8d15d8bb40a75(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' nocoursesinprogress, block_myoverview ';
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
                
                $buffer .= ' nocoursesinprogress, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section911c92c9b48685e08b89aeb3773ea74e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#haspages}}
                {{#pages}}
                    <ul class="list-group unstyled hidden" data-region="course-block">
                        {{#courses}} {{> block_myoverview/course-item }} {{/courses}}
                    </ul>
                {{/pages}}
                <div class="text-xs-center text-center m-t-1">
                    <button type="button" class="btn btn-secondary" data-action="more-courses">
                        {{#str}} morecourses, block_myoverview {{/str}}
                        <span class="hidden" data-region="loading-icon-container">
                            {{> core/loading }}
                        </span>
                    </button>
                </div>
            {{/haspages}}
            {{^haspages}}
                <div class="text-xs-center text-center m-t-3">
                    <img class="empty-placeholder-image-lg"
                         src="{{urls.noevents}}"
                         alt="{{#str}} nocoursesinprogress, block_myoverview {{/str}}"
                         role="presentation">
                    <p class="text-muted m-t-1">{{#str}} nocoursesinprogress, block_myoverview {{/str}}</p>
                </div>
            {{/haspages}}
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
                
                // 'haspages' section
                $value = $context->find('haspages');
                $buffer .= $this->sectionB784e7168646278227c84ed767da695a($context, $indent, $value);
                // 'haspages' inverted section
                $value = $context->find('haspages');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                <div class="text-xs-center text-center m-t-3">
';
                    $buffer .= $indent . '                    <img class="empty-placeholder-image-lg"
';
                    $buffer .= $indent . '                         src="';
                    $value = $this->resolveValue($context->findDot('urls.noevents'), $context);
                    $buffer .= call_user_func($this->mustache->getEscape(), $value);
                    $buffer .= '"
';
                    $buffer .= $indent . '                         alt="';
                    // 'str' section
                    $value = $context->find('str');
                    $buffer .= $this->sectionFbb484deb1c2186e4ba8d15d8bb40a75($context, $indent, $value);
                    $buffer .= '"
';
                    $buffer .= $indent . '                         role="presentation">
';
                    $buffer .= $indent . '                    <p class="text-muted m-t-1">';
                    // 'str' section
                    $value = $context->find('str');
                    $buffer .= $this->sectionFbb484deb1c2186e4ba8d15d8bb40a75($context, $indent, $value);
                    $buffer .= '</p>
';
                    $buffer .= $indent . '                </div>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6308c3fb489bf5ded00c8b74931078c9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{#inprogress}}
            {{#haspages}}
                {{#pages}}
                    <ul class="list-group unstyled hidden" data-region="course-block">
                        {{#courses}} {{> block_myoverview/course-item }} {{/courses}}
                    </ul>
                {{/pages}}
                <div class="text-xs-center text-center m-t-1">
                    <button type="button" class="btn btn-secondary" data-action="more-courses">
                        {{#str}} morecourses, block_myoverview {{/str}}
                        <span class="hidden" data-region="loading-icon-container">
                            {{> core/loading }}
                        </span>
                    </button>
                </div>
            {{/haspages}}
            {{^haspages}}
                <div class="text-xs-center text-center m-t-3">
                    <img class="empty-placeholder-image-lg"
                         src="{{urls.noevents}}"
                         alt="{{#str}} nocoursesinprogress, block_myoverview {{/str}}"
                         role="presentation">
                    <p class="text-muted m-t-1">{{#str}} nocoursesinprogress, block_myoverview {{/str}}</p>
                </div>
            {{/haspages}}
        {{/inprogress}}
        {{^inprogress}}
            <div class="text-xs-center text-center m-t-3">
                <img class="empty-placeholder-image-lg"
                     src="{{urls.noevents}}"
                     alt="{{#str}} nocoursesinprogress, block_myoverview {{/str}}"
                     role="presentation">
                <p class="text-muted m-t-1">{{#str}} nocoursesinprogress, block_myoverview {{/str}}</p>
            </div>
        {{/inprogress}}
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
                
                // 'inprogress' section
                $value = $context->find('inprogress');
                $buffer .= $this->section911c92c9b48685e08b89aeb3773ea74e($context, $indent, $value);
                // 'inprogress' inverted section
                $value = $context->find('inprogress');
                if (empty($value)) {
                    
                    $buffer .= $indent . '            <div class="text-xs-center text-center m-t-3">
';
                    $buffer .= $indent . '                <img class="empty-placeholder-image-lg"
';
                    $buffer .= $indent . '                     src="';
                    $value = $this->resolveValue($context->findDot('urls.noevents'), $context);
                    $buffer .= call_user_func($this->mustache->getEscape(), $value);
                    $buffer .= '"
';
                    $buffer .= $indent . '                     alt="';
                    // 'str' section
                    $value = $context->find('str');
                    $buffer .= $this->sectionFbb484deb1c2186e4ba8d15d8bb40a75($context, $indent, $value);
                    $buffer .= '"
';
                    $buffer .= $indent . '                     role="presentation">
';
                    $buffer .= $indent . '                <p class="text-muted m-t-1">';
                    // 'str' section
                    $value = $context->find('str');
                    $buffer .= $this->sectionFbb484deb1c2186e4ba8d15d8bb40a75($context, $indent, $value);
                    $buffer .= '</p>
';
                    $buffer .= $indent . '            </div>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section379dadfe063ca43747b3206c1f772ecf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    require([\'jquery\', \'core/custom_interaction_events\', \'block_myoverview/event_list_by_course\'],
        function($, CustomEvents, EventListByCourse) {

        var root = $("#sort-by-courses-view-{{uniqid}}");
        // This flag is used so that we can delay the loading of the events until the tab
        // is toggled by the user.
        var seen = false;

        CustomEvents.define(root, [CustomEvents.events.activate]);
        // Show more courses and load their events when the user clicks the "more courses"
        // button.
        root.on(CustomEvents.events.activate, \'[data-action="more-courses"]\', function(e, data) {
            var button = $(e.target);
            var blocks = root.find(\'[data-region="course-block"].hidden\');

            if (blocks && blocks.length) {
                var block = blocks.first();
                EventListByCourse.init(block);
                block.removeClass(\'hidden\');
            }

            // If there was only one hidden block then we have no more to show now
            // so we can disable the button.
            if (blocks && blocks.length == 1) {
                button.prop(\'disabled\', true);
            }

            if (data) {
                data.originalEvent.preventDefault();
                data.originalEvent.stopPropagation();
            }
            e.stopPropagation();
        });

        // Listen for when the user changes tab so that we can show the first set of courses
        // and load their events when they request the sort by courses view for the first time.
        root.closest(\'[data-region="timeline-view"]\').on(\'shown shown.bs.tab\', function(e) {
            if (seen) {
                return;
            }

            var tab = $(e.target);
            var tabTarget = $(tab.attr(\'href\'));

            if (!tabTarget || !tabTarget.length) {
                return;
            }

            var viewCourses = tabTarget.find(\'#sort-by-courses-view-{{uniqid}}\');

            if (viewCourses && viewCourses.length && !seen) {
                seen = true;
                viewCourses.find(\'[data-action="more-courses"]\').trigger(CustomEvents.events.activate);
            }
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
                
                $buffer .= $indent . '    require([\'jquery\', \'core/custom_interaction_events\', \'block_myoverview/event_list_by_course\'],
';
                $buffer .= $indent . '        function($, CustomEvents, EventListByCourse) {
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '        var root = $("#sort-by-courses-view-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '");
';
                $buffer .= $indent . '        // This flag is used so that we can delay the loading of the events until the tab
';
                $buffer .= $indent . '        // is toggled by the user.
';
                $buffer .= $indent . '        var seen = false;
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '        CustomEvents.define(root, [CustomEvents.events.activate]);
';
                $buffer .= $indent . '        // Show more courses and load their events when the user clicks the "more courses"
';
                $buffer .= $indent . '        // button.
';
                $buffer .= $indent . '        root.on(CustomEvents.events.activate, \'[data-action="more-courses"]\', function(e, data) {
';
                $buffer .= $indent . '            var button = $(e.target);
';
                $buffer .= $indent . '            var blocks = root.find(\'[data-region="course-block"].hidden\');
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '            if (blocks && blocks.length) {
';
                $buffer .= $indent . '                var block = blocks.first();
';
                $buffer .= $indent . '                EventListByCourse.init(block);
';
                $buffer .= $indent . '                block.removeClass(\'hidden\');
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '            // If there was only one hidden block then we have no more to show now
';
                $buffer .= $indent . '            // so we can disable the button.
';
                $buffer .= $indent . '            if (blocks && blocks.length == 1) {
';
                $buffer .= $indent . '                button.prop(\'disabled\', true);
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '            if (data) {
';
                $buffer .= $indent . '                data.originalEvent.preventDefault();
';
                $buffer .= $indent . '                data.originalEvent.stopPropagation();
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '            e.stopPropagation();
';
                $buffer .= $indent . '        });
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '        // Listen for when the user changes tab so that we can show the first set of courses
';
                $buffer .= $indent . '        // and load their events when they request the sort by courses view for the first time.
';
                $buffer .= $indent . '        root.closest(\'[data-region="timeline-view"]\').on(\'shown shown.bs.tab\', function(e) {
';
                $buffer .= $indent . '            if (seen) {
';
                $buffer .= $indent . '                return;
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '            var tab = $(e.target);
';
                $buffer .= $indent . '            var tabTarget = $(tab.attr(\'href\'));
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '            if (!tabTarget || !tabTarget.length) {
';
                $buffer .= $indent . '                return;
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '            var viewCourses = tabTarget.find(\'#sort-by-courses-view-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= call_user_func($this->mustache->getEscape(), $value);
                $buffer .= '\');
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '            if (viewCourses && viewCourses.length && !seen) {
';
                $buffer .= $indent . '                seen = true;
';
                $buffer .= $indent . '                viewCourses.find(\'[data-action="more-courses"]\').trigger(CustomEvents.events.activate);
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '        });
';
                $buffer .= $indent . '    });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
